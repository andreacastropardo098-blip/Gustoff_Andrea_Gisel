<?php

class Usuario
{
    private $id_usuario;
    private $nombre;
    private $correo;
    private $clave_hash;
    private $rol;
    private $activo;

    // CONSTRUCTOR
    public function __construct($id_usuario = null, $nombre = "", $correo = "", $clave_hash = "", $rol = "usuario", $activo = 1)
    {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->clave_hash = $clave_hash;
        $this->rol = $rol;
        $this->activo = $activo;
    }

    // GETTERS
    public function getId_usuario() { return $this->id_usuario; }
    public function getNombre() { return $this->nombre; }
    public function getCorreo() { return $this->correo; }
    public function getClave_hash() { return $this->clave_hash; }
    public function getRol() { return $this->rol; }
    public function getActivo() { return $this->activo; }

    // SETTERS
    public function setId_usuario($v) { $this->id_usuario = $v; }
    public function setNombre($v) { $this->nombre = $v; }
    public function setCorreo($v) { $this->correo = $v; }
    public function setClave_hash($v) { $this->clave_hash = $v; }
    public function setRol($v) { $this->rol = $v; }
    public function setActivo($v) { $this->activo = $v; }
}
