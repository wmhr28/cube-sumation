<?php

namespace App\Libraries;

/**
 * Description of Utils
 * 
 * Esta clase almacena una colección de funciones que reutilizables y de uso común
 * 
 * 
 * @author wmhr28
 */
class Utils {

    /**
     * Verifica si un valor se encuentra dentro de un rango, 
     * además permite establecer un mensaje descriptivo del error 
     * 
     * @param  int  $valor 
     * @param  int  $min
     * @param  int  $max
     * @param  string $error (opcional)( 
     * 
     * @return array ['result' => $result, 'errors' => $error]
     *  
     */
    public static function estaEntre($valor, $min, $max, $error='') {
        $result = false;
        if ($valor >= $min and $valor <= $max) {
            $result = TRUE;
        }
        $resp['result'] = $result;
        if (!$result) {
            $resp['errors'] = $error;
        }

        return $resp;
    }

}
