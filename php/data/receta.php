<?php
include_once 'config.php';
require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

/**
 * Elimina un tipo de receta
 * @param int $id ID del tipo a eliminar
 * @return int Número de filas afectadas
 */
class Receta{
    private Database $db;

    /**
     * Constructor: inicializa la conexión a la base de datos
     */
    public function __construct(){
        $this->db = new Database();
    }

    /**
     * Obtiene todas las recetas de la base de datos
     * @return array Lista de todas las recetas con sus detalles
     */
    public function getAll(){
        $result = $this->db->query("SELECT id, id_tipo, img, nombre, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos FROM receta");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    /**
     * Obtiene una receta específica por su ID
     * @param int $id ID de la receta a buscar
     * @return array|null Datos de la receta encontrada o null
     */
    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, id_tipo, img, nombre, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos FROM receta WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva receta
     * @param string $imagen Ruta de la imagen de la receta
     * @param string $nombre Nombre de la receta
     * @param string $descripcion Descripción de la receta
     * @param int $comensales Número de comensales
     * @param string $preparacion Tiempo de preparación
     * @param string $cocinar Tiempo de cocción
     * @param int $temperatura Temperatura de cocción
     * @param string|null $ingredientes Lista de ingredientes (opcional)
     * @param string|null $pasos Pasos de preparación (opcional)
     * @return mixed ID de la nueva receta o array de errores
     */
    public function create($imagen, $nombre, $descripcion, $comensales, $preparacion, $cocinar, $temperatura, $ingredientes = null, $pasos = null){
        $data = ['img' => $imagen,'nombre' => $nombre, 'descripcion' => $descripcion, 'comensales' => $comensales, 'preparacion' => $preparacion, 'cocinar' => $cocinar, 'temperatura' => $temperatura, 'ingredientes' => $ingredientes, 'pasos' => $pasos];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $imagenSaneado = $dataSaneados['img'];
        $nombreSaneado = $dataSaneados['nombre'];
        $descripcionSaneado = $dataSaneados['descripcion'];
        $comensalesSaneado = $dataSaneados['comensales'];
        $preparacionfiaSaneado = $dataSaneados['preparacion'];
        $cocinarSaneado = $dataSaneados['cocinar'];
        $temperaturafiaSaneado = $dataSaneados['temperatura'];
        $ingredientesSaneado = $dataSaneados['ingredientes'];
        $pasosSaneado = $dataSaneados['pasos'];

        //lanzamos la consulta
        $this->db->query("INSERT INTO receta (img, nombre, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)", [$imagenSaneado, $nombreSaneado, $descripcionSaneado, $comensalesSaneado, $preparacionfiaSaneado, $cocinarSaneado, $temperaturafiaSaneado, $ingredientesSaneado, $pasosSaneado]);

        return $this->db->query("SELECT LAST_INSERT_ID() as id")->fetch_assoc()['id'];
    }

    /**
     * Actualiza una receta existente
     * @param int $id ID de la receta a actualizar
     * @param int $id_tipo Tipo de receta
     * @param string $imagen Nueva ruta de imagen
     * @param string $nombre Nuevo nombre
     * @param string $descripcion Nueva descripción
     * @param int $comensales Nuevo número de comensales
     * @param string $preparacion Nuevo tiempo de preparación
     * @param string $cocinar Nuevo tiempo de cocción
     * @param int $temperatura Nueva temperatura
     * @param string|null $ingredientes Nuevos ingredientes
     * @param string|null $pasos Nuevos pasos
     * @return mixed Número de filas afectadas o array de errores
     */
    public function update($id, $id_tipo, $imagen, $nombre, $descripcion, $comensales, $preparacion, $cocinar, $temperatura, $ingredientes = null, $pasos = null){
        $data = ['id' => $id, 'id_tipo'=> $id_tipo, 'img' => $imagen, 'nombre' => $nombre, 'descripcion' => $descripcion, 'comensales' => $comensales, 'preparacion' => $preparacion, 'cocinar' => $cocinar, 'temperatura' => $temperatura, 'ingredientes' => $ingredientes, 'pasos' => $pasos];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $imagenSaneado = $dataSaneados['img'];
        $nombreSaneado = $dataSaneados['nombre'];
        $descripcionSaneado = $dataSaneados['descripcion'];
        $comensalesSaneado = $dataSaneados['comensales'];
        $preparacionfiaSaneado = $dataSaneados['preparacion'];
        $cocinarSaneado = $dataSaneados['cocinar'];
        $temperaturafiaSaneado = $dataSaneados['temperatura'];
        $ingredientesSaneado = $dataSaneados['ingredientes'];
        $pasosSaneado = $dataSaneados['pasos'];
        $idSaneado = $dataSaneados['id'];


        $this->db->query("UPDATE receta SET img = ?, nombre = ?, apellido = ?, f_nacimiento = ?, biografia = ? WHERE id = ?", [$imagenSaneado, $nombreSaneado, $descripcionSaneado, $comensalesSaneado, $preparacionfiaSaneado, $cocinarSaneado, $temperaturafiaSaneado, $ingredientesSaneado, $pasosSaneado, $idSaneado]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }

    /**
     * Elimina una receta
     * @param int $id ID de la receta a eliminar
     * @return int Número de filas afectadas
     */
    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM receta WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}



// LOGIN
/**
 * Clase UsuarioBD
 * Gestiona la autenticación y gestión de usuarios en la base de datos
 * Incluye funcionalidades de registro, verificación, inicio de sesión y recuperación de contraseña
 */
class UsuarioBD{
    private $conn;
    private $url = 'http://localhost/PHP/PHP_proyecto';

    /**
     * Constructor: establece la conexión con la base de datos
     * @throws Exception Si hay error en la conexión
     */
    public function __construct(){
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->conn->connect_error){
            die("Error en la conexión: " . $this->conn->connect_error);
        }
    }

    // FUNCION PARA ENVIAR CORREOS SIMULADOS
    /**
     * Simula el envío de correos guardándolos en un archivo de log
     * @param string $destinatario Email del destinatario
     * @param string $asunto Asunto del correo
     * @param string $mensaje Contenido del mensaje
     * @return array Estado del envío simulado
     */
    public function enviarCorreosSimulados($destinatario, $asunto, $mensaje){
        $archivo_log = __DIR__ . '/correos_simulados.log';
        $contenido = "Fecha: " .date('Y-m-d H:i:s' . "\n");
        $contenido .= "Para: $destinatario\n";
        $contenido .= "Asunto: $asunto\n";
        $contenido .= "Mensaje: \n$mensaje\n";
        $contenido .= "__________________________________\n\n";

        file_put_contents($archivo_log, $contenido, FILE_APPEND);

        return ["success" => false, "message" => "Registro exitoso. Por favor verifica tu correo"];
    }

    // LAS SIGUIENTES FUNCIONES SON FUNCIONES DE ENCRIPTADO
    // GENERAR UN TOKEN ALEATORIO
    /**
     * Genera un token aleatorio para verificación o recuperación
     * @return string Token hexadecimal de 64 caracteres
     */
    public function generarToken(){
        // Esto genera un string aleatorio de números y letras en hexadecimal (0-9 y a-f)
        return bin2hex(random_bytes((32)));
    }

    /**
     * Registra un nuevo usuario en el sistema
     * @param string $nombre Nombre del usuario
     * @param string $email Email del usuario
     * @param string $password Contraseña sin encriptar
     * @param int $verificado Estado de verificación inicial
     * @return array Resultado del registro
     */
    public function registrarUsuario($nombre, $email, $password, $verificado = 0){
        // FUNCION QUE ENCRIPTA CONTRASEÑA AL GUARDARLA
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = $this->generarToken();        

        //comprobar si el email existe
        $existe = $this->existeEmail($email);

        $sql = "INSERT INTO admin (nombre, email, password, token, verificado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        // Indicamos que la siguiente linea es un string al poner "sssi"
        $stmt->bind_param("ssssi",$nombre,  $email, $password, $token, $verificado);

        if(!$existe){
            if($stmt->execute()){
                // Correcto
                $mensaje = "Por favor, verifica tu cuenta haciendo clic en este enlace: $this->url/verificar.php?token=$token";

                // PARA LOS CORREOS POR FTP
                // $mensaje = Correo::enviarCorreo($email, "Cliente", "Verificación de cuenta", $mensaje);

                // PARA LOS CORREOS SIMULADOS
                $mensaje = $this->enviarCorreosSimulados($email, "Verificación de cuenta", $mensaje);
            }else{
                $mensaje = ["success" => false, "message" => "Error en el registro: " . $stmt->error];
            }
        }else{
            $mensaje = ["success" => false, "message" => "Ya existe una cuenta con ese email"];
        }

        return $mensaje;
    }

    /**
     * Verifica el token de un usuario
     * @param string $token Token de verificación
     */
    public function verificarTokens($token){
        // Buscar al usuario(id) con el token recibido
        $sql = "SELECT id FROM admin WHERE token = ? AND verificado = 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            // token es válido y actualizamos el estado de verificacion del usuario
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            $update_sql = "UPDATE admin SET verificado = 1, token = NULL WHERE id = ?";
            $update_stmt = $this->conn->prepare($update_sql);
            $update_stmt->bind_param("i", $user_id);

            $resultado = ["success" => 'error', "message" => "Hubo un error en la verificación de su cuenta. Por favor inténtalo de nuevo más tarde"];

            if($update_stmt->execute()){
                $resultado = ["success" => 'success', "message" => "Verificacion realizada exitosamente"];
            }
            return $resultado;
        }
    }

