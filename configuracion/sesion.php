<?php
// Manejo de sesión, roles, mensajes (flash) y protección CSRF.

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(["httponly" => true, "samesite" => "Lax"]);
    session_start();
}

class Sesion
{
    // Guarda al usuario en la sesión después de un login correcto
    public static function iniciar($usuario)
    {
        session_regenerate_id(true);
        $_SESSION["usuario"] = [
            "id"     => (int) $usuario->getId_usuario(),
            "nombre" => $usuario->getNombre(),
            "correo" => $usuario->getCorreo(),
            "rol"    => $usuario->getRol()
        ];
    }

    // Cierra la sesión del usuario
    public static function cerrar()
    {
        unset($_SESSION["usuario"]);
        session_regenerate_id(true);
    }

    public static function usuario()
    {
        return $_SESSION["usuario"] ?? null;
    }

    public static function estaLogueado()
    {
        return isset($_SESSION["usuario"]);
    }

    public static function esAdmin()
    {
        return self::estaLogueado() && $_SESSION["usuario"]["rol"] === "administrador";
    }

    public static function esUsuario()
    {
        return self::estaLogueado() && $_SESSION["usuario"]["rol"] === "usuario";
    }

    public static function id()
    {
        return self::estaLogueado() ? (int) $_SESSION["usuario"]["id"] : 0;
    }

    // Exige haber iniciado sesión
    public static function requerirLogin()
    {
        if (!self::estaLogueado()) {
            self::flash("warning", "Inicia sesión para continuar.");
            header("Location: index.php?accion=login");
            exit;
        }
    }

    // Exige ser administrador
    public static function requerirAdmin()
    {
        self::requerirLogin();
        if (!self::esAdmin()) {
            self::flash("danger", "No tienes permiso para entrar a esa sección.");
            header("Location: index.php");
            exit;
        }
    }

    // ---------- Mensajes de una sola vez ----------
    public static function flash($tipo, $mensaje)
    {
        $_SESSION["flash"] = [$tipo, $mensaje];
    }

    public static function tomarFlash()
    {
        $f = $_SESSION["flash"] ?? null;
        unset($_SESSION["flash"]);
        return $f;
    }

    // ---------- CSRF ----------
    public static function token()
    {
        if (empty($_SESSION["token"])) {
            $_SESSION["token"] = bin2hex(random_bytes(32));
        }
        return $_SESSION["token"];
    }

    public static function verificarToken()
    {
        $enviado = $_POST["token"] ?? "";
        if (!is_string($enviado) || !hash_equals(self::token(), $enviado)) {
            self::flash("danger", "El formulario expiró o no es válido. Inténtalo de nuevo.");
            header("Location: index.php");
            exit;
        }
    }
}
