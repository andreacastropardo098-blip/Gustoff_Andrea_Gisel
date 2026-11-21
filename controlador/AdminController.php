<?php
require_once __DIR__ . "/../modelo/RecetaDao.php";
require_once __DIR__ . "/../modelo/CategoriaDao.php";
require_once __DIR__ . "/../modelo/UsuarioDao.php";

// Panel de administración (el router ya exige rol "administrador")
class AdminController
{
    private $recetaDao;
    private $categoriaDao;
    private $usuarioDao;

    private $tipos = ["desayuno", "almuerzo", "cena", "ambos", "postre", "snack"];
    private $dificultades = ["facil", "media", "dificil"];
    private $platos = ["sopa", "segundo", "ensalada", "desayuno", "postre", "snack"];

    public function __construct($conexion)
    {
        $this->recetaDao = new RecetaDao($conexion);
        $this->categoriaDao = new CategoriaDao($conexion);
        $this->usuarioDao = new UsuarioDao($conexion);
    }

    public function panel()
    {
        $recetasEstado = $this->recetaDao->contarPorEstado();
        $usuariosRol = $this->usuarioDao->contarPorRol();
        $totalIngredientes = $this->recetaDao->contarIngredientes();
        $categorias = $this->categoriaDao->listar();
        require __DIR__ . "/../vista/admin/panel.php";
    }
    // RECETAS: listar, buscar y filtrar
    private function filtrosRecetas()
    {
        $cat = $_GET["categoria"] ?? "";
        return [
            "q"         => mb_substr(trim($_GET["q"] ?? ""), 0, 60),
            "categoria" => $cat === "sin" ? "sin" : ((int) $cat > 0 ? (int) $cat : ""),
            "estado"    => in_array($_GET["estado"] ?? "", ["0", "1"], true) ? $_GET["estado"] : "",
            "tipo"      => in_array($_GET["tipo"] ?? "", ["desayuno", "almuerzo", "cena", "postre", "snack"], true) ? $_GET["tipo"] : ""
        ];
    }

    public function recetas()
    {
        $filtros = $this->filtrosRecetas();
        $lista = $this->recetaDao->listarAdmin($filtros);
        $categorias = $this->categoriaDao->listar();
        require __DIR__ . "/../vista/admin/recetas.php";
    }

   
    // RECETAS: formulario de crear / editar
    public function recetaForm()
    {
        $id = (int) ($_GET["id"] ?? 0);
        $errores = [];
        $datos = [
            "id_receta" => 0, "nombre" => "", "descripcion" => "", "id_categoria" => 0, "tipo_comida" => "almuerzo", "tipo_plato" => "segundo",
            "dificultad" => "facil", "tiempo_minutos" => 30, "porciones" => 2, "imagen_url" => "", "activa" => 1
        ];
        $ingredientes = [["nombre" => "", "cantidad" => "", "unidad" => "", "opcional" => 0]];
        $pasos = [""];

        if ($id > 0) {
            $r = $this->recetaDao->buscarPorId($id, false);
            if ($r === null) {
                Sesion::flash("danger", "La receta no existe.");
                header("Location: index.php?accion=admin_recetas");
                exit;
            }
            $datos = [
                "id_receta" => $id, "nombre" => $r->getNombre(), "descripcion" => $r->getDescripcion(),
                "id_categoria" => (int) $r->getId_categoria(), "tipo_comida" => $r->getTipo_comida(), "tipo_plato" => $r->getTipo_plato(),
                "dificultad" => $r->getDificultad(), "tiempo_minutos" => $r->getTiempo_minutos(),
                "porciones" => $r->getPorciones(), "imagen_url" => $r->getImagen_url(), "activa" => $r->getActiva()
            ];
            $ingredientes = [];
            foreach ($this->recetaDao->listarIngredientes($id) as $i) {
                $ingredientes[] = [
                    "nombre" => $i["nombre"], "cantidad" => formatearCantidad($i["cantidad"]),
                    "unidad" => $i["unidad"] ?? "", "opcional" => (int) $i["opcional"]
                ];
            }
            $pasos = array_column($this->recetaDao->listarPasos($id), "descripcion");
            if (empty($ingredientes)) { $ingredientes = [["nombre" => "", "cantidad" => "", "unidad" => "", "opcional" => 0]]; }
            if (empty($pasos)) { $pasos = [""]; }
        }
        $this->mostrarFormulario($datos, $ingredientes, $pasos, $errores);
    }

    private function mostrarFormulario($datos, $ingredientes, $pasos, $errores)
    {
        $categorias = $this->categoriaDao->listar();
        $sugerencias = $this->recetaDao->nombresIngredientes();
        $tipos = $this->tipos;
        $platos = $this->platos;
        require __DIR__ . "/../vista/admin/receta_form.php";
    }

