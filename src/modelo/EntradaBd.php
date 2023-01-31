<?php

namespace dwesgram\modelo;

use dwesgram\modelo\Entrada;
use dwesgram\modelo\BaseDatos;

class EntradaBd
{
    use BaseDatos;



    public static function getEntradas(): array
    {
        try {
            $resultado = [];
            $conexion = BaseDatos::getConexion();
            $queryResultado = $conexion->query("select id, texto, imagen, autor from entrada order by creado desc");
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {
                    $entrada = new Entrada(
                        id: $fila['id'],
                        texto: $fila['texto'],
                        imagen: $fila['imagen'],
                        autor: $fila['autor'],
                        listaAutoresMegusta: MegustaBd::getAutores($fila['id'])
                    );
                    $resultado[] = $entrada;
                }
            }
            return $resultado;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
    public static function getEntrada(int $id): Entrada|null
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, texto,imagen,autor, creado from entrada where id=?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $resultado = $sentencia->get_result();
            $fila = $resultado->fetch_assoc();
            if ($fila == null) {
                return null;
            } else {
                return new Entrada(
                    id: $fila['id'],
                    texto: $fila['texto'],
                    imagen: $fila['imagen'],
                    autor: $fila['autor'],
                    creado: $fila['creado'],
                    listaAutoresMegusta: MegustaBd::getAutores($fila['id'])
                );
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function insertar(Entrada $entrada): int|null
    {
        try {
            $texto = $entrada->getTexto();
            $imagen = $entrada->getImagen();
            $autor = $entrada->getAutor();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into entrada (texto,imagen,autor) values (?,?,?)");
            $sentencia->bind_param('ssi', $texto, $imagen, $autor);
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    public static function eliminar(int $id): bool
    {
        try {
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("delete from entrada where id = ?");
            $sentencia->bind_param('i', $id);
            return $sentencia->execute();
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
