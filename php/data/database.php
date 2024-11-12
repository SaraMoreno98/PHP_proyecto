<?php
require_once 'config.php';

/**
 * Clase Database
 * Maneja la conexión y las operaciones con la base de datos MySQL
 */
class Database{
    /** @var mysqli Conexión a la base de datos */
    private $conn;

    /**
     * Constructor de la clase
     * Establece la conexión con la base de datos usando las constantes definidas en config.php
     * @throws Exception Si hay error en la conexión
     */
    public function __construct(){
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if($this->conn->connect_error){
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    /**
     * Ejecuta una consulta SQL preparada
     * @param string $sql Consulta SQL con marcadores de posición (?)
     * @param array $params Array de parámetros para la consulta preparada
     * @return mysqli_result Resultado de la consulta
     * @throws Exception Si hay error en la preparación o ejecución de la consulta
     */
    public function query($sql, $params = []){
        // Preparar la consulta
        $estamento = $this->conn->prepare($sql);
        if($estamento === false){
            die("Error en la preparación: " . $this->conn->error);
        } 

        // Si hay parámetros, vincularlos a la consulta
        if(!empty($params)){
            /**
             * Crear cadena de tipos ('s' para cada parámetro)
             * count($params) cuenta los parámetros que hay en el array
             * str_repeat('s', count($params)) crea una cadena con tantas
             * 's' como parámetros hay
             * 's' indica que todos los parámetros serán tratados como strings
             */
            $types = str_repeat('s', count($params));

            /**
             * Vincular los parámetros
             * Añade los parámetros a la consulta
             * $types es la cadena de  tipos que acabamos de crear
             * ...$params es el operador de expansión que desempaqueta el array $params en argumentos individuales
             */
            $estamento->bind_param($types, ...$params);
        }
        // Ejecutar la consulta
        $estamento->execute();
        
        return $estamento->get_result();
    }

    /**
     * Cierra la conexión con la base de datos
     */
    public function close(){
        $this->conn->close();
    }
}