    // RECETAS: guardar (crear o modificar) con validación en el servidor
    public function recetaGuardar()
    {
        $actual = $this->recetaDao->buscarPorId((int) ($_POST["id_receta"] ?? 0), false);
        $datos = [
            "id_receta"      => $actual ? (int) $_POST["id_receta"] : 0,
            "nombre"         => trim($_POST["nombre"] ?? ""),
            "descripcion"    => trim($_POST["descripcion"] ?? ""),
            "id_categoria"   => (int) ($_POST["id_categoria"] ?? 0),
            "tipo_comida"    => $_POST["tipo_comida"] ?? "",
            "tipo_plato"     => $_POST["tipo_plato"] ?? "",
            "dificultad"     => $_POST["dificultad"] ?? "",
            "tiempo_minutos" => $_POST["tiempo_minutos"] ?? "",
            "porciones"      => $_POST["porciones"] ?? "",
            "imagen_url"     => $actual ? $actual->getImagen_url() : "",
            "activa"         => !empty($_POST["activa"]) ? 1 : 0
        ];

        // ----- Ingredientes -----
        $ingredientes = [];
        $nombres = (array) ($_POST["ing_nombre"] ?? []);
        $cantidades = (array) ($_POST["ing_cantidad"] ?? []);
        $unidades = (array) ($_POST["ing_unidad"] ?? []);
        $opcionales = (array) ($_POST["ing_opcional"] ?? []);
        foreach ($nombres as $i => $nombre) {
            $nombre = trim((string) $nombre);
            $cantidad = trim((string) ($cantidades[$i] ?? ""));
            $unidad = trim((string) ($unidades[$i] ?? ""));
            if ($nombre === "" && $cantidad === "" && $unidad === "") {
                continue; // fila vacía
            }
            $ingredientes[] = [
                "nombre" => $nombre, "cantidad" => $cantidad, "unidad" => $unidad,
                "opcional" => (($opcionales[$i] ?? "0") === "1") ? 1 : 0
            ];
        }

        // ----- Pasos -----
        $pasos = [];
        foreach ((array) ($_POST["pasos"] ?? []) as $p) {
            $p = trim((string) $p);
            if ($p !== "") {
                $pasos[] = $p;
            }
        }

        // ----- Validaciones -----
        $errores = [];
        if (!Validador::texto($datos["nombre"], 3, 120)) {
            $errores[] = "El nombre debe tener entre 3 y 120 caracteres.";
        }
        if (mb_strlen($datos["descripcion"], "UTF-8") > 255) {
            $errores[] = "La descripción no puede pasar de 255 caracteres.";
        }
        if ($datos["id_categoria"] > 0 && $this->categoriaDao->buscarPorId($datos["id_categoria"]) === null) {
            $errores[] = "La categoría elegida no existe.";
        }
        if (!in_array($datos["tipo_comida"], $this->tipos, true)) {
            $errores[] = "Elige un tipo de comida válido.";
        }
        if (!in_array($datos["tipo_plato"], $this->platos, true)) {
            $errores[] = "Elige un tipo de plato válido (sopa, segundo, ensalada...).";
        }
        if (!in_array($datos["dificultad"], $this->dificultades, true)) {
            $errores[] = "Elige una dificultad válida.";
        }
        if (!Validador::entero($datos["tiempo_minutos"], 1, 1440)) {
            $errores[] = "El tiempo debe ser un número de minutos entre 1 y 1440.";
        }
        if (!Validador::entero($datos["porciones"], 1, 100)) {
            $errores[] = "Las porciones deben ser un número entre 1 y 100.";
        }
        if (empty($ingredientes)) {
            $errores[] = "Agrega al menos un ingrediente.";
        }
        foreach ($ingredientes as $n => $ing) {
            if (!Validador::texto($ing["nombre"], 2, 80)) {
                $errores[] = "Ingrediente " . ($n + 1) . ": el nombre debe tener entre 2 y 80 caracteres.";
            }
            if ($ing["cantidad"] !== "" && (!is_numeric($ing["cantidad"]) || $ing["cantidad"] < 0 || $ing["cantidad"] > 99999)) {
                $errores[] = "Ingrediente " . ($n + 1) . ": la cantidad debe ser un número positivo.";
            }
            if (mb_strlen($ing["unidad"], "UTF-8") > 30) {
                $errores[] = "Ingrediente " . ($n + 1) . ": la unidad no puede pasar de 30 caracteres.";
            }
        }
        if (empty($pasos)) {
            $errores[] = "Agrega al menos un paso de preparación.";
        }
        foreach ($pasos as $n => $p) {
            if (mb_strlen($p, "UTF-8") < 5 || mb_strlen($p, "UTF-8") > 500) {
                $errores[] = "Paso " . ($n + 1) . ": debe tener entre 5 y 500 caracteres.";
            }
        }

        // ----- Imagen: archivo subido, o enlace, o quitar -----
        $imagenAnterior = $datos["imagen_url"];
        $enlace = trim($_POST["imagen_enlace"] ?? "");
        if (!empty($_POST["quitar_imagen"])) {
            $datos["imagen_url"] = "";
        }
        if ($enlace !== "") {
            if (!preg_match('#^https?://#i', $enlace) || filter_var($enlace, FILTER_VALIDATE_URL) === false || strlen($enlace) > 255) {
                $errores[] = "El enlace de la imagen no es válido (debe comenzar con http:// o https://).";
            } else {
                $datos["imagen_url"] = $enlace;
            }
        }
        $archivoNuevo = null;
        if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE) {
            [$ruta, $errorImg] = $this->subirImagen($_FILES["imagen"]);
            if ($errorImg !== "") {
                $errores[] = $errorImg;
            } else {
                $archivoNuevo = $ruta;
                $datos["imagen_url"] = $ruta;
            }
        }

