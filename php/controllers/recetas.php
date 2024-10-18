<?php

require_once '../data/receta.php';
require_once 'utilidades.php';

header('Content-Type: application/json');

$receta = new Receta();
 
//obtener el método de la petición (GET, POST, PUT, DELETE)
  $method = $_SERVER['REQUEST_METHOD'];

  // Obtener la URI de la petición
  $uri = $_SERVER['REQUEST_URI'];

  //obtener los parámetros de la petición
  $parametros = Utilidades::parseUriParameters($uri);

  //obtener el parámetro id
  $id = Utilidades::getParameterValue($parametros, 'id');
  
  switch($method){
    case 'GET':
        if($id){
            $respuesta = getRecetaById($receta, $id);
        }else{
            $respuesta = getAllRecetas($receta);
        }
        echo json_encode($respuesta);
        break;
    case 'POST':
        setReceta($receta);
        break;
    case 'PUT':
        if($id){
          updateReceta($receta, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    case 'DELETE':
        if($id){
          deleteReceta($receta, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
  }

  function getRecetaById($receta, $id){
    return $receta->getById($id);
  }

  function getAllRecetas($receta){
    return $receta->getAll();
  }

  function setReceta($receta){
    $data = json_decode(file_get_contents('php://input'), true);

    $ingredientes = null;
    $pasos = null;

    if(isset($data['ingredientes'])){
      $ingredientes = $data['ingredientes'];
    }

    if(isset($data['pasos'])){
      $pasos = $data['pasos'];
    }

    if(isset($data['img']) && isset($data['nombre']) && isset($data['descripcion']) && isset($data['comensales']) && isset($data['preparacion']) && isset($data['cocinar']) && isset($data['temperatura'], $ingredientes, $pasos)){
        $id = $receta->create($data['img'], $data['nombre'], $data['descripcion'], $data['comensales'], $data['preparacion'], $data['cocinar'], $data['temperatura'], $ingredientes, $pasos);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  function updateReceta($receta, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    $ingredientes = null;
    $pasos = null;

    if(isset($data['ingredientes'])){
        $ingredientes = $data['ingredientes'];
    }

    if(isset($data['pasos'])){
        $pasos = $data['pasos'];
    }

    if(isset($data['img']) && isset($data['nombre']) && isset($data['descripcion']) && isset($data['comensales']) && isset($data['preparacion']) && isset($data['cocinar']) && isset($data['temperatura'])){
      $affected = $receta->update($id,$data['img'],  $data['nombre'], $data['descripcion'], $data['comensales'], $data['preparacion'], $data['cocinar'], $data['temperatura'], $ingredientes, $pasos);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  function deleteReceta($receta, $id){
    $affected = $receta->delete($id);
    echo json_encode(['affected' => $affected]);
}