# Instrucciones para Proteger phpMyAdmin

## Contexto
phpMyAdmin no fue encontrado en ubicaciones comunes del sistema. Sin embargo, si estás usando **Laravel Herd**, es probable que accedas a la base de datos mediante:

1. **DBngin** (gestor de bases de datos incluido en Herd)
2. **TablePlus** u otro cliente SQL
3. **phpMyAdmin** instalado manualmente

## Opciones de Protección

### Opción 1: Si usas phpMyAdmin instalado manualmente

Si tienes phpMyAdmin instalado en alguna ubicación, aplica estas medidas:

#### 1.1 Renombrar la carpeta
```bash
# Ejemplo: si está en C:\phpmyadmin
# Renombrar a algo no obvio
mv C:\phpmyadmin C:\gestion_db_2026_secure
```

#### 1.2 Proteger con .htaccess
Crear archivo `.htaccess` dentro de la carpeta de phpMyAdmin:

```apache
# Permitir acceso solo desde localhost
Order Deny,Allow
Deny from all
Allow from 127.0.0.1
Allow from ::1

# Autenticación adicional (opcional)
AuthType Basic
AuthName "Área Restringida"
AuthUserFile /ruta/completa/.htpasswd
Require valid-user
```

#### 1.3 Crear archivo .htpasswd
```bash
# Generar usuario y contraseña
htpasswd -c .htpasswd admin_usuario
```

### Opción 2: Si usas DBngin (recomendado para Herd)

DBngin ya viene protegido por defecto y solo es accesible localmente. No requiere configuración adicional.

### Opción 3: Deshabilitar phpMyAdmin completamente

Si no lo necesitas, la mejor opción es desinstalarlo:
```bash
# Detener servicio si existe
# Eliminar carpeta
rm -rf /ruta/a/phpmyadmin
```

## Alternativas Seguras

### TablePlus (Recomendado)
- Conexión local segura
- No expuesto a web
- Interfaz moderna

### Adminer (Alternativa ligera)
Si necesitas acceso web, usa Adminer en lugar de phpMyAdmin:
- Un solo archivo PHP
- Más ligero y seguro
- Fácil de proteger con .htaccess

```php
// adminer.php protegido
<?php
// Solo permitir desde localhost
if ($_SERVER['REMOTE_ADDR'] !== '127.0.0.1' && $_SERVER['REMOTE_ADDR'] !== '::1') {
    die('Acceso denegado');
}
include('adminer-4.8.1.php');
?>
```

## Verificación de Seguridad

Después de aplicar las medidas, verifica:

1. ✅ No se puede acceder desde IP externa
2. ✅ URL no es obvia (si renombraste)
3. ✅ Requiere autenticación adicional
4. ✅ No aparece en escaneos de puertos comunes

## Recomendación Final

Para **Laravel Herd**, la mejor práctica es:
- Usar **DBngin** para gestión local de BD
- Usar **TablePlus** o **DBeaver** como cliente SQL
- **NO exponer** phpMyAdmin en producción
- Si necesitas acceso remoto, usar **túnel SSH** en lugar de acceso web directo
