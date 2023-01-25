<?php

namespace dwesgram\utility;

class Sesion
{
    private int|null $id;
    private string|null $nombre;
    private string|null $avatar;

    public function __construct()
    {
        $this->id = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;
        $this->nombre = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre']) ? $_SESSION['usuario']['nombre'] : '';
        $this->avatar = $_SESSION && isset($_SESSION['usuario']) && isset($_SESSION['usuario']['avatar']) ? $_SESSION['usuario']['avatar'] : '';
    }
    public function haySesion(): bool
    {
        return $this->id !== null && $this->nombre !== null ? true : false;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
