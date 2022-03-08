<?php
// BINARIO A HEXADECIMAL
$numero="1110100110";
$conteo=strlen($numero)-1;
$matriz=[];
$numeroD="";
$a=0;
$i=0;

// do {
//     $numeroD.=$numero[$conteo];
//      echo $i."<br>";
//     if ($i == 2) {
//         $i=0;
//         $matriz[]=$numeroD;
//         $numeroD="";
//     }else{
//         /* if ($i == 1 && strlen($numeroD) < 3 ) {
//             $numeroD = str_pad($numeroD, 3, "0", STR_PAD_LEFT);
//             $matriz[]=$numeroD;
//         } */
//         $i++;
//     }
//     $conteo--;
    
// } while ($conteo > 0 );
// Separamos el numero en cifras de 3
for ($i=$conteo; $i >= 0 ; $i--) { 
    $numeroD.=$numero[$i];
    if ($a == 3) {
        /* if (strlen($numeroD) < 3) {
            // Agregamos ceros a la izquierda
            $numeroD = str_pad($numeroD, 3, "0", STR_PAD_RIGHT);
        } */
        $a=0;
        // Le damos vuelta porque lo estamo contado de izquierda a derecha
        $matriz[]=strrev($numeroD);
        // echo $numeroD."<br>";
        $numeroD="";
    }else{
        if ($i == 0 && strlen($numeroD) < 4 ) {
            $numeroD = str_pad($numeroD, 4, "0", STR_PAD_LEFT);
            $matriz[]=$numeroD;
        }
        $a++;
    }

}

// print_r(array_reverse($matriz));
// exit();
$matriz=array_reverse($matriz);
// print_r($matriz);
// exit();
$respueta="";
$i=0;
$a=0;
$tabla=array("0"=>"0000","1"=>"0001","2"=>"0010","3"=>"0011","4"=>"0100","5"=>"0101","6"=>"0110","7"=>"0111","8"=>"1000","9"=>"1001","A"=>"1010","B"=>"1011","C"=>"1100","D"=>"1101","E"=>"1110","F"=>"1111");
// echo count($matriz);
// exit();
for ($i=0; $i < count($matriz) ; $i++) { 
    if (in_array($matriz[$i],$tabla)) {
        $respueta.=array_search($matriz[$i],$tabla);
    }
}
// for ($i=10; $i < 16; $i++) { 
//     if (strpos($respuesta, $i)) {
//         $respuesta=str_replace($i, array_search($i, $tabla), $respuesta);
//     }
// }

echo $respueta."<sub>16</sub> <small>(Se uso tabla)</small>";
// print_r($tabla);
