<?php
require_once __DIR__ . "/Usuario.php";

class UsuarioDao
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    private function aObjeto($f)
    {
        return new Usuario($f["id_usuario"], $f["nombre"], $f["correo"], $f["clave_hash"], $f["rol"], $f["activo"]);
    }

    public function buscarPorCorreo($correo)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE correo = :correo");
        $stmt->execute(["correo" => trim($correo)]);
        $f = $stmt->fetch();
        return $f ? $this->aObjeto($f) : null;
    }

    public function buscarPorId($id)
    {
        $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
        $stmt->execute(["id" => (int) $id]);
        $f = $stmt->fetch();
        return $f ? $this->aObjeto($f) : null;
    }

    // Registro público: siempre con rol "usuario"
    public function crear($nombre, $correo, $clave)
    {
        $sql = "INSERT INTO usuarios (nombre, correo, clave_hash, rol) VALUES (:n, :c, :h, 'usuario')";
        $this->conexion->prepare($sql)->execute([
            "n" => trim($nombre),
            "c" => trim($correo),
            "h" => password_hash($clave, PASSWORD_DEFAULT)
        ]);
        return (int) $this->conexion->lastInsertId();
    }

    // Lista para el panel de administración, con búsqueda y filtros
    public function listar($filtros = [])
    {
        $where = "WHERE 1=1";
        $p = [];
        if (!empty($filtros["q"])) {
            $where .= " AND (u.nombre LIKE ? OR u.correo LIKE ?)";
            $p[] = "%" . $filtros["q"] . "%";
            $p[] = "%" . $filtros["q"] . "%";
        }
        if (!empty($filtros["rol"])) {
            $where .= " AND u.rol = ?";
            $p[] = $filtros["rol"];
        }
        if (isset($filtros["estado"]) && $filtros["estado"] !== "") {
            $where .= " AND u.activo = ?";
            $p[] = (int) $filtros["estado"];
        }
        $sql = "SELECT u.id_usuario, u.nombre, u.correo, u.rol, u.activo, u.fecha_registro
                FROM usuarios u $where
                ORDER BY u.rol ASC, u.nombre ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute($p);
        return $stmt->fetchAll();
    }

    public function cambiarRol($id, $rol)
    {
        $this->conexion->prepare("UPDATE usuarios SET rol = ? WHERE id_usuario = ?")->execute([$rol, (int) $id]);
    }

    public function cambiarEstado($id, $activo)
    {
        $this->conexion->prepare("UPDATE usuarios SET activo = ? WHERE id_usuario = ?")->execute([(int) $activo, (int) $id]);
    }

    public function contarAdministradoresActivos()
    {
        return (int) $this->conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'administrador' AND activo = 1")->fetchColumn();
    }

    public function contarPorRol()
    {
        $r = ["administrador" => 0, "usuario" => 0];
        foreach ($this->conexion->query("SELECT rol, COUNT(*) AS total FROM usuarios GROUP BY rol") as $f) {
            $r[$f["rol"]] = (int) $f["total"];
        }
        return $r;
    }
}
