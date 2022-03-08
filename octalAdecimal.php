<?php
// OCTAL A  DECIMAL
// PENDIENTE CON PUNTO DECIMAL POR EJEMPLO 24.6
$numero="24.6";
$datos="";
$suma="";
$operacion="";
$resultado=0;
$i=0;
$a=1;

if (strpos($numero, '.')) {
    $cantidad=strlen($numero)-2;
    $cantidad2=strlen($numero)-1;
    do {
        if ($numero[$i] == '.') {
            $i++;
        }
        $datos.=$numero[$i]."x8<sup>".($cantidad-$a)."</sup>+";
        $operacion.=$numero[$i]."x".pow(8,($cantidad-$a))."+";
        $suma.=$numero[$i]*pow(8,($cantidad-$a))."+";
        $resultado+=$numero[$i]*pow(8,($cantidad-$a));
        $a++;
        $i++;
    } while ($a <= $cantidad2);
    $datos=rtrim($datos, "+");
    $operacion=rtrim($operacion, "+");
    $suma=rtrim($suma, "+");
}else{
    $alrevez=strrev($numero);
    for ($i=0; $i < strlen($alrevez); $i++) { 
        $datos.=$alrevez[$i]."x8<sup>".$i."</sup>+";
        $operacion.=pow(8,$i)."x".$alrevez[$i]."+";
        $suma.=(pow(8,$i)*$alrevez[$i])."+";
        $resultado+=(pow(8,$i)*$alrevez[$i]);
    }
    
    $datos=rtrim($datos, "+");
    $operacion=rtrim($operacion, "+");
    $suma=rtrim($suma, "+");
}

echo $numero."<br>= ".$datos."<br>= ".$operacion."<br>= ".$suma."<br>R/= ".$resultado."<sub>10</sub>";

    // exit();
