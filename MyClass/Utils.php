<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author maherrera
 */
class Utils {

    public static function restricionesValor($valor, $min, $max, $error) {
        $result = FALSE;
        if (!($min <= $valor or $valor <= $max)) {
            $result = TRUE;
        }
        $resp['result'] = $result;
        $resp['errors'] = $error;
        return $resp;
    }

}
