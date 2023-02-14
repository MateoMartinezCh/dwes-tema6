<?php

namespace dwesgram\modelo;

use dwesgram\modelo\BaseDatos;

class ComentarioBd
{
    use BaseDatos;


    /**
     * !ESTE METODO NO ESTA TERMINADO NI FUNCIONA AÚN
     */
    public static function getComentarios(int $id): array
    {
        try {
            $autores = [];
            $conexion = BaseDatos::getConexion();
            $sentencia = $conexion->prepare("select id, comentario, usuario from megusta where entrada = ?");
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
