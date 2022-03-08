<?php
// Decimal a octal
$numero=intval("9991339");
// Declaramos variables
$a=0;
$datos="";
$respuesta="";
// Procedimiento


do {
    $operacion=$numero/8;
    $datos.=$numero."/8=".$operacion."=";
    if (strpos(($operacion), '.')) {
        $matriz=explode(".",$operacion);
        $matriz[1]=floatval("0.".$matriz[1]);
        $datos.=$matriz[1]."x 8 =".$matriz[1]*8;
        $datos.="<br>";
        $respuesta.=$matriz[1]*8;

    }else{
        $datos.="0 x 8 = 0 <br>";
        $respuesta.="0";

    }
    $numero=intval($operacion);
    if ($numero==0 ) {
        $datos.="R/=".strrev($respuesta);
        break;
    }

    $a++;
} while ($a != 10);

echo $datos;
