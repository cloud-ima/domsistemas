-- ============================================================
-- INDEXES CRITICOS para resolver CPU al 100%
-- Ejecutar en el servidor Ubuntu: mysql -u root -p domsistemas < fix_indexes.sql
-- Este script se puede ejecutar multiples veces sin error
-- ============================================================

-- cert2009: 155,322 filas sin ningun indice excepto PRIMARY(id)
-- El JOIN con rut hace full table scan de 155k x 38k = 6 BILLONES de comparaciones

CREATE INDEX idx_estado ON cert2009 (estado) ALGORITHM=INPLACE;
CREATE INDEX idx_fecha_solicitud ON cert2009 (fecha_solicitud) ALGORITHM=INPLACE;
CREATE INDEX idx_rut ON cert2009 (rut) ALGORITHM=INPLACE;
CREATE INDEX idx_idcert ON cert2009 (idcert) ALGORITHM=INPLACE;
CREATE INDEX idx_estado_id ON cert2009 (estado, id) ALGORITHM=INPLACE;
CREATE INDEX idx_estado_fecha ON cert2009 (estado, fecha_solicitud) ALGORITHM=INPLACE;
CREATE INDEX idx_rol ON cert2009 (rol) ALGORITHM=INPLACE;

-- rut: 38,511 filas - el campo 'rut' NO tiene indice, solo 'id' (PK)
-- Todos los JOINs y WHERE buscan por rut.rut, no por rut.id
CREATE INDEX idx_rut_rut ON rut (rut) ALGORITHM=INPLACE;

-- usuarios: se busca por campo 'usuario' sin indice
CREATE INDEX idx_usuario ON usuarios (usuario) ALGORITHM=INPLACE;
