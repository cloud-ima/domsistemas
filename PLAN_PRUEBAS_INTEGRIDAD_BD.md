# Plan de pruebas de integridad de base de datos

Este plan valida que los datos de `domsistemas_Backup` estén correctamente migrados en `domsistemas`, manteniendo la estructura actual del sistema.

## Comandos

Ejecutar reporte legible:

```bash
php pruebas_integridad_bd.php
```

Ejecutar reporte JSON para auditoría o automatización:

```bash
php pruebas_integridad_bd.php --json
```

## Criterio de éxito

- `T01` a `T05`, `T07` y `T08` deben salir `PASS`.
- `T06` puede salir `WARN` si `domsistemas` conserva filas extra que no existen en `domsistemas_Backup`.
- Cualquier `FAIL` indica que la migración debe revisarse antes de usar el sistema como correcto.

## Pruebas cubiertas

- Mismo set de tablas entre ambas bases.
- Mismo charset y collation.
- Diferencias estructurales permitidas solo en `usuarios.password`.
- Todas las filas de `domsistemas_Backup` existen en `domsistemas`.
- Las filas compartidas coinciden en valores, excluyendo `usuarios.password` y `usuarios.session`.
- Las contraseñas de `domsistemas` están hasheadas y no hay sesiones activas.
- Existe una base de respaldo previa a la migración.

## Interpretación actual

El resultado esperado actual es `7 PASS`, `0 FAIL`, `1 WARN`.

El `WARN` corresponde a filas extra conservadas en `domsistemas`. No significa que falten datos del backup; significa que `domsistemas` no es una copia estrictamente idéntica porque mantiene registros adicionales.
