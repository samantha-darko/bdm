use bdm;
DROP FUNCTION IF EXISTS desbloquear_usuario;
DELIMITER $$
CREATE FUNCTION desbloquear_usuario(F_email varchar(250)) 
RETURNS VARCHAR(250) 
begin 
	declare rtn varchar(250);
    set @temp_usuario = (select id_usuario from usuario where baja_logica = 0 and email = F_email);
    if @temp_usuario <> '' then
		update usuario set errores = 0 where id_usuario = @temp_usuario;
		set rtn = 'Usuario desbloqueado';
	else
		set rtn = 'No se encontro al usuario, verifique que ingreso el correo como a continuacion: usuario@example.com';
    end if;
	return rtn;
end$$
DELIMITER ;
#----------------------------------------------------------------------------#
DELIMITER $$
DROP FUNCTION IF EXISTS promedio;
CREATE FUNCTION promedio(id_curso INT)
RETURNS DECIMAL(10,2)
BEGIN
    DECLARE promedio DECIMAL(10,2);
    
    SELECT AVG(calificacion) INTO promedio
    FROM comentario
    WHERE id_curso_f = id_curso;
    
    RETURN promedio;
END$$
DELIMITER ;
