use bdm;
#----------------------- LOG CAMBIOS ---------------------------------#
DROP TRIGGER IF EXISTS insertar_log_contra;
DELIMITER $$
CREATE TRIGGER insertar_log_contra
AFTER UPDATE ON usuario
FOR EACH ROW
BEGIN
    IF NEW.contra <> OLD.contra THEN
        INSERT INTO log (id_usuario_f, cambio, fecha_cambio)
        VALUES (NEW.id_usuario, 'Se actualizó la contraseña', NOW());
    END IF;
END $$
DELIMITER ;
#----------------------- CREAR DIPLOMA -------------------------------#
DROP TRIGGER IF EXISTS insert_diploma_trigger;
DELIMITER $$
CREATE TRIGGER insert_diploma_trigger
AFTER UPDATE ON curso_inscrito
FOR EACH ROW
BEGIN
    IF NEW.finalizado = 1 THEN
        INSERT INTO diploma (id_curso_inscrito_f, fecha_generado)
        VALUES (NEW.id_curso_inscrito, CURDATE());
    END IF;
END $$
DELIMITER ;