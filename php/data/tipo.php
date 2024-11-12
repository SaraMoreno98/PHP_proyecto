<?php
require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

/**
 * Clase Tipo
 * Gestiona los tipos de recetas en la base de datos
 * Implementa operaciones CRUD básicas para la tabla 'tipo'
 */
class Tipo{
    private Database $db;

    /**
     * Constructor: inicializa la conexión a la base de datos
     */
    public function __construct(){
        $this->db = new Database();
    }

    /**
     * Obtiene todos los tipos de recetas
     * @return array Lista de todos los tipos disponibles
     */
    public function getAll(){
        $result = $this->db->query("SELECT id, nombre FROM tipo");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    /**
     * Obtiene un tipo específico por su ID
     * @param int $id ID del tipo a buscar
     * @return array|null Datos del tipo encontrado o null
     */
    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, nombre FROM tipo WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo tipo de receta
     * @param string $nombre Nombre del nuevo tipo
     * @return mixed ID del nuevo registro o array de errores
     */
    public function create($nombre){
        $data = ['nombre' => $nombre];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $nombreSaneado = $dataSaneados['nombre'];

        //lanzamos la consulta
        $this->db->query("INSERT INTO tipo (nombre) VALUES(?)", [$nombreSaneado]);

        return $this->db->query("SELECT LAST_INSERT_ID() as id")->fetch_assoc()['id'];
    }

    /**
     * Actualiza un tipo existente
     * @param int $id ID del tipo a actualizar
     * @param string $nombre Nuevo nombre del tipo
     * @return mixed Número de filas afectadas o array de errores
     */
    public function update($id, $nombre){
        $data = ['id' => $id, 'nombre' => $nombre];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $nombreSaneado = $dataSaneados['nombre'];
        $idSaneado = $dataSaneados['id'];


        $this->db->query("UPDATE tipo SET nombre = ? WHERE id = ?", [$nombreSaneado, $idSaneado]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }

    /**
     * Elimina un tipo de receta
     * @param int $id ID del tipo a eliminar
     * @return int Número de filas afectadas
     */
    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM tipo WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}