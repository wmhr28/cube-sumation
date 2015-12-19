<?php
require_once './ControllerInput.php';

$objController=new ControllerInput(4,5); 
var_dump($objController->input('UPDATE 2 2 2 4'));
var_dump($objController->input('QUERY 1 1 1 3 3 3'));
var_dump($objController->input('UPDATE 1 1 1 23'));
var_dump($objController->input('QUERY 2 2 2 4 4 4'));
var_dump($objController->input('QUERY 1 1 1 3 3 3'));

/*
require_once './Matriz.php';
$N = 4;
$objMatriz = new Matriz($N);
$respUpd= $objMatriz->update(2, 2, 2, 4); 
if (!$respUpd['result']) {
    var_dump($respUpd['validate']);
}

$respQuery=$objMatriz->query(1, 1, 1, 3, 3, 3);
if (!$respQuery['result']) {
    var_dump($respQuery['validate']);
}else{
    echo  $respQuery['value']. '<br>'; 
}

$objMatriz->update(1, 1, 1, 23); 
echo $objMatriz->query(2, 2, 2, 4, 4, 4) . '<br>';
echo $objMatriz->query(1, 1, 1, 3, 3, 3) . '<br>';

$N = 2;
$objMatriz1 = new Matriz($N);
$objMatriz1->update(2, 2, 2, 1); 
echo $objMatriz1->query(1, 1, 1, 1, 1, 1) . '<br>';
echo $objMatriz1->query(1, 1, 1, 2, 2, 2) . '<br>';
echo $objMatriz1->query(2, 2, 2, 2, 2, 2) . '<br>';*/

?>