use bdm;
#-------------- VISTA CURSO RECIENTES --------------#
DROP VIEW IF EXISTS vista_cursos_recientes;
CREATE VIEW vista_cursos_recientes AS
SELECT A.id_curso, A.id_usuario_f, A.titulo, A.descripcion, A.activo, A.imagen, A.costo
FROM curso AS A 
JOIN nivel AS B ON A.id_curso = B.id_curso_f
WHERE A.activo = 1 AND B.baja_logica = 0
GROUP BY A.id_curso
order by a.id_curso desc;
#----------------------- VISTA PAGOS CURSOS -----------------------#
DROP VIEW IF EXISTS vista_pagos_cursos;
CREATE VIEW vista_pagos_cursos AS
SELECT a.id_pago_curso, a.forma_pago, curso.titulo, 
SUM(a.cantidad_pago) AS total_ventas, 
COUNT(curso_inscrito.id_usuario_f) AS total_alumnos, usuario.id_usuario
FROM pago_curso AS a
JOIN curso_inscrito ON a.id_curso_inscrito_f = curso_inscrito.id_curso_inscrito
JOIN curso ON curso_inscrito.id_curso_f = curso.id_curso
JOIN usuario ON curso.id_usuario_f = usuario.id_usuario
GROUP BY curso.titulo;
#------------------------ VISTA CURSO -----------------------#
DROP VIEW IF EXISTS vista_curso;
CREATE VIEW vista_curso AS
SELECT titulo, descripcion, imagen
FROM curso;
#---------------------- VISTA RECURSOS CURSO -----------------------#
DROP VIEW IF EXISTS vista_recursos_curso;
CREATE VIEW vista_recursos_curso AS
SELECT c.id_curso, ci.id_curso_inscrito AS id_cursoinscrito,
c.titulo AS curso_titulo, c.imagen AS curso_imagen, r.id_recursos AS id_recurso, r.nombre AS recurso_nombre, 
n.titulo AS nivel_titulo, n.id_nivel AS nivel_id, r.tipo recurso_tipo, r.contenido
FROM curso_inscrito ci
JOIN curso c ON ci.id_curso_f = c.id_curso
JOIN nivel n ON n.id_curso_f = c.id_curso
JOIN recursos r ON r.id_nivel_f = n.id_nivel;
#---------------- VISTA CURSO INSCRITO ----------------#
DROP VIEW IF EXISTS vista_curso_inscrito;
CREATE VIEW vista_curso_inscrito AS
SELECT curso_inscrito.id_curso_inscrito, curso_inscrito.fecha_inscripcion, curso_inscrito.finalizado, curso_inscrito.id_usuario_f, 
curso.titulo, curso.id_curso, if((select fecha_generado from diploma where id_curso_inscrito_f = curso_inscrito.id_curso_inscrito) != '', 
(select fecha_generado from diploma where id_curso_inscrito_f = curso_inscrito.id_curso_inscrito), '0000-00-00') as fecha_generado
FROM curso_inscrito
JOIN curso ON curso_inscrito.id_curso_f = curso.id_curso;
#-------------------- VISTA CURSO NIVEL --------------------#
DROP VIEW IF EXISTS vista_curso_nivel;
CREATE VIEW vista_curso_nivel AS
SELECT A.id_curso, A.id_usuario_f, A.titulo AS titulo_curso, A.descripcion AS descripcion_curso,
A.costo AS costo_curso, A.imagen AS imagen_curso, B.id_nivel, B.id_curso_f, B.titulo AS titulo_nivel, 
B.resumen, B.costo AS costo_nivel
FROM curso AS A
JOIN nivel AS B
ON A.id_curso = B.id_curso_f;
#-------------------- VISTA USUARIOS --------------------#
DROP VIEW IF EXISTS vista_usuarios;
CREATE VIEW vista_usuarios AS
SELECT id_usuario, email, nombre, apellido_p, apellido_m
FROM usuario;
#-------------------- VISTA CURSO --------------------#
DROP VIEW IF EXISTS vista_curso;
CREATE VIEW vista_curso AS
select id_curso, id_usuario_f, titulo, descripcion,
activo, imagen, costo from curso;
#-------------------- VISTA RECURSOS --------------------#
DROP VIEW IF EXISTS vista_recursos;
CREATE VIEW vista_recursos AS
SELECT nombre, tipo, contenido, id_nivel_f FROM recursos;
#-------------- VISTA RECURSOS_CURSO_HISTORIAL --------------#
DROP VIEW IF EXISTS vista_recursos_curso_historial;
CREATE VIEW vista_recursos_curso_historial AS
select recursos.id_recursos, recursos.nombre, recursos.tipo, recursos.contenido, 
curso.titulo, curso.id_curso
from recursos
JOIN nivel ON nivel.id_nivel = recursos.id_nivel_f
JOIN curso ON curso.id_curso = nivel.id_curso_f;
#---------------- VISTA DIPLOMA ----------------#
DROP VIEW IF EXISTS vista_diploma;
CREATE VIEW vista_diploma AS
SELECT 
	curso_inscrito.id_usuario_f,
	curso_inscrito.id_curso_inscrito,
	curso.titulo,
	diploma.fecha_generado,
    CONCAT(usuario.nombre, ' ',
    usuario.apellido_p, ' ',
    usuario.apellido_m, ' ') 
    as nombre_alumno, 
    (SELECT CONCAT(usuario.nombre, ' ', usuario.apellido_p, ' ', usuario.apellido_m)
		FROM usuario WHERE usuario.id_usuario = curso.id_usuario_f) AS nombre_profesor
FROM diploma
JOIN curso_inscrito ON diploma.id_curso_inscrito_f = curso_inscrito.id_curso_inscrito
JOIN curso ON curso_inscrito.id_curso_f = curso.id_curso
JOIN usuario ON curso_inscrito.id_usuario_f = usuario.id_usuario;
