<?php
$numero=trim($_POST['numero']);
// $numero="372";
$numero = preg_replace('/\s+/', '', $numero);
$TIPO=$_POST['tipo'];
// $A=$_POST['tipo2'];
// $VALOR1=BinarioDecimal($numero);
// $VALOR2=BinarioHexadecimal($numero);
// $VALOR3=BinarioOctal($numero);
// $VALOR4=DecimalBinario($numero);
// $VALOR5=DecimalOctal($numero);
// $VALOR6=DecimalHexadecimal($numero);
// $VALOR7=HexadecimalBinario($numero);
// $VALOR8=HexadecimalDecimal($numero);
// $VALOR9=OctalBinario($numero);
// $VALOR10=OctalDecimal($numero);
// print_r($VALOR10);

if ($TIPO== "BINARIO") {
    $VALOR1=BinarioDecimal($numero);
    $VALOR2=BinarioOctal($numero);
    $VALOR3=DecimalHexadecimal($VALOR1['RESPUESTA']);
}else if($TIPO=="DECIMAL"){
    $VALOR1=DecimalBinario($numero);
    $VALOR2=DecimalOctal($numero);
    $VALOR3=DecimalHexadecimal($numero);
}else if($TIPO=="OCTAL"){
    $VALOR1=OctalBinario($numero);
    $VALOR2=OctalDecimal($numero);
    $VALOR3=DecimalHexadecimal($VALOR2['RESPUESTA']);
}else if($TIPO=="HEXADECIMAL"){
    $VALOR1=HexadecimalBinario($numero);
    $VALOR2=HexadecimalDecimal($numero);
    $VALOR3=DecimalOctal($VALOR2['RESPUESTA']);
}
$datos=[
    "TITULO1"=>$VALOR1["TITULO"],
    "CONTENIDO1"=>$VALOR1["CONTENIDO"],
    "RESPUESTA1"=>$VALOR1["RESPUESTA"],
    "TITULO2"=>$VALOR2["TITULO"],
    "CONTENIDO2"=>$VALOR2["CONTENIDO"],
    "RESPUESTA2"=>$VALOR2["RESPUESTA"],
    "TITULO3"=>$VALOR3["TITULO"],
    "CONTENIDO3"=>$VALOR3["CONTENIDO"],
    "RESPUESTA3"=>$VALOR3["RESPUESTA"],
];

echo json_encode($datos);


function BinarioDecimal($numero){
    // BINARIO A DECIMAL
    $numero=ltrim($numero, '0'); #elimina los ceros a la izquierda
    $var =strrev($numero);
    // Declaramos variables
    $proceso="";
    $suma="";
    $total=0;
    $a=0;
    // Estraemos cada uno de los numero y lo metemos en el array
    for ($i=(strlen($var)-1); $i > -1; $i--) { 
        if ($var[$i] == 1) {
            $datos=pow(2,$i);
            $suma.=$datos."+";
            $total+=$datos;
            $proceso.="2<sup>".$i."</sup>";
            $a++;
        }
    }
    $suma=rtrim($suma, "+");
    $DATOS=[
        "TITULO"=>"DECIMAL",
        "CONTENIDO"=>$numero."= ".$proceso."= ".$suma."= ".$total."<sub>10</sub>",
        "RESPUESTA"=>$total
    ];
    return $DATOS;
}

