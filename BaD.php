<?php
// BINARIO A DECIMAL
$numero="100011011011";
$numero=ltrim($numero, '0'); #elimina los ceros a la izquierda
$var =strrev($numero);
// Declaramos variables
$proceso="";
$suma="";
$total=0;
$a=0;

// Estraemos cada uno de los numero y lo metemos en el array


for ($i=(strlen($var)-1); $i > -1; $i--) { 
     // $proceso[]=$var[$i];
     // echo "<br>".$i;
     if ($var[$i] == 1) {
          
          $datos=pow(2,$i);
          $suma.=$datos."+";
          $total+=$datos;
          // $datos=2**$i;
          $proceso.="2<sup>".$i."</sup>";
          $a++;
     }

}
// echo $a;
$suma=rtrim($suma, "+");
echo $numero."<br>= ".$proceso."<br>= ".$suma."<br>R/= ".$total."<sub>10</sub>";
// print_r($proceso);