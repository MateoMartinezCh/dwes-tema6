<?php

namespace dwesgram\modelo;

use dwesgram\modelo\BaseDatos;

class ComentarioBd
{
    use BaseDatos;


    /**
     * 
     */
    public static function getComentarios(int $id): array
    {
        try {
            $comentarios = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, comentario, usuario  from comentario where entrada = ?");
            $sentencia->bind_param('i', $id);
            $sentencia->execute();
            $queryResultado = $sentencia->get_result();
            if ($queryResultado !== false) {
                while (($fila = $queryResultado->fetch_assoc()) != null) {

                    $comentarios[] = array(
                        "usuario" => $fila['usuario'],
                        "comentario" => $fila['comentario']
                    );
                }
            }
            return $comentarios;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return [];
        }
    }
    /**
     * 
     */
    public static function insertar(Comentario $comentario): int|null
    {
        try {
            $usuario = $comentario->getUsuario();
            $entrada = $comentario->getEntrada();
            $texto = $comentario->getTexto();
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("insert into comentario (usuario,entrada,comentario) values (?,?,?)");
            $sentencia->bind_param('iis', $usuario, $entrada, $texto);
            $sentencia->execute();
            return $conexion->insert_id;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
}