    /**
     * Procesa el inicio de sesión de un usuario
     * @param string $email Email del usuario
     * @param string $password Contraseña sin encriptar
     * @return array Resultado del inicio de sesión
     */
    public function inicioSesion($email, $password){
        $sql = "SELECT id, email, password, verificado FROM admin WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $resultado = ["success"=> 'info', "message"=> "Usuario no encontrado"];

        if($row = $result->fetch_assoc()){
            if($row['verificado'] == 1 && password_verify($password, $row['password'])){
                $resultado = ["success" => "success", "message" => "Has iniciado sesion con " . $email, "id" => $row['id']];
                // Actualizamos la fecha del último inicio de sesión
                $sql = "UPDATE admin SET ultima_conexion = CURRENT_TIMESTAMP WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $row['id']);
                $stmt->execute();
            }
        }else{
            $resultado = ["success" => "error", "message" => "Credenciales invalidas o cuenta no válida"];
        }
        return $resultado;
    }

    /**
     * Verifica si existe un email en la base de datos
     * @param string $email Email a verificar
     * @return bool True si existe, False si no
     */
    public function existeEmail($email){
        //verificamos si existe el correo en la bbdd
        $check_sql = "SELECT id FROM admin WHERE email = ?";
        $check_stmt = $this->conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();

        $result = $check_stmt->get_result();

        return $result->num_rows > 0;
    }

