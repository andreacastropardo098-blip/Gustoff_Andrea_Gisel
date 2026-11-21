<?php
// Funciones de ayuda para las vistas y validaciones del servidor (PHP).

// Escapa texto para mostrarlo en HTML de forma segura
function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function etiquetaDificultad($d)
{
    $mapa = ["facil" => "Fácil", "media" => "Media", "dificil" => "Difícil"];
    return $mapa[$d] ?? $d;
}

function etiquetaTipo($t)
{
    $mapa = ["desayuno" => "Desayuno", "almuerzo" => "Almuerzo", "cena" => "Cena",
             "ambos" => "Almuerzo / Cena", "postre" => "Postre", "snack" => "Snack"];
    return $mapa[$t] ?? $t;
}

// Cantidad sin ceros sobrantes: 1.50 -> 1.5, 2.00 -> 2
function formatearCantidad($cantidad)
{
    if ($cantidad === null || $cantidad === "") {
        return "";
    }
    return rtrim(rtrim(number_format((float) $cantidad, 2, ".", ""), "0"), ".");
}

// Campo oculto con el token CSRF para los formularios POST
function campoToken()
{
    return '<input type="hidden" name="token" value="' . e(Sesion::token()) . '">';
}

// Devuelve una dirección interna segura para redirigir (evita enlaces a otros sitios)
function urlSegura($url, $porDefecto = "index.php")
{
    $url = is_string($url) ? trim($url) : "";
    if ($url !== "" && strpos($url, "index.php") === 0 && !preg_match('/[\r\n\\\\]/', $url)) {
        return $url;
    }
    return $porDefecto;
}

// Tipo de plato (sopa, segundo, ensalada...)
function etiquetaPlato($p)
{
    $mapa = ["sopa" => "Sopas", "segundo" => "Segundos", "ensalada" => "Ensaladas",
             "desayuno" => "Desayunos", "postre" => "Postres", "snack" => "Snacks"];
    return $mapa[$p] ?? $p;
}

function iconoPlato($p)
{
    $mapa = ["sopa" => "🍲", "segundo" => "🍽", "ensalada" => "🥗", "desayuno" => "🍳", "postre" => "🍮", "snack" => "🥟"];
    return $mapa[$p] ?? "🍽";
}

// "Sopa de maní" -> "sopa-de-mani" (nombre de archivo esperado para la foto de la receta)
function slugReceta($nombre)
{
    $t = mb_strtolower(trim((string) $nombre), "UTF-8");
    $t = strtr($t, ["á" => "a", "é" => "e", "í" => "i", "ó" => "o", "ú" => "u", "ü" => "u", "ñ" => "n"]);
    $t = preg_replace('/[^a-z0-9]+/', "-", $t);
    return trim($t, "-");
}

function imagenPorNombre($nombre, $imagenBd = "")
{
    if ($imagenBd !== null && $imagenBd !== "") {
        return $imagenBd;
    }
    $slug = slugReceta($nombre);
    $carpeta = __DIR__ . "/../publico/img/recetas/";
    foreach (["jpg", "jpeg", "png", "webp"] as $ext) {
        if ($slug !== "" && is_file($carpeta . $slug . "." . $ext)) {
            return "publico/img/recetas/" . $slug . "." . $ext;
        }
    }
    return "";
}

function imagenReceta($receta)
{
    return imagenPorNombre($receta->getNombre(), $receta->getImagen_url());
}

class Validador
{
    public static function texto($valor, $min, $max)
    {
        $largo = mb_strlen(trim((string) $valor), "UTF-8");
        return $largo >= $min && $largo <= $max;
    }

    public static function correo($valor)
    {
        return filter_var(trim((string) $valor), FILTER_VALIDATE_EMAIL) !== false && mb_strlen($valor) <= 120;
    }

    // Mínimo 6 caracteres, con al menos una letra y un número
    public static function clave($valor)
    {
        return is_string($valor) && strlen($valor) >= 6 && strlen($valor) <= 72
            && preg_match('/[A-Za-z]/', $valor) && preg_match('/\d/', $valor);
    }

    public static function entero($valor, $min, $max)
    {
        return filter_var($valor, FILTER_VALIDATE_INT, ["options" => ["min_range" => $min, "max_range" => $max]]) !== false;
    }
}
