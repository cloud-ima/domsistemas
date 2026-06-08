# Corrección de lentitud en Solicitudes y Confeccionar Certificado

## Problema

Al entrar a los módulos:

- `solicitud/list_solicitudes.php` — Solicitudes en Trámite
- `solicitud/list_solicitudes_ok.php` — Confeccionar Certificado

el sistema quedaba muy lento, entraba en aparente bucle o terminaba pegando el servicio web, obligando a reiniciar Apache.

## Causa

La tabla principal del periodo activo, `cert2009`, tenía más de 150.000 registros y solo contaba con índice primario por `id`.

Las consultas de los listados filtraban y ordenaban por campos como:

- `estado`
- `fecha_solicitud`
- `rut`
- `idcert`
- `rol`

Además, el `JOIN` con la tabla `rut` se hacía por `rut.rut`, campo que tampoco tenía índice.

Esto provocaba escaneos completos de tablas y uso de `filesort`/tablas temporales en MySQL.

## Solución Aplicada

Se ejecutó el archivo de índices críticos:

```bash
mysql -u root -p domsistemas < fix_indexes_compatible.sql
```

El archivo original `fix_indexes.sql` usaba `ALGORITHM=INPLACE`, pero el servidor MySQL no lo soportaba para esta operación:

```text
ERROR 1845 (0A000): ALGORITHM=INPLACE is not supported for this operation. Try ALGORITHM=COPY
```

Por eso se creó una versión compatible removiendo la cláusula `ALGORITHM=INPLACE`:

```bash
cp fix_indexes.sql fix_indexes_original.sql
sed 's/ ALGORITHM=INPLACE//g' fix_indexes.sql > fix_indexes_compatible.sql
```

## Índices Creados

En `cert2009`:

- `idx_estado`
- `idx_fecha_solicitud`
- `idx_rut`
- `idx_idcert`
- `idx_estado_id`
- `idx_estado_fecha`
- `idx_rol`

En `rut`:

- `idx_rut_rut`

En `usuarios`:

- `idx_usuario`

## Actualización de Estadísticas

Después de crear los índices se ejecutó:

```bash
mysql -u root -p domsistemas -e "ANALYZE TABLE cert2009, rut, usuarios;"
```

Resultado:

```text
domsistemas.cert2009  analyze  status  OK
domsistemas.rut       analyze  status  Table is already up to date
domsistemas.usuarios  analyze  status  OK
```

Luego se reinició Apache:

```bash
sudo systemctl restart apache2
```

## Verificación

Se verificó la existencia de índices con:

```bash
mysql -u root -p domsistemas -e "SHOW INDEX FROM cert2009; SHOW INDEX FROM rut; SHOW INDEX FROM usuarios;"
```

Y se confirmó que los módulos:

- Solicitudes en Trámite
- Confeccionar Certificado

volvieron a cargar correctamente.

## Nota

Esta corrección no cambia datos del sistema. Solo agrega índices para que MySQL pueda resolver más rápido las consultas existentes.

## Corrección adicional: filas duplicadas en listados

Después de aplicar índices se detectó que algunos registros se veían duplicados en:

- `solicitud/list_solicitudes.php`
- `solicitud/list_solicitudes_ok.php`

La causa no era que la solicitud estuviera duplicada en `cert2009`, sino que la tabla `rut` contiene algunos RUT repetidos. El listado hacía:

```sql
LEFT JOIN rut r ON c.rut = r.rut
```

Si un mismo `rut.rut` existe más de una vez, MySQL devuelve una fila por cada coincidencia, repitiendo visualmente la misma solicitud.

La consulta fue ajustada para unir contra un solo registro de `rut` por RUT, usando el mayor `rut.id` como registro vigente para mostrar `nombre` y `apellidos`.

Validación local:

```text
No syntax errors detected in solicitud/list_solicitudes_ok.php
No syntax errors detected in solicitud/list_solicitudes.php
```

Además se probó con solicitudes que antes se repetían por RUT duplicado y el resultado quedó con IDs únicos.
