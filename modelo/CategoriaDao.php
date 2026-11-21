<?php

class CategoriaDao
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Todas las categorías con la cantidad de recetas que tiene cada una
    public function listar()
    {
        $sql = "SELECT c.id_categoria, c.nombre, c.icono,
                       (SELECT COUNT(*) FROM recetas r WHERE r.id_categoria = c.id_categoria AND r.activa = 1) AS total,
                       (SELECT COUNT(*) FROM recetas r WHERE r.id_categoria = c.id_categoria) AS total_todas
                FROM categorias c
                ORDER BY c.id_categoria";
        return $this->conexion->query($sql)->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $stmt->execute([(int) $id]);
        return $stmt->fetch() ?: null;
    }

    public function existeNombre($nombre, $excluirId = 0)
    {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM categorias WHERE nombre = ? AND id_categoria <> ?");
        $stmt->execute([trim($nombre), (int) $excluirId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function crear($nombre, $icono)
    {
        $this->conexion->prepare("INSERT INTO categorias (nombre, icono) VALUES (?, ?)")
            ->execute([trim($nombre), trim($icono) !== "" ? trim($icono) : null]);
    }

    public function actualizar($id, $nombre, $icono)
    {
        $this->conexion->prepare("UPDATE categorias SET nombre = ?, icono = ? WHERE id_categoria = ?")
            ->execute([trim($nombre), trim($icono) !== "" ? trim($icono) : null, (int) $id]);
    }

    // Las recetas de la categoría quedan "sin categoría" (ON DELETE SET NULL)
    public function eliminar($id)
    {
        $this->conexion->prepare("DELETE FROM categorias WHERE id_categoria = ?")->execute([(int) $id]);
    }
}
