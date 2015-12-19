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

class ControllerTest {

    private $T;
    private $T_realizados;

    function __construct($T) {
        $this->T = $T;
        $this->T_realizados = 0;
    }

    function test() {
        $result = FALSE;
        $error = '';
        if ($this->T < $this->T_realizados) {
            $this->T_realizados++;
            $result = TRUE;
        } else {
            $error = 'Ha exedido la cantidad de Test establecidos';
        }
        return array('result' => $result, 'error' => $error);
    }

}
