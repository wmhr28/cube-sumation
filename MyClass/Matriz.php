<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Matriz
 *
 * @author maherrera
 */
require_once './Utils.php';
class Matriz {

    private $matriz;
    private $T;
    private $N;
    private $M;

    function getCountMatriz() {
        return count($this->matriz);
    }

    function getMatriz() {
        return $this->matriz;
    }

    function setT($T) {
        $this->T = $T;
    }

    function setN($N) {
        $this->N = $N;
    }

    function setM($M) {
        $this->M = $M;
    }

      function __construct($N) {
        for ($x = 0; $x < $N; $x++) {
            for ($y = 0; $y < $N; $y++) {
                for ($z = 0; $z < $N; $z++) {
                    $this->matriz[$x][$y][$z] = 0;
                }
            }
        }
    }

      function update($x, $y, $z, $W) {
        $result = FALSE;
        $validate = $this->restricionesUpdate($x, $y, $z, $W);
        if (!$validate['result']) {
            $x--;
            $y--;
            $z--;
            $this->matriz[$x][$y][$z] = $W;
             $result = TRUE;
        }
        $resp['result'] = $result; 
        $resp['validate'] = $validate;
        return $resp;
    }

      function query($vx1, $vy1, $vz1, $vx2, $vy2, $vz2) {
        $result = FALSE;
        $suma = 0;
        $validate = $this->restricionesQuery($vx1, $vy1, $vz1, $vx2, $vy2, $vz2);
        if (!$validate['result']) {
            $result = TRUE;
            $vx1--;
            $vy1--;
            $vz1--;

            for ($x = $vx1; $x < $vx2; $x++) {
                for ($y = $vy1; $y < $vy2; $y++) {
                    for ($z = $vz1; $z < $vz2; $z++) {
                        $suma+=$this->matriz[$x][$y][$z];
                    }
                }
            }
        } 
        $resp['value'] = $suma;
        $resp['result'] = $result; 
        $resp['validate'] = $validate;
        return $resp;
    }

   

    public function restricionesT($valor) {
        return Utils::restricionesValor($valor, 1, 50, 'Restricción de valor en T');
    }

    public function restricionesN($valor) {
        return Utils::restricionesValor($valor, 1, 100, 'Restricción de valor en N');
    }

    public function restricionesM($valor) {
        return Utils::restricionesValor($valor, 1, 1000, 'Restricción de valor en M');
    }

    public function restricionesW($valor) {
        return Utils::restricionesValor($valor, pow(-10, 9), pow(10, 9), 'Restricción de valor en W');
    }

    public function restricionesEjes($x, $y, $z) { 
        $N = $this->getCountMatriz();
        $restX = Utils::restricionesValor($x, 1, $N,'Restricción de valor en X');        
        $restY = Utils::restricionesValor($y, 1, $N, 'Restricción de valor en Y');        
        $restZ = Utils::restricionesValor($z, 1, $N,'Restricción de valor en Z'); 
        
        $resp['result'] = $restX['result'] and $restY['result'];
        $resp['errors'] = array(
            'X' => $restX['errors'],
            'Y' => $restY['errors'],
            'Z' => $restZ['errors'] 
        );
        return $resp; 
    }

    public function restricionesUpdate($x, $y, $z, $W) {
        $restEje = $this->restricionesEjes($x, $y, $z);
        $restW = $this->restricionesW($W);

        $resp['result'] = $restEje['result'] and $restW['result'];
        $resp['errors'] = array(
            'ejes' => $restEje['errors'],
            'W' => $restW['errors']
        );
        return $resp;
    }

    public function restricionesQuery($x1, $y1, $z1, $x2, $y2, $z2) {
        $restEje1 = $this->restricionesEjes($x1, $y1, $z1);
        $restEje2 = $this->restricionesEjes($x2, $y2, $z2);

        $resp['result'] = $restEje1['result'] and $restEje2['result'];
        $resp['errors'] = array(
            'eje1' => $restEje1['errors'],
            'eje2' => $restEje2['errors']
        );
        return $resp;
    }

}
