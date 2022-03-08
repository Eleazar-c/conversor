<?php
// DECIMAL A BINARIO
$var =25; #Este es un numero decimal

$procedimiento=[];
$respuestas=array();
$i=0;
$n=0;
do {
    //El numero decimal se divide en 2
    $datos=$var/2;
    // Verificamos si tiene punto decimal
    if (strpos($datos, '.')) {
        $binario=1;
    }else{
        $binario=0;
    }
 
    $procedimiento[]=$var.'/2='.$datos.'='.$binario;
    $respuestas[]=$binario;
    //verificar si es 1 o no 
    if (intval($datos) == 1 || intval($datos) == 0) {
        break;
    }
    $var=intval($datos);
    
    if ($n==100) {
        echo "hola";
        break;
    }
    $n++;
    
} while ($i != 1);

foreach ($procedimiento as $filas) {
    echo $filas."<br>";
}
$respuestas=array_reverse($respuestas);
$fila=1;
foreach ($respuestas as $row) {
    $fila.=$row;
}


echo "<br> R/=".$fila."<sub>2</sub>";
