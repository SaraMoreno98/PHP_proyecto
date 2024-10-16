<?php

require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

class Tipo{
    private Database $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $result = $this->db->query("SELECT id, nombre FROM tipo");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, nombre FROM tipo WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

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

    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM tipo WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}