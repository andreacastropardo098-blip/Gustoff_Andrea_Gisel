<?php
require_once __DIR__ . "/Receta.php";
require_once __DIR__ . "/Ingrediente.php";

class RecetaDao
{
    private $conexion;

    // CONSTRUCTOR
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Convierte una fila de la base de datos en un objeto Receta
    public static function aReceta($f, $porcentaje = 0, $faltantes = [])
    {
        $r = new Receta(
            $f["id_receta"], $f["nombre"], $f["descripcion"] ?? "", $f["tipo_comida"], $f["dificultad"],
            $f["tiempo_minutos"], $f["porciones"], $f["imagen_url"] ?? "", (int) $porcentaje, $faltantes
        );
        $r->setId_categoria($f["id_categoria"] ?? null);
        $r->setCategoria($f["categoria"] ?? "");
        $r->setIcono(!empty($f["icono"]) ? $f["icono"] : "🍽");
        $r->setActiva($f["activa"] ?? 1);
        $r->setTipo_plato($f["tipo_plato"] ?? "segundo");
        return $r;
    }

    // Condición SQL según el tipo de comida ("ambos" sirve para almuerzo y cena)
    private function condicionTipo($tipo, &$parametros)
    {
        if ($tipo === "almuerzo" || $tipo === "cena") {
            $parametros[] = $tipo;
            return " AND r.tipo_comida IN (?, 'ambos')";
        }
        $parametros[] = $tipo;
        return " AND r.tipo_comida = ?";
    }

    private static $tipos = ["desayuno", "almuerzo", "cena", "postre", "snack"];
    public static $platos = ["sopa", "segundo", "ensalada", "desayuno", "postre", "snack"];

    // BUSCAR RECETAS POR INGREDIENTES
    public function buscar($ingredientes, $filtros = [])
    {
        if (count($ingredientes) === 0) {
            return [];
        }

        $marcas = implode(",", array_fill(0, count($ingredientes), "?"));
        $parametros = array_merge($ingredientes, $ingredientes);
        $where = "";
        $having = "";

        if (!empty($filtros["tipo"]) && in_array($filtros["tipo"], self::$tipos, true)) {
            $where .= $this->condicionTipo($filtros["tipo"], $parametros);
        }
        if (!empty($filtros["dificultad"])) {
            $where .= " AND r.dificultad = ?";
            $parametros[] = $filtros["dificultad"];
        }
        if (!empty($filtros["tiempo"])) {
            $where .= " AND r.tiempo_minutos <= ?";
            $parametros[] = (int) $filtros["tiempo"];
        }
        if (!empty($filtros["solo_completas"])) {
            $having .= " AND t.tengo = t.total_req";
        }

        // La consulta interna calcula los totales; la externa filtra y ordena con ellos
        $sql = "SELECT * FROM (
                    SELECT r.*, c.nombre AS categoria, c.icono,
                           COUNT(*) AS total_req,
                           SUM(CASE WHEN i.es_basico = 1 OR i.nombre_normalizado IN ($marcas) THEN 1 ELSE 0 END) AS tengo,
                           SUM(CASE WHEN i.es_basico = 0 AND i.nombre_normalizado IN ($marcas) THEN 1 ELSE 0 END) AS coincidencias
                    FROM recetas r
                    LEFT JOIN categorias c ON c.id_categoria = r.id_categoria
                    JOIN receta_ingredientes ri ON ri.id_receta = r.id_receta AND ri.opcional = 0
                    JOIN ingredientes i ON i.id_ingrediente = ri.id_ingrediente
                    WHERE r.activa = 1 $where
                    GROUP BY r.id_receta, c.nombre, c.icono
                ) AS t
                WHERE t.coincidencias > 0 $having
                ORDER BY (t.tengo / t.total_req) DESC, t.coincidencias DESC, t.tiempo_minutos ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($parametros);
        $filas = $stmt->fetchAll();

        // Ingredientes de todas las recetas encontradas (una sola consulta)
        $detalle = $this->ingredientesDeRecetas(array_column($filas, "id_receta"));

