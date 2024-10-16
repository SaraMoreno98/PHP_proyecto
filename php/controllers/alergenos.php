<?php

require_once '../data/alergeno.php';
require_once 'utilidades.php';

header('Content-Type: application/json');

$alergeno = new Alergenos();
 
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
            $respuesta = getAlergenoById($alergeno, $id);
        }else{
            $respuesta = getAllAlergenos($alergeno);
        }
        echo json_encode($respuesta);
        break;
    case 'POST':
        setAlergeno($alergeno);
        break;
    case 'PUT':
        if($id){
          updateAlergeno($alergeno, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    case 'DELETE':
        if($id){
          deleteAlergeno($alergeno, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
  }

  function getAlergenoById($alergeno, $id){
    return $alergeno->getById($id);
  }

  function getAllAlergenos($alergeno){
    return $alergeno->getAll();
  }

  function setAlergeno($alergeno){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
        $id = $alergeno->create($data['nombre']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  function updateAlergeno($alergeno, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
      $affected = $alergeno->update($id, $data['nombre']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  function deleteAlergeno($alergeno, $id){
    $affected = $alergeno->delete($id);
    echo json_encode(['affected' => $affected]);
}