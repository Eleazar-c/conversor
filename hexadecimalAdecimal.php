<?php
$numero="1BC2";
$datos="";
$suma="";
$operacion="";
$resultado=0;
$a=1;
$tabla=array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","A"=>"10","B"=>"11","C"=>"12","D"=>"13","E"=>"14","F"=>"15");

$alrevez=strrev($numero);

    for ($i=0; $i < strlen($alrevez); $i++) { 
        $numeroOperar=$alrevez[$i];
        if (!is_numeric($numeroOperar)) {
            $numeroOperar=$tabla[$alrevez[$i]];
        }   
       
   
        $datos.=$numeroOperar."x16<sup>".$i."</sup>+";
        $operacion.=pow(16,$i)."x".$numeroOperar."+";
        $suma.=(pow(16,$i)*$numeroOperar)."+";
        $resultado+=(pow(16,$i)*$numeroOperar);
    }
    $datos=rtrim($datos, "+");
    $operacion=rtrim($operacion, "+");
    $suma=rtrim($suma, "+");
echo $numero."<br>= ".$datos."<br>= ".$operacion."<br>= ".$suma."<br>R/= ".$resultado."<sub>10</sub>";

    