    /**
     * Inicia el proceso de recuperación de contraseña
     * @param string $email Email del usuario
     * @return array Resultado del proceso
     */
    public function recuperarPassword($email){

        $existe = $this->existeEmail($email);

        $resultado = ["success" => 'info', "message" => "El correo electrónico  proporcionado no corresponde a ningún usuario registrado."];

        //si el correo existe en la bbdd
        if($existe){
            $token = $this->generarToken();

            $sql = "UPDATE admin SET token_recuperacion = ? WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $token, $email);

            //ejecuta la consulta
            if($stmt->execute()){
                $mensaje = "Para restablecer tu contraseña, haz click en este enlace: $this->url/restablecer.php?token=$token";

                // PARA LOS CORREOS POR FTP
                // $mensaje = Correo::enviarCorreo($email, "Cliente", "Restablecer Contraseña", $mensaje);

                // PARA CORREOS SIMULADOS
                $this->enviarCorreosSimulados($email, "Recuperación de contraseña", $mensaje);
                $resultado = ["success" => 'success', "message" => "Se ha enviado un enlace de recuperación a tu correo"];
            }else{
                $resultado = ["success" => 'error', "message" => "Error al procesar la solicitud"];
            }
        }
        return $resultado;
    }

    /**
     * Restablece la contraseña de un usuario
     * @param string $token Token de recuperación
     * @param string $nueva_password Nueva contraseña sin encriptar
     * @return array Resultado del proceso
     */
    public function restablecerContraseña($token, $nueva_password){
        $password = password_hash($nueva_password, PASSWORD_DEFAULT);
        // Buscamos al usuario con el token proporcionado
        $sql = "SELECT id FROM admin WHERE token_recuperacion = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $result = $stmt->get_result();

        $resultado = ["success" => ' info', "message" => "El token de recuperación no es válido o ya ha sido utilizado"];

        if ($result->num_rows === 1){
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            // Actualizar la contraseña y eliminar el token de recuperación
            $update_sql = "UPDATE admin SET password = ?, token_recuperacion = NULL WHERE id = ?";
            $update_stmt = $this->conn->prepare($update_sql);
            $update_stmt->bind_param("si", $password, $user_id);

            if($update_stmt->execute()){
                $resultado = ["success" => 'success', "message" => "La contraseña se ha actualizado correctamente"];
            }else{
                $resultado = ["success" => 'error', "message" => "La contraseña no se ha podido actualizar. Por favor, intételo de nuevo"];
            }
        }
        return $resultado;
    }
}