function BinarioHexadecimal($numero){
    $conteo=strlen($numero)-1;
    $matriz=[];
    $numeroD="";
    $a=0;
    $i=0;

    for ($i=$conteo; $i >= 0 ; $i--) { 
        $numeroD.=$numero[$i];
        if ($a == 3) {
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

    $matriz=array_reverse($matriz);
    $respueta="";
    $i=0;
    $a=0;
    $tabla=array("0"=>"0000","1"=>"0001","2"=>"0010","3"=>"0011","4"=>"0100","5"=>"0101","6"=>"0110","7"=>"0111","8"=>"1000","9"=>"1001","A"=>"1010","B"=>"1011","C"=>"1100","D"=>"1101","E"=>"1110","F"=>"1111");

    for ($i=0; $i < count($matriz) ; $i++) { 
        if (in_array($matriz[$i],$tabla)) {
            $respueta.=array_search($matriz[$i],$tabla);
        }
    }

    $DATOS=[
        "TITULO"=>"HEXADECIMAL",
        "CONTENIDO"=>$respueta."<sub>16</sub> <small>(Se uso tabla)</small>",
        "RESPUESTA"=>$respueta
    ];
    return $DATOS;
}

function BinarioOctal($numero){
    // BINARIO A OCTAL
    $conteo=strlen($numero)-1;
    $matriz=[];
    $numeroD="";
    $a=0;
    $i=0;
    // Separamos el numero en cifras de 3
    for ($i=$conteo; $i >= 0 ; $i--) { 
        $numeroD.=$numero[$i];
        if ($a == 2) {
         
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
    $matriz=array_reverse($matriz);
    $respueta="";
    $i=0;
    $a=0;
    $tabla=array("000","001","010","011","100","101","110","111");
    for ($i=0; $i < count($matriz) ; $i++) { 
        if (in_array($matriz[$i],$tabla)) {
            $respueta.=array_search($matriz[$i],$tabla);
        }
    }

    $DATOS=[
        "TITULO"=>"OCTAL",
        "CONTENIDO"=>$respueta."<sub>8</sub> <small>(Se uso tabla)</small>",
        "RESPUESTA"=>$respueta
    ];
    return $DATOS;

}

function DecimalBinario($numero){
    // DECIMAL A BINARIO
    $procedimiento="";
    $respuestas=array();
    $i=0;
    $n=0;
    do {
        //El numero decimal se divide en 2
        $datos=$numero/2;
        // Verificamos si tiene punto decimal
        if (strpos($datos, '.')) {
            $binario=1;
        }else{
            $binario=0;
        }
        $procedimiento.="» ".$numero.'/2='.$datos.'='.$binario."<br>";
        $respuestas[]=$binario;
        //verificar si es 1 o no 
        if (intval($datos) == 1 || intval($datos) == 0) {
            break;
        }
        $numero=intval($datos);
        if ($n==100) {
            echo "error";
            break;
        }
        $n++;
    } while ($i != 1);

    $respuestas=array_reverse($respuestas);
    $fila=1;
    foreach ($respuestas as $row) {
        $fila.=$row;
    }
    $procedimiento.="R/=".$fila;
    $DATOS=[
        "TITULO"=>"BINARIO",
        "CONTENIDO"=>$procedimiento."<sub>2</sub>",
        "RESPUESTA"=>$fila
    ];
    return $DATOS;
}

function DecimalOctal($numero){
    // Decimal a octal
    // Declaramos variables
    $a=0;
    $total=0;
    $datos="";
    $respuesta="";
    // Procedimiento
    do {
        $operacion=$numero/8;
        $datos.="» ".$numero."/8=".$operacion."=";
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
            $datos.="R/=".strrev($respuesta)."<sub>8</sub>";
            $total=strrev($respuesta);
            break;
        }
        $a++;
    } while ($a != 10);

    $DATOS=[
        "TITULO"=>"OCTAL",
        "CONTENIDO"=>$datos,
        "RESPUESTA"=>$total
    ];
    return $DATOS;

}

function DecimalHexadecimal($numero){
   // Declaramos variables
   $numero=intval($numero);
    $datos="";
    $respuesta="";
    $conteo=strlen($numero);
    // Procedimiento
    for ($i=0; $i < $conteo; $i++) { 
        $operacion=$numero/16;
        $datos.="» ".$numero."/16=".$operacion."=";
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


    $DATOS=[
        "TITULO"=>"HEXADECIMAL",
        "CONTENIDO"=>$datos."R/=".$respuesta."<sub>16</sub>",
        "RESPUESTA"=>$respuesta
    ];
    return $DATOS;

}

function TABLA($n){
    $tabla=array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","A"=>"10","B"=>"11","C"=>"12","D"=>"13","E"=>"14","F"=>"15");

    if (!$tabla[$n]) {
        $n=array_search($n, $tabla); 
    }
   
    return $n;
}

function HexadecimalBinario($numero){
    $numero=strtoupper($numero);
    $tabla=array("0"=>"0000","1"=>"0001","2"=>"0010","3"=>"0011","4"=>"0100","5"=>"0101","6"=>"0110","7"=>"0111","8"=>"1000","9"=>"1001","A"=>"1010","B"=>"1011","C"=>"1100","D"=>"1101","E"=>"1110","F"=>"1111");
    $datos="";
    for ($i=0; $i < strlen($numero); $i++) { 
        $datos.=$tabla[$numero[$i]];
    }
    $DATOS=[
        "TITULO"=>"BINARIO",
        "CONTENIDO"=>$datos."<sub>2</sub><small> se uso tabla</small>",
        "RESPUESTA"=>$datos
    ];
    return $DATOS;
}

function HexadecimalDecimal($numero){
    $numero=strtoupper($numero);
    $datos="";
    $suma="";
    $operacion="";
    $resultado=0;
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
    $DATOS=[
        "TITULO"=>"DECIMAL",
        "CONTENIDO"=>$numero."<br>» ".$datos."<br>» ".$operacion."<br>» ".$suma."<br>R/= ".$resultado."<sub>10</sub>",
        "RESPUESTA"=>$resultado
    ];
    return $DATOS;
}

function OctalBinario($numero){
    // OCTAL A BINARIO
    $conteo=strlen($numero);
    $respueta="";
    $i=0;
    $tabla=array("000","001","010","011","100","101","110","111");
    do {
        if (array_key_exists($numero[$i],$tabla)) {
            $respueta.=$tabla[$numero[$i]];
        }
        $i++;
    } while ($i < $conteo);

    $DATOS=[
        "TITULO"=>"BINARIO",
        "CONTENIDO"=>$respueta."<sub>2</sub> <small>(Se uso tabla)</small>",
        "RESPUESTA"=>$respueta
    ];
    return $DATOS;
}

function OctalDecimal($numero){
    // OCTAL A  DECIMAL
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
    $DATOS=[
        "TITULO"=>"DECIMAL",
        "CONTENIDO"=>$numero."<br>= ".$datos."<br>= ".$operacion."<br>= ".$suma."<br>R/= ".$resultado."<sub>10</sub>",
        "RESPUESTA"=>$resultado
    ];
    return $DATOS;
}