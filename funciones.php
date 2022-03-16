<?php
// TRAEMOS EL TIPO DE  NUMERO QUE ESTAMOS ENVIANDO
$TIPO=$_POST['tipo'];
// TRIM ELIMINA LOS ESPACION EN BLANCO DEL INICO Y DEL FINAL
$numero=trim($_POST['numero']);
// ELIMINA LOS ENTRESPACIADOS
$numero = preg_replace('/\s+/', '', $numero);

// ANTES DE COMENZAR A CONVERTIR LOS DATOS COMENZAMOS A VERIFICAR QUE EL TIPO CONCUERDE CON LOS DATOS EMVIADOS
if ($TIPO == "BINARIO") {
    if (verificar_datos("[01.]{1,1000}",$numero)) {
        $datos=[
            "TITULO"=>"NO ES UN NUMERO BINARIO"
        ];
        echo json_encode($datos);
        exit();
     }
}else if ($TIPO == "OCTAL") {
    if (verificar_datos("[0-7.]{1,1000}",$numero)) {
        $datos=[
            "TITULO"=>"NO ES UN NUMERO OCTAL"
        ];
        echo json_encode($datos);
        exit();
     }
}else if ($TIPO == "DECIMAL") {
    if (verificar_datos("[0-9.]{1,1000}",$numero)) {
        $datos=[
            "TITULO"=>"NO ES UN NUMERO DECIMAL "
        ];
        echo json_encode($datos);
        exit();
     }
}else if ($TIPO == "HEXADECIMAL") {
    if (verificar_datos("[0-9A-Fa-f.]{1,1000}",$numero)) {
        $datos=[
            "TITULO"=>"NO ES UN NUMERO HEXADECIMAL "
        ];
        echo json_encode($datos);
        exit();
     }
}


if ($TIPO== "BINARIO") {
    $VALOR1=BinarioDecimal($numero);
    $VALOR2=Binario_H_O($numero,"BAH");// BINARIO A HEXADECIMAL
    $VALOR3=Binario_H_O($numero,"BAO");//BINARIO A OCTAL
}else if($TIPO=="DECIMAL"){
    $VALOR1=DecimalBinario($numero);
    $VALOR2=Decimal_O_H($numero,"OCTAL");
    $VALOR3=Decimal_O_H($numero,"HEXADECIMAL");
}else if($TIPO=="OCTAL"){
    $VALOR1=OctalBinario($numero);
    $VALOR2=O_H_A_D($numero,"OCTAL");
    $VALOR3=Decimal_O_H($VALOR2['RESPUESTA'],"HEXADECIMAL");
}else if($TIPO=="HEXADECIMAL"){
        /* El strtoupper es por si el numero trae letras pero las trae en minusculta 
        entonces la converimos en  mayusculas*/
    $numero=strtoupper($numero);
    $VALOR1=HexadecimalBinario($numero);
    $VALOR2=O_H_A_D($numero,"HEXADECIMAL");
    $VALOR3=Decimal_O_H($VALOR2['RESPUESTA'],"OCTAL");
}