        if (!empty($errores)) {
            if ($archivoNuevo) { $this->borrarArchivoLocal($archivoNuevo); }
            $datos["imagen_url"] = $imagenAnterior;
            if (empty($ingredientes)) { $ingredientes = [["nombre" => "", "cantidad" => "", "unidad" => "", "opcional" => 0]]; }
            if (empty($pasos)) { $pasos = [""]; }
            $this->mostrarFormulario($datos, $ingredientes, $pasos, $errores);
            return;
        }

        try {
            $id = $this->recetaDao->guardar($datos, $ingredientes, $pasos);
        } catch (Throwable $e) {
            if ($archivoNuevo) { $this->borrarArchivoLocal($archivoNuevo); }
            $datos["imagen_url"] = $imagenAnterior;
            $this->mostrarFormulario($datos, $ingredientes, $pasos, ["No se pudo guardar la receta: " . $e->getMessage()]);
            return;
        }

        // Si la foto anterior era un archivo local y ya no se usa, se borra
        if ($imagenAnterior !== "" && $imagenAnterior !== $datos["imagen_url"]) {
            $this->borrarArchivoLocal($imagenAnterior);
        }

        Sesion::flash("success", $actual ? "Receta actualizada correctamente." : "Receta creada correctamente.");
        header("Location: index.php?accion=admin_recetas");
        exit;
    }

    private function subirImagen($archivo)
    {
        if ($archivo["error"] !== UPLOAD_ERR_OK) {
            return ["", "No se pudo subir la imagen (error " . (int) $archivo["error"] . "). El tamaño máximo es 2 MB."];
        }
        if ($archivo["size"] > 2 * 1024 * 1024) {
            return ["", "La imagen no puede pesar más de 2 MB."];
        }
        $info = @getimagesize($archivo["tmp_name"]);
        $extensiones = ["image/jpeg" => "jpg", "image/png" => "png", "image/webp" => "webp"];
        if ($info === false || !isset($extensiones[$info["mime"]])) {
            return ["", "La imagen debe ser JPG, PNG o WEBP."];
        }
        $carpeta = __DIR__ . "/../publico/img/recetas/";
        if (!is_dir($carpeta)) {
            @mkdir($carpeta, 0775, true);
        }
        $nombre = "receta_" . bin2hex(random_bytes(6)) . "." . $extensiones[$info["mime"]];
        if (!move_uploaded_file($archivo["tmp_name"], $carpeta . $nombre)) {
            return ["", "No se pudo guardar la imagen en el servidor."];
        }
        return ["publico/img/recetas/" . $nombre, ""];
    }

    // Borra solo archivos que están dentro de publico/img/recetas/
    private function borrarArchivoLocal($ruta)
    {
        if (preg_match('#^publico/img/recetas/receta_[a-f0-9]+\.(jpg|png|webp)$#', $ruta)) {
            $completa = __DIR__ . "/../" . $ruta;
            if (is_file($completa)) {
                @unlink($completa);
            }
        }
    }

    // RECETAS: activar / desactivar y eliminar
    public function recetaEstado()
    {
        $id = (int) ($_POST["id_receta"] ?? 0);
        $r = $this->recetaDao->buscarPorId($id, false);
        if ($r !== null) {
            $nuevo = $r->getActiva() ? 0 : 1;
            $this->recetaDao->cambiarEstado($id, $nuevo);
            Sesion::flash("success", $nuevo ? "Receta activada: ya se muestra al público." : "Receta desactivada: ya no se muestra al público.");
        }
        header("Location: " . urlSegura($_POST["volver"] ?? "", "index.php?accion=admin_recetas"));
        exit;
    }

    public function recetaEliminar()
    {
        $id = (int) ($_POST["id_receta"] ?? 0);
        $r = $this->recetaDao->buscarPorId($id, false);
        if ($r !== null) {
            $imagen = $r->getImagen_url();
            $this->recetaDao->eliminar($id);
            if ($imagen !== "") { $this->borrarArchivoLocal($imagen); }
            Sesion::flash("success", "Receta eliminada definitivamente.");
        }
        header("Location: index.php?accion=admin_recetas");
        exit;
    }

    // CATEGORÍAS (CRUD)
    public function categorias()
    {
        $categorias = $this->categoriaDao->listar();
        $editar = !empty($_GET["editar"]) ? $this->categoriaDao->buscarPorId((int) $_GET["editar"]) : null;
        require __DIR__ . "/../vista/admin/categorias.php";
    }

    public function categoriaGuardar()
    {
        $id = (int) ($_POST["id_categoria"] ?? 0);
        $nombre = trim($_POST["nombre"] ?? "");
        $icono = trim($_POST["icono"] ?? "");

        if (!Validador::texto($nombre, 2, 60)) {
            Sesion::flash("danger", "El nombre de la categoría debe tener entre 2 y 60 caracteres.");
        } elseif (mb_strlen($icono, "UTF-8") > 4) {
            Sesion::flash("danger", "El ícono debe ser un solo emoji (máximo 4 caracteres).");
        } elseif ($this->categoriaDao->existeNombre($nombre, $id)) {
            Sesion::flash("danger", "Ya existe una categoría con ese nombre.");
        } elseif ($id > 0) {
            $this->categoriaDao->actualizar($id, $nombre, $icono);
            Sesion::flash("success", "Categoría actualizada.");
        } else {
            $this->categoriaDao->crear($nombre, $icono);
            Sesion::flash("success", "Categoría creada.");
        }
        header("Location: index.php?accion=admin_categorias");
        exit;
    }

    public function categoriaEliminar()
    {
        $id = (int) ($_POST["id_categoria"] ?? 0);
        if ($this->categoriaDao->buscarPorId($id) !== null) {
            $this->categoriaDao->eliminar($id);
            Sesion::flash("success", "Categoría eliminada. Sus recetas quedaron sin categoría.");
        }
        header("Location: index.php?accion=admin_categorias");
        exit;
    }

    // USUARIOS (listar, cambiar rol, activar / desactivar)
    public function usuarios()
    {
        $filtros = [
            "q"      => mb_substr(trim($_GET["q"] ?? ""), 0, 60),
            "rol"    => in_array($_GET["rol"] ?? "", ["administrador", "usuario"], true) ? $_GET["rol"] : "",
            "estado" => in_array($_GET["estado"] ?? "", ["0", "1"], true) ? $_GET["estado"] : ""
        ];
        $lista = $this->usuarioDao->listar($filtros);
        require __DIR__ . "/../vista/admin/usuarios.php";
    }

    // Reglas: no puedes quitarte tu propio acceso y siempre debe quedar un administrador activo
    public function usuarioRol()
    {
        $id = (int) ($_POST["id_usuario"] ?? 0);
        $rol = $_POST["rol"] ?? "";
        $u = $this->usuarioDao->buscarPorId($id);

        if ($u === null || !in_array($rol, ["administrador", "usuario"], true)) {
            Sesion::flash("danger", "Datos no válidos.");
        } elseif ($id === Sesion::id()) {
            Sesion::flash("warning", "No puedes cambiar tu propio rol.");
        } else {
            $this->usuarioDao->cambiarRol($id, $rol);
            Sesion::flash("success", "Rol de " . $u->getNombre() . " actualizado.");
        }
        header("Location: index.php?accion=admin_usuarios");
        exit;
    }

    public function usuarioEstado()
    {
        $id = (int) ($_POST["id_usuario"] ?? 0);
        $u = $this->usuarioDao->buscarPorId($id);

        if ($u === null) {
            Sesion::flash("danger", "El usuario no existe.");
        } elseif ($id === Sesion::id()) {
            Sesion::flash("warning", "No puedes desactivar tu propia cuenta.");
        } else {
            $nuevo = $u->getActivo() ? 0 : 1;
            if ($nuevo === 0 && $u->getRol() === "administrador" && $this->usuarioDao->contarAdministradoresActivos() <= 1) {
                Sesion::flash("warning", "Debe quedar al menos un administrador activo.");
            } else {
                $this->usuarioDao->cambiarEstado($id, $nuevo);
                Sesion::flash("success", "Cuenta de " . $u->getNombre() . ($nuevo ? " activada." : " desactivada."));
            }
        }
        header("Location: index.php?accion=admin_usuarios");
        exit;
    }
}
