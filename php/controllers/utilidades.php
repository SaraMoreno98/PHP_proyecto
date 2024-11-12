<?php

/**
 * Clase Utilidades
 * Proporciona métodos estáticos para el manejo de parámetros de URL y otras utilidades
 */
class Utilidades{

    /**
     * Parsea los parámetros de una URI y los devuelve como array asociativo
     * @param string $uri La URI a parsear
     * @return array Array asociativo con los parámetros encontrados
     */
    public static function parseUriParameters($uri) {
        // Separar la ruta de los parámetros usando el carácter '?'
        $parts = explode('?', $uri);
        
        // Si no hay parámetros (no hay '?'), devolver array vacío
        if (count($parts) == 1) {
            return [];
        }
        
        // Obtener la cadena de parámetros (todo lo que va después del '?')
        $paramString = $parts[1];
        
        // Dividir los parámetros por el carácter '&'
        $paramPairs = explode('&', $paramString);
        
        // Array para almacenar los pares clave-valor de los parámetros
        $params = [];
        
        // Procesar cada par de parámetros
        foreach ($paramPairs as $pair) {
            $item = explode('=', $pair);
            if (count($item) == 2) {
                $key = urldecode($item[0]);
                $value = urldecode($item[1]);
                $params[$key] = $value;
            }
        }
        
        return $params;
    }

    /**
     * Obtiene el valor de un parámetro específico del array de parámetros
     * @param array $params Array de parámetros
     * @param string $paramName Nombre del parámetro a buscar
     * @return mixed|null Valor del parámetro o null si no existe
     */
    public static function getParameterValue(array $params, string $paramName) {
        return $params[$paramName] ?? null;
    }
}