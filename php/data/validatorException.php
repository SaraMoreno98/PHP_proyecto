<?php
/**
 * Clase ValidatorException
 * Extiende la clase Exception para manejar errores de validación
 * Permite almacenar y recuperar múltiples errores de validación
 */
class ValidatorException extends Exception{
    /** @var array Array de errores de validación */
    protected $errors;

    /**
     * Constructor de la excepción
     * @param array $errors Array de mensajes de error
     */
    public function __construct($errors)
    {
        $this->errors = $errors;
        parent::__construct("Error de validación");
    }

    /**
     * Obtiene los errores de validación
     * @return array Array de errores
     */
    public function getErrors(){
        return $this->errors;
    }
}