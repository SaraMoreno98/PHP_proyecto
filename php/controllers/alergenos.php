<?php
// Importar las clases necesarias
require_once '../data/alergeno.php';
require_once 'utilidades.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Crear instancia de la clase Alergenos
$alergeno = new Alergenos();

  // Obtener el método de la petición HTTP
  // Obtener el método de la petición (GET, POST, PUT, DELETE)
  $method = $_SERVER['REQUEST_METHOD'];

  // Obtener la URI de la petición
  $uri = $_SERVER['REQUEST_URI'];

  // Obtener los parámetros de la URI
  $parametros = Utilidades::parseUriParameters($uri);

  // Obtener el ID si existe
  $id = Utilidades::getParameterValue($parametros, 'id');
  
  // Manejar las diferentes peticiones HTTP
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

  /**
   * Obtiene un alérgeno por su ID
   * @param object $alergeno Instancia de la clase Alergenos
   * @param int $id ID del alérgeno
   * @return array Datos del alérgeno
   */
  function getAlergenoById($alergeno, $id){
    return $alergeno->getById($id);
  }

  /**
   * Obtiene todos los alérgenos
   * @param object $alergeno Instancia de la clase Alergenos
   * @return array Lista de alérgenos
   */
  function getAllAlergenos($alergeno){
    return $alergeno->getAll();
  }

  /**
   * Crea un nuevo alérgeno
   * @param object $alergeno Instancia de la clase Alergenos
   */
  function setAlergeno($alergeno){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
        $id = $alergeno->create($data['nombre']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  /**
   * Actualiza un alérgeno existente
   * @param object $alergeno Instancia de la clase Alergenos
   * @param int $id ID del alérgeno a actualizar
   */
  function updateAlergeno($alergeno, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
      $affected = $alergeno->update($id, $data['nombre']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  /**
   * Elimina un alérgeno
   * @param object $alergeno Instancia de la clase Alergenos
   * @param int $id ID del alérgeno a eliminar
   */
  function deleteAlergeno($alergeno, $id){
    $affected = $alergeno->delete($id);
    echo json_encode(['affected' => $affected]);
}