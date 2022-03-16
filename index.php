<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor</title>
    <!-- IMPORTAMOS LOS ESTILOS DE BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- YA QUE ESTOY IMPORTANDO LOS ESTILOS DE BOOSTRAP DE ESTA MANERA DEBEMOS  DE TENER INTERNET EN LA PC
        SI NON LOS ESTILOS NO SE PODRAN CARGAR -->
    <style>

    .procesos {
        font-size: 20px;
        position: absolute;
    }

    #TituloId {
        text-align: center;
    }

    .procesos,
    #texto,
    #recuadro,
    #TablaResultado,
    #TituloId {
        visibility: hidden;
    }

    </style>
</head>

<body>
    <!-- Creamos un contenedor -->
    <div class="container">
        <!-- dentro de este contenedor se crea una fila -->
        <div class="row">
            <!-- TUTILO -->
            <h1 style="text-align: center;">Conversion de Numeros</h1>
            <!-- LINEA HORIZONTAL PARA LA DIVISION -->
            <hr>
            <!-- CREAMOS UNA COLOMUNA QUE OCUPARA TODO EL ESTACION DE LA FILA "COL-MD-12" Y CUNADO SEA 
                PANTALLAS PEQUEÑAS SOLO OCUPARA 6 -->
            <div class="col-sm-6 col-md-12">
                <!-- DE ESTA FILA CREAREMOS OTRA SUB FILA QUE VA ESTA JUSTIFICADO AL CENTRO "justify-content-md-center"
                VA TENER UN PADDIN DE 1 Y TAMBIEN UN MARGEN DE 1 -->
                <div class="row p-2 m-1 justify-content-md-center ">
                    <!-- CREAREMOS COLUMNAS AUTOMATICAS QUE DEPENDE DEL TAMAÑO DE LA PANTALLA ASI SERA LA CANTIDAD DE PIXELES
                    CON UN PADDING DE 2 -->
                    <div class="col-auto p-2">
                        <!-- CREAMOS UN FOMRULARIO QUE VA TENER UN ID -->
                        <form action="funciones.php" id="conversor" method="post">
                            <!-- CREAMOS UNA ENTRADA DE TEXTO -->
                            <input type="text" name="numero" id="numero" class="form-control" placeholder="Numero">
                    </div>
                    <!-- CREAMOS OTRA COLUMNA AUTO ADMINISTRABLE -->
                    <div class="col-auto p-2">
                        <!-- AHORA CREAMOS UN SELECTRO Q VA TENER UN ATRIBUTO "NAME" Y UN ID -->
                        <select class="form-select" name="tipo" aria-label="Default select example">
                            <option value="BINARIO" selected>BINARIO</option>
                            <option value="DECIMAL">DECIMAL</option>
                            <option value="OCTAL">OCTAL</option>
                            <option value="HEXADECIMAL">HEXADECIMAL</option>
                        </select>
                    </div>
   
                    <!-- OTRA COLUMNA AUTO ADMINISTRABLE CON UN "P-2" DE DOS Y UN "BOTTON"(alineacion hacia abajo) DE 2  -->
                    <div class="col-auto p-2 bt-2">
                        <!-- CREAMOS EL POTON PARA QUE COMIENZE A EJECUTAR EL CODIGO DE JAVASCRITP -->
                        <button type="submit" class="bton btn btn-primary">Convertir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- AL PRINCIPIO ESTO ESTA OCULTADO  ES DONDE SE MUESTRA LA TABLA -->
        <div class="row p-2 m-2 justify-content-md-center">
            <!-- PARRAFO -->
            <p id="texto" style="text-align: center;">Presiona el recuadro del numero al que quiere ver su proceso.</p>
            <!-- COLIMNA DE 6 Y UNA BARRA DE SCROLL AUTOMATICA -->
            <div class="col-md-6 overflow-auto ">
                <!-- CREAMOS LA TABLA CON SIS ESTIDLOS -->
                <table class="table table-sm table-striped table-bordered" id="TablaResultado" align="center">
                   <!-- ENCABEZDO DE TABLA ES DONDE VAN A IR LOS TITULOS -->
                    <thead style="text-align: center;">
                        <tr>
                            <th id="titulo1"></th>
                            <th id="titulo2"></th>
                            <th id="titulo3"></th>
                        </tr>
                    </thead>
                    <!-- EL CUERPO DE LA TABLA DONDE VAN A IR LOS RESULTADO -->
                    <tbody>
                        <tr>
                            <!-- ONCLICK ES CUANDO EL USUARIO PRECIONE LA CELDA CORRESPONDIENTES Y SE 
                        EJECUTA UNA FUNCION DONDE MOSTRAR SU PROCESO -->
                            <td id="respuesta1" onclick="verProceso('1');"></td>
                            <td id="respuesta2" onclick="verProceso('2');"></td>
                            <td id="respuesta3" onclick="verProceso('3');"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- </div> -->
        </div>

        <h1 id="TituloId">Procedimiento:</h1>
        <!--    AQUI MOSTRAR COMO FUE QUE SE HIZO -->
        <div class="row p-2 m-2 justify-content-md-center " id="recuadro">
            <div class="col-md-6 overflow-auto ">
                <div class="procesos" id="contenido1"></div>
                <div class="procesos" id="contenido2"></div>
                <div class="procesos" id="contenido3"></div>
            </div>
        </div>

    </div>

    <!-- IMPORTAMOS EL JAVASCRIPT DE BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>

    //TRAEMOS TODOS LOS VALORES QUE SE INGRESO EN EL FORMULARIO 
    const CONVERSORFORM = document.querySelectorAll("#conversor");

    function conversor(e) {
        // ESTA LINEA EVITA QUE LA PAGINA SE RECARGE
        e.preventDefault();

        // TODOS LOS VALORES DEL FOMULARIO LOS ALMACENAMOS EN UNA VARIABLE
        let data = new FormData(this);
        // TRAEMOS EL VALOR DEL ATRIBUTO METHOD DEL FOMRUMARIO
        let method = this.getAttribute("method");
        // TRAEMOS EL VALOR DEL ATRIBUTO ACTION DEL FOMRUMARIO
        let action = this.getAttribute("action");
        // CREAMOS UN ENCABEZADO
        let encabezados = new Headers();

        //array de datos o json que vamos a pasar a la funcion de fech para que puede enivar y resivir los datos
        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        }

        // ANTES DE SEGUIR COMPROVAMOS SI EL NUMERO QUE ESTAMOS ENVIANDO CORRESPONDE A SU TIPOS
        
        
        // A LA FUNCION FETCH LE PASAMOS EL ARRAY CONFIG Y LA VARIABLE ACTION QUE CONTIENE LA RUTA
        fetch(action, config)
  
            //LE DECIMOS QUE LA RESPUESTA QUE NOS TIENE QUE DEVOLVER VA SER DE TIPO JSON 
            .then(respuesta => respuesta.json())
            // .then(respuesta => respuesta.text())
            // console.log(respuesta);
            
            .then(respuesta => {
                respuestas(respuesta);
               
            });
    }

    // RECORREMOS ESO VALORES CON UN FOR EACH
    CONVERSORFORM.forEach(formularios => {
        // AL MOMENTO QUE PRESIONOS SUBMIR SE EJECUTA LA FUNCION CONVERSOR
        formularios.addEventListener("submit", conversor);
    });

    // ESTA FUNCION ES PARA MOSTRA EL PROCESO DE LO QUE SE HIZO DEPENDIENDO SI EL USUARIO HACE CLIC EN LOS RECUADROS
    function verProceso(posicion) {
        if (posicion == "1") {
            document.getElementById('TituloId').style.visibility = 'visible';
            document.getElementById('contenido1').style.visibility = 'visible';
            document.getElementById('contenido2').style.visibility = 'hidden';
            document.getElementById('contenido3').style.visibility = 'hidden';
        } else if (posicion == "2") {
            document.getElementById('TituloId').style.visibility = 'visible';
            document.getElementById('contenido1').style.visibility = 'hidden';
            document.getElementById('contenido2').style.visibility = 'visible';
            document.getElementById('contenido3').style.visibility = 'hidden';
        } else if (posicion == "3") {
            document.getElementById('TituloId').style.visibility = 'visible';
            document.getElementById('contenido1').style.visibility = 'hidden';
            document.getElementById('contenido2').style.visibility = 'hidden';
            document.getElementById('contenido3').style.visibility = 'visible';

        }
    }

    function respuestas(respuestas){
        if(respuestas.TITULO=="RESULTADOS"){
             // UN VEZ TEMGAMOS LAS RESPUESTAS ESTONCES LAS VAMOS INSERTANDO EN EL HTML
                // PRIMERO TODOS LOS TITULOS DE LA TABLA
                let TituloUno = document.querySelector('#titulo1');
                TituloUno.innerHTML = '';
                TituloUno.innerHTML += respuestas['TITULO1'];
                let TituloDos = document.querySelector('#titulo2');
                TituloDos.innerHTML = '';
                TituloDos.innerHTML += respuestas['TITULO2'];
                let TituloTres = document.querySelector('#titulo3');
                TituloTres.innerHTML = '';
                TituloTres.innerHTML += respuestas['TITULO3'];

                // PROCEDIMIENTOS
                let RespuestaUno = document.querySelector('#contenido1');
                RespuestaUno.innerHTML = '';
                RespuestaUno.innerHTML += respuestas['CONTENIDO1'];
                let RespuestaDos = document.querySelector('#contenido2');
                RespuestaDos.innerHTML = '';
                RespuestaDos.innerHTML += respuestas['CONTENIDO2'];
                let Respuesta3 = document.querySelector('#contenido3');
                Respuesta3.innerHTML = '';
                Respuesta3.innerHTML += respuestas['CONTENIDO3'];

                // RESPUESTAS
                let tabla = document.querySelector('#respuesta1');
                tabla.innerHTML = '';
                tabla.innerHTML += respuestas['RESPUESTA1'];
                let tabla2 = document.querySelector('#respuesta2');
                tabla2.innerHTML = '';
                tabla2.innerHTML += respuestas['RESPUESTA2'];
                let tabla3 = document.querySelector('#respuesta3');
                tabla3.innerHTML = '';
                tabla3.innerHTML += respuestas['RESPUESTA3'];

                // Y DESPUES MOSTRAMOS LA TABLA, EL TEXTO Y RECUADRO
                document.getElementById('TablaResultado').style.visibility = 'visible';
                document.getElementById('texto').style.visibility = 'visible';
                document.getElementById('recuadro').style.visibility = 'visible';
        }else{
            alert(respuestas.TITULO);
        }
    }
    </script>
</body>

</html>