<?php

class IntegralesTest extends TestCase {

    /**
     * A basic route app test.
     *
     * @return void
     */
    public function testPeticionesPeticionesValidas() {
        $this->call('GET', '/');
        $this->assertResponseOk();


        $redirectToIndex = array('iniciarTest', 'siguienteTest');
        foreach ($redirectToIndex as $item) {
            $this->call('GET', "/$item");
            $this->assertRedirectedTo('/');
        }
    }

    public function testFlujoApp() {
        // Si el T_actual (test actual) es igual a T (test permitidos)
        // el siguienteTest debe redirigirse al inicio de la app o directorio raiz

        $this->session(array('T' => 1, 'T_actual' => 1));
        $this->call('POST', 'siguienteTest');
        $this->assertRedirectedTo('/');

        // Si el T_actual (test actual) es igual a T (test permitidos)
        // se debe mantener en la pagina que tiene en el titulo Test 1

        $this->session(array('T' => 1, 'T_actual' => 0));
        $this->call('POST', 'siguienteTest');
        $this->contains('Test 1');
    }

    public function testCubeSumation() {
        /* 4 5
          UPDATE 2 2 2 4
          QUERY 1 1 1 3 3 3
          UPDATE 1 1 1 23
          QUERY 2 2 2 4 4 4
          QUERY 1 1 1 3 3 3 */
        $N = 4;
        $result1=4;
        $result2=4;
        $result3=27;
        $matriz = new App\Libraries\Matriz($N);
        $operaciones = new App\Libraries\Operaciones();
        $operaciones->input('UPDATE 2 2 2 4', $matriz);
        $resp = $operaciones->input('QUERY 1 1 1 3 3 3', $matriz);
        $this->assertEquals($result1, $resp['resp']['value']);
        
        $operaciones->input('UPDATE 1 1 1 23', $matriz);
        $resp = $operaciones->input('QUERY 2 2 2 4 4 4', $matriz);
        $this->assertEquals($result2, $resp['resp']['value']);
        
        
        $resp = $operaciones->input('QUERY 1 1 1 3 3 3', $matriz);
        $this->assertEquals($result3, $resp['resp']['value']);

        //Test desde Matriz

        $matriz2 = new App\Libraries\Matriz($N);
        $matriz2->update(2, 2, 2, 4);
        $resp = $matriz2->query(1, 1, 1, 3, 3, 3);
        $this->assertEquals($result1, $resp['value']);
    }

}
