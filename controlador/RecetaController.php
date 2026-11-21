<?php
require_once __DIR__ . "/../modelo/Receta.php";
require_once __DIR__ . "/../modelo/Ingrediente.php";
require_once __DIR__ . "/../modelo/RecetaDao.php";
require_once __DIR__ . "/../modelo/CategoriaDao.php";
require_once __DIR__ . "/../servicio/ApiRecetasService.php";

class RecetaController
{
    private $dao;
    private $categoriaDao;

    // CONSTRUCTOR
    public function __construct($conexion)
    {
        $this->dao = new RecetaDao($conexion);
        $this->categoriaDao = new CategoriaDao($conexion);
    }

    // INICIO (Pantalla 1): ingreso de ingredientes, categorías y recetas destacadas
    public function index()
    {
        $categorias = $this->categoriaDao->listar();
        $destacadas = $this->dao->destacadas(6);
        require __DIR__ . "/../vista/recetas/index.php";
    }

    // CONFIRMAR INGREDIENTES (Pantalla 2)
    public function confirmar()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header("Location: index.php");
            exit;
        }
        $texto = trim($_POST["ingredientes"] ?? "");
        $ingredientes = Ingrediente::listaDesdeTexto($texto);

        if (count($ingredientes) === 0) {
            Sesion::flash("warning", "Escribe o dicta al menos un ingrediente.");
            header("Location: index.php");
            exit;
        }
        require __DIR__ . "/../vista/recetas/confirmar.php";
    }

    public function buscar()
    {
        $crudos = isset($_GET["ingredientes"]) && is_array($_GET["ingredientes"]) ? $_GET["ingredientes"] : [];
        $ingredientes = Ingrediente::listaDesdeTexto(implode(",", array_map("strval", $crudos)));

        if (count($ingredientes) === 0) {
            Sesion::flash("warning", "Escribe o dicta al menos un ingrediente.");
            header("Location: index.php");
            exit;
        }

        $platos = RecetaDao::$platos;
        $platoElegido = in_array($_GET["plato"] ?? "", $platos, true) ? $_GET["plato"] : "";

        $filtros = [
            "tipo"           => in_array($_GET["tipo"] ?? "", ["desayuno", "almuerzo", "cena", "postre", "snack"], true) ? $_GET["tipo"] : "",
            "dificultad"     => in_array($_GET["dificultad"] ?? "", ["facil", "media", "dificil"], true) ? $_GET["dificultad"] : "",
            "tiempo"         => max(0, (int) ($_GET["tiempo"] ?? 0)),
            "solo_completas" => !empty($_GET["solo_completas"]) ? 1 : 0
        ];
        $hayFiltros = $filtros["tipo"] !== "" || $filtros["dificultad"] !== "" || $filtros["tiempo"] > 0 || $filtros["solo_completas"] === 1;

        // Todas las recetas que usan al menos uno de los ingredientes (de más a menos completa)
        $todas = $this->dao->buscar($ingredientes, $filtros);

        // Si los filtros no dejaron nada, se muestran las recetas sin filtros
        $filtrosIgnorados = false;
        if (empty($todas) && $hayFiltros) {
            $todas = $this->dao->buscar($ingredientes, []);
            $filtrosIgnorados = true;
            $filtros = ["tipo" => "", "dificultad" => "", "tiempo" => 0, "solo_completas" => 0];
        }

        // Cantidad de recetas por tipo de plato (sopas, segundos, ensaladas...)
        $conteo = array_fill_keys($platos, 0);
        foreach ($todas as $r) {
            $conteo[$r->getTipo_plato()] = ($conteo[$r->getTipo_plato()] ?? 0) + 1;
        }

        // Si eligió un tipo de plato, se muestran solo esos
        $recetas = $todas;
        if ($platoElegido !== "") {
            $recetas = array_values(array_filter($todas, function ($r) use ($platoElegido) {
                return $r->getTipo_plato() === $platoElegido;
            }));
        }

        // Ingredientes que el sistema todavía no tiene en ninguna receta
        $conocidos = $this->dao->ingredientesConocidos($ingredientes);
        $desconocidos = array_values(array_diff($ingredientes, $conocidos));

        // Si no hay nada, se sugieren recetas destacadas en lugar de mostrar un error
        $destacadas = empty($todas) ? $this->dao->destacadas(6) : [];

        // Datos para armar los enlaces (se conservan ingredientes y filtros)
        $consultaIng = "";
        foreach ($ingredientes as $ing) {
            $consultaIng .= "&ingredientes[]=" . urlencode($ing);
        }
        $consultaFiltros = "";
        foreach ($filtros as $k => $v) {
            if ($v !== "" && $v !== 0) {
                $consultaFiltros .= "&" . $k . "=" . urlencode((string) $v);
            }
        }

        // Integración con la API de TheMealDB (ideas internacionales con esos ingredientes)
        $api = (new ApiRecetasService())->sugerirPorIngredientes($ingredientes, 6);

        require __DIR__ . "/../vista/recetas/resultados.php";
    }

    // CATÁLOGO: todas las recetas con búsqueda, filtros y paginación
    public function catalogo()
    {
        $filtros = [
            "q"          => mb_substr(trim($_GET["q"] ?? ""), 0, 60),
            "categoria"  => max(0, (int) ($_GET["categoria"] ?? 0)),
            "plato"      => in_array($_GET["plato"] ?? "", RecetaDao::$platos, true) ? $_GET["plato"] : "",
            "tipo"       => in_array($_GET["tipo"] ?? "", ["desayuno", "almuerzo", "cena", "postre", "snack"], true) ? $_GET["tipo"] : "",
            "dificultad" => in_array($_GET["dificultad"] ?? "", ["facil", "media", "dificil"], true) ? $_GET["dificultad"] : "",
            "tiempo"     => max(0, (int) ($_GET["tiempo"] ?? 0)),
            "rapidas"    => !empty($_GET["rapidas"]) ? 1 : 0,
            "orden"      => in_array($_GET["orden"] ?? "", ["nombre", "rapidas", "recientes"], true) ? $_GET["orden"] : "nombre"
        ];

        $porPagina = 12;
        $total = $this->dao->contarCatalogo($filtros);
        $paginas = max(1, (int) ceil($total / $porPagina));
        $pagina = min(max(1, (int) ($_GET["pagina"] ?? 1)), $paginas);

        $recetas = $this->dao->catalogo($filtros, $pagina, $porPagina);
        $categorias = $this->categoriaDao->listar();

        // Parámetros de la URL (sin la página) para armar los enlaces de paginación
        $consulta = array_filter($filtros, function ($v) { return $v !== "" && $v !== 0; });

        require __DIR__ . "/../vista/recetas/catalogo.php";
    }

    // DETALLE DE UNA RECETA (Pantalla 4)
    public function detalle()
    {
        $id_receta = (int) ($_GET["id"] ?? 0);
        // El administrador puede ver también recetas desactivadas
        $receta = $this->dao->buscarPorId($id_receta, !Sesion::esAdmin());

        if ($receta === null) {
            Sesion::flash("danger", "La receta solicitada no existe.");
            header("Location: index.php");
            exit;
        }

        $crudos = isset($_GET["ing"]) && is_array($_GET["ing"]) ? $_GET["ing"] : [];
        $misIngredientes = Ingrediente::listaDesdeTexto(implode(",", array_map("strval", $crudos)));
        $ingredientes = $this->dao->listarIngredientes($id_receta);
        $pasos = $this->dao->listarPasos($id_receta);

        require __DIR__ . "/../vista/recetas/detalle.php";
    }

    // DETALLE DE UNA RECETA DE LA API (TheMealDB)
    public function apiDetalle()
    {
        $meal = (new ApiRecetasService())->detalle($_GET["id"] ?? "");
        if ($meal === null) {
            Sesion::flash("warning", "No se pudo cargar esa receta internacional. Revisa tu conexión a internet.");
            header("Location: index.php");
            exit;
        }
        require __DIR__ . "/../vista/recetas/api_detalle.php";
    }

    // "Sorpréndeme": receta aleatoria de la API
    public function apiAzar()
    {
        $meal = (new ApiRecetasService())->azar();
        if ($meal === null) {
            Sesion::flash("warning", "No se pudo conectar con el servicio de recetas. Intenta de nuevo más tarde.");
            header("Location: index.php");
            exit;
        }
        require __DIR__ . "/../vista/recetas/api_detalle.php";
    }
}