// JUNTAMOS TODO LOS VALORES QUE NOS ENVIO CADA FUNCION Y LOS METEMOS EN UN ARRAY
$datos=[
    "TITULO"=>"RESULTADOS",
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

// la repuesta se va a devolver en un tipo JSON
echo json_encode($datos);

// LISTO
function BinarioDecimal($numero){
   // BINARIO A DECIMAL
    // Eliminamos los ceros a la izquierda
    // $numero=ltrim($numero, '0');
    // Si tiene decimales lo convertimos entero ya que esto nos va servir para el ciclos
    $numeroEntero=intval($numero);
    // Declaracion de decimales
    $proceso="";
    $suma="";
    $total=0;
    $a=0;
    // Ponemos el numero al revez el primero al ultimo y el ultimo al primero
        /* Ejemplo Hello world! =>  !dlrow olleH esto se hace para que las posiciones queden bien */
    $var =strrev($numeroEntero);
    $CantidadEntero=strlen($var)-1; // Se le resta una posicion porque contamos el cero 

    // Estraemos cada uno de los numero y lo metemos en el array
    for ($i=$CantidadEntero; $i > -1; $i--) { 
        // Si encuentra el nuemero 1 entra al if para calcular su posicion
        if ($var[$i] == 1) {   
            // El numero 2 lo eleva a la posicion que encontro el 1  
            $datos=pow(2,$i);
            // Lo concatena con  un simbolo mas que es la separacion
            $suma.=$datos."+";
            // El resultado de la elevacion 2 elevado a  la posicion lo va sumando en una variable
            $total+=$datos;
            /* Esto va mostrar el 2 elevado a la posicion y las etiquetas "sup"
            ponen el numeor de la posicion arriba del 2*/
            $proceso.="2<sup>".$i."</sup>+";
        }
    }

    // Buscamos si tiene punto decimal
    $buscarPunto=(strpos(($numero),"."));
    if ($buscarPunto==true){
        $a=1;
        /* vamos separar el numero entero con el decimal por medio del punto
        y convertirlo en un array*/
           /*  0             1
        1010101010  .    10110
                         012345 */
        $decimalesArray = explode('.',$numero);
        //Contamos la cantidad de caracteres que tiene el numeor despues del punto
        $CaniddadDecimal=strlen($decimalesArray[1]);
        // Comenzamos a operar los decimales
        for ($i=0; $i < $CaniddadDecimal; $i++) {
            // Si encuentra el nuemero 1 entra al if para calcular su posicion
            if ($decimalesArray[1][$i] == 1) {   
                // El numero 2 lo eleva a la posicion que encontro el 1 
                $posicion=intval(("-".$a));
                $datos=pow(2,($posicion));
                // Lo concatena con  un simbolo mas que es la separacion
                $suma.=$datos."+";
                // El resultado de la elevacion 2 elevado a  la posicion lo va sumando en una variable
                $total+=$datos;
                /* Esto va mostrar el 2 elevado a la posicion y las etiquetas "sup"
                    ponen el numeor de la posicion arriba del 2*/
                $proceso.="2<sup>".$posicion."</sup>+";
            }
            $a++;
        }  
        
    }
    // Vamos a quital el ultimo simbolo de "+"
    $suma=rtrim($suma, "+");
    $proceso=rtrim($proceso, "+");
    //Todas las variables las guardamos en un array para que sean facil su manipulacion
    $DATOS=[
        "TITULO"=>"DECIMAL",
        "CONTENIDO"=>$numero."= ".$proceso."= ".$suma."= ".$total."<sub>10</sub>",
        "RESPUESTA"=>$total
    ];
    return $DATOS;
}

// LISTO
function Binario_H_O($numero,$tipo){
   // BINARIO A HEXADECIMAL O BINARIO A OCTAL
    // Lo convertimos a un numero entero
    $numeroEntero = $numero;
    if (strpos(($numero),".")) {
        $numeroEntero=explode(".",$numero);
        $numeroEntero=$numeroEntero[0];
    }
    // Contamos la cantidad de caracteres que tiene
    $conteo=strlen($numeroEntero)-1;
    // Declarmos las variables a usar
    $matriz=[]; //Tambien declaramos una matriz
    $numeroD="";
    $a=0;
    $i=0;
    $indicador = ($tipo=="BAH") ? 3 : 2 ;
    $tipo2 = ($tipo=="BAH") ? "HEXADECIMAL" : "OCTAL" ;
    // Convertimos el numero entero a hexadecimal
    for ($i=$conteo; $i >= 0 ; $i--) {
        // Vamos concatenando el numero  para forma un numero binario de 4 dijitos
        $numeroD.=$numero[$i];
        // Entrara al if cuando la posicion sea a=3 que equivale a un conjuto de 4 digitos 
        if ($a == $indicador) {
            // Reseteamos la variable a
            $a=0;
            /* Le damos vuelta porque lo estamo contado de izquierda a derecha
                por ejemplo el numero que debe de quedar es 1010 y el programa lo tiene 0101*/
            $matriz[]=strrev($numeroD);
            // Volvemos a poner la variable vacia
            $numeroD="";
        }else{
            // Va entrar al if cundo los uiltmos digitos no queden en 4 sino en 3,2 o 1 
            if ($i == 0 && strlen($numeroD) < ($indicador+1) ) {
                // invertimos los numero 
                $numeroD=strrev($numeroD);
                // Va rellenar el binario con ceros a la izquierda que faltan para que se complete los ($indicador+1)
                $numeroD = str_pad($numeroD, ($indicador+1), "0", STR_PAD_LEFT);
                // Lo agregamos al array
                $matriz[]=$numeroD;
                
            }
            $a++;
        }
    }

    // Una vez termonamos de operrar los enteros ahora revertimos el array
    $matriz=array_reverse($matriz);
    //Traemos el resultado final que lo tendra una funcion
    $respuesta = ($tipo=="BAH") ? tabla("BAH",$matriz) : tabla("BAO",$matriz) ;

    // Ahroa verificamos si tiene dicimal
    $buscarPunto=(strpos(($numero),"."));
    if ($buscarPunto==true){
        $a=0; //Reseteamos esta variables que ya teniamos antes
        $numeroD="";
        $matriz=[]; //Tambien declaramos una matriz
        // Dividimos el numero entero con el nuero decimal
        $Decimal=explode(".",$numero);
        // Contamos cuandos caracteres tiene
        $conteo=strlen($Decimal[1]);
        for ($i=0; $i < $conteo ; $i++) {
            // Vamos concatenando el numero  para forma un numero binario de 4 dijitos
            $numeroD.=$Decimal[1][$i];
            // Entrara al if cuando la posicion sea a=3 que equivale a un conjuto de 4 digitos 
            if ($a == $indicador) {
                // Reseteamos la variable a
                $a=0;
                /* Le damos vuelta porque lo estamo contado de izquierda a derecha
                    por ejemplo el numero que debe de quedar es 1010 y el programa lo tiene 0101*/
                $matriz[]=$numeroD;
                // Volvemos a poner la variable vacia
                $numeroD="";
            }else{
                // Va entrar al if cundo los uiltmos digitos no queden en 4 sino en 3,2 o 1 
                if ($i == ($conteo-1) && strlen($numeroD) < ($indicador+1) ) {
                    // Va rellenar el binario con los ceros que faltan para que se complete los 4
                    $numeroD = str_pad($numeroD, ($indicador+1), "0", STR_PAD_RIGHT);
                    // Lo agregamos al array
                    $matriz[]=$numeroD;
                    
                }
                $a++;
            }
        }

        // Volvemos a traer el resultado final de la funcion que tiene la tabla 
        $respuesta2 = ($tipo=="BAH") ? tabla("BAH",$matriz) : tabla("BAO",$matriz) ;
        $respuesta.=".".$respuesta2;
    }
    $DATOS=[
        "TITULO"=>$tipo2,
        "CONTENIDO"=>$numero."<br>".$respuesta."<sub>16</sub> <small>(Se uso tabla)</small>",
        "RESPUESTA"=>$respuesta
    ];
    return $DATOS;
}

// LISTO
function DecimalBinario($numero){
    // DECIMAL A BINARIO
   // Declaramos las variables a usar
   $numeroEntero=intval($numero);
   $procedimiento="Operamos los numero decimales <br>";
   $respuestas=array();
   $i=0;
   $n=0;

   // Creamos un ciclo infinito que nos nos permita calcular hasta que si valor sea 1 o 0 
   do {
       //El numero decimal se divide en 2
       $datos=$numeroEntero/2;
       // Verificamos si tiene punto decimal
       if (strpos($datos, '.')) {
           $binario=1;
       }else{
           $binario=0;
       }
       // Procedemos A contatenar el resultado para mostrar al final el proceso
       $procedimiento.="= ".$numeroEntero.'/2='.$datos.'='.$binario."<br>";
       // Lo añadimos al array que va tener el resultado final
       $respuestas[]=$binario;
       //verificar si es 1 o 0 detiene el ciclo que significa que ya termino de calcular 
       if (intval($datos) == 1 || intval($datos) == 0) {
           break;
       }
       // si no es 1 o 0 entonces seguimos calculando y tomammos el numero entero que quedo
       $numeroEntero=intval($datos);
       // Por si salgo sale mal tiene un contador  que llegara a 100 y se detiene
       if ($n==100) {
           $DATOS=[
               "TITULO"=>"BINARIO",
               "CONTENIDO"=>"Error!",
               "RESPUESTA"=>"Error!"
           ];
           return $DATOS;
           break;
       }
       // Vamos incrementando la varible N que es la varible de conteo
       $n++;
   } while ($i != 1);
   // Una vez finalizamos el resultado el numero binario que quede le damos vuelta
   $respuestas=array_reverse($respuestas);
   // establecemos el uno que siempre se le tiene que agregar
   $ResultadoFinal=1;
   // Recoremos el array para unir el binario completo
   foreach ($respuestas as $row) {
       $ResultadoFinal.=$row;
   }

   // si hay punto decimal entonces comenzamos a operar sino aqui se salta es IF
   if (strpos($numero, '.')) {
       // Anunciamos que viene la parte de los decimales
        //las etiquetas strong es para poner el texto en negrita
       $procedimiento.="<strong>Ahora operamos los numeros decimales</strong> <br>";
       // Declaraos las variabeles
       $n=0;
       $respuestas2=array();
       // Converitmos el numero en un array para sacar los numero decimales
       $numeroDecimal=explode(".",$numero);
       // Los numero decimales estan enla posicion 1 de array
       $cantidadDecimal="0.".$numeroDecimal[1];
       // Y se hace lo mismo se crea un bucle infinito
       do {
           //El numero decimal se multiplica por 2 porque son decimales que estamos trabajando
           $datos=$cantidadDecimal*2;
           // el resultado de esa divicion tomamos el numero entero 
           $binario=intval($datos); 
           // Registramos el proceso que se hizo
           $procedimiento.="= ".$cantidadDecimal.'x2='.$datos.'='.$binario."<br>";
           // Tambien el resultado lo añadimos en el array
           $respuestas2[]=$binario;
           //verificar si es 1 o no  
           if (intval($datos) == 1) {
               // si es 1 entonces detiene la ejecucion
               break;
           }
           // Ahora modiciamos la variableque se va usar para oprerar el siguiente numero
           $cantidadDecimal=$datos;
           // Por si algo falla se hace una detencion de respaldo ya que es un bucle infinito
           if ($n==100) {
               $DATOS=[
                   "TITULO"=>"BINARIO",
                   "CONTENIDO"=>"Error!",
                   "RESPUESTA"=>"Error!"
               ];
               return $DATOS;
               break;
           }
           $n++;
           
       } while ($i != 1);
       // Le agregamos un punto decimal antes que se comienze a juntar el resultado
       $ResultadoFinal.=".";
       // Recoremos el azrray y vamos juntado el resultado
       foreach ($respuestas2 as $row) {
           $ResultadoFinal.=$row;
       }
        //    le agregamos un numero 1 que queda al final
       $ResultadoFinal.=1;
   }
    //juntamos la respuesta final con el procedimiento    
   $procedimiento.="<br>R/=".$ResultadoFinal;

    $DATOS=[
        "TITULO"=>"BINARIO",
        "CONTENIDO"=>$numero."<br>".$procedimiento."<sub>2</sub>",
        "RESPUESTA"=>$ResultadoFinal
    ];
    return $DATOS;
}
// LISTO
function Decimal_O_H($numero,$TIPO){
   // Decimal a octal o hexadecimal
    $numeroEntero=intval($numero);
    // Declaramos variables
    $a=0;
    $n=0;
    $numeroDecimal="";
    $datos="";
    $RespuestaFinal="";
    $respuesta="";
    $indicador="entero";
    $BASE = ($TIPO=="HEXADECIMAL") ? 16 : 8 ;
    // hacemos un bucle infinito
    do {
        if ($indicador=="entero") {
            // lo dividimos por 8 si es octal o 16 si es hexadecimal
            $operacion=$numeroEntero/$BASE;
            // Registramos la oprescacion que hicimos 
            $datos.="= ".$numeroEntero."/ ".$BASE."=".$operacion."=";
            // Verificamos si el resutlado tiene punto decimal
            if (strpos(($operacion), '.')) {
                // si tiene punto decimal el resultado lo convertimos en un array
                $matriz=explode(".",$operacion);
                // Contertimos la cantidad de la posicion 1 (porque eson los decimaeles)
                $matriz[1]=floatval("0.".$matriz[1]);
                // Ahora los decimales lo pultiplicamos por 8 si es octal o 16  si es exadecimal y damos un salto de linea
                $datos.=$matriz[1]."x ".$BASE." =".($matriz[1]*$BASE)."<br>";
                // ahora volvemos hacer la operacion solo pa juntarlo a la variable final "$respuesta"
                if ($TIPO=="HEXADECIMAL") {
                    $respuesta.=TABLA("DAH",($matriz[1]*$BASE));
                }else{
                    $respuesta.=$matriz[1]*$BASE;
                }
            }else{
                // Si no tiene punto decimal quedara cero 
                $datos.="0 x ".$BASE." = 0 <br>";
                $respuesta.="0";

            }
            // Ahora al resultado de la varible $operacion le quitamos los decimales y los convertimos en enteros
            $numeroEntero=intval($operacion);

            // si el numero ya es cero finalizamo el  proceso
            if ($numeroEntero==0 ) {
                $RespuestaFinal.=strrev($respuesta);
                // Ahora vamos a verificar si la cantidad que desean convertir tiene decimales y si no tiene paramos el ciclo
                if (strpos($numero, '.')) {
                    $respuesta="";
                    // Actuazliamos el indicador
                    $indicador="decimal";
                    // convertimos en un array el numero original
                    $numeroDecimal=explode(".",$numero);
                    // le agregamos el "0." a la posicion 1
                    $numeroDecimal[1]="0.".$numeroDecimal[1];
                    // Para la respuesta final le agregamos un punto donde mas adelante de van a concatenar los demas
                    $RespuestaFinal.=".";
                    // Informamos que vamos a comenzar a operar los decimales
                    $datos.="Comenzamos a operar los numero decimales <br>";
                }else{
                        break;
                };
            }
            
        }else{
            // lo dividimos por 8 si es octal o 16 si es hexadecimal
            $operacion=$numeroDecimal[1]*$BASE;
            // Registramos la oprescacion que hicimos 
            $datos.="= ".$numeroDecimal[1]."x ".$BASE."=".$operacion."<br>";
            /*Entrar al este if solo si es hexadecimal porque aveces el numero se
             puede convertir en una letra y si es octal sigue su camino no consulta 
             a ningua tabla*/
            if ($TIPO=="HEXADECIMAL") {
                $respuesta=TABLA("DAH",intval($operacion));
                $RespuestaFinal.=$respuesta;
            }else{
                $RespuestaFinal.=intval($operacion);    
            }
            if (!strpos(($operacion), '.')) {
                    break;
            }else{
                // La cantidad lo convertimos en un array para extraeles los decimales
                $verificacion=explode(".",$operacion);
            }
            // Ahora al resultado de la varible $operacion le quitamos los decimales y los convertimos en enteros
            $numeroDecimal[1]="0.".$verificacion[1];
        }
         // Por si algo falla se hace una detencion de respaldo ya que es un bucle infinito
         if ($n==100) {
            $DATOS=[
                "TITULO"=>"BINARIO",
                "CONTENIDO"=>"Error!",
                "RESPUESTA"=>"Error!"
            ];
            return $DATOS;
            break;
        }
        $n++;
    } while ($a != 10);

    $DATOS=[
        "TITULO"=>$TIPO,
        "CONTENIDO"=>$numero."<sub>10</sub><br>".$datos."<br> <strong> R/=".$RespuestaFinal."<sub>".$BASE."</sub><strong>",
        "RESPUESTA"=>$RespuestaFinal
    ];
    return $DATOS;

}

// LISTO
function OctalBinario($numero){
    // OCTAL A BINARIO
     $respueta="";
     if(strpos(($numero),".")){
         $numeroMatriz=explode(".",$numero);
         $respueta=tabla("OAB",$numeroMatriz[0]);
         $respueta.=".".tabla("OAB",$numeroMatriz[1]);
     }else{
         $respueta=tabla("OAB",$numero); 
     }
 
     $DATOS=[
         "TITULO"=>"BINARIO",
         "CONTENIDO"=>$numero."<sub>8</sub><br> = ".$respueta."<sub>2</sub><small>(Se uso tabla)</small>",
         "RESPUESTA"=>$respueta
     ];
     return $DATOS;
}

// LISTO
function O_H_A_D($numero,$TIPO){
    // OCTAL A  DECIMAL
    // declaramos variables
    $datos="";
    $suma="";
    $operacion="";
    $resultado=0;
    $a=1;
    // Declaramos la base que queremos usar 
    $BASE = ($TIPO== "OCTAL") ? 8 : 16 ;
    // verificamos si tiene punto decimal o no
    if (strpos($numero, '.')) {
        // Esta varible nos va a servir para calcular la posicion haciendo una resta con otra variable
        $cantidad=explode(".",$numero);
        $cantidad=strlen($cantidad[0]);
        // despues creaos otra variables pero esta vez le quitamos la posicion del punto
        $cantidad2=strlen($numero)-1;
        // Comenzamos el ciclo para operar
        for ($i=0; $i <= $cantidad2; $i++) {
            // primero creamos una variable que contendra el primer dijito de todo el numero que estamos reciviendo

            $numeroOperar=$numero[$i];
            // esto va servir para cuando llegue al punto se lo salte
            if ($numeroOperar == '.') {
                $i++;
                $numeroOperar=$numero[$i];
            }
            // entrara al fin solo si la base es 13 y el numero a convertir es hexadecimal
            if (!is_numeric($numeroOperar)== true && $BASE== 16) {
                // buscaremos el valor correspondiente de la letra en la tabla
                $numeroOperar=tabla("HAD",$numeroOperar);
            }
            // Ahora comenzamos a dejar constancia de la operacion
            $datos.=$numeroOperar."x".$BASE."<sup>".($cantidad-$a)."</sup>+";
            // tambien dejamos grabalo el proceso siguiente
            $operacion.=$numeroOperar."x".pow($BASE,($cantidad-$a))."+";
            // una vez dejamos el proceso registrado entonces ahora si comenzamos a operar
            $suma.=$numeroOperar*pow($BASE,($cantidad-$a))."+";
            // El  resultado de la operacion lo guaramos en una varibale para mostrarlo al final
            $resultado+=$numeroOperar*pow($BASE,($cantidad-$a));
            $a++;
        }
        // le quitamos el simbolo de mas que esta al final
        $datos=rtrim($datos, "+");
        $operacion=rtrim($operacion, "+");
        $suma=rtrim($suma, "+");
    }else{
        // Vamos a girar los numeros 
        $alrevez=strrev($numero);
        // Comenzamos desde la posicion cero
        for ($i=0; $i < strlen($alrevez); $i++) { 
            $numeroOperar=$alrevez[$i];
            // Si se quiere convertir un numero hexadecimal a binario debemos de tranformar las letras a numeros
            if (!is_numeric($numeroOperar)== true && $BASE== 16) {
                $numeroOperar=tabla("HAD",$numeroOperar);
            }
            // comenzamos a dejar constancia del proceso
            $datos.=$numeroOperar."x".$BASE."<sup>".$i."</sup>+";
            // El resultado que nos dio las potencias dejamos contancias
            $operacion.=$numeroOperar."x".pow($BASE,$i)."+";
            // despues sumamos el resultado de la pontencia con el nuemro dado y dejamos constancia del proceso
            $suma.=(pow($BASE,$i)*$numeroOperar)."+";
            // Despues el resultado que quedo con la elevacion vamos a multiplicarlo con el numero de que nos estan dando
            $resultado+=(pow($BASE,$i)*$numeroOperar);
        }
        
        // una vez terminamos de calcular le quitamos el simbolo del mas que quedo al final de toda la operacoin
        $datos=rtrim($datos, "+");
        $operacion=rtrim($operacion, "+");
        $suma=rtrim($suma, "+");
    }
    
    // return $numero."<br>= ".$datos."<br>= ".$operacion."<br>= ".$suma."<br>R/= ".$resultado."<sub>10</sub>";
    $NUMERO=$numero."<sub>".$BASE."</sub><br>= ".$datos."<br>= ".$operacion."<br>= ".$suma."<br>R/= ".$resultado."<sub>10</sub>";
    $DATOS=[
        "TITULO"=>"DECIMAL",
        "CONTENIDO"=>$NUMERO,
        "RESPUESTA"=>$resultado
    ]; 
    return $DATOS;
}

// LISTO
function HexadecimalBinario($numero){

    // verificamos si tiene punto decimal
    if (strpos(($numero), '.')) {
        $numeroDecimal=explode(".",$numero);
        $resultado=tabla("HAB",$numeroDecimal[0]);
        $resultado.=".".tabla("HAB",$numeroDecimal[1]);
    }else{
        // si no tiene buscamos en la tabla las cantidades
        $resultado=tabla("HAB",$numero);
    }
    $DATOS=[
        "TITULO"=>"BINARIO",
        "CONTENIDO"=>$numero."<sub>16</sub><br>".$resultado."<sub>2</sub><small> se uso tabla</small>",
        "RESPUESTA"=>$resultado
    ];
    return $DATOS;
}


function TABLA($tipo,$cantidad){
    /* Esta funcion contiene todas las tablas hexadecimales o octales y aveces es llamada
     son llamdas para convertir numeros a hexadecimales o a binarios*/
    if ($tipo=="BAH" || $tipo=="HAB") {
        // declarion de tabla
        $tabla=array("0"=>"0000","1"=>"0001","2"=>"0010","3"=>"0011","4"=>"0100","5"=>"0101","6"=>"0110","7"=>"0111","8"=>"1000","9"=>"1001","A"=>"1010","B"=>"1011","C"=>"1100","D"=>"1101","E"=>"1110","F"=>"1111");
        // convertir de Bianario a Hexadecimal
        if ($tipo=="BAH") {
            // declaramos las varibles a usar
            $i=0;
            $respueta="";
            // recoremos el aray con este foeach
            foreach ($cantidad as $datos) {
                // con la fucion establecida en php verificamos si el valor esta en el aray tabla
                if (in_array($cantidad[$i],$tabla)) {
                    /* si el numero se encuentra en el array entonces traemos 
                        el valor del indice que contiene el numeor binario y lo anidamos*/
                    $respueta.=array_search($cantidad[$i],$tabla);
                }
                // Vamos sumando la variable i para pasar la siguiente posicion del array
                $i++;
            }
            // Devolvemos el resultado
        }else{
            $respueta="";
            // convertir de hexadecimal a binario
            for ($i=0; $i < strlen($cantidad); $i++) { 
                /* recoremos el for y miestrar que lo recorre va esta adjuntando los
                resultados en la varible respuesta*/
                $respueta.=$tabla[$cantidad[$i]];
            }
        }
        // devolvemos la respuesta
        return $respueta;

    }else if ($tipo=="BAO" || $tipo=="OAB"){
        // declaracion de tabla y varibles
        $i=0;
        $respueta="";
        $tabla=array("000","001","010","011","100","101","110","111");
        // binario a octal
        if ($tipo=="BAO") {
            // hacemos un for donde va para hasta que sea menor a la variable $cantidad
            for ($i=0; $i < count($cantidad) ; $i++) { 
                // buscamos si en el array existe ese valor
                if (in_array($cantidad[$i],$tabla)) {
                    // una vez encontramos le decimos a php que nos devulva su posicion o indice
                        $respueta.=array_search($cantidad[$i],$tabla);
                }
            }
        }else{
            // si es de octal a binario contamos cuantos caracteres tiene en la varible cantidad
            $conteo=strlen($cantidad);
            // creamos un for donde va parar dependiendo de la cantidad de caracteres que tiene conteo
            for ($i=0; $i < $conteo ; $i++) { 
                // mientras que lo recores nos va esta adjuntando las respuestas
                    $respueta.=$tabla[$cantidad[$i]];
            }
        }
        // devolvemos el resultado final ya procesado
        return $respueta;
    }else if ($tipo=="DAH" ||  $tipo=="HAD"){
        // declaracion de la tabla
        $tabla=array("0"=>"0","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","A"=>"10","B"=>"11","C"=>"12","D"=>"13","E"=>"14","F"=>"15");
        // verificamos que tipo queremos convertir el numero que nos estan dando
        if ($tipo=="DAH") {
            /* la funcion in_array es una funcion de php y nos dice si el valor que 
            estamos pasando se encuentra en el array*/
            if (in_array($cantidad,$tabla)) {
                /* si se encuentra en el array  entonces llamamos a otra funcion de php 
                llamado array_search, con esta funcion le pasamos el valor que y el array TABLA
                entonces le decimos a php que me valla a traer el indice donde se encuentra ese valor*/ 
                $cantidad=array_search($cantidad, $tabla); 
            }
        }else{
            /* si vamoa a convertir de hexadecimal a decimal solo creamos una variable
            y le pasamos la cantidad que ese seria su indice y php va devolver su valor  */
            $cantidad=$tabla[$cantidad];
        }
        // retornamos el resultado
        return $cantidad;
    }

}

// FUNCION PARA VERIFICAR SU SE CUMPLE UN PATRON
function verificar_datos($filtro,$cadena){
    /*la funcion preg_match realiza una comparacion con una 
    expresion regular*/
    if (preg_match("/^".$filtro."$/" ,$cadena)) {
        return false;
    } else {
        return true;
    }
    
}