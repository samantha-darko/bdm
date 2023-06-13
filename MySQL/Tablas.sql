drop database if exists bdm;
create database if not exists bdm;
use bdm;
#------------------------TABLA ADMINISTRADOR-------------------------#
drop table if exists administrador;
create table administrador(
	id_administrador		int				not null auto_increment comment 'ID del Administrador',
    usuario					varchar(40)		not null comment 'Nombre de Usuario del Administrador',
    contra					varchar(40)		not null comment 'descripción de cada columna',
    
    primary key(id_administrador)
);

#----------------------------TABLA USUARIO----------------------------#
drop table if exists usuario;
create table usuario(
	id_usuario				int 			not null auto_increment comment 'ID del Usuario',
	email 					varchar(250) 	not null unique comment 'Correo del Usuario',
	contra 					varchar(250) 	not null collate utf8_spanish_ci comment 'Contraseña del Usuario',
	rol 					varchar(50) 	not null comment 'Rol de Usuario (Maestro/Alumno)',
	imagen 					longblob		not null comment 'Foto de Perfil del Usuario',
	nombre 					varchar(200) 	not null comment 'Nombre del Usuario',
	apellido_p 				varchar(200) 	not null comment 'Apellido Paterno del Usuario',
	apellido_m 				varchar(200) 	not null comment 'Apellido Materno del Usuario',
	fch_nacimiento 			date 			not null comment 'Fecha de Nacimiento del Usuario',
	genero 					varchar(25) 	not null comment 'Genero del Usuario (Hombre/Mujer)',
    errores					int				default 0 not null comment 'Intentos fallidos de iniciar sesion',
    baja_logica				bit				default 0 not null comment 'Cuenta eliminada',
	fch_ingreso 			date 			default now() not null comment 'Ultima fecha inicio de sesion',
    
	primary key(id_usuario)
)engine=InnoDB auto_increment=261296 collate=utf8_unicode_ci;

#------------------------TABLA CURSO INSCRIOTO-----------------------#
drop table if exists curso_inscrito;
create table curso_inscrito(
	id_curso_inscrito		int				not null auto_increment comment 'ID del Curso Inscrito',
    id_curso_f				int				not null comment 'ID del Curso',
    id_usuario_f			int				not null comment 'ID del Alumno',
    nivel_actual			int				not null comment 'ID del Nivel',
    finalizado				bit				not null comment 'Finalizacion del curso si/no',
    fecha_inscripcion		DATETIME		default now() not null comment 'Fecha de Inscripcion al curso',
    
    primary key(id_curso_inscrito)
)engine=InnoDB auto_increment=261296;
# alter table curso_inscrito add constraint fK_usuario	foreign key(id_usuario_f) 	references usuario(id_usuario);
# alter table curso_inscrito add constraint fk_curso		foreign key(id_curso_f) 	references curso(id_curso);


#----------------------------TABLA DIPLOMA-----------------------------#
drop table if exists diploma;
create table diploma(
	id_diploma				int				not null auto_increment comment 'ID del diploma',
    id_curso_inscrito_f		int				not null comment 'ID del Curso Inscrito',
    fecha_generado			date			default now() not null comment 'Fecha en que se genero el diploma',
    
    primary key(id_diploma)
)engine=InnoDB auto_increment=261296;
# alter table diploma add constraint fk_curso_inscrito		foreign key(id_curso_inscrito_f) 	references curso_inscrito(id_curso_inscrito);

