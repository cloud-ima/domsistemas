-- ============================================================
-- INDEXES CRITICOS para resolver CPU al 100%
-- Ejecutar en el servidor Ubuntu: mysql -u root -p domsistemas < fix_indexes.sql
-- ============================================================

-- cert2009: 155,322 filas sin ningun indice excepto PRIMARY(id)
-- El JOIN con rut hace full table scan de 155k x 38k = 6 BILLONES de comparaciones

ALTER TABLE cert2009 ADD INDEX idx_estado (estado);
ALTER TABLE cert2009 ADD INDEX idx_fecha_solicitud (fecha_solicitud);
ALTER TABLE cert2009 ADD INDEX idx_rut (rut);
ALTER TABLE cert2009 ADD INDEX idx_idcert (idcert);
ALTER TABLE cert2009 ADD INDEX idx_estado_id (estado, id);
ALTER TABLE cert2009 ADD INDEX idx_estado_fecha (estado, fecha_solicitud);

-- rut: 38,511 filas - el campo 'rut' NO tiene indice, solo 'id' (PK)
-- Todos los JOINs y WHERE buscan por rut.rut, no por rut.id
ALTER TABLE rut ADD INDEX idx_rut_rut (rut);

-- rut: busqueda por rol en consultas
ALTER TABLE cert2009 ADD INDEX idx_rol (rol);

-- usuarios: se busca por campo 'usuario' sin indice
ALTER TABLE usuarios ADD INDEX idx_usuario (usuario);