        $recetas = [];
        foreach ($filas as $fila) {
            $porcentaje = round($fila["tengo"] * 100 / $fila["total_req"]);
            $faltantes = [];
            $usados = [];
            foreach ($detalle[$fila["id_receta"]] ?? [] as $ing) {
                $loTengo = !$ing["es_basico"] && in_array($ing["nombre_normalizado"], $ingredientes, true);
                if ($loTengo) {
                    $usados[] = $ing["nombre"];
                }
                if (!$ing["es_basico"] && !$loTengo && !$ing["opcional"]) {
                    $faltantes[] = $ing["nombre"];
                }
            }
            $r = self::aReceta($fila, $porcentaje, $faltantes);
            $r->setUsados($usados);
            $recetas[] = $r;
        }
        return $recetas;
    }

    // Ingredientes de varias recetas a la vez: [id_receta => [filas]]
    private function ingredientesDeRecetas($ids)
    {
        if (count($ids) === 0) {
            return [];
        }
        $marcas = implode(",", array_fill(0, count($ids), "?"));
        $stmt = $this->conexion->prepare("SELECT ri.id_receta, i.nombre, i.nombre_normalizado, i.es_basico, ri.opcional
                                          FROM receta_ingredientes ri
                                          JOIN ingredientes i ON i.id_ingrediente = ri.id_ingrediente
                                          WHERE ri.id_receta IN ($marcas)
                                          ORDER BY i.nombre");
        $stmt->execute(array_map("intval", $ids));
        $porReceta = [];
        foreach ($stmt->fetchAll() as $f) {
            $porReceta[$f["id_receta"]][] = $f;
        }
        return $porReceta;
    }

    // De la lista del usuario, cuáles ingredientes existen en la base de datos
    public function ingredientesConocidos($ingredientes)
    {
        if (count($ingredientes) === 0) {
            return [];
        }
        $marcas = implode(",", array_fill(0, count($ingredientes), "?"));
        $stmt = $this->conexion->prepare("SELECT nombre_normalizado FROM ingredientes WHERE nombre_normalizado IN ($marcas)");
        $stmt->execute(array_values($ingredientes));
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // CATÁLOGO con búsqueda y filtros (por nombre, categoría, tipo, dificultad, tiempo)
    private function armarFiltrosCatalogo($f, &$p)
    {
        $where = " WHERE r.activa = 1";
        if (!empty($f["q"])) {
            $like = "%" . $f["q"] . "%";
            $where .= " AND (r.nombre LIKE ? OR r.descripcion LIKE ? OR r.id_receta IN (
                            SELECT ri.id_receta FROM receta_ingredientes ri
                            JOIN ingredientes i ON i.id_ingrediente = ri.id_ingrediente
                            WHERE i.nombre LIKE ?))";
            array_push($p, $like, $like, $like);
        }
        if (!empty($f["categoria"])) {
            $where .= " AND r.id_categoria = ?";
            $p[] = (int) $f["categoria"];
        }
        if (!empty($f["plato"]) && in_array($f["plato"], self::$platos, true)) {
            $where .= " AND r.tipo_plato = ?";
            $p[] = $f["plato"];
        }
        if (!empty($f["tipo"]) && in_array($f["tipo"], self::$tipos, true)) {
            $where .= $this->condicionTipo($f["tipo"], $p);
        }
        if (!empty($f["dificultad"])) {
            $where .= " AND r.dificultad = ?";
            $p[] = $f["dificultad"];
        }
        if (!empty($f["tiempo"])) {
            $where .= " AND r.tiempo_minutos <= ?";
            $p[] = (int) $f["tiempo"];
        }
        if (!empty($f["rapidas"])) {
            $where .= " AND r.tiempo_minutos <= 30 AND r.dificultad = 'facil'";
        }
        return $where;
    }

    public function contarCatalogo($filtros)
    {
        $p = [];
        $where = $this->armarFiltrosCatalogo($filtros, $p);
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM recetas r $where");
        $stmt->execute($p);
        return (int) $stmt->fetchColumn();
    }

    public function catalogo($filtros, $pagina = 1, $porPagina = 12)
    {
        $p = [];
        $where = $this->armarFiltrosCatalogo($filtros, $p);

        $orden = [
            "nombre"    => "r.nombre ASC",
            "rapidas"   => "r.tiempo_minutos ASC, r.nombre ASC",
            "recientes" => "r.id_receta DESC"
        ];
        $ordenSql = $orden[$filtros["orden"] ?? "nombre"] ?? $orden["nombre"];
        $desde = max(0, ((int) $pagina - 1) * (int) $porPagina);

        $sql = "SELECT r.*, c.nombre AS categoria, c.icono
                FROM recetas r
                LEFT JOIN categorias c ON c.id_categoria = r.id_categoria
                $where
                ORDER BY $ordenSql
                LIMIT " . (int) $porPagina . " OFFSET " . (int) $desde;
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($p);

        $lista = [];
        foreach ($stmt->fetchAll() as $fila) {
            $lista[] = self::aReceta($fila);
        }
        return $lista;
    }

    // Recetas destacadas para el inicio
    public function destacadas($limite = 6)
    {
        $sql = "SELECT r.*, c.nombre AS categoria, c.icono
                FROM recetas r
                LEFT JOIN categorias c ON c.id_categoria = r.id_categoria
                WHERE r.activa = 1
                ORDER BY r.id_receta ASC
                LIMIT " . (int) $limite;
        $lista = [];
        foreach ($this->conexion->query($sql)->fetchAll() as $fila) {
            $lista[] = self::aReceta($fila);
        }
        return $lista;
    }

    // BUSCAR POR ID (si $soloActivas es false también devuelve las desactivadas: panel de administración)
    public function buscarPorId($id_receta, $soloActivas = true)
    {
        $sql = "SELECT r.*, c.nombre AS categoria, c.icono
                FROM recetas r
                LEFT JOIN categorias c ON c.id_categoria = r.id_categoria
                WHERE r.id_receta = ?" . ($soloActivas ? " AND r.activa = 1" : "");
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([(int) $id_receta]);
        $fila = $stmt->fetch();
        return $fila ? self::aReceta($fila) : null;
    }

    // INGREDIENTES DE UNA RECETA
    public function listarIngredientes($id_receta)
    {
        $sql = "SELECT i.nombre, i.nombre_normalizado, i.es_basico,
                       ri.cantidad, ri.unidad, ri.opcional
                FROM receta_ingredientes ri
                JOIN ingredientes i ON i.id_ingrediente = ri.id_ingrediente
                WHERE ri.id_receta = :id_receta
                ORDER BY ri.opcional ASC, i.nombre ASC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(["id_receta" => (int) $id_receta]);
        return $stmt->fetchAll();
    }

    // PASOS DE UNA RECETA
    public function listarPasos($id_receta)
    {
        $sql = "SELECT numero_paso, descripcion
                FROM pasos_receta
                WHERE id_receta = :id_receta
                ORDER BY numero_paso";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(["id_receta" => (int) $id_receta]);
        return $stmt->fetchAll();
    }

    // ADMINISTRACIÓN (CRUD)

    // Listado para el panel (arreglos simples)
    public function listarAdmin($filtros = [])
    {
        $where = " WHERE 1=1";
        $p = [];
        if (!empty($filtros["q"])) {
            $where .= " AND r.nombre LIKE ?";
            $p[] = "%" . $filtros["q"] . "%";
        }
        if (!empty($filtros["categoria"])) {
            if ($filtros["categoria"] === "sin") {
                $where .= " AND r.id_categoria IS NULL";
            } else {
                $where .= " AND r.id_categoria = ?";
                $p[] = (int) $filtros["categoria"];
            }
        }
        if (isset($filtros["estado"]) && $filtros["estado"] !== "") {
            $where .= " AND r.activa = ?";
            $p[] = (int) $filtros["estado"];
        }
        if (!empty($filtros["tipo"]) && in_array($filtros["tipo"], self::$tipos, true)) {
            $where .= $this->condicionTipo($filtros["tipo"], $p);
        }

        $sql = "SELECT r.id_receta, r.nombre, r.imagen_url, r.tipo_comida, r.tipo_plato, r.dificultad, r.tiempo_minutos, r.porciones, r.activa,
                       c.nombre AS categoria
                FROM recetas r
                LEFT JOIN categorias c ON c.id_categoria = r.id_categoria
                $where
                ORDER BY c.nombre IS NULL, c.nombre ASC, r.nombre ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($p);
        return $stmt->fetchAll();
    }

    // Busca el ingrediente por su nombre normalizado; si no existe lo crea
    private function obtenerIdIngrediente($nombre)
    {
        $norm = Ingrediente::normalizar($nombre);
        $stmt = $this->conexion->prepare("SELECT id_ingrediente FROM ingredientes WHERE nombre_normalizado = ?");
        $stmt->execute([$norm]);
        $id = $stmt->fetchColumn();
        if ($id) {
            return (int) $id;
        }
        $nombreBonito = mb_strtoupper(mb_substr(trim($nombre), 0, 1, "UTF-8"), "UTF-8") . mb_substr(trim($nombre), 1, null, "UTF-8");
        $this->conexion->prepare("INSERT INTO ingredientes (nombre, nombre_normalizado, es_basico) VALUES (?, ?, 0)")
            ->execute([$nombreBonito, $norm]);
        return (int) $this->conexion->lastInsertId();
    }

    // Crea o actualiza una receta con sus ingredientes y pasos (todo en una transacción)
    // $d: datos de la receta | $ings: [nombre, cantidad, unidad, opcional] | $pasos: [texto, texto, ...]
    public function guardar($d, $ings, $pasos)
    {
        $this->conexion->beginTransaction();
        try {
            $campos = [
                $d["id_categoria"] ?: null, $d["nombre"], $d["descripcion"] !== "" ? $d["descripcion"] : null,
                $d["tipo_comida"], $d["tipo_plato"], $d["dificultad"], (int) $d["tiempo_minutos"], (int) $d["porciones"],
                $d["imagen_url"] !== "" ? $d["imagen_url"] : null, (int) $d["activa"]
            ];

            if ((int) $d["id_receta"] > 0) {
                $id = (int) $d["id_receta"];
                $this->conexion->prepare("UPDATE recetas SET id_categoria = ?, nombre = ?, descripcion = ?, tipo_comida = ?,
                        tipo_plato = ?, dificultad = ?, tiempo_minutos = ?, porciones = ?, imagen_url = ?, activa = ? WHERE id_receta = ?")
                    ->execute(array_merge($campos, [$id]));
                $this->conexion->prepare("DELETE FROM receta_ingredientes WHERE id_receta = ?")->execute([$id]);
                $this->conexion->prepare("DELETE FROM pasos_receta WHERE id_receta = ?")->execute([$id]);
            } else {
                $this->conexion->prepare("INSERT INTO recetas (id_categoria, nombre, descripcion, tipo_comida, tipo_plato, dificultad,
                        tiempo_minutos, porciones, imagen_url, activa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")
                    ->execute($campos);
                $id = (int) $this->conexion->lastInsertId();
            }

            $usados = [];
            $insIng = $this->conexion->prepare("INSERT INTO receta_ingredientes (id_receta, id_ingrediente, cantidad, unidad, opcional)
                                                VALUES (?, ?, ?, ?, ?)");
            foreach ($ings as $ing) {
                $idIng = $this->obtenerIdIngrediente($ing["nombre"]);
                if (isset($usados[$idIng])) {
                    continue; // el mismo ingrediente no se repite en una receta
                }
                $usados[$idIng] = true;
                $insIng->execute([
                    $id, $idIng,
                    $ing["cantidad"] !== "" ? $ing["cantidad"] : null,
                    $ing["unidad"] !== "" ? $ing["unidad"] : null,
                    (int) $ing["opcional"]
                ]);
            }

            $insPaso = $this->conexion->prepare("INSERT INTO pasos_receta (id_receta, numero_paso, descripcion) VALUES (?, ?, ?)");
            foreach (array_values($pasos) as $i => $texto) {
                $insPaso->execute([$id, $i + 1, $texto]);
            }

            $this->conexion->commit();
            return $id;
        } catch (Throwable $e) {
            $this->conexion->rollBack();
            throw $e;
        }
    }

    // Activar / desactivar (borrado lógico)
    public function cambiarEstado($id, $activa)
    {
        $this->conexion->prepare("UPDATE recetas SET activa = ? WHERE id_receta = ?")->execute([(int) $activa, (int) $id]);
    }

    // Eliminar definitivamente (ingredientes y pasos se borran en cascada)
    public function eliminar($id)
    {
        $this->conexion->prepare("DELETE FROM recetas WHERE id_receta = ?")->execute([(int) $id]);
    }

    // Conteo de recetas para el panel
    public function contarPorEstado()
    {
        $r = ["activas" => 0, "inactivas" => 0];
        foreach ($this->conexion->query("SELECT activa, COUNT(*) AS total FROM recetas GROUP BY activa") as $f) {
            $r[$f["activa"] ? "activas" : "inactivas"] = (int) $f["total"];
        }
        return $r;
    }

    public function contarIngredientes()
    {
        return (int) $this->conexion->query("SELECT COUNT(*) FROM ingredientes")->fetchColumn();
    }

    // Autocompletado de ingredientes en el formulario del administrador
    public function nombresIngredientes()
    {
        return $this->conexion->query("SELECT nombre FROM ingredientes ORDER BY nombre")->fetchAll(PDO::FETCH_COLUMN);
    }
}
