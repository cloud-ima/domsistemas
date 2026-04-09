# Guía Completa de Base de Datos - Sistema DOM

## Tabla de Contenidos
1. [Índices Críticos](#índices-críticos)
2. [Encriptación de Contraseñas](#encriptación-de-contraseñas)
3. [Optimización de Consultas](#optimización-de-consultas)
4. [Seguridad SQL](#seguridad-sql)
5. [Mantenimiento y Monitoreo](#mantenimiento-y-monitoreo)
6. [Backup y Recuperación](#backup-y-recuperación)

---

## Índices Críticos

### Estado Actual
La base de datos `domsistemas` tiene **155,322 registros** en `cert2009` y **38,511 registros** en `rut`. Sin índices adecuados, cada consulta hace **full table scan** causando CPU al 100%.

### Índices Implementados

#### Tabla `cert2009` (155,322 filas)
```sql
-- Índices individuales para búsquedas específicas
CREATE INDEX idx_estado ON cert2009 (estado);
CREATE INDEX idx_fecha_solicitud ON cert2009 (fecha_solicitud);
CREATE INDEX idx_rut ON cert2009 (rut);
CREATE INDEX idx_idcert ON cert2009 (idcert);
CREATE INDEX idx_rol ON cert2009 (rol);

-- Índices compuestos para consultas complejas
CREATE INDEX idx_estado_id ON cert2009 (estado, id);
CREATE INDEX idx_estado_fecha ON cert2009 (estado, fecha_solicitud);
```

**Razón:** Estas columnas se usan en:
- `WHERE estado = X` (list_solicitudes.php, entregar.php, estadisticas/)
- `WHERE fecha_solicitud = X` (menu-adm.php, menu-normal.php)
- `JOIN ON c.rut = r.rut` (todas las consultas con JOIN)
- `WHERE idcert = X` (estadisticas/index.php)
- `WHERE rol = X` (consultas/index.php)

#### Tabla `rut` (38,511 filas)
```sql
-- Índice en columna 'rut' para JOINs
CREATE INDEX idx_rut_rut ON rut (rut);
```

**Razón:** Todos los JOINs buscan por `rut.rut`, no por `rut.id` (PRIMARY KEY).

#### Tabla `usuarios`
```sql
-- Índice en columna 'usuario' para búsquedas
CREATE INDEX idx_usuario ON usuarios (usuario);
```

**Razón:** Se busca por `usuario` en mostrar_solicitud.php, solicitud_completa.php.

### Verificar Índices Existentes

```bash
# Ver todos los índices de cert2009
mysql -u root -p domsistemas -e "SHOW INDEX FROM cert2009;"

# Ver solo índices personalizados (no PRIMARY)
mysql -u root -p domsistemas -e "SHOW INDEX FROM cert2009 WHERE Key_name LIKE 'idx_%';"

# Ver tamaño de índices
mysql -u root -p domsistemas -e "
SELECT 
    table_name,
    index_name,
    ROUND(stat_value * @@innodb_page_size / 1024 / 1024, 2) AS size_mb
FROM mysql.innodb_index_stats
WHERE database_name = 'domsistemas' 
    AND table_name = 'cert2009'
    AND stat_name = 'size'
ORDER BY size_mb DESC;
"
```

### Eliminar Índices (si es necesario)

```sql
-- Solo si necesitas recrear un índice
DROP INDEX idx_estado ON cert2009;
DROP INDEX idx_fecha_solicitud ON cert2009;
-- etc...
```

---

## Encriptación de Contraseñas

### ⚠️ PROBLEMA ACTUAL: Contraseñas en Texto Plano

La tabla `usuarios` actualmente almacena contraseñas **SIN ENCRIPTAR**:

```sql
-- Ver estructura actual
DESCRIBE usuarios;
```

### Solución: Migrar a Password Hashing

#### Paso 1: Agregar columna para hash
```sql
-- Agregar nueva columna para password hasheado
ALTER TABLE usuarios ADD COLUMN password_hash VARCHAR(255) DEFAULT NULL AFTER password;
```

#### Paso 2: Crear script de migración

Crear archivo `c:\Users\Admin\Herd\domsistemas\migrar_passwords.php`:

```php
<?php
require_once 'conexion.php';

$link = Conectarse();

// Obtener todos los usuarios con password en texto plano
$query = "SELECT id, usuario, password FROM usuarios WHERE password_hash IS NULL";
$result = mysqli_query($link, $query);

$migrados = 0;
while ($row = mysqli_fetch_assoc($result)) {
    // Generar hash usando password_hash (bcrypt)
    $hash = password_hash($row['password'], PASSWORD_BCRYPT);
    
    // Actualizar registro
    $update = "UPDATE usuarios SET password_hash = ? WHERE id = ?";
    $stmt = mysqli_prepare($link, $update);
    mysqli_stmt_bind_param($stmt, 'si', $hash, $row['id']);
    mysqli_stmt_execute($stmt);
    
    $migrados++;
    echo "Migrado usuario: {$row['usuario']}\n";
}

echo "\nTotal migrados: $migrados usuarios\n";
mysqli_close($link);
```

#### Paso 3: Ejecutar migración

```bash
# En el servidor Ubuntu
cd /srv/webdata/www
php migrar_passwords.php
```

#### Paso 4: Actualizar código de login

Modificar `validacion.php` o el archivo de login:

```php
<?php
// ANTES (INSEGURO):
$qry = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";

// DESPUÉS (SEGURO):
$qry = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = mysqli_prepare($link, $qry);
mysqli_stmt_bind_param($stmt, 's', $usuario);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Verificar password con hash
    if (password_verify($password, $row['password_hash'])) {
        // Login exitoso
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['tipousuario'] = $row['tipousuario'];
        // ... resto del código
    } else {
        // Password incorrecto
        echo "Credenciales inválidas";
    }
} else {
    // Usuario no existe
    echo "Credenciales inválidas";
}
```

#### Paso 5: Actualizar cambio de contraseña

Modificar `cambiopass.php`:

```php
<?php
// Al cambiar password, usar password_hash
$nuevo_password = $_POST['nuevo_password'];
$password_hash = password_hash($nuevo_password, PASSWORD_BCRYPT);

$update = "UPDATE usuarios SET password_hash = ? WHERE usuario = ?";
$stmt = mysqli_prepare($link, $update);
mysqli_stmt_bind_param($stmt, 'ss', $password_hash, $usuario_actual);
mysqli_stmt_execute($stmt);
```

#### Paso 6: Eliminar columna antigua (DESPUÉS de probar)

```sql
-- SOLO después de verificar que todo funciona correctamente
-- y tener un backup completo
ALTER TABLE usuarios DROP COLUMN password;
```

### Mejores Prácticas de Passwords

```php
// Configuración recomendada
$options = [
    'cost' => 12, // Mayor = más seguro pero más lento
];
$hash = password_hash($password, PASSWORD_BCRYPT, $options);

// Verificación
if (password_verify($password_ingresado, $hash_almacenado)) {
    // Correcto
}

// Re-hashear si el algoritmo cambió
if (password_needs_rehash($hash, PASSWORD_BCRYPT, $options)) {
    $nuevo_hash = password_hash($password, PASSWORD_BCRYPT, $options);
    // Actualizar en BD
}
```

---

## Optimización de Consultas

### Patrones a EVITAR

#### ❌ Consultas Duplicadas
```php
// MAL - Query ejecutada 2 veces
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
    $total += $row['total'];
}

$result = mysql_query($sql); // DUPLICADO
while ($row = mysql_fetch_array($result)) {
    // procesar...
}
```

```php
// BIEN - Query ejecutada 1 vez
$result = mysql_query($sql);
$total = 0;
$rows = [];
while ($row = mysql_fetch_array($result)) {
    $total += $row['total'];
    $rows[] = $row;
}

foreach ($rows as $row) {
    // procesar...
}
```

#### ❌ N+1 Queries (Query en Loop)
```php
// MAL - 1 query + N queries adicionales
$result = mysql_query("SELECT * FROM cert2009 WHERE estado = 2");
while ($row = mysql_fetch_array($result)) {
    // Query adicional por cada fila
    $qry = "SELECT * FROM rut WHERE rut = '{$row['rut']}'";
    $res = mysql_query($qry);
    $nombre = mysql_result($res, 0, 'nombre');
}
```

```php
// BIEN - 1 query con JOIN
$sql = "SELECT c.*, r.nombre, r.apellidos 
        FROM cert2009 c 
        LEFT JOIN rut r ON c.rut = r.rut 
        WHERE c.estado = 2";
$result = mysql_query($sql);
while ($row = mysql_fetch_array($result)) {
    $nombre = $row['nombre']; // Ya está en el resultado
}
```

#### ❌ SELECT * para Contar
```php
// MAL - Trae todas las columnas de todas las filas
$result = mysql_query("SELECT * FROM cert2009 WHERE fecha_solicitud = '$hoy'");
$total = mysql_num_rows($result);
```

```php
// BIEN - Solo cuenta
$result = mysql_query("SELECT COUNT(*) as cnt FROM cert2009 WHERE fecha_solicitud = '$hoy'");
$row = mysql_fetch_array($result);
$total = $row['cnt'];
```

#### ❌ Funciones en WHERE que Impiden Índices
```php
// MAL - YEAR() impide uso del índice en fecha_solicitud
$sql = "SELECT * FROM cert2009 WHERE YEAR(fecha_solicitud) = '$anio'";
```

```php
// BIEN - Rango de fechas usa el índice
$inicio = "$anio-01-01";
$fin = "$anio-12-31";
$sql = "SELECT * FROM cert2009 WHERE fecha_solicitud >= '$inicio' AND fecha_solicitud <= '$fin'";
```

### Usar EXPLAIN para Analizar Queries

```sql
-- Ver cómo MySQL ejecuta la query
EXPLAIN SELECT c.*, r.nombre 
FROM cert2009 c 
LEFT JOIN rut r ON c.rut = r.rut 
WHERE c.estado = 2 
ORDER BY c.id DESC 
LIMIT 400;
```

**Buscar:**
- `type: ALL` = Full table scan (MALO)
- `type: ref` o `type: range` = Usa índice (BUENO)
- `rows: 155322` = Escanea todas las filas (MALO)
- `rows: 100` = Escanea pocas filas (BUENO)

---

## Seguridad SQL

### SQL Injection Prevention

#### ❌ NUNCA hacer esto:
```php
// VULNERABLE a SQL Injection
$rol = $_POST['rol'];
$sql = "SELECT * FROM cert2009 WHERE rol = '$rol'";
```

#### ✅ Usar Prepared Statements:
```php
// SEGURO - Prepared statement
$rol = $_POST['rol'];
$sql = "SELECT * FROM cert2009 WHERE rol = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, 's', $rol);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
```

#### ✅ O usar escape (menos seguro que prepared statements):
```php
// ACEPTABLE - Escape manual
$rol = mysqli_real_escape_string($link, $_POST['rol']);
$sql = "SELECT * FROM cert2009 WHERE rol = '$rol'";
```

### Validación de Entrada

```php
// Validar RUT
$rut = strtoupper(trim($_POST['rut']));
if (!preg_match('/^[0-9]{1,8}-[0-9K]$/', $rut)) {
    die("RUT inválido");
}

// Validar ROL
$rol = trim($_POST['rol']);
if (!preg_match('/^[0-9]{1,10}$/', $rol)) {
    die("ROL inválido");
}

// Validar fecha
$fecha = $_POST['fecha'];
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    die("Fecha inválida");
}
```

---

## Mantenimiento y Monitoreo

### Monitoreo de Performance

#### Ver queries lentas
```sql
-- Habilitar slow query log
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2; -- Queries > 2 segundos

-- Ver queries lentas
SELECT * FROM mysql.slow_log ORDER BY start_time DESC LIMIT 10;
```

#### Ver queries activas
```sql
-- Ver procesos actuales
SHOW PROCESSLIST;

-- Ver queries en ejecución
SELECT * FROM information_schema.processlist 
WHERE command != 'Sleep' 
ORDER BY time DESC;
```

#### Estadísticas de tablas
```sql
-- Ver tamaño de tablas
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS size_mb,
    table_rows
FROM information_schema.tables
WHERE table_schema = 'domsistemas'
ORDER BY size_mb DESC;
```

### Optimización de Tablas

```sql
-- Optimizar tabla (reorganiza datos y reconstruye índices)
OPTIMIZE TABLE cert2009;
OPTIMIZE TABLE rut;

-- Analizar tabla (actualiza estadísticas de índices)
ANALYZE TABLE cert2009;
ANALYZE TABLE rut;

-- Verificar integridad
CHECK TABLE cert2009;
CHECK TABLE rut;
```

### Limpieza de Datos

```sql
-- Eliminar registros antiguos (ejemplo: > 5 años)
DELETE FROM cert2009 
WHERE fecha_solicitud < DATE_SUB(NOW(), INTERVAL 5 YEAR)
LIMIT 1000; -- Por lotes para no bloquear

-- Archivar datos antiguos
CREATE TABLE cert2009_archivo LIKE cert2009;
INSERT INTO cert2009_archivo 
SELECT * FROM cert2009 
WHERE fecha_solicitud < '2020-01-01';

DELETE FROM cert2009 
WHERE fecha_solicitud < '2020-01-01';
```

---

## Backup y Recuperación

### Backup Completo

```bash
#!/bin/bash
# Script: backup_domsistemas.sh

FECHA=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/srv/backups/mysql"
DB_NAME="domsistemas"
DB_USER="root"

# Crear directorio si no existe
mkdir -p $BACKUP_DIR

# Backup completo
mysqldump -u $DB_USER -p $DB_NAME > $BACKUP_DIR/domsistemas_$FECHA.sql

# Comprimir
gzip $BACKUP_DIR/domsistemas_$FECHA.sql

# Eliminar backups > 30 días
find $BACKUP_DIR -name "domsistemas_*.sql.gz" -mtime +30 -delete

echo "Backup completado: domsistemas_$FECHA.sql.gz"
```

### Backup Solo Estructura (sin datos)

```bash
mysqldump -u root -p --no-data domsistemas > estructura_domsistemas.sql
```

### Backup Solo Datos (sin estructura)

```bash
mysqldump -u root -p --no-create-info domsistemas > datos_domsistemas.sql
```

### Backup de Tablas Específicas

```bash
mysqldump -u root -p domsistemas cert2009 rut usuarios > backup_tablas_criticas.sql
```

### Restaurar Backup

```bash
# Restaurar backup completo
mysql -u root -p domsistemas < domsistemas_20260409.sql

# Restaurar backup comprimido
gunzip < domsistemas_20260409.sql.gz | mysql -u root -p domsistemas
```

### Automatizar Backups (Cron)

```bash
# Editar crontab
crontab -e

# Agregar línea para backup diario a las 2 AM
0 2 * * * /srv/scripts/backup_domsistemas.sh >> /var/log/backup_domsistemas.log 2>&1
```

---

## Checklist de Seguridad y Performance

### ✅ Seguridad
- [ ] Contraseñas encriptadas con `password_hash()`
- [ ] Prepared statements en todas las queries con input de usuario
- [ ] Validación de entrada (RUT, ROL, fechas, etc.)
- [ ] Permisos de usuario MySQL limitados (no usar root en producción)
- [ ] Conexión SSL/TLS entre app y MySQL
- [ ] Backups automáticos diarios
- [ ] Logs de auditoría habilitados

### ✅ Performance
- [ ] Índices en todas las columnas usadas en WHERE, JOIN, ORDER BY
- [ ] No usar `SELECT *` innecesariamente
- [ ] No usar funciones en WHERE que impidan índices (YEAR, MONTH, etc.)
- [ ] Evitar N+1 queries (usar JOINs)
- [ ] LIMIT en queries que pueden retornar muchas filas
- [ ] Queries duplicadas eliminadas
- [ ] `EXPLAIN` ejecutado en queries críticas
- [ ] Slow query log habilitado y monitoreado

### ✅ Mantenimiento
- [ ] `OPTIMIZE TABLE` mensual
- [ ] `ANALYZE TABLE` semanal
- [ ] Monitoreo de tamaño de tablas
- [ ] Limpieza de datos antiguos
- [ ] Verificación de integridad mensual

---

## Comandos Útiles de Referencia

```bash
# Conectar a MySQL
mysql -u root -p domsistemas

# Ver bases de datos
SHOW DATABASES;

# Usar base de datos
USE domsistemas;

# Ver tablas
SHOW TABLES;

# Ver estructura de tabla
DESCRIBE cert2009;

# Ver índices
SHOW INDEX FROM cert2009;

# Ver tamaño de BD
SELECT 
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables
WHERE table_schema = 'domsistemas'
GROUP BY table_schema;

# Ver variables de configuración
SHOW VARIABLES LIKE 'innodb_buffer_pool_size';
SHOW VARIABLES LIKE 'max_connections';

# Ver status
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Uptime';
```

---

## Contacto y Soporte

Para problemas con la base de datos:
1. Revisar logs: `/var/log/mysql/error.log`
2. Verificar espacio en disco: `df -h`
3. Ver procesos MySQL: `SHOW PROCESSLIST;`
4. Contactar al administrador del sistema

**Última actualización:** 9 de Abril, 2026
