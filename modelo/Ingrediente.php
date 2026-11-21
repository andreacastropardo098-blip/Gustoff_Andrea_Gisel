<?php

class Ingrediente
{
    private $id_ingrediente;
    private $nombre;
    private $nombre_normalizado;
    private $es_basico;

    // CONSTRUCTOR
    public function __construct($id_ingrediente = null, $nombre = "", $nombre_normalizado = "", $es_basico = 0)
    {
        $this->id_ingrediente = $id_ingrediente;
        $this->nombre = $nombre;
        $this->nombre_normalizado = $nombre_normalizado;
        $this->es_basico = $es_basico;
    }

    // GETTERS
    public function getId_ingrediente() { return $this->id_ingrediente; }
    public function getNombre() { return $this->nombre; }
    public function getNombre_normalizado() { return $this->nombre_normalizado; }
    public function getEs_basico() { return $this->es_basico; }

    // SETTERS
    public function setId_ingrediente($v) { $this->id_ingrediente = $v; }
    public function setNombre($v) { $this->nombre = $v; }
    public function setNombre_normalizado($v) { $this->nombre_normalizado = $v; }
    public function setEs_basico($v) { $this->es_basico = $v; }

    // Sinónimos comunes en Bolivia: lo que escribe el usuario -> nombre normalizado en la base de datos
    private static $sinonimos = [
        "patata" => "papa", "jitomate" => "tomate", "pechuga" => "pollo", "pechuga de pollo" => "pollo",
        "muslo" => "pollo", "muslo de pollo" => "pollo", "carne" => "carne de res", "res" => "carne de res",
        "carne de vaca" => "carne de res", "cerdo" => "carne de cerdo", "chancho" => "carne de cerdo",
        "espagueti" => "fideo", "spaghetti" => "fideo", "tallarin" => "fideo", "pasta" => "fideo",
        "macarron" => "fideo", "aji" => "aji amarillo", "cacahuate" => "mani", "maiz" => "choclo",
        "banano" => "platano", "banana" => "platano", "calabaza" => "zapallo", "chuno" => "chuño",
        "locote" => "locoto", "aji locoto" => "locoto", "cebolla morada" => "cebolla", "cebolla blanca" => "cebolla",
        "pan molido" => "pan rallado", "salsa soya" => "salsa de soya", "soya" => "salsa de soya",
        "manteca" => "mantequilla", "charke" => "charque"
    ];

    // NORMALIZAR: minúsculas, sin tildes (la ñ se conserva), sin símbolos y en singular sencillo (papas -> papa)
    public static function normalizar($texto)
    {
        $t = mb_strtolower(trim($texto), "UTF-8");
        $t = strtr($t, ["á" => "a", "é" => "e", "í" => "i", "ó" => "o", "ú" => "u", "ü" => "u"]);
        $t = preg_replace('/[^a-zñ ]/u', "", $t);
        $t = trim(preg_replace('/\s+/', " ", $t));

        // plural -> singular
        if (mb_strlen($t) > 4 && preg_match('/(ones|ores)$/u', $t)) {          // limones -> limon
            $t = mb_substr($t, 0, -2);
        } elseif (mb_strlen($t) > 4 && preg_match('/ces$/u', $t)) {             // nueces -> nuez
            $t = mb_substr($t, 0, -3) . "z";
        } elseif (mb_strlen($t) > 3 && mb_substr($t, -1) === "s") {              // papas -> papa
            $t = mb_substr($t, 0, -1);
        }

        return self::$sinonimos[$t] ?? $t;
    }

    // Convierte un texto ("papa, huevo y cebolla") en una lista sin duplicados
    public static function listaDesdeTexto($texto, $maximo = 30)
    {
        $partes = preg_split('/[,;\n]+|\sy\s/u', $texto);
        $lista = [];

        foreach ($partes as $parte) {
            $n = self::normalizar($parte);
            if ($n !== "" && mb_strlen($n) <= 40 && !in_array($n, $lista, true)) {
                $lista[] = $n;
            }
        }
        return array_slice($lista, 0, $maximo);
    }
}
