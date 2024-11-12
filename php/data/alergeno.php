<?php
require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

/**
 * Clase Alergenos
 * Gestiona las operaciones CRUD para los alérgenos en la base de datos
 */
class Alergenos{
    /** @var Database Instancia de la conexión a la base de datos */
    private Database $db;

    /**
     * Constructor de la clase
     * Inicializa la conexión a la base de datos
     */
    public function __construct(){
        $this->db = new Database();
    }

    /**
     * Obtiene todos los alérgenos de la base de datos
     * @return array Lista de todos los alérgenos
     */
    public function getAll(){
        $result = $this->db->query("SELECT id, nombre FROM alergenos");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    /**
     * Obtiene un alérgeno específico por su ID
     * @param mixed $id ID del alérgeno a buscar
     * @return array|null Datos del alérgeno o null si no existe
     */
    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, nombre FROM alergenos WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

    /**
     * Crea un nuevo alérgeno en la base de datos
     * @param string $nombre Nombre del nuevo alérgeno
     * @return mixed ID del nuevo alérgeno o array de errores si la validación falla
     */
    public function create($nombre){
        $data = ['nombre' => $nombre];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        // Si hay errores de validación, retornarlos
        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $nombreSaneado = $dataSaneados['nombre'];

        // Insertar el nuevo alérgeno
        $this->db->query("INSERT INTO alergenos (nombre) VALUES(?)", [$nombreSaneado]);

        // Retornar el ID del nuevo registro
        return $this->db->query("SELECT LAST_INSERT_ID() as id")->fetch_assoc()['id'];
    }

    /**
     * Actualiza un alérgeno existente
     * @param mixed $id ID del alérgeno a actualizar
     * @param string $nombre Nuevo nombre del alérgeno
     * @return mixed Número de filas afectadas o array de errores si la validación falla
     */
    public function update($id, $nombre){
        $data = ['id' => $id, 'nombre' => $nombre];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        // Si hay errores de validación, retornarlos
        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $nombreSaneado = $dataSaneados['nombre'];
        $idSaneado = $dataSaneados['id'];

        // Actualizar el alérgeno
        $this->db->query("UPDATE alergenos SET nombre = ? WHERE id = ?", [$nombreSaneado, $idSaneado]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }

    /**
     * Elimina un alérgeno de la base de datos
     * @param mixed $id ID del alérgeno a eliminar
     * @return int Número de filas afectadas
     */
    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM alergenos WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}