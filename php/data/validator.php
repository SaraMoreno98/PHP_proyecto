<?php

class Validator{
    public static function sanear($datos){
        $saneados = [];
        foreach($datos as $key => $value){
            $saneados[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
        }
        return $saneados;
    }

    //validar nombre
    if(!isset($data['nombre']) || empty(trim($data['nombre']))){
        $errors['nombre'] = "El nombre es necesario";
    }elseif(strlen($data['nombre']) < 2 || strlen($data['nombre']) > 15){
        $errors['nombre'] = "El nombre debe tener entre 2 y 15 caracteres";
    }

    //validar apellido
    if(!isset($data['apellido']) || empty(trim($data['apellido']))){
        $errors['apellido'] = "El apellido es necesario";
    }elseif(strlen($data['apellido']) < 2 || strlen($data['apellido']) > 30){
        $errors['apellido'] = "El apellido debe tener entre 2 y 30 caracteres";
    }


    //validar biografia
    if(isset($data['biografia']) && strlen($data['biografia']) > 200){
        $errors['biografia'] = "La biografia es demasiado extensa";
    }

    return $errors;
}