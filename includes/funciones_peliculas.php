<?php

//importar conexion
require 'database.php';

function ejecutarConsulta($sql){
    global $conexion;
    return mysqli_query($conexion, $sql);
}

//Consultas a la tabla películas
function obtener_peliculas(){
    $sql = "SELECT * FROM pelicula;";

    return ejecutarConsulta($sql);
}

function obtener_pelicula_por_id($id){
    $sql = "SELECT * FROM pelicula WHERE id=$id";

    return ejecutarConsulta($sql);
}

function crear_Pelicula($titulo, $precio, $director){
    //crear la consulta
    $sql = "INSERT INTO pelicula(titulo, precio, id_director) VALUES ('$titulo', $precio, $director)";
    
    return ejecutarConsulta($sql);
}

function modificar_pelicula($id, $titulo, $precio, $director){
    $sql = "UPDATE pelicula SET titulo = '$titulo', precio = $precio, id_director = $director WHERE id = $id;";
    return ejecutarConsulta($sql);
}

function eliminar_pelicula($id){
    $sql = "DELETE FROM pelicula WHERE id=$id;";
    
    return ejecutarConsulta($sql);
}