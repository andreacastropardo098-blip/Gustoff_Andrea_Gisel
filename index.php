<?php
// ENRUTADOR: único punto de entrada. Aquí solo hay PHP (sin HTML);
// las pantallas están en la carpeta vista/.

require_once "configuracion/sesion.php";
require_once "configuracion/ayudas.php";
require_once "configuracion/database.php";

// Conexión a la base de datos
$database = new Database();
$conexion = $database->conectar();

// accion => [controlador, método, acceso]
// acceso: "publico" (cualquiera) | "login" (sesión iniciada) | "admin" (solo administrador)
$rutas = [
    // --- Público ---
    "index"        => ["RecetaController", "index",      "publico"],
    "confirmar"    => ["RecetaController", "confirmar",  "publico"],
    "buscar"       => ["RecetaController", "buscar",     "publico"],
    "catalogo"     => ["RecetaController", "catalogo",   "publico"],
    "detalle"      => ["RecetaController", "detalle",    "publico"],
    "api_detalle"  => ["RecetaController", "apiDetalle", "publico"],
    "api_azar"     => ["RecetaController", "apiAzar",    "publico"],
    "login"        => ["AuthController",   "login",      "publico"],
    "registro"     => ["AuthController",   "registro",   "publico"],
    "salir"        => ["AuthController",   "salir",      "publico"],

    // --- Administrador ---
    "admin_panel"            => ["AdminController", "panel",            "admin"],
    "admin_recetas"          => ["AdminController", "recetas",          "admin"],
    "admin_receta_form"      => ["AdminController", "recetaForm",       "admin"],
    "admin_receta_guardar"   => ["AdminController", "recetaGuardar",    "admin"],
    "admin_receta_estado"    => ["AdminController", "recetaEstado",     "admin"],
    "admin_receta_eliminar"  => ["AdminController", "recetaEliminar",   "admin"],
    "admin_categorias"       => ["AdminController", "categorias",       "admin"],
    "admin_categoria_guardar"  => ["AdminController", "categoriaGuardar",  "admin"],
    "admin_categoria_eliminar" => ["AdminController", "categoriaEliminar", "admin"],
    "admin_usuarios"         => ["AdminController", "usuarios",         "admin"],
    "admin_usuario_rol"      => ["AdminController", "usuarioRol",       "admin"],
    "admin_usuario_estado"   => ["AdminController", "usuarioEstado",    "admin"]
];

// Acción solicitada (si no existe, se muestra el inicio)
$accion = $_GET["accion"] ?? "index";
if (!is_string($accion) || !isset($rutas[$accion])) {
    $accion = "index";
}
[$clase, $metodo, $acceso] = $rutas[$accion];

// Protección CSRF para todos los formularios POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    Sesion::verificarToken();
}

// Control de acceso por rol
if ($acceso === "login") {
    Sesion::requerirLogin();
} elseif ($acceso === "admin") {
    Sesion::requerirAdmin();
}

// Ejecutar acción
require_once "controlador/" . $clase . ".php";
$controlador = new $clase($conexion);
$controlador->$metodo();
