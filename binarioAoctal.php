<?php
// BINARIO A OCTAL
$numero="100111010";
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
    if ($a == 2) {
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
        if ($i == 0 && strlen($numeroD) < 3 ) {
            $numeroD = str_pad($numeroD, 3, "0", STR_PAD_LEFT);
            $matriz[]=$numeroD;
        }
        $a++;
    }

}

// print_r(array_reverse($matriz));
// exit();
$matriz=array_reverse($matriz);
$respueta="";
$i=0;
$a=0;
$tabla=array("000","001","010","011","100","101","110","111");
// echo count($matriz);
// exit();
for ($i=0; $i < count($matriz) ; $i++) { 
    if (in_array($matriz[$i],$tabla)) {
        $respueta.=array_search($matriz[$i],$tabla);
       
    }
}

echo $respueta." <small>(Se uso tabla)</small>";
// print_r($tabla);
