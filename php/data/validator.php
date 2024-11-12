<?php
/**
 * Clase Validator
 * Proporciona funcionalidades de validación y saneamiento de datos
 * para el sistema de gestión de recetas
 */
class Validator{
    /**
     * Sanea un array de datos eliminando HTML, espacios extras y caracteres especiales
     * @param array $datos Array de datos a sanear
     * @return array Array con los datos saneados
     */
    public static function sanear($datos){
        $saneados = [];
        foreach($datos as $key => $value){
            $saneados[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
        }
        return $saneados;
    }

// VALIDAR RECETA
    /**
     * Valida los datos de una receta según las reglas de negocio establecidas
     * @param array $data Array con los datos de la receta a validar
     * @return array Array con los errores encontrados (vacío si no hay errores)
     */
    public static function validarReceta($data){
        $errors = [];

        //validar nombre
        if(!isset($data['nombre']) || empty(trim($data['nombre']))){
            $errors['nombre'] = "El nombre es necesario";
        }elseif(strlen($data['nombre']) < 2 || strlen($data['nombre']) > 50){
            $errors['nombre'] = "El nombre debe tener entre 2 y 50 caracteres";
        }

        //validar descripción
        if(!isset($data['descripcion']) || empty(trim($data['descripcion']))){
            $errors['descripcion'] = "La descripción es necesaria";
        }elseif(strlen($data['descripcion']) < 2 || strlen($data['descripcion']) > 1000){
            $errors['descripcion'] = "La descripción debe tener entre 2 y 1000 caracteres";
        }

        //validar comensales
        if(isset($data['comensales']) && strlen($data['comensales']) > 20){
            $errors['comensales'] = "Demasiados comensales";
        }

        //validar tiempo de preparación
        if(isset($data['preparacion']) && strlen($data['preparacion']) > 12){
            $errors['preparacion'] = "Recalcula el tiempo";
        }

        //validar tiempo de cocinar
        if(isset($data['cocinar']) && strlen($data['cocinar']) > 12){
            $errors['cocinar'] = "Recalcula el tiempo";
        }

        //validar temperatura
        if(isset($data['temperatura']) && strlen($data['temperatura']) > 7){
            $errors['temperatura'] = "Demasiada temperatura";
        }

        //validar ingredientes
        if(isset($data['ingredientes']) && strlen($data['ingredientes']) > 65000){
            $errors['ingredientes'] = "Demasiada info";
        }

        //validar pasos
        if(isset($data['pasos']) && strlen($data['pasos']) > 65000){
            $errors['pasos'] = "Demasiada info";
        }

        return $errors;
    }
    
}