<?php

namespace dwesgram\controlador;

use dwesgram\modelo\Usuario;
use dwesgram\modelo\UsuarioBd;
use dwesgram\modelo\Modelo;

class UsuarioControlador extends Controlador
{
    public function login(): array|string|null
    {
        if ($this->autenticado()) {
            header('Location:index.php');
            return null;
        }
        if (!$_POST) {
            $this->vista = 'usuario/login';
            return null;
        }
        //si llega post comprobamos si hay usuario
        $nombre = $_POST && isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $clave = $_POST && isset($_POST['clave']) ? $_POST['clave'] : '';
        $usuario = UsuarioBd::getUsuarioPorNombre($nombre);
        if ($usuario !== null  && password_verify($clave, $usuario->getClave())) {
            $_SESSION['usuario'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'avatar' => $usuario->getAvatar()
            ];
            header('Location:index.php');
            return null;
        }
        //si el usuario no es valido falta rellenar los campos
        $this->vista = 'usuario/login';
        return ['nombre' => $nombre, 'mensaje' => 'Nombre Y/0 contraseña incorrectos'];
    }

    public function registro(): Usuario|string|null
    {
        if ($this->autenticado()) {
            header('Location:index.php');
            return null;
        }
        if (!$_POST) {
            $this->vista = 'usuario/registro';
            return null;
        }
        //si llega POST creamos el modelo Usuario
        $usuario = Usuario::crearUsuarioDesdePost($_POST);
        $usuario->anyadirAvatarDesdeFile($_FILES);
        if (!$usuario->esValido()) {
            $this->vista = 'usuario/registro';
            return $usuario;
        }
        //insertamos el usuario en la base de datos
        $id = UsuarioBd::insertar($usuario);
        if ($id !== null) {
            $this->vista = 'usuario/mensaje';
            return "Te has registrado correctamente... Ya puedes iniciar sesión.";
        } else {
            $this->vista = 'usuario/registro';
            return 'No se ha podidio llevar a cabo el registro, prueba más tarde.';
        }
    }

    public function logout(): void
    {
        if (!$this->autenticado()) {
            return;
        }
        session_destroy();
        header('Location: index.php');
    }
}
