<?php

require_once '../data/tipo.php';
require_once 'utilidades.php';

header('Content-Type: application/json');

$tipo = new Tipo();
 
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
            $respuesta = getTipoById($tipo, $id);
        }else{
            $respuesta = getAllTipos($tipo);
        }
        echo json_encode($respuesta);
        break;
    case 'POST':
        setTipo($tipo);
        break;
    case 'PUT':
        if($id){
          updateTipo($tipo, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    case 'DELETE':
        if($id){
          deleteTipo($tipo, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
  }

  function getTipoById($tipo, $id){
    return $tipo->getById($id);
  }

  function getAllTipos($tipo){
    return $tipo->getAll();
  }

  function setTipo($tipo){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
        $id = $tipo->create($data['nombre']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  function updateTipo($tipo, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
      $affected = $tipo->update($id, $data['nombre']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  function deleteTipo($tipo, $id){
    $affected = $tipo->delete($id);
    echo json_encode(['affected' => $affected]);
}