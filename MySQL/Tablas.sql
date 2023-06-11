drop database if exists bdm;
create database if not exists bdm;
use bdm;
#------------------------TABLA ADMINISTRADOR-------------------------#
drop table if exists administrador;
create table administrador(
	id_administrador		int				not null auto_increment,
    usuario					varchar(40)		not null,
    contra					varchar(40)		not null comment 'descripción de cada columna',
    
    primary key(id_administrador)
);

#----------------------------TABLA USUARIO----------------------------#
drop table if exists usuario;
create table usuario(
	id_usuario				int 			not null auto_increment,
	email 					varchar(250) 	not null unique,
	contra 					varchar(250) 	not null collate utf8_spanish_ci,
	rol 					varchar(50) 	not null,
	imagen 					longblob		not null,
	nombre 					varchar(200) 	not null,
	apellido_p 				varchar(200) 	not null,
	apellido_m 				varchar(200) 	not null,
	fch_nacimiento 			date 			not null,
	genero 					varchar(25) 	not null,
    errores					int				default 0 not null,
    baja_logica				bit				default 0 not null,
	fch_ingreso 			date 			default now() not null,
    
	primary key(id_usuario)
)engine=InnoDB auto_increment=261296 collate=utf8_unicode_ci;


#------------------------TABLA CURSO INSCRIOTO-----------------------#
drop table if exists curso_inscrito;
create table curso_inscrito(
	id_curso_inscrito		int				not null auto_increment,
    id_curso_f				int				not null,
    id_usuario_f			int				not null,
    nivel_actual			int				not null,
    finalizado				bit				not null,
    fecha_inscripcion		DATETIME		default now() not null,
    
    primary key(id_curso_inscrito)
)engine=InnoDB auto_increment=261296;
# alter table curso_inscrito add constraint fK_usuario	foreign key(id_usuario_f) 	references usuario(id_usuario);
# alter table curso_inscrito add constraint fk_curso		foreign key(id_curso_f) 	references curso(id_curso);


#----------------------------TABLA DIPLOMA-----------------------------#
drop table if exists diploma;
create table diploma(
	id_diploma				int				not null auto_increment,
    id_curso_inscrito_f		int				not null,
    imgen_diploma			longblob		not null,
    fecha_generado			date			default now() not null,
    
    primary key(id_diploma)
)engine=InnoDB auto_increment=261296;
# alter table diploma add constraint fk_curso_inscrito		foreign key(id_curso_inscrito_f) 	references curso_inscrito(id_curso_inscrito);

#----------------------------TABLA PAGO CURSO----------------------------#
drop table if exists pago_curso;
create table pago_curso(
	id_pago_curso			int				not null auto_increment,
    id_curso_inscrito_f		int				default 0,
    total					bit				not null,
    forma_pago				varchar(30)		not null,
    cantidad_pago			decimal(15, 2)	not null,
    nivel					int				default 0,
    
    primary key(id_pago_curso)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA MENSAJES----------------------------#
drop table if exists mensajes;
create table mensajes(
	id_mensajes				int				not null auto_increment,
    id_enviado_f			int				not null,
    id_recivido_f			int				not null,
    mensaje					varchar(500)	not null,
    fecha_envio				datetime		default now() not null,
    
    primary key(id_mensajes)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA LOG----------------------------#
drop table if exists log;
create table log(
	id_log					int				not null auto_increment,
    id_usuario_f			int				not null,
    cambio					varchar(200)	not null,
    fecha_cambio			datetime		default now(),
    
    primary key(id_log)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA CATEGORIA----------------------------#
drop table if exists categoria;
create table categoria(
	id_categoria			int				not null auto_increment,
    id_usuario_f			int				not null,
    titulo					varchar(64)		not null,
    descripcion				varchar(500)	not null,
    fecha_creacion			date			default(now()) not null,
    baja_logica				bit				default 0 not null,
    
    primary key(id_categoria)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA CURSO----------------------------#
drop table if exists curso;
create table curso(
	id_curso				int				not null auto_increment,
    id_usuario_f			int				not null,
	titulo					varchar(64)		not null,
    descripcion				varchar(500)	not null,
    #promedio consulta
	activo					bit				default 1 not null,
    imagen					longblob		not null,
    costo					decimal(15, 2)	not null,
    
    primary key(id_curso)
)engine=InnoDB auto_increment=261296;

#----------------------TABLA MM_CURSO_CATEGORIA---------------------#
drop table if exists mm_curso_categoria;
create table mm_curso_categoria(
	id_mm_curso_categoria	int				not null auto_increment,
    id_curso_f				int				not null,
    id_categoria_f			int				not null,
    
    primary key(id_mm_curso_categoria)
);

#----------------------------TABLA NIVEL----------------------------#
drop table if exists nivel;
create table nivel(
	id_nivel				int				not null auto_increment,
    id_curso_f				int				not null,
    titulo					varchar(64)		not null,
    resumen					varchar(300)	not null,
    contenido				varchar(2000)	not null,
	costo					decimal(15, 2)	not null,
    video					longblob		not null,
    baja_logica				bit				default 0 not null,
    
    primary key(id_nivel)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA RECURSOS----------------------------#
drop table if exists recursos;
create table recursos(
	id_recursos				int				not null auto_increment,
    id_nivel_f				int				not null,
    nombre					varchar(128)	not null,
    tipo					varchar(64)		not null,
    contenido				longblob		not null,
    
	primary key(id_recursos)
)engine=InnoDB auto_increment=261296;

#----------------------------TABLA COMENTARIO----------------------------#
drop table if exists comentario;
create table comentario(
	id_comentario			int				not null auto_increment,
    id_usuario_f			int				not null,
    id_curso_f				int				not null,
    comentario				varchar(300)	not null,
    calificacion			int				not null,
    fecha_comentario		datetime		default now(),

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