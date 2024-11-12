<?php
// Importar las clases necesarias
require_once '../data/tipo.php';
require_once 'utilidades.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Crear instancia de la clase Tipo
$tipo = new Tipo();

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

  /**
   * Obtiene un tipo por su ID
   * @param object $tipo Instancia de la clase Tipo
   * @param int $id ID del tipo
   * @return array Datos del tipo
   */
  function getTipoById($tipo, $id){
    return $tipo->getById($id);
  }

  /**
   * Crea un nuevo tipo
   * @param object $tipo Instancia de la clase Tipo
   */
  function getAllTipos($tipo){
    return $tipo->getAll();
  }

  /**
   * Crea un nuevo tipo
   * @param object $tipo Instancia de la clase Tipo
   */
  function setTipo($tipo){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
        $id = $tipo->create($data['nombre']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  /**
   * Actualiza un tipo existente
   * @param object $tipo Instancia de la clase Tipo
   * @param int $id ID del tipo a actualizar
   */
  function updateTipo($tipo, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['nombre'])){
      $affected = $tipo->update($id, $data['nombre']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  /**
   * Elimina un tipo
   * @param object $tipo Instancia de la clase Tipo
   * @param int $id ID del tipo a eliminar
   */
  function deleteTipo($tipo, $id){
    $affected = $tipo->delete($id);
    echo json_encode(['affected' => $affected]);
}