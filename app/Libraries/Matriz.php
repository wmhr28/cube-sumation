<?php

namespace App\Libraries;

/**
 * Description of Matriz
 * 
 * Esta clase de maneja las reglas para resolver las operaciones sobre la matriz 3D (N,N,N)
 * 
 * 
 * @author wmhr28
 */
class Matriz {

    private $matriz;
    private $N;

    /**
     * Construye la Matriz 3D de acuerdo al tamaño N
     *  
     * @return void
     */
    function __construct($N) {
        $this->N = $N;
        for ($x = 0; $x < $N; $x++) {
            for ($y = 0; $y < $N; $y++) {
                for ($z = 0; $z < $N; $z++) {
                    $this->matriz[$x][$y][$z] = 0;
                }
            }
        }
    }

    /**
     * Devuelve el valor del atributo N
     *  
     * @return int 
     */
    function getN() {
        return $this->N;
    }

    /**
     * Ejecuta una operación update (si es válida) dentro la matriz 3D,
     * esta operación permite establecer un nuevo valor para una celda específica
     * 
     * @param  int  $x 
     * @param  int  $y
     * @param  int  $z
     * @param  int  $W (nuevo valor)  
     * 
     * @return array ['result' => $result, 'es_valido' => $validate]
     * 
     * @example 
     * Formato: $matriz->update(1, 2, 1, 40)  
     */
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

    /**
     * Ejecuta una operación query (si es válida) dentro la matriz 3D ,
     * esta operación permite sumar los valores en un rango de celdas con condición inclusiva
     * 
     * @param  int  $x1
     * @param  int  $y1
     * @param  int  $z1
     * @param  int  $x2
     * @param  int  $y2
     * @param  int  $z2  
     * 
     * @return array ['result' => $result, 'es_valido' => $validate,'value' => $suma]
     * 
     * @example 
     * Formato: $matriz->query(2, 2, 2, 3, 3, 3)  
     */
    function query($x1, $y1, $z1, $x2, $y2, $z2) {
        $result = FALSE;
        $suma = 0;
        $validate = $this->esValidoQuery($x1, $y1, $z1, $x2, $y2, $z2);
        if ($validate['result']) {
            $result = TRUE;
            $x1--;
            $y1--;
            $z1--;

            for ($x = $x1; $x < $x2; $x++) {
                for ($y = $y1; $y < $y2; $y++) {
                    for ($z = $z1; $z < $z2; $z++) {
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

    /**
     * Comprueba que el valor para W este dentro de un rango permitido
     * 
     * @param  int $valor
     * 
     * @return array ['result' => $result, 'errors' => $error] 
     *  
     */
    public function esValidoW($valor) {
        return Utils::estaEntre($valor, pow(-10, 9), pow(10, 9), 'Restricción de valor en W');
    }

    /**
     * Comprueba que el valor de un eje (x,y,z) sea valido de acuerdo al tamaño de la matriz
     * 
     * @param  int  $x 
     * @param  int  $y
     * @param  int  $z
     * 
     * @return array ['result' => $result, 'errors' => [$errors]] 
     *  
     */
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

    /**
     * Comprueba que los valores de una operación update sean válidos de acuerdo a las reglas
     * 
     * @param  int  $x 
     * @param  int  $y
     * @param  int  $z
     * @param  int  $W
     * 
     * @return array ['result' => $result, 'errors' => ['eje' => $respEje,'W' => $respW]] 
     *  
     */
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

    /**
     * Comprueba que los valores de una operación query sean válidos de acuerdo a las reglas
     * 
     * @param  int  $x1
     * @param  int  $y1
     * @param  int  $z1
     * @param  int  $x2
     * @param  int  $y2
     * @param  int  $z2
     * 
     * @return array ['result' => $result, 'errors' => ['eje_1' => $respEje_1,'eje_2' => $respEje_2]] 
     *  
     */
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
