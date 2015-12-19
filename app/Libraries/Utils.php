<?php

namespace App\Libraries;

class Utils {

    public static function estaEntre($valor, $min, $max, $error) {
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
