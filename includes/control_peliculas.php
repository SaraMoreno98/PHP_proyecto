<?php
session_start();

require 'funciones_peliculas.php';
// $lista_directores = obtener_directores();

$metodo = '';
if(isset($_POST) && isset($_POST['metodo'])){
    $metodo = $_POST['metodo'];
}

switch($metodo){
    case 'crear':
        crearPelicula();
        break;
    case 'delete':
        deletePelicula();
        break;
    case 'modificar':
        modificarPeliculas();
        break;
    case 'modificacion':
        modificacionPeliculas();
        break;
}

function crearPelicula(){
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $director = $_POST['directores'];


    $respuesta = crear_Pelicula($titulo, $precio, $director);

    if ($respuesta) {
        $_SESSION['mensaje'] = "Los datos se insertaron correctamente.";
        $_SESSION['datos_insertados'] = [
            'titulo' => $titulo,
            'precio' => $precio,
            'director' => $director
        ];
    } else {
        $_SESSION['mensaje'] = "Error: " . mysqli_connect_error();
    }
    header("Location: ../crearPelicula.php");
    exit();
}

function deletePelicula(){
    $id = $_POST['id'];
    //llama a eliminar pelicula
    $respuesta = eliminar_pelicula($id);
    if($respuesta){
        //la pelicula ha sido eliminada
        echo json_encode(['success' => true, 'message' => 'Película eliminada']);
    }else{
        //la base de datos nos devuelve un error
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    }
}

function modificarPeliculas(){
    $_SESSION ['IDPelicula'] = $_POST ['IDPelicula'];
    $_SESSION ['metodo'] = $_POST ['metodo'];

    header("Location: ../crearPelicula.php");
}

function modificacionPeliculas(){
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $director = $_POST['directores'];



    $respuesta = modificar_pelicula($id, $titulo, $precio, $director);

    if ($respuesta) {
        $_SESSION['mensaje'] = "Los datos se modificaron correctamente.";
        $_SESSION['datos_insertados'] = [
            'titulo' => $titulo,
            'precio' => $precio,
            'director' => $director
        ];
    } else {
        $_SESSION['mensaje'] = "Error: " . mysqli_connect_error();
    }
    header("Location: ../crearPelicula.php");
    exit();
}

// FUNCIONES ANTIGUAS
    // if($metodo === 'crear'){
    //     $titulo = $_POST['titulo'];
    //     $precio = $_POST['precio'];
    //     $director = $_POST['directores'];


    //     $respuesta = crear_Pelicula($titulo, $precio, $director);

    //     if ($respuesta) {
    //         $_SESSION['mensaje'] = "Los datos se insertaron correctamente.";
    //         $_SESSION['datos_insertados'] = [
    //             'titulo' => $titulo,
    //             'precio' => $precio,
    //             'director' => $director
    //         ];
    //     } else {
    //         $_SESSION['mensaje'] = "Error: " . mysqli_connect_error();
    //     }
    //     header("Location: ../crearPelicula.php");
    //     exit();
    // }

    // if ($metodo === 'delete') {
    //     $id = $_POST['id'];
    //     //llama a eliminar pelicula
    //     $respuesta = eliminar_pelicula($id);
    //     if($respuesta){
    //         //la pelicula ha sido eliminada
    //         echo json_encode(['success' => true, 'message' => 'Película eliminada']);
    //     }else{
    //         //la base de datos nos devuelve un error
    //         echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    //     }
    // }

    // if ($metodo === 'modificar') {
    //     $_SESSION ['IDPelicula'] = $_POST ['IDPelicula'];
    //     $_SESSION ['metodo'] = $_POST ['metodo'];

    //     header("Location: ../crearPelicula.php");
    // }

    // if($metodo === 'modificacion'){
    //     $id = $_POST['id'];
    //     $titulo = $_POST['titulo'];
    //     $precio = $_POST['precio'];
    //     $director = $_POST['directores'];



    //     $respuesta = modificar_pelicula($id, $titulo, $precio, $director);

    //     if ($respuesta) {
    //         $_SESSION['mensaje'] = "Los datos se modificaron correctamente.";
    //         $_SESSION['datos_insertados'] = [
    //             'titulo' => $titulo,
    //             'precio' => $precio,
    //             'director' => $director
    //         ];
    //     } else {
    //         $_SESSION['mensaje'] = "Error: " . mysqli_connect_error();
    //     }
    //     header("Location: ../crearPelicula.php");
    //     exit();
    // }