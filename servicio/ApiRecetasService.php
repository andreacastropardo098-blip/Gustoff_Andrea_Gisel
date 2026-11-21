<?php
/**
 * Servicio de integración con TheMealDB (API pública y gratuita de recetas).
 *  - sugerirPorIngredientes(): recetas internacionales según los ingredientes del usuario.
 *  - detalle(): receta completa de TheMealDB.
 *  - azar(): receta aleatoria ("Sorpréndeme").
 * Si la API falla (sin internet, tiempo agotado), devuelve vacío y el sistema sigue
 * funcionando con las recetas locales.
 *
 * Nota: TheMealDB usa nombres de ingredientes en inglés, por eso existe la tabla de traducción.
 */
class ApiRecetasService
{
    private $urlBase = "https://www.themealdb.com/api/json/v1/1/";

    // ingrediente (normalizado, en español) => ingrediente en inglés
    private static $traduccion = [
        "papa" => "potatoes", "huevo" => "eggs", "cebolla" => "onions", "arroz" => "rice", "tomate" => "tomatoes",
        "ajo" => "garlic", "zanahoria" => "carrots", "pollo" => "chicken", "carne de res" => "beef",
        "carne de cerdo" => "pork", "carne molida" => "minced beef", "pescado" => "salmon", "trucha" => "trout",
        "fideo" => "spaghetti", "queso" => "cheese", "leche" => "milk", "mantequilla" => "butter",
        "harina" => "flour", "limon" => "lemon", "lenteja" => "lentils", "arveja" => "peas", "choclo" => "sweetcorn",
        "mani" => "peanuts", "quinua" => "quinoa", "zapallo" => "pumpkin", "yuca" => "cassava", "platano" => "bananas",
        "chocolate" => "chocolate", "canela" => "cinnamon", "pan" => "bread", "lechuga" => "lettuce",
        "pepino" => "cucumber", "mayonesa" => "mayonnaise", "salchicha" => "sausages", "azucar" => "sugar",
        "nuez" => "walnuts", "vinagre" => "vinegar", "mostaza" => "mustard", "jengibre" => "ginger", "perejil" => "parsley"
    ];

    // Hace la petición HTTP y devuelve el JSON como arreglo (o null si falla)
    private function pedir($endpoint)
    {
        try {
            $contexto = stream_context_create(["http" => ["timeout" => 4], "ssl" => ["verify_peer" => true]]);
            $respuesta = @file_get_contents($this->urlBase . $endpoint, false, $contexto);
            if ($respuesta === false) {
                return null;
            }
            $datos = json_decode($respuesta, true);
            return is_array($datos) ? $datos : null;
        } catch (Throwable $e) {
            return null;
        }
    }

    // Recetas de TheMealDB que llevan un ingrediente (en inglés)
    public function buscarPorIngrediente($ingredienteEnIngles)
    {
        $datos = $this->pedir("filter.php?i=" . urlencode($ingredienteEnIngles));
        return $datos["meals"] ?? [];
    }

    // Sugerencias a partir de la lista de ingredientes del usuario (en español)
    public function sugerirPorIngredientes($ingredientes, $maximo = 6)
    {
        $intentos = 0;
        foreach ($ingredientes as $ing) {
            if (!isset(self::$traduccion[$ing])) {
                continue;
            }
            $lista = $this->buscarPorIngrediente(self::$traduccion[$ing]);
            if (!empty($lista)) {
                return ["ingrediente" => $ing, "recetas" => array_slice($lista, 0, $maximo)];
            }
            if (++$intentos >= 3) {
                break;
            }
        }
        return ["ingrediente" => "", "recetas" => []];
    }

    // Convierte la respuesta cruda de TheMealDB en un arreglo ordenado
    private function ordenarReceta($m)
    {
        $ingredientes = [];
        for ($i = 1; $i <= 20; $i++) {
            $nombre = trim($m["strIngredient$i"] ?? "");
            if ($nombre !== "") {
                $ingredientes[] = ["nombre" => $nombre, "medida" => trim($m["strMeasure$i"] ?? "")];
            }
        }
        return [
            "id"           => $m["idMeal"],
            "nombre"       => $m["strMeal"],
            "categoria"    => $m["strCategory"] ?? "",
            "origen"       => $m["strArea"] ?? "",
            "imagen"       => $m["strMealThumb"] ?? "",
            "instrucciones" => $m["strInstructions"] ?? "",
            "youtube"      => $m["strYoutube"] ?? "",
            "ingredientes" => $ingredientes
        ];
    }

    public function detalle($id)
    {
        if (!ctype_digit((string) $id)) {
            return null;
        }
        $datos = $this->pedir("lookup.php?i=" . $id);
        return !empty($datos["meals"][0]) ? $this->ordenarReceta($datos["meals"][0]) : null;
    }

    public function azar()
    {
        $datos = $this->pedir("random.php");
        return !empty($datos["meals"][0]) ? $this->ordenarReceta($datos["meals"][0]) : null;
    }
}
