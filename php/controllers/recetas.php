<?php
// Iniciar sesión para manejar variables de sesión
session_start();

// Importar las clases y configuraciones necesarias
include_once '../data/config.php';
require_once '../data/receta.php';
require_once 'utilidades.php';

// Establecer el tipo de contenido como JSON
header('Content-Type: application/json');

// Crear instancia de la clase Receta
$receta = new Receta();

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

  /**
   * Obtiene una receta por su ID
   * @param object $receta Instancia de la clase Receta
   * @param int $id ID de la receta
   * @return array Datos de la receta
   */
  function getRecetaById($receta, $id){
    return $receta->getById($id);
  }

  /**
   * Obtiene todas las recetas
   * @param object $receta Instancia de la clase Receta
   * @return array Lista de recetas
   */
  function getAllRecetas($receta){
    return $receta->getAll();
  }

  /**
   * Crea una nueva receta
   * @param object $receta Instancia de la clase Receta
   */
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

  /**
   * Actualiza una receta existente
   * @param object $receta Instancia de la clase Receta
   * @param int $id ID de la receta a actualizar
   */
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

  /**
   * Elimina una receta
   * @param object $receta Instancia de la clase Receta
   * @param int $id ID de la receta a eliminar
   */
  function deleteReceta($receta, $id){
    $affected = $receta->delete($id);
    echo json_encode(['affected' => $affected]);
}



// LOGIN
$usuarioBd = new UsuarioBD();

/**
 * Redirige a una URL con un mensaje
 * @param string $url URL de destino
 * @param string $success Indicador de éxito
 * @param string $mensaje Mensaje a mostrar
 */
function redirigirConMensaje($url, $success, $mensaje){
    // Almacenar el resultado en la sesión
    $_SESSION['success'] = $success;
    $_SESSION['message'] = $mensaje;

    // Realizar la redirección
    header("Location: $url");
    exit();
}

// REGISTRO USUARIO
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['registro'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $resultado = $usuarioBd->registrarUsuario($nombre, $email, $password);

    redirigirConMensaje('../../login.php', $resultado['success'], $resultado['message']);
}

// INICIO DE SESION
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $resultado = $usuarioBd->inicioSesion($email, $password);

    if($resultado['success'] == "success"){
        $_SESSION['user_id'] = $resultado['id'];
    }

    redirigirConMensaje('../../adminRecetas.php', $resultado['success'], $resultado['message']);
}

// RECUPERACION DE CONTRASEÑA
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['recuperar'])){
    $email = $_POST['email'];

    $resultado = $usuarioBd->recuperarPassword($email);

    redirigirConMensaje('../../login.php', $resultado['success'], $resultado['message']);
}