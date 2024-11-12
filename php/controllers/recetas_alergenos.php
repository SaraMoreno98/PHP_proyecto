<?php
// Importar las clases necesarias
require_once '../data/receta_alergeno.php';
require_once 'utilidades.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Crear instancia de la clase recetaAlergenos
$recetaAlergenos = new recetaAlergenos();

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

  /**
   * Obtiene una relación receta-alérgeno por su ID
   * @param object $recetaAlergenos Instancia de la clase recetaAlergenos
   * @param int $id ID de la relación
   * @return array Datos de la relación
   */
  function getRecetaAlergenoById($recetaAlergenos, $id){
    return $recetaAlergenos->getById($id);
  }

  /**
   * Obtiene todas las relaciones receta-alérgeno
   * @param object $recetaAlergenos Instancia de la clase recetaAlergenos
   * @return array Lista de relaciones
   */
  function getAllRecetaAlergenos($recetaAlergenos){
    return $recetaAlergenos->getAll();
  }

  /**
   * Crea una nueva relación receta-alérgeno
   * @param object $recetaAlergenos Instancia de la clase recetaAlergenos
   */
  function setRecetaAlergeno($recetaAlergenos){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id_receta'])){
        $id = $recetaAlergenos->create($data['id_receta']);
        echo json_encode(['id' => $id]);
    }else{
        echo json_encode(['Error' => 'Datos insuficientes']);
    }
  }

  /**
   * Actualiza una relación receta-alérgeno existente
   * @param object $recetaAlergenos Instancia de la clase recetaAlergenos
   * @param int $id ID de la relación a actualizar
   */
  function updateRecetaAlergeno($recetaAlergenos, $id){
    $data = json_decode(file_get_contents('php://input'), true);

    if(isset($data['id_receta'])){
      $affected = $recetaAlergenos->update($id, $data['id_receta']);
      echo json_encode(['affected' => $affected]); 
    }else{
      echo json_encode(['Error' => 'Datos insuficientes']);
    }
 
  }

  /**
   * Elimina una relación receta-alérgeno
   * @param object $recetaAlergenos Instancia de la clase recetaAlergenos
   * @param int $id ID de la relación a eliminar
   */
  function deleteRecetaAlergeno($recetaAlergenos, $id){
    $affected = $recetaAlergenos->delete($id);
    echo json_encode(['affected' => $affected]);
}