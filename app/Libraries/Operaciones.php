<?php

namespace App\Libraries;

/**
 * Description of Operaciones
 * 
 * Esta clase se encarga de formatear, validar y ejecutar las operaciones solicitadas sobre una Matriz 3D.
 * 
 * 
 * @author wmhr28
 */
class Operaciones {

    /**
     * Recibe una operación y las verifica, luego la ejecuta dentro de una matriz 3D, 
     * y devuelve el resultado de la operación
     * 
     * @param  string  $operacion 
     * @param  \App\Libraries\Matriz  $Matriz
     * 
     * @return array ['result' => $result, 'input' => $inputType, 'value' => $operacion, 'resp' => $resp, 'error' => $error]
     * 
     * @example 
     * Formato 1: Operaciones::input("UPDATE x y z W", $Matriz)
     * Formato 2: Operaciones::input("QUERY  x1 y1 z1 x2 y2 z2", $Matriz) 
     * 
     * Ejemplo 1: Operaciones::input("UPDATE 2 2 2 4", $Matriz)
     * Ejemplo 2: Operaciones::input("QUERY  1 1 1 3 3 3", $Matriz)
     */
    static function input($operacion, $Matriz) {
        $result = FALSE;
        $error = '';
        $resp = '';

        $data = explode(' ', $operacion);
        $inputType = $data[0];
        switch ($inputType) {
            case 'UPDATE':
                $result = TRUE;
                $resp = $Matriz->update($data[1], $data[2], $data[3], $data[4]);
                break;
            case 'QUERY':
                $result = TRUE;
                $resp = $Matriz->query($data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
                break;
            default:
                $error = 'No existe ese tipo de operación';
                break;
        }

        return array('result' => $result, 'input' => $inputType, 'value' => $operacion, 'resp' => $resp, 'error' => $error);
    }

}
