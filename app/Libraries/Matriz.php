<?php

namespace App\Libraries;

class Matriz {

    private $matriz;
    private $N;

    function getN() {
        return $this->N;
    }

    function getMatriz() {
        return $this->matriz;
    }

    function setN($N) {
        $this->N = $N;
    }

    function __construct($N) {
        $this->N=$N;
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
        $validate = $this->esValidoUpdate($x, $y, $z, $W);
        if ($validate['result']) {
            $x--;
            $y--;
            $z--;
            $this->matriz[$x][$y][$z] = $W;
            $result = TRUE;
        }
        $resp['result'] = $result;
        $resp['es_valido'] = $validate;
        return $resp;
    }

    function query($vx1, $vy1, $vz1, $vx2, $vy2, $vz2) {
        $result = FALSE;
        $suma = 0;
        $validate = $this->esValidoQuery($vx1, $vy1, $vz1, $vx2, $vy2, $vz2);
        if ($validate['result']) {
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
        $resp['es_valido'] = $validate;
        return $resp;
    }

    public function esValidoN($valor) {
        return Utils::estaEntre($valor, 1, 100, 'Restricción de valor en N');
    }

    public function esValidoW($valor) {
        return Utils::estaEntre($valor, pow(-10, 9), pow(10, 9), 'Restricción de valor en W');
    }

    public function esValidoEje($x, $y, $z) {
        $N = $this->getN();
        
        $restX = Utils::estaEntre($x, 1, $N, 'Restricción de valor en X');
        $restY = Utils::estaEntre($y, 1, $N, 'Restricción de valor en Y');
        $restZ = Utils::estaEntre($z, 1, $N, 'Restricción de valor en Z');
        
        $validacion = ($restX['result'] and $restY['result'] and $restZ['result']);
        $resp['result'] = $validacion;

        if (!$restX['result']) {
            $resp['errors'][] = $restX['errors'];
        }
        if (!$restY['result']) {
            $resp['errors'][] = $restY['errors'];
        }
        if (!$restZ['result']) {
            $resp['errors'][] = $restZ['errors'];
        }

        return $resp;
    }

    public function esValidoUpdate($x, $y, $z, $W) {
        $restEje = $this->esValidoEje($x, $y, $z);
        $restW = $this->esValidoW($W);
        $validacion = ($restEje['result'] and $restW['result']);
        $resp['result'] = $validacion;


        if (!$restEje['result']) {
            $resp['errors']['eje'] = $restEje['errors'];
        }
        if (!$restW['result']) {
            $resp['errors']['W'] = $restW['errors'];
        }

        return $resp;
    }

    public function esValidoQuery($x1, $y1, $z1, $x2, $y2, $z2) {
        $restEje1 = $this->esValidoEje($x1, $y1, $z1);
        $restEje2 = $this->esValidoEje($x2, $y2, $z2);

        $validacion = ($restEje1['result'] and $restEje2['result']);
        $resp['result'] = $validacion;
        if (!$restEje1['result']) {
            $resp['errors']['eje_1'] = $restEje1['errors'];
        }
        if (!$restEje2['result']) {
            $resp['errors']['eje_2'] = $restEje2['errors'];
        }

        return $resp;
    }

}
