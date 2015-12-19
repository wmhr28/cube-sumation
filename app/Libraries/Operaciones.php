<?php

namespace App\Libraries;

class Operaciones {

    static function input($value, $Matriz) {
        $result = FALSE;
        $error = '';
        $resp = '';

        $data = explode(' ', $value);
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

        return array('result' => $result,'input'=>$inputType,'value'=>$value, 'resp' => $resp, 'error' => $error);
    }

}
