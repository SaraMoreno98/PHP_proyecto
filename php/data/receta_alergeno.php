<?php

require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

class recetaAlergenos{
    private Database $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $result = $this->db->query("SELECT id, id_receta, id_alergenos FROM receta_alergenos");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, id_receta, id_alergenos FROM receta_alergenos WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

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

    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM receta_alergenos WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}