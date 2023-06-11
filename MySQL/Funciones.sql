use bdm;
DROP FUNCTION IF EXISTS desbloquear_usuario;
DELIMITER $$
CREATE FUNCTION desbloquear_usuario(F_email varchar(250)) 
RETURNS VARCHAR(50) 
begin 
	declare rtn varchar(50);
    set @temp_usuario = (select id_usuario from usuario where baja_logica = 0 and email = F_email);
    if @temp_usuario <> '' then
		update usuario set errores = 0 where id_usuario = @temp_usuario;
		set rtn = 'Usuario desbloqueado';
	else
		set rtn = 'No se encontro al usuario';
    end if;
	return rtn;
end$$
DELIMITER ;