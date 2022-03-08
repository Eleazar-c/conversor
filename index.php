<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

    /* @media only screen and (max-width:768px) {
        .procesos {
            font-size: 20px;
        }
    } */
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1 style="text-align: center;">Conversion de Numeros</h1>
            <hr>
            <div class="col-sm-6 col-md-12">
                <div class="row p-2 m-1 justify-content-md-center ">

                    <div class="col-auto p-2">
                        <form action="funciones.php" id="conversor" method="post">
                            <input type="text" name="numero" id="numero" class="form-control" placeholder="Numero">
                    </div>
                    <div class="col-auto p-2">
                        <select class="form-select" name="tipo" aria-label="Default select example">
                            <option value="BINARIO" selected>BINARIO</option>
                            <option value="DECIMAL">DECIMAL</option>
                            <option value="OCTAL">OCTAL</option>
                            <option value="HEXADECIMAL">HEXADECIMAL</option>
                        </select>
                    </div>
                    <!-- <div class="col-auto"> -->
                    <!-- <span id="passwordHelpInline" class="form-text">
                                Seleccione el tipo de numero que ha escrito.
                                </span> -->
                    <!-- </div> -->
                    <div class="col-auto p-2 bt-2">
                        <button type="submit" class="bton btn btn-primary">Convertir</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row p-2 m-2 justify-content-md-center">
            <p id="texto" style="text-align: center;">Presiona el recuadro del numero al que quiere ver su proceso.</p>
            <!-- <div class="col-md-4"> -->
            <div class="col-md-6 overflow-auto ">
                <table class="table table-sm table-striped table-bordered" id="TablaResultado" align="center">
                    <thead style="text-align: center;">
                        <tr>
                            <th id="titulo1"></th>
                            <th id="titulo2"></th>
                            <th id="titulo3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
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
        <div class="row p-2 m-2 justify-content-md-center " id="recuadro">
            <div class="col-md-6 overflow-auto ">
                <div class="procesos" id="contenido1"></div>
                <div class="procesos" id="contenido2"></div>
                <div class="procesos" id="contenido3"></div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
    // document.getElementById('TablaResultado').style.visibility  = 'hidden';
    // document.getElementById('recuadro').style.visibility  = 'hidden';



    const CONVERSORFORM = document.querySelectorAll("#conversor");

    function conversor(e) {
        e.preventDefault();

        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");
        let encabezados = new Headers();

        //array de datos o json que vamos a pasar a la funcion de fech para que puede enivar y resivir los datos
        let config = {
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        }
        fetch(action, config)
            .then(respuesta => respuesta.json())
            //Este pedasito de codigo me servira por si hay un error en la ejecucion y me dira cual sera el error
            // .then(respuesta => respuesta.text())
            // .then(text =>console.log(text))

            .then(respuesta => {
                // console.log(respuesta);
                document.getElementById('TablaResultado').style.visibility = 'visible';
                document.getElementById('texto').style.visibility = 'visible';
                document.getElementById('recuadro').style.visibility = 'visible';
                // TITULOS DE LA TABLA
                let TituloUno = document.querySelector('#titulo1');
                TituloUno.innerHTML = '';
                TituloUno.innerHTML += respuesta['TITULO1'];
                let TituloDos = document.querySelector('#titulo2');
                TituloDos.innerHTML = '';
                TituloDos.innerHTML += respuesta['TITULO2'];
                let TituloTres = document.querySelector('#titulo3');
                TituloTres.innerHTML = '';
                TituloTres.innerHTML += respuesta['TITULO3'];

                // PROCEDIMIENTOS
                let RespuestaUno = document.querySelector('#contenido1');
                RespuestaUno.innerHTML = '';
                RespuestaUno.innerHTML += respuesta['CONTENIDO1'];
                let RespuestaDos = document.querySelector('#contenido2');
                RespuestaDos.innerHTML = '';
                RespuestaDos.innerHTML += respuesta['CONTENIDO2'];
                let Respuesta3 = document.querySelector('#contenido3');
                Respuesta3.innerHTML = '';
                Respuesta3.innerHTML += respuesta['CONTENIDO3'];

                // RESPUESTAS
                let tabla = document.querySelector('#respuesta1');
                tabla.innerHTML = '';
                tabla.innerHTML += respuesta['RESPUESTA1'];
                let tabla2 = document.querySelector('#respuesta2');
                tabla2.innerHTML = '';
                tabla2.innerHTML += respuesta['RESPUESTA2'];
                let tabla3 = document.querySelector('#respuesta3');
                tabla3.innerHTML = '';
                tabla3.innerHTML += respuesta['RESPUESTA3'];
            });
    }

    CONVERSORFORM.forEach(formularios => {
        formularios.addEventListener("submit", conversor);
    });

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
    </script>
</body>

</html>