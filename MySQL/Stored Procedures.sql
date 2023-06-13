use bdm;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_mmcursocategoria;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_mmcursocategoria`(
in	spid_mm_curso_categoria		int,
in	spid_curso_f 				int,
in	spid_categoria_f 			varchar(64),
in 	opcion						varchar(20)
)
SQL SECURITY INVOKER
begin
	if opcion =	'I' then
		INSERT INTO mm_curso_categoria(id_curso_f, id_categoria_f)
		VALUES(spid_curso_f, spid_categoria_f);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	if opcion = 'U' then    
		update mm_curso_categoria set
		id_curso_f = if(spid_curso_f <> '', spid_curso_f, id_curso_f),
		id_categoria_f = if(spid_categoria_f <> '', spid_categoria_f, id_categoria_f)
		where id_mm_curso_categoria = spid_mm_curso_categoria;
		
		select 1 as codigo,
		concat('registro modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		DELETE FROM mm_curso_categoria
		WHERE id_mm_curso_categoria = spid_mm_curso_categoria;

        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_calificacion;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_calificacion`(
in	id_comentario			int,
in	id_usuario_f			int,
in	id_curso_f				int,
in	comentario				varchar(300),
in	calificacion			int,
in	fecha_comentario		datetime,
in	opcion					varchar(100)
)
SQL SECURITY INVOKER
begin
	if opcion =	'I' then
		INSERT INTO comentario(id_usuario_f, id_curso_f, comentario, calificacion)
		VALUES(id_usuario_f, id_curso_f, comentario, calificacion);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	/*if opcion = 'U' then    
		update usuario set
		contra = if(sp_contra <> '', sp_contra, contra),
		imagen = if(sp_imagen <> '', sp_imagen, imagen),
		nombre = if(sp_nombre <> '', sp_nombre, nombre),
		apellido_p = if(sp_apellido_p <> '', sp_apellido_p, apellido_p),
		apellido_m = if(sp_apellido_m <> '', sp_apellido_m, apellido_m),
		fch_nacimiento = if(sp_fch_nacimiento <> '', sp_fch_nacimiento, fch_nacimiento),
		genero = if(sp_genero <> '', sp_genero, genero)
		where id_usuario = (select id_usuario from usuario where email = sp_email);
		
		select 1 as codigo,
		concat('Usuario modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		update usuario set baja_logica = 1 
        WHERE id_usuario = (select id_usuario from usuario where email = sp_email);
        
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;*/
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_usuario;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario`(
in	sp_email 					varchar(250),
in	sp_contra 					varchar(250),
in	sp_rol 						varchar(50),
in	sp_imagen 					longblob,
in	sp_nombre 					varchar(200),
in	sp_apellido_p 				varchar(200),
in	sp_apellido_m 				varchar(200),
in	sp_fch_nacimiento 			date,
in	sp_genero 					varchar(25),
in 	opcion						varchar(2)
)
SQL SECURITY INVOKER
begin

	DECLARE EXIT HANDLER FOR 1062
		BEGIN
			SELECT 1062 as codigo,
            CONCAT('ERROR, El correo  (',sp_email,') ya esta en uso, vuelva intentar con otro correo') 
            AS mensaje;
		END;

	DECLARE EXIT HANDLER FOR 1146 
		SELECT 1146 as codigo,
        'Tabla no encontrada' as mensaje;
        
	#DECLARE EXIT HANDLER FOR SQLEXCEPTION 
	#	SELECT 100 as codigo,
     #   'Error en base de datos' as mensaje; 

	if opcion =	'I' then
		INSERT INTO usuario(email, contra, rol, imagen, nombre, apellido_p, apellido_m, fch_nacimiento, genero)
		VALUES(sp_email, sp_contra, sp_rol, sp_imagen, sp_nombre, sp_apellido_p, sp_apellido_m, sp_fch_nacimiento, sp_genero);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	if opcion = 'U' then    
		update usuario set
		contra = if(sp_contra <> '', sp_contra, contra),
		imagen = if(sp_imagen <> '', sp_imagen, imagen),
		nombre = if(sp_nombre <> '', sp_nombre, nombre),
		apellido_p = if(sp_apellido_p <> '', sp_apellido_p, apellido_p),
		apellido_m = if(sp_apellido_m <> '', sp_apellido_m, apellido_m),
		fch_nacimiento = if(sp_fch_nacimiento <> '', sp_fch_nacimiento, fch_nacimiento),
		genero = if(sp_genero <> '', sp_genero, genero)
		where id_usuario = (select id_usuario from usuario where email = sp_email);
		
		select 1 as codigo,
		concat('Usuario modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		update usuario set baja_logica = 1 
        WHERE id_usuario = (select id_usuario from usuario where email = sp_email);
        
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_usuario_inicio_sesion;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_usuario_inicio_sesion`(
in 	sp_email					varchar(250),
in	sp_contra 					varchar(250)
)
SQL SECURITY INVOKER
begin

	DECLARE EXIT HANDLER FOR 1146 
		SELECT 1146 as codigo,
        'Tabla no encontrada' as mensaje;
    
	set @temp_contra = (select contra from usuario where baja_logica = 0 and email = sp_email);
	set @temp_errores = (select errores from usuario where baja_logica = 0 and email = sp_email);
    if @temp_contra <> '' then
        if @temp_contra = sp_contra and @temp_errores < 3 then
			#update usuario set errores = 0 where id_usuario = (select id_usuario from usuario  where baja_logica = 0 and email = sp_email);
			UPDATE usuario SET errores = 0 WHERE id_usuario IN (SELECT id_usuario FROM (SELECT id_usuario FROM usuario WHERE baja_logica = 0 AND email = sp_email) AS temp);
            select * from usuario where baja_logica = 0 and email = sp_email and contra = sp_contra;
		else
			if @temp_errores < 3 then
				#update usuario set errores = errores + 1 where id_usuario = (select id_usuario from usuario  where baja_logica = 0 and email = sp_email);
				UPDATE usuario SET errores = errores + 1 WHERE id_usuario IN (SELECT id_usuario FROM (SELECT id_usuario FROM usuario WHERE baja_logica = 0 AND email = sp_email) AS temp);
                select CONCAT('te quedan ', (3 - (@temp_errores + 1)), ' intentos') as mensaje;
            else
				select 'cuenta bloqueada' as mensaje;
            end if;
        end if;
	else
		select 'correo no registrado' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_nivel;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_nivel`(
in sp_idnivel 		int,
in sp_idcursof		int,
in sp_titulo 		varchar(64),
in sp_resumen 		varchar(300),
in sp_contenido 	varchar(2000),
in sp_costo		 	decimal(15, 2),
in sp_video			longblob,
in opcion 			varchar(100)
)
SQL SECURITY INVOKER
begin
	
    if opcion =	'I' then
		INSERT INTO nivel(id_curso_f, titulo, resumen, contenido, costo, video)
		VALUES(sp_idcursof, sp_titulo, sp_resumen, sp_contenido, sp_costo, sp_video);
        SELECT LAST_INSERT_ID() as idnivel, 1 as codigo, concat('registro exitoso') as mensaje;
		
		#select 1 as codigo,
		#concat('registro exitoso') as mensaje;
	end if;
    
    if opcion = 'U' then    
		update nivel set
		id_curso_f = if(sp_idcursof <> '', sp_idcursof, id_curso_f),
		titulo = if(sp_titulo <> '', sp_titulo, titulo),
		resumen = if(sp_resumen <> '', sp_resumen, resumen),
		contenido = if(sp_contenido <> '', sp_contenido, contenido),
		costo = if(sp_costo <> '', sp_costo, costo),
		video = if(sp_video <> '', sp_video, video)
		where id_nivel = sp_idnivel;
    
		select 1 as codigo,
		concat('Nivel modificado exitosamente') as mensaje;
	end if;
    
     if opcion = 'D' then 
		update nivel set baja_logica = 1 
        where id_nivel = sp_idnivel;
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
    
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_recursos;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_recursos`(
IN id 			INT,
IN id_nivel 	INT,
IN nombre 		VARCHAR(128),
IN tipo 		VARCHAR(64),
IN contenido 	LONGBLOB,
IN opcion		VARCHAR(2)
)
SQL SECURITY INVOKER
begin
	if opcion =	'I' then
        INSERT INTO recursos (id_nivel_f, nombre, tipo, contenido)
        VALUES (id_nivel, nombre, tipo, contenido);
	
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	if opcion = 'U' then    
        UPDATE recursos
        SET id_nivel_f = id_nivel,
            nombre = nombre,
            tipo = tipo,
            contenido = contenido
        WHERE id_recursos = id;
		
		select 1 as codigo,
		concat('Usuario modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
        UPDATE recursos
        SET baja_logica = 1
        WHERE id_recursos = id;
        
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_categoria;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categoria`(
in	sp_id_categoria					int,
in	sp_id_usuario_f 				int,
in	sp_titulo 						varchar(64),
in	sp_descripcion 					varchar(500),
in 	opcion						varchar(20)
)
SQL SECURITY INVOKER
begin
	if opcion = 'lista' then
		SELECT id_categoria, titulo
        FROM categoria WHERE baja_logica = 0;
    end if;

	if opcion =	'I' then
		INSERT INTO categoria(id_usuario_f, titulo, descripcion)
		VALUES(sp_id_usuario_f, sp_titulo, sp_descripcion);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	if opcion = 'U' then
    
    update categoria set
		titulo = if(sp_titulo <> '', sp_titulo, titulo),
		descripcion = if(sp_descripcion <> '', sp_descripcion, descripcion)
		where id_categoria = sp_id_categoria;
		
		select 1 as codigo,
		concat('Categoria modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		update categoria set baja_logica = 1 
        where id_categoria = sp_id_categoria;
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_curso;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_curso`(
in	sp_id_curso				int,
in  sp_id_usuario_f			int,
in	sp_titulo				varchar(64),
in	sp_descripcion			varchar(500),
in  sp_imagen				longblob,
in  sp_costo				decimal(15, 2),
in	opcion					varchar(20)
)
SQL SECURITY INVOKER
begin

	DECLARE EXIT HANDLER FOR 1146 
		SELECT 1146 as codigo,
        'Tabla no encontrada' as mensaje;
        
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
		SELECT 100 as codigo,
       'Error en base de datos' as mensaje;
       
	if opcion =	'I' then
		INSERT INTO curso(id_usuario_f, titulo, descripcion, imagen, costo)
		VALUES(sp_id_usuario_f, sp_titulo, sp_descripcion, sp_imagen, sp_costo);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
    
	if opcion = 'U' then    
		update curso set
		titulo = if(sp_titulo <> '', sp_titulo, titulo),
		descripcion = if(sp_descripcion <> '', sp_descripcion, descripcion),
		imagen = if(sp_imagen <> '', sp_imagen, imagen),
		costo = if(sp_costo <> '', sp_costo, costo)
		where id_curso = sp_id_curso;
		
		select 1 as codigo,
		concat('Curso modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		update curso set activo = 0 
        where id_curso = sp_id_curso
        ;
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_inscribir_curso;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_inscribir_curso`(
in sp_id_curso_inscrito int,
in sp_id_curso_f	int,
in sp_id_usuario_f int,
in sp_nivel_actual int,
in sp_finalizado bit,
in opcion varchar(100)
)
SQL SECURITY INVOKER
begin

	DECLARE EXIT HANDLER FOR 1146 
		SELECT 1146 as codigo,
        'Tabla no encontrada' as mensaje;
        
	DECLARE EXIT HANDLER FOR SQLEXCEPTION 
		SELECT 100 as codigo,
        'Error en base de datos' as mensaje; 
        
	if opcion = 'finalizarcursoinscrito' then
		UPDATE curso_inscrito
		SET finalizado = 1
		WHERE id_curso_inscrito = sp_id_curso_inscrito;
        SELECT sp_id_curso_inscrito as id_curso_inscrito, 1 as codigo, concat("registro exitoso") as mensaje;	
    end if;

	if opcion =	'I' then
		INSERT INTO curso_inscrito(id_curso_f, id_usuario_f, nivel_actual, finalizado, fecha_inscripcion) 
        VALUES(sp_id_curso_f, sp_id_usuario_f, sp_nivel_actual, 0, CURRENT_TIMESTAMP); 
        SELECT LAST_INSERT_ID() as idcursoinscrito, 1 as codigo, concat("registro exitoso") as mensaje;		
	end if;
    
	if opcion = 'U' then
    
    update curso_inscrito set
    id_curso_f = if(sp_id_curso_f <> '', sp_id_curso_f, id_curso_f),
    descripcion = if(sp_id_usuario_f <> '', sp_id_usuario_f, id_usuario_f),
    imagen = if(sp_nivel_actual <> 0, sp_nivel_actual, nivel_actual),
    costo = if(sp_finalizado <> 0, sp_finalizado, finalizado)
    where id_curso_inscrito = sp_id_curso_inscrito
    ;
    
     select 1 as codigo,
    concat('Categoria modificado exitosamente') as mensaje;
    end if;
    
     if opcion = 'D' then 
		update curso_inscrito set baja_logica = 1 
        where id_curso_inscrito = sp_id_curso_inscrito
        ;
        select 1 as codigo, 
        'Baja exitosa' as mensaje;
    end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_consulta;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consulta`(
in sp_id		 	int,
in sp_inicio		int,
in sp_cantidad 		int,
in opcion 			varchar(100)
)
SQL SECURITY INVOKER
begin
	if opcion = 'suma_total_alumnos' then
		SELECT SUM(total_alumnos) AS suma_total_alumnos
		FROM vista_pagos_cursos
		WHERE id_usuario = sp_id;
    end if;
    
	if opcion = 'CursoInscritoInfo' then
		select a.id_curso AS idcurso, a.titulo AS titulo_curso, a.descripcion AS descripcion_curso, a.imagen AS imagen_curso,
		b.id_curso_inscrito, b.fecha_inscripcion, b.finalizado, b.id_curso_inscrito
		from curso AS a
		JOIN curso_inscrito AS b
		ON b.id_curso_f = a.id_curso
		where b.id_usuario_f = sp_id;
	end if;
    
	if opcion =	'TotalRegistros' then
		SELECT COUNT(*) AS total_filas
		FROM (
			SELECT n.titulo AS nivel_titulo,
				   c.titulo AS curso_titulo,
				   c.descripcion AS curso_descripcion,
				   c.imagen AS curso_imagen,
				   r.id_nivel_f AS recurso_idnivel,
				   r.nombre AS recurso_nombre,
				   r.tipo AS recurso_tipo,
				   r.contenido AS recurso_contenido
			FROM Curso c
			JOIN Curso_Inscrito ci ON c.id_curso = ci.id_curso_f
			JOIN Nivel n ON c.id_curso = n.id_curso_f
			JOIN Recursos r ON n.id_nivel = r.id_nivel_f
			WHERE ci.id_usuario_f = sp_id
		) AS subquery;
	end if;

    if opcion = 'CursoInscritoAlumno' then
		SELECT n.titulo AS nivel_titulo,
		c.titulo AS curso_titulo, c.descripcion AS curso_descripcion, c.imagen AS curso_imagen,
		r.id_nivel_f AS recurso_idnivel, r.nombre AS recurso_nombre, r.tipo AS recurso_tipo, r.contenido AS recurso_contenido
		FROM Curso c
		JOIN Curso_Inscrito ci ON c.id_curso = ci.id_curso_f
		JOIN Nivel n ON c.id_curso = n.id_curso_f
		JOIN Recursos r ON n.id_nivel = r.id_nivel_f
		where ci.id_usuario_f = sp_id;
    end if;
    
	if opcion = 'VerCursoHistorial' then
		select id_curso, id_usuario_f, a.titulo as titulo_curso, a.descripcion as descripcion_curso, a.costo as costo_curso, a.imagen as imagen_curso,
		id_nivel, id_curso_f, b.titulo as titulo_nivel, resumen, b.costo as costo_nivel
		from curso as A
		JOIN nivel as B
		ON A.id_curso = B.id_curso_f
		WHERE a.id_curso = sp_id;
	end if;

	if opcion = 'VerCursoNivel' then
		select id_curso, id_usuario_f, a.titulo as titulo_curso, a.descripcion as descripcion_curso, a.costo as costo_curso, a.imagen as imagen_curso,
		id_nivel, id_curso_f, b.titulo as titulo_nivel, resumen, b.costo as costo_nivel
		from curso as A
		JOIN nivel as B
		ON A.id_curso = B.id_curso_f
		WHERE a.id_curso = sp_id AND a.activo = 1 AND b.baja_logica = 0;
	end if;
    
	if opcion =	'ListadoMaestro' then
		SELECT id_curso, id_usuario_f, titulo, descripcion, 
        activo, imagen, costo from curso 
        where id_usuario_f = sp_id
        LIMIT sp_inicio, sp_cantidad;
	end if;
        
	if opcion =	'TodosCursosMaestro' then
		SELECT id_curso, id_usuario_f, titulo, descripcion, activo, imagen, costo from curso
        where id_usuario_f = sp_id;
	end if;
        
	if opcion =	'LosMasVistos' then
		select a.id_curso, a.id_usuario_f, a.titulo, a.descripcion, a.activo, a.imagen, a.costo
		from curso as A
		JOIN nivel as B
		ON A.id_curso = B.id_curso_f
		WHERE a.activo = 1 AND b.baja_logica = 0  LIMIT 10;
	end if;
    
    if opcion =	'ListaCursosRecientes' then
		select id_curso, id_usuario_f, titulo, descripcion, activo, imagen, costo
		from vista_cursos_recientes
		LIMIT sp_inicio, sp_cantidad;
	end if;
    
    if opcion = 'TotalRecursos' then
		SELECT id_recursos, id_nivel_f, nombre, tipo, contenido from recursos
        where id_nivel_f = sp_id;
    end if;
    
    if opcion = 'ListadoRecursos' then
		SELECT id_recursos, id_nivel_f, nombre, tipo, contenido from recursos
        where id_nivel_f = sp_id
        LIMIT sp_inicio, sp_cantidad;
    end if;
    
    if opcion = 'TotalNiveles' then
		SELECT id_nivel, id_curso_f, titulo, resumen, contenido, costo, video, baja_logica from nivel
        where id_curso_f = sp_id and baja_logica = 0;
    end if;
    
    if opcion = 'ListadoNiveles' then
		SELECT id_nivel, id_curso_f, titulo, resumen, contenido, costo, video, baja_logica from nivel
        where id_curso_f = sp_id and baja_logica = 0
        LIMIT sp_inicio, sp_cantidad;
    end if;
    
    if opcion = 'TotalCategorias' then
		SELECT id_categoria, id_usuario_f, titulo, descripcion, fecha_creacion, baja_logica from categoria
        where id_usuario_f = sp_id AND baja_logica = 0;
    end if;
    
    if opcion = 'ListadoCategorias' then
		SELECT id_categoria, id_usuario_f, titulo, descripcion, fecha_creacion from categoria
        WHERE id_usuario_f = sp_id AND baja_logica = 0
        LIMIT sp_inicio, sp_cantidad;
    end if;
    
    if opcion = 'CostoCurso' then
		select costo, titulo from curso where id_curso = sp_id;
	end if;
end$$
DELIMITER ;
#------------------------------------------------------#
DROP PROCEDURE IF EXISTS sp_vista;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_vista`(
in spid				int,
in opcion 			varchar(100)
)
SQL SECURITY INVOKER
begin
	if opcion = 'diploma' then
		select id_curso_inscrito as idcurso, id_usuario_f as id_alumno, titulo, 
        fecha_generado as fecha_finalizado, nombre_alumno, nombre_profesor 
		from vista_diploma where id_curso_inscrito = spid;
    end if;

	if opcion = 'vista_recursos_curso_historial' then
		SELECT id_recursos, nombre, tipo, contenido, titulo, id_curso
		FROM vista_recursos_curso_historial
        WHERE id_curso = spid;
	end if;
	if opcion = 'vista_recursos' then
		SELECT nombre, tipo, contenido, id_nivel_f
		FROM vista_recursos
        WHERE id_nivel_f = spid;
	end if;
    
	if opcion = 'vista_pagos_cursos' then
		SELECT id_pago_curso, forma_pago, titulo, total_ventas, total_alumnos, id_usuario
		FROM vista_pagos_cursos 
        WHERE id_usuario = spid;
	end if;
    
	if opcion = 'vista_curso' then
		SELECT id_curso, id_usuario_f, titulo, descripcion, activo, imagen, costo
		FROM vista_curso;
	end if;
    
    if opcion = 'vista_curso_porusuario' then
		SELECT id_curso, id_usuario_f, titulo, descripcion, activo, imagen, costo
		FROM vista_curso
        where id_curso = spid;
	end if;
    
	if opcion = 'vista_recursos_curso' then
		SELECT id_cursoinscrito, curso_titulo, curso_imagen, id_recurso, recurso_nombre, nivel_titulo, nivel_id, recurso_tipo, contenido 
        from vista_recursos_curso
        where id_cursoinscrito = spid;
	end if;
    
	if opcion = 'vista_curso_inscrito' then
		SELECT vista.fecha_inscripcion, vista.finalizado, vista.id_usuario_f, vista.titulo, vista.id_curso, vista.fecha_generado
		FROM vista_curso_inscrito AS vista
		WHERE vista.id_usuario_f = spid;
	end if;
    
	if opcion = 'vista_curso_nivel' then
		SELECT id_curso, id_usuario_f, titulo_curso, descripcion_curso, costo_curso, 
        imagen_curso, id_nivel, id_curso_f, titulo_nivel, resumen, costo_nivel
		FROM vista_curso_nivel;
	end if;  
    
    if opcion = 'vista_usuarios' then
		select id_usuario, email, nombre, apellido_p, apellido_m
		from vista_usuarios;
	end if;
end$$
DELIMITER ;
DROP PROCEDURE IF EXISTS sp_pagocurso;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pagocurso`(
in	sp_id_pago_curso			int,
in	sp_id_curso_inscrito_f		int,
in	sp_total					bit,
in	sp_forma_pago				varchar(30),
in	sp_cantidad_pago			decimal(15, 2),
in	sp_nivel					int,
in 	opcion					varchar(2)
)
SQL SECURITY INVOKER
begin
	if opcion =	'I' then
		INSERT INTO pago_curso(id_curso_inscrito_f,total,forma_pago,cantidad_pago,nivel)
		VALUES(sp_id_curso_inscrito_f,sp_total,sp_forma_pago,sp_cantidad_pago,sp_nivel);
		
		select 1 as codigo,
		concat('registro exitoso') as mensaje;
	end if;
end$$
DELIMITER ;
#------------------------------------------------------#