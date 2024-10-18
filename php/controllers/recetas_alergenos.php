<?php

require_once '../data/receta_alergeno.php';
require_once 'utilidades.php';

header('Content-Type: application/json');

$recetaAlergenos = new recetaAlergenos();
 
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
            $respuesta = getRecetaAlergenoById($recetaAlergenos, $id);
        }else{
            $respuesta = getAllRecetaAlergenos($recetaAlergenos);
        }
        echo json_encode($respuesta);
        break;
    case 'POST':
        setRecetaAlergeno($recetaAlergenos);
        break;
    case 'PUT':
        if($id){
          updateRecetaAlergeno($recetaAlergenos, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    case 'DELETE':
        if($id){
          deleteRecetaAlergeno($recetaAlergenos, $id);
        }else{
          http_response_code(400);
          echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
  }

  function getRecetaAlergenoById($recetaAlergenos, $id){
    return $recetaAlergenos->getById($id);
  }

  function getAllRecetaAlergenos($recetaAlergenos){
    return $recetaAlergenos->getAll();
  }

  function setRecetaAlergeno($recetaAlergenos){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id_receta'])){
        $id = $recetaAlergenos->create($data['id_receta']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  function updateRecetaAlergeno($recetaAlergenos, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id_receta'])){
      $affected = $recetaAlergenos->update($id, $data['id_receta']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  function deleteRecetaAlergeno($recetaAlergenos, $id){
    $affected = $recetaAlergenos->delete($id);
    echo json_encode(['affected' => $affected]);
}