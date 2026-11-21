<?php

class Receta
{
    private $id_receta;
    private $nombre;
    private $descripcion;
    private $tipo_comida;
    private $dificultad;
    private $tiempo_minutos;
    private $porciones;
    private $imagen_url;
    private $porcentaje;
    private $faltantes;
    // Datos adicionales (categoría y estado)
    private $id_categoria = null;
    private $categoria = "";
    private $icono = "🍽";
    private $activa = 1;
    private $tipo_plato = "segundo";
    private $usados = [];   // ingredientes del usuario que usa la receta

    // CONSTRUCTOR
    public function __construct(
        $id_receta = null,
        $nombre = "",
        $descripcion = "",
        $tipo_comida = "ambos",
        $dificultad = "facil",
        $tiempo_minutos = 0,
        $porciones = 0,
        $imagen_url = "",
        $porcentaje = 0,
        $faltantes = []
    ) {
        $this->id_receta = $id_receta;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->tipo_comida = $tipo_comida;
        $this->dificultad = $dificultad;
        $this->tiempo_minutos = $tiempo_minutos;
        $this->porciones = $porciones;
        $this->imagen_url = $imagen_url;
        $this->porcentaje = $porcentaje;
        $this->faltantes = $faltantes;
    }

    // GETTERS
    public function getId_receta() { return $this->id_receta; }
    public function getNombre() { return $this->nombre; }
    public function getDescripcion() { return $this->descripcion; }
    public function getTipo_comida() { return $this->tipo_comida; }
    public function getDificultad() { return $this->dificultad; }
    public function getTiempo_minutos() { return $this->tiempo_minutos; }
    public function getPorciones() { return $this->porciones; }
    public function getImagen_url() { return $this->imagen_url; }
    public function getPorcentaje() { return $this->porcentaje; }
    public function getFaltantes() { return $this->faltantes; }
    public function getId_categoria() { return $this->id_categoria; }
    public function getCategoria() { return $this->categoria; }
    public function getIcono() { return $this->icono; }
    public function getActiva() { return $this->activa; }
    public function getTipo_plato() { return $this->tipo_plato; }
    public function getUsados() { return $this->usados; }

    // SETTERS
    public function setId_receta($v) { $this->id_receta = $v; }
    public function setNombre($v) { $this->nombre = $v; }
    public function setDescripcion($v) { $this->descripcion = $v; }
    public function setTipo_comida($v) { $this->tipo_comida = $v; }
    public function setDificultad($v) { $this->dificultad = $v; }
    public function setTiempo_minutos($v) { $this->tiempo_minutos = $v; }
    public function setPorciones($v) { $this->porciones = $v; }
    public function setImagen_url($v) { $this->imagen_url = $v; }
    public function setPorcentaje($v) { $this->porcentaje = $v; }
    public function setFaltantes($v) { $this->faltantes = $v; }
    public function setId_categoria($v) { $this->id_categoria = $v; }
    public function setCategoria($v) { $this->categoria = $v; }
    public function setIcono($v) { $this->icono = $v; }
    public function setActiva($v) { $this->activa = $v; }
    public function setTipo_plato($v) { $this->tipo_plato = $v; }
    public function setUsados($v) { $this->usados = $v; }
}
