<?php

require_once 'database.php';
require_once 'validator.php';
require_once 'validatorException.php';

class Receta{
    private Database $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll(){
        $result = $this->db->query("SELECT id, id_tipo, img, nombre, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos FROM receta");

        return $result->fetch_all((MYSQLI_ASSOC));
    }

    public function getById($id){
        $idSaneado = Validator::sanear([$id]);
        $result = $this->db->query("SELECT id, id_tipo, img, nombre, descripcion, comensales, preparacion, cocinar, temperatura, ingredientes, pasos FROM receta WHERE id = ?", [$idSaneado[0]]);

        return $result->fetch_assoc();
    }

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

    public function delete($id){
        $idSaneado = Validator::sanear([$id]);
        $this->db->query("DELETE FROM receta WHERE id = ?", [$idSaneado[0]]);
        return $this->db->query("SELECT ROW_COUNT() as affected")->fetch_assoc()['affected'];
    }
}