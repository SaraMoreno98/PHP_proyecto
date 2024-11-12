<?php

require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

/**
 * Clase recetaAlergenos
 * Gestiona la relación entre recetas y alérgenos en la base de datos
 * Implementa operaciones CRUD (Create, Read, Update, Delete)
 */
class recetaAlergenos{
    private Database $db;

    /**
     * Constructor: inicializa la conexión a la base de datos
     */
    public function __construct(){
        $this->db = new Database();
    }

    /**
     * Obtiene todos los registros de receta_alergenos
     * @return array Lista de todas las relaciones receta-alérgeno
     */
    public function getAll(){
        $result = $this->db->query("SELECT id, id_receta, id_alergenos FROM receta_alergenos");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    /**
     * Obtiene un registro específico por ID
     * @param int $id ID del registro a buscar
     * @return array|null Datos del registro encontrado o null
     */
    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, id_receta, id_alergenos FROM receta_alergenos WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

    /**
     * Crea una nueva relación receta-alérgeno
     * @param int $id_receta ID de la receta
     * @param int $id_alergenos ID del alérgeno
     * @return mixed ID del nuevo registro o array de errores
     */
    public function create($id_receta, $id_alergenos){
        $data = ['id_receta' => $id_receta, 'id_alergenos' => $id_alergenos];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $id_receta = $dataSaneados['id_receta'];
        $id_alergenos = $dataSaneados['id_alergenos'];

        //lanzamos la consulta
        $this->db->query("INSERT INTO receta_alergenos (id_receta, id_alergenos) VALUES(?, ?)", [$id_receta, $id_alergenos]);

        return $this->db->query("SELECT LAST_INSERT_ID() as id")->fetch_assoc()['id'];
    }

    /**
     * Actualiza una relación receta-alérgeno existente
     * @param int $id ID del registro a actualizar
     * @param int $id_receta Nuevo ID de receta
     * @param int $id_alergenos Nuevo ID de alérgeno
     * @return mixed Número de filas afectadas o array de errores
     */
    public function update($id, $id_receta, $id_alergenos){
        $data = ['id' => $id, 'id_receta' => $id_receta, 'id_alergenos' => $id_alergenos];
        $dataSaneados = Validator::sanear($data);
        $errors = Validator::validarReceta($dataSaneados);

        if(!empty($errors)){
            $errores = new ValidatorException($errors);
            return $errores->getErrors();
        }

        $id_receta = $dataSaneados['id_receta'];
        $id_alergenos = $dataSaneados['id_alergenos'];
        $idSaneado = $dataSaneados['id'];


        $this->db->query("UPDATE receta_alergenos SET id_receta = ?, id_alergenos = ? WHERE id = ?", [$id_receta, $id_alergenos, $idSaneado]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }

    /**
     * Elimina una relación receta-alérgeno
     * @param int $id ID del registro a eliminar
     * @return int Número de filas afectadas
     */
    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM receta_alergenos WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}