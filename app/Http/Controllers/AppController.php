<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Description of AppController
 * 
 * Esta clase de tipo Controller contiene la lógica del flujo de la aplicación, y sus peticiones, 
 * debido que es una aplicación pequeña se creó un solo controlador
 * 
 * 
 * @author wmhr28
 */
class AppController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | AppController
      |--------------------------------------------------------------------------
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Muestra la pantalla inicial de la aplicación.
     *
     * @return Response view index.blade.php 
     * @category ControllerViews
     */
    public function index() {
        return view('index');
    }

    /**
     * Muestra la pantalla para realizar el test
     *
     * @return Response view test.blade.php 
     * @category ControllerViews
     */
    public function iniciarTest(Request $request) {
        $T = $request->input('T');
        session(['T' => $T]);
        session(['T_actual' => 1]);
        return view('test');
    }

    /**
     * Permite realizar una petición AJAX para obtener los campos que permitirán el ingreso de los datos (Operaciones)
     *
     * @return string html 
     * @category AjaxRequests
     */
    public function conf_operaciones(Request $request) {
        $M = $request->input('M');

        $campo_tpl = '<div class="form-group">
                                <label for="%1$s">%3$s</label>
                                <input class="form-control" type="text" required="required" min="1" max="1000" id="%2$s" name="%1$s" id="%1$s">
                            </div>';
        $resp = '';
        for ($i = 1; $i <= $M; $i++) {
            $resp.=sprintf($campo_tpl, "ops[]", "id_op_$i", "Operaci&oacute;n $i");
        }
        return $resp;
    }

    /**
     * Permite realizar una petición AJAX para obtener el resultado de las operaciones
     *
     * @return string html 
     * @category AjaxRequests
     */
    public function resultado(Request $request) {
        $N = $request->input('N');
        $token = $request->input('_token');
        $ops = $request->input("ops_");

        $matriz = new \App\Libraries\Matriz($N);

        $fila_tpl = '<div class="form-group">
                                <label >Entrada: </label>
                                <label >%1$s</label><br/>
                                <label >Salida: </label>
                                <label >%2$s</label>
                            </div>';
        $boton_tpl = '<div class="form-group"> 
            <form method="POST" action="siguienteTest" accept-charset="UTF-8"><input name="_token" type="hidden" value="' . $token . '">
                                <input class="btn btn-primary form-control" type="submit" id="siguiente" value="Continuar">
                                  </form>
                      </div>';
        $result = '';
        if (!empty($ops)) {
            foreach ($ops as $item) {
                $entrada = $item['value'];
                $resp = \App\Libraries\Operaciones::input($entrada, $matriz);
                $input = $resp['input'];
                $salida = '';
                if ($resp['result']) {
                    if ($resp['resp']['result']) {
                        if ($input == 'QUERY') {
                            $salida = $resp['resp']['value'];
                        }
                    } else {
                        if (!$resp['resp']['es_valido']['result']) {

                            $salida = json_encode($resp['resp']['es_valido']['errors']);
                        }
                    }
                } else {
                    $salida = $resp['error'];
                }
                $result.=sprintf($fila_tpl, $entrada, $salida);
            }
        }
        return $result . $boton_tpl;
    }

    /**
     * Dirigue el flujo de las pruebas realizadas, en caso de que complete la cantidad de pruebas regresa al inicio.
     *
     * @return Response view/redirect
     * @category ControllerViews
     */
    public function siguienteTest() {
        $T = session('T');

        $T_actual = session('T_actual');
        $T_actual++;
        session(['T_actual' => $T_actual]);

        if ($T_actual <= $T) {
            return view('test');
        } else {
            session()->flush();
            session()->regenerate();
            return redirect('/');
        }
    }

}
