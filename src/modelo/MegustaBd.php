<?php

namespace dwesgram\modelo;

use dwesgram\modelo\BaseDatos;

class MegustaBd
{
    use BaseDatos;



    public static function getAutores(int $id): array
    {
        try {
            $autores = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select usuario from megusta where id = ?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $queryResultado = $sentencia->get_result();
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {

                    $autores[] = $fila['usuario'];
                }
            }
            return $autores;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
    public static function getMegusta(int $id): Megusta|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, usuario, entrada from megusta where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Megusta(
                    id: $fila['id'],
                    usuario: $fila['usuario'],
                    entrada: $fila['entrada']
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function insertar(Megusta $megusta): int|null
    {
        try {
            $usuario = $megusta->getUsuario();
            $entrada = $megusta->getEntrada();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into megusta (usuario,entrada) values (?,?)");
            $sentencia->bind_param('ii', $usuario, $entrada);
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
