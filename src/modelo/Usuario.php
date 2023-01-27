<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Modelo;

class Usuario extends Modelo
{
    private array $errores = [];

    public function __construct(
        private string|null $nombre = null,
        private string|null $clave = null,
        private int|null $id = null,
        private string|null $email = null,
        private string|null $avatar = null
    ) {
    }

    public static function crearUsuarioDesdePost(array $post): Usuario
    {
        $usuario = new Usuario(
            nombre: $post && isset($post['nombre']) ? htmlspecialchars(trim($post['nombre'])) : "",
            clave: $post && isset($post['clave']) ? htmlspecialchars(trim($post['clave'])) : "",
            email: $post && isset($post['email']) ? htmlspecialchars(trim($post['email'])) : ""
        );
        $repiteClave = $post && isset($post['repiteclave']) ? htmlspecialchars(trim($post['repiteclave'])) : "";
        if ($usuario->clave !== $repiteClave) {
            $usuario->errores['clave'] = 'Las claves no coinciden';
        }
        if (mb_strlen($usuario->clave) < 8) {
            $usuario->errores['clave'] = 'La clave tiene que tener, al menos, 8 caracteres';
        }
        if (mb_strlen($usuario->nombre) === 0) {
            $usuario->errores['nombre'] = 'El nombre no puede estar vacío';
        } else {
            $otro =  UsuarioBd::getUsuarioPorNombre($usuario->nombre);
            if ($otro !== null) {
                $usuario->errores['nombre'] = 'El nombre de usuario no está disponible';
            }
        }
        if (mb_strlen($usuario->email) === 0) {
            $usuario->errores['email'] = 'El email no puede estar vacío';
        }
        return $usuario;
    }
    public function anyadirAvatarDesdeFile(array $file): void
    {
        if (
            $file && isset($file['avatar']) &&
            $file['avatar']['error'] === UPLOAD_ERR_OK

        ) {
            //En mi proyecto permito Gifs también porque me resulta
            //interesante dar la opción de tener un avatar que se pueda mover
            //así es como se hace en sitios como steam.

            $permitidos = array("png", "jpg", "gif");
            $extension =  pathinfo($file['avatar']['name'], PATHINFO_EXTENSION);
            $mimesPermitidos = array("image/jpg", "image/png", "image/jpeg", "image/gif");
            $fichero = $file['avatar']['tmp_name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_fichero = finfo_file($finfo, $fichero);
            if (in_array($extension, $permitidos) && in_array($mime_fichero, $mimesPermitidos)) {
                $tiempoactualirrepetible = getdate();
                $file['avatar']['name'] = $tiempoactualirrepetible['0'] . "." . $extension;
                $rutaFicheroDestino = './assets/img/' . basename($file['avatar']['name']);
                move_uploaded_file($file['avatar']['tmp_name'], $rutaFicheroDestino);
                $this->avatar = $rutaFicheroDestino;
            } else {
                $this->errores['avatar'] = 'Extensión o Mime no permitido';
            }
        }
    }
    public function esValido(): bool
    {
        return count($this->errores) == 0;
    }
    public function getErrores(): array
    {
        return $this->errores;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getClave(): string
    {
        return $this->clave;
    }
    public function setClave(string $clave): void
    {
        $this->clave = $clave;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getAvatar(): string
    {
        return $this->avatar ? $this->avatar : "./assets/img/default.webp";
    }
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }
}
