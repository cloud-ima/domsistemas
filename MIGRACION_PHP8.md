# Migración a PHP 8.3.6 - Sistema DOM

## Resumen de Cambios Realizados

### 1. Archivo de Conexión (`conexion.php`)
- Migrado de `mysql_*` (deprecado) a `mysqli`
- Creadas funciones de compatibilidad que emulan las funciones antiguas
- Configuración centralizada con constantes `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`

### 2. Short Open Tags
- Corregidos **77+ archivos** con `<?` a `<?php`
- Incluye todos los módulos: propiedades, solicitud, usuarios, etc.

### 3. Variables Superglobales
- Corregidos **65+ archivos** con acceso a `$_GET`, `$_POST`, `$_REQUEST`
- Agregado operador null coalescing (`??`) para evitar warnings

### 4. Archivos Modificados por Módulo

| Módulo | Archivos |
|--------|----------|
| Raíz | conexion.php, login.php, principal.php, validacion.php, seguridad.php, logout.php |
| Propiedades | index.php, propiedades.php, fichapropiedades.php, cert_*.php |
| Solicitud | solicitud.php, list_solicitudes.php, entregar.php, etc. |
| Usuarios | index.php, formulario.php, mantenedor.php |
| Otros | clases, destino, zonas, parametros, tipocertificado, etc. |

---

## Configuración en Servidor Ubuntu

### Requisitos
- **Apache:** 2.4.58
- **PHP:** 8.3.6
- **MySQL:** 8.x con mysqlnd
- **Extensiones PHP:** mysqli, curl, mbstring, session

### Pasos de Instalación

1. **Copiar archivos al servidor:**
   ```bash
   scp -r  usuario@servidor:/var/www/html/
   ```

2. **Configurar credenciales de BD:**
   Editar `conexion.php` líneas 9-12:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'tu_usuario');
   define('DB_PASS', 'tu_contraseña');
   define('DB_NAME', 'imaarica_domsistemas');
   ```

3. **Crear base de datos:**
   ```sql
   CREATE DATABASE imaarica_domsistemas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Importar estructura y datos:**
   ```bash
   mysql -u usuario -p imaarica_domsistemas < backup.sql
   ```

5. **Configurar permisos:**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/domsistemas
   sudo chmod -R 755 /var/www/html/domsistemas
   ```

6. **Verificar instalación:**
   Acceder a: `http://tu-servidor/test_php8_compatibility.php`

---

## Funciones de Compatibilidad

El archivo `conexion.php` incluye estas funciones que emulan el comportamiento antiguo:

| Función Antigua | Implementación |
|-----------------|----------------|
| `mysql_query()` | Usa `mysqli_query()` |
| `mysql_fetch_array()` | Usa `mysqli_fetch_array()` |
| `mysql_fetch_assoc()` | Usa `mysqli_fetch_assoc()` |
| `mysql_num_rows()` | Usa `mysqli_num_rows()` |
| `mysql_result()` | Usa `mysqli_data_seek()` + `mysqli_fetch_array()` |
| `mysql_insert_id()` | Usa `mysqli_insert_id()` |
| `mysql_affected_rows()` | Usa `mysqli_affected_rows()` |
| `mysql_real_escape_string()` | Usa `mysqli_real_escape_string()` |
| `mysql_close()` | Usa `mysqli_close()` |
| `mysql_error()` | Usa `mysqli_error()` |
| `mysql_connect()` | Usa `new mysqli()` |
| `mysql_select_db()` | Usa `mysqli_select_db()` |

---

## Scripts de Utilidad

| Archivo | Descripción |
|---------|-------------|
| `migrate_php8.php` | Corrige short open tags |
| `fix_php8_warnings.php` | Corrige acceso a superglobales |
| `test_php8_compatibility.php` | Verifica compatibilidad del sistema |

---

## Notas Importantes

1. **Encoding:** El sistema usa ISO-8859-1. Se recomienda migrar a UTF-8 en el futuro.

2. **Seguridad:** Se recomienda:
   - Mover credenciales a variables de entorno
   - Implementar prepared statements para prevenir SQL injection
   - Agregar protección CSRF a formularios

3. **Librerías externas:** Los directorios `tcpdf/`, `impresion/`, `fckeditor/` no fueron modificados.

---

## Verificación Post-Migración

Ejecutar el test de compatibilidad:
```bash
php test_php8_compatibility.php
```

O acceder vía navegador:
```
http://tu-servidor/test_php8_compatibility.php
```

---

**Fecha de migración:** Enero 2026
**Versión PHP objetivo:** 8.3.6
**Servidor:** Apache/2.4.58 (Ubuntu)
