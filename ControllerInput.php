<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author maherrera
 */
require_once './Matriz.php';

class ControllerInput {

    private $M;
    private $N;
    private $Matriz;
    private $M_realizados;

    function __construct($N, $M) {
        $this->N = $N;
        $this->Matriz = new Matriz($N);
        $this->M = $M;
        $this->M_realizados = 0;
    }

    function input($value) {
        $result = FALSE;
        $error = '';
        $resp ='';
        if ($this->M < $this->M_realizados) {
            $this->M_realizados++; 
            $data = explode(' ', $value);
            $inputType = $data[0];
            switch ($inputType) {
                case 'UPDATE':
                    $result = TRUE;
                    $resp = $this->Matriz->update($data[1], $data[2], $data[3], $data[4]);
                    break;
                case 'QUERY':
                    $result = TRUE;
                    $resp = $this->Matriz->query($data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
                    break;
                default:
                    $error = 'No existe ese tipo de entrada';
                    break;
            }
        } else {
            $error = 'Ha exedido la cantidad de Movimientos establecidos';
        }
        return array('result' => $result, 'resp' => $resp, 'error' => $error);
    }

}