#----------------------------TABLA PAGO CURSO----------------------------#
drop table if exists pago_curso;
create table pago_curso(
	id_pago_curso			int				not null auto_increment comment 'ID del Pago',
    id_curso_inscrito_f		int				default 0 comment 'ID del Curso Inscrito',
    total					bit				not null comment 'Total del Monto a Pagar',
    forma_pago				varchar(30)		not null comment 'Metodo de Pago',
    cantidad_pago			decimal(15, 2)	not null comment 'Cantidad Pagada',
    nivel					int				default 0 comment 'Nivel Pagado',
    
    primary key(id_pago_curso)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA MENSAJES----------------------------#
drop table if exists mensajes;
create table mensajes(
	id_mensajes				int				not null auto_increment comment 'ID del Mensaje',
    id_enviado_f			int				not null comment 'ID del Usuario que envia el mensaje',
    id_recivido_f			int				not null comment 'ID del Usuario que recibe el mensaje',
    mensaje					varchar(500)	not null comment 'Mensaje',
    fecha_envio				datetime		default now() not null comment 'Fecha de envio del mensaje',
    
    primary key(id_mensajes)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA LOG----------------------------#
drop table if exists log;
create table log(
	id_log					int				not null auto_increment comment 'ID del Log',
    id_usuario_f			int				not null comment 'ID del Usuario que genero el log',
    cambio					varchar(200)	not null comment 'Descripcion del cambio',
    fecha_cambio			datetime		default now() comment 'Fecha del cambio',
    
    primary key(id_log)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA CATEGORIA----------------------------#
drop table if exists categoria;
create table categoria(
	id_categoria			int				not null auto_increment comment 'ID de la Categoria',
    id_usuario_f			int				not null comment 'ID del Usuario',
    titulo					varchar(64)		not null comment 'Nombre de la Categoria',
    descripcion				varchar(500)	not null comment 'Descripcion de la Categoria',
    fecha_creacion			date			default(now()) not null comment 'Fecha de Creacion de la Categoria',
    baja_logica				bit				default 0 not null comment 'Eliminacion de la Categoria',
    
    primary key(id_categoria)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA CURSO----------------------------#
drop table if exists curso;
create table curso(
	id_curso				int				not null auto_increment comment 'ID del Curso',
    id_usuario_f			int				not null comment 'ID del Maestro que lo creo',
	titulo					varchar(64)		not null comment 'Titulo del Curso',
    descripcion				varchar(500)	not null comment 'Descripcion del Curso',
	activo					bit				default 1 not null comment 'Curso Activo',
    imagen					longblob		not null comment 'Imagen del Curso',
    costo					decimal(15, 2)	not null comment 'Costo del Curso',
    
    primary key(id_curso)
)engine=InnoDB auto_increment=261296;

#----------------------TABLA MM_CURSO_CATEGORIA---------------------#
drop table if exists mm_curso_categoria;
create table mm_curso_categoria(
	id_mm_curso_categoria	int				not null auto_increment comment 'ID del Curso-Categoria',
    id_curso_f				int				not null comment 'ID del Curso',
    id_categoria_f			int				not null comment 'ID de la Categoria',
    
    primary key(id_mm_curso_categoria)
);

#----------------------------TABLA NIVEL----------------------------#
drop table if exists nivel;
create table nivel(
	id_nivel				int				not null auto_increment comment 'ID del Nivel',
    id_curso_f				int				not null comment 'ID del Curso al que pertenece el nivel',
    titulo					varchar(64)		not null comment 'Titulo del Nivel',
    resumen					varchar(300)	not null comment 'Descripcion del Nivel',
    contenido				varchar(2000)	not null comment 'Contenido del Nivel',
	costo					decimal(15, 2)	not null comment 'Costo del Nivel',
    video					longblob		not null comment 'Video del Nivel',
    baja_logica				bit				default 0 not null comment 'Eliminacion del Video',
    
    primary key(id_nivel)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA RECURSOS----------------------------#
drop table if exists recursos;
create table recursos(
	id_recursos				int				not null auto_increment comment 'ID del Recurso',
    id_nivel_f				int				not null comment 'ID del Nivel al que pertenece el recurso',
    nombre					varchar(128)	not null comment 'Nombre del Recurso',
    tipo					varchar(64)		not null comment 'Tipo de Recurso',
    contenido				longblob		not null comment 'Recurso (Video/Imagen/PDF/etc)',
    
	primary key(id_recursos)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA COMENTARIO----------------------------#
drop table if exists comentario;
create table comentario(
	id_comentario			int				not null auto_increment comment 'ID del Comentario',
    id_usuario_f			int				not null comment 'ID del Usuario que hizo el comentario',
    id_curso_f				int				not null comment 'ID del Curso en donde se hizo el comentario',
    comentario				varchar(300)	not null comment 'Comentario',
    calificacion			int				not null comment 'Calificacion del Curso',
    fecha_comentario		datetime		default now() comment 'Fecha del Comentario',

	primary key(id_comentario)
)engine=InnoDB auto_increment=261296;

#========================CONSTRAINS=========================#
alter table curso_inscrito 		add constraint fK_usuario							foreign key(id_usuario_f) 			references usuario(id_usuario);
alter table curso_inscrito 		add constraint fk_curso								foreign key(id_curso_f) 			references curso(id_curso);
alter table diploma 			add constraint fk_curso_inscrito					foreign key(id_curso_inscrito_f) 	references curso_inscrito(id_curso_inscrito);
alter table pago_curso 			add constraint fk_curso_inscrito_pago_curso			foreign key(id_curso_inscrito_f) 	references curso_inscrito(id_curso_inscrito);
alter table mensajes 			add constraint fk_enviado							foreign key(id_enviado_f) 			references usuario(id_usuario);
alter table mensajes 			add constraint fk_recivido							foreign key(id_recivido_f) 			references usuario(id_usuario);
alter table log 				add constraint fk_usuario_log						foreign key(id_usuario_f) 			references usuario(id_usuario);
alter table categoria 			add constraint fk_usuario_categoria					foreign key(id_usuario_f) 			references usuario(id_usuario);
alter table curso 				add constraint fk_usuario_curso						foreign key(id_usuario_f) 			references usuario(id_usuario);
alter table mm_curso_categoria 	add constraint fk_curso_mm_curso_categoria			foreign key(id_curso_f) 			references curso(id_curso);
alter table mm_curso_categoria 	add constraint fk_categoria_mm_curso_categoria		foreign key(id_categoria_f) 		references categoria(id_categoria);
alter table nivel 				add constraint fk_curso_nivel						foreign key(id_curso_f) 			references curso(id_curso);
alter table recursos 			add constraint fk_nivel								foreign key(id_nivel_f) 			references nivel(id_nivel);
alter table comentario 			add constraint fk_usuario_comentario				foreign key(id_usuario_f) 			references usuario(id_usuario);
alter table comentario 			add constraint fk_curso_comentraio					foreign key(id_curso_f) 			references curso(id_curso);