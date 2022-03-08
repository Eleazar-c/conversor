<?php
// Decimal a HEXADECIMAL
$numero=intval("682");
// Declaramos variables
// Declaramos variables
$datos="";
$respuesta="";
$conteo=strlen($numero);
// Procedimiento
// echo strlen($numero);
for ($i=0; $i < $conteo; $i++) { 
    $operacion=$numero/16;
   
    $datos.=$numero.'/16='.$operacion."=";
    if (strpos(($operacion), '.')) {
        $matriz=explode(".",$operacion);
        $matriz[1]=floatval("0.".$matriz[1]);
        $resul=TABLA($matriz[1]*16);
        $datos.=$matriz[1]."x 16 =".$resul;
        $datos.="<br>";
        $respuesta.=$resul;

    }else{
        $datos.="0 x 16 = 0 <br>";
        $respuesta.="0";

    }
    $numero=intval($operacion);
    if ($numero==0) {
        break;
    }

}


$respuesta=strrev($respuesta);


function TABLA($n){
    $tabla=array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","A"=>"10","B"=>"11","C"=>"12","D"=>"13","E"=>"14","F"=>"15");

    $n=array_search($n, $tabla); 
   
    return $n;
}

echo $datos."R/=".$respuesta."<sub>16</sub>";
