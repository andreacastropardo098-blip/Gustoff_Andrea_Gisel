<?php
require_once __DIR__ . "/../modelo/Usuario.php";
require_once __DIR__ . "/../modelo/UsuarioDao.php";

class AuthController
{
    private $dao;

    public function __construct($conexion)
    {
        $this->dao = new UsuarioDao($conexion);
    }

    // INICIAR SESIÓN
    public function login()
    {
        if (Sesion::estaLogueado()) {
            header("Location: " . (Sesion::esAdmin() ? "index.php?accion=admin_panel" : "index.php"));
            exit;
        }

        $errores = [];
        $correo = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $correo = trim($_POST["correo"] ?? "");
            $clave = $_POST["clave"] ?? "";

            if (!Validador::correo($correo)) {
                $errores[] = "Escribe un correo válido.";
            }
            if (!is_string($clave) || $clave === "") {
                $errores[] = "Escribe tu contraseña.";
            }

            if (empty($errores)) {
                $usuario = $this->dao->buscarPorCorreo($correo);

                if ($usuario === null || !password_verify($clave, $usuario->getClave_hash())) {
                    $errores[] = "Correo o contraseña incorrectos.";
                } elseif (!$usuario->getActivo()) {
                    $errores[] = "Tu cuenta está desactivada. Comunícate con el administrador.";
                } else {
                    Sesion::iniciar($usuario);
                    Sesion::flash("success", "¡Bienvenido, " . $usuario->getNombre() . "!");
                    header("Location: " . ($usuario->getRol() === "administrador" ? "index.php?accion=admin_panel" : "index.php"));
                    exit;
                }
            }
        }
        require __DIR__ . "/../vista/auth/login.php";
    }

    // REGISTRO DE UN NUEVO USUARIO (rol "usuario")
    public function registro()
    {
        if (Sesion::estaLogueado()) {
            header("Location: index.php");
            exit;
        }

        $errores = [];
        $nombre = "";
        $correo = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = trim($_POST["nombre"] ?? "");
            $correo = trim($_POST["correo"] ?? "");
            $clave = $_POST["clave"] ?? "";
            $confirmar = $_POST["confirmar"] ?? "";

            if (!Validador::texto($nombre, 2, 100)) {
                $errores[] = "El nombre debe tener entre 2 y 100 caracteres.";
            }
            if (!Validador::correo($correo)) {
                $errores[] = "Escribe un correo válido.";
            } elseif ($this->dao->buscarPorCorreo($correo) !== null) {
                $errores[] = "Ya existe una cuenta con ese correo.";
            }
            if (!Validador::clave($clave)) {
                $errores[] = "La contraseña debe tener al menos 6 caracteres, con letras y números.";
            }
            if ($clave !== $confirmar) {
                $errores[] = "Las contraseñas no coinciden.";
            }

            if (empty($errores)) {
                $id = $this->dao->crear($nombre, $correo, $clave);
                Sesion::iniciar($this->dao->buscarPorId($id));
                Sesion::flash("success", "¡Cuenta creada! Ya puedes buscar tus recetas.");
                header("Location: index.php");
                exit;
            }
        }
        require __DIR__ . "/../vista/auth/registro.php";
    }

    // CERRAR SESIÓN
    public function salir()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            Sesion::cerrar();
            Sesion::flash("info", "Cerraste sesión correctamente.");
        }
        header("Location: index.php");
        exit;
    }
}
