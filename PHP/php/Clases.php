<?php
class Usuario
{
    public $id_usuario;
    public $email;
    public $contra;
    public $rol;
    public $imagen;
    public $nombre;
    public $apellido_p;
    public $apellido_m;
    public $fch_nacimiento;
    public $genero;
    public $errores;
    public $baja_logica;
    public $fch_ingreso;

    public function __construct(
        $id_usuario,
        $email,
        $contra,
        $rol,
        $imagen,
        $nombre,
        $apellido_p,
        $apellido_m,
        $fch_nacimiento,
        $genero,
        $errores,
        $baja_logica,
        $fch_ingreso
    ) {
        $this->id_usuario = $id_usuario;
        $this->email = $email;
        $this->contra = $contra;
        $this->rol = $rol;
        $this->imagen = $imagen;
        $this->nombre = $nombre;
        $this->apellido_p = $apellido_p;
        $this->apellido_m = $apellido_m;
        $this->fch_nacimiento = $fch_nacimiento;
        $this->genero = $genero;
        $this->errores = $errores;
        $this->baja_logica = $baja_logica;
        $this->fch_ingreso = $fch_ingreso;
    }
}


class Curso
{
    public $id_curso;
    public $id_usuario_f;
    public $titulo;
    public $descripcion;
    public $activo;
    public $imagen;
    public $costo;

    public function __construct(
        $id_curso,
        $id_usuario_f,
        $titulo,
        $descripcion,
        $activo,
        $imagen,
        $costo
    ) {
        $this->id_curso = $id_curso;
        $this->id_usuario_f = $id_usuario_f;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->activo = $activo;
        $this->imagen = $imagen;
        $this->costo = $costo;
    }
}

class Nivel
{
    public $id_nivel;
    public $id_curso_f;
    public $titulo;
    public $resumen;
    public $contenido;
    public $costo;
    public $video;
    public $baja_logica;

    public function __construct(
        $id_nivel,
        $id_curso_f,
        $titulo,
        $resumen,
        $contenido,
        $costo,
        $video,
        $baja_logica
    ) {
        $this->id_nivel = $id_nivel;
        $this->id_curso_f = $id_curso_f;
        $this->titulo = $titulo;
        $this->resumen = $resumen;
        $this->contenido = $contenido;
        $this->costo = $costo;
        $this->video = $video;
        $this->baja_logica = $baja_logica;
    }
}

class Categoria
{
    public $id_categoria;
    public $id_usuario_f;
    public $titulo;
    public $descripcion;
    public $fecha_creacion;
    public $baja_logica;

    public function __construct(
        $id_categoria,
        $id_usuario_f,
        $titulo,
        $descripcion,
        $fecha_creacion,
        $baja_logica
    ) {
        $this->id_categoria = $id_categoria;
        $this->id_usuario_f = $id_usuario_f;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion;
        $this->baja_logica = $baja_logica;
    }
}