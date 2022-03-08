<?php
// OCTAL A BINARIO
$numero="5431";
$conteo=strlen($numero);
$respueta="";
$i=0;
$a=0;
$tabla=array("000","001","010","011","100","101","110","111");

do {
    
    if (array_key_exists($numero[$i],$tabla)) {

        $respueta.=$tabla[$numero[$i]];
    }
     $i++;
} while ($i < $conteo);

echo $respueta." <small>(Se uso tabla)</small>";
// print_r($tabla);
