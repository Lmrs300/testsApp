<?php
session_start();

if (!isset($_SESSION['rol'])) {
    //para que si la sesion no esta iniciada te saque al login.
    header('location: http://localhost/testsApp/');
} else {
    if ($_SESSION['rol'] != 2) {
        //para que si no eres un usuario autorizado para estar en esta pagina te saque al login.
        header('location: http://localhost/testsApp/');
    }
}

require("../../../Controllers/test_controller.php");

$datos = new Test_controller();

if (isset($_POST['id_test'])) {
    $datos->eliminar_volver($_POST['id_test']);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar test</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/test_config.css?v=<?php echo (rand()); ?>" />
    <script src="../../js/jquery-3.6.4.min.js"></script>
    <script src="../../js/test_config.js?v=<?php echo (rand()); ?>"></script>
    <script>
        async function guardar_test() {
            let cont_pregs = document.querySelectorAll(".contenedor_preg")

            if (cont_pregs.length <= 0) {
                $("#error").html("Error: Debe crear al menos una pregunta.")
                return
            } else {
                $("#error").html("")
            }

            let obj_preg = []
            var error = false
            cont_pregs.forEach((cont_preg, index) => {
                let tipo_preg = cont_preg.getAttribute("tipo_preg")

                let input_preg = cont_preg.querySelector("#preg")

                if (input_preg.value == "" || input_preg.value == " ") {
                    $("#error").html("Error: Todos los campos deben ser llenados")
                    error = true
                    return
                }

                let spansResps_radio = cont_preg.querySelectorAll(".radio_contenedor span")

                if (tipo_preg == "pregunta sel mul") {
                    if (spansResps_radio.length > 1) {
                        var respuestas = []
                        var seleccionada = []

                        spansResps_radio.forEach((spanResps_radio) => {
                            respuestas.push(spanResps_radio.innerText)

                            if (spanResps_radio.nextElementSibling.checked) {
                                seleccionada.push(true)
                            } else {
                                seleccionada.push(false)
                            }

                        })

                        if (!seleccionada.includes(true)) {
                            $("#error").html("Error: Debe seleccionar al menos una opción de cada pregunta de selección multiple.")
                            error = true
                            return
                        }
                    } else {
                        $("#error").html("Error: Debe crear al menos dos opciones para cada pregunta de selección multiple.")
                        error = true
                        return
                    }
                } else {
                    var respuestas = 0
                    var seleccionada = 0
                }



                obj_preg.push({
                    pregunta: input_preg.value,
                    tipo_preg: tipo_preg,
                    resp: respuestas,
                    seleccionada: seleccionada,
                    id_test: <?php echo $_GET['id_test'] ?>,
                    accion: "guardar_config_test",
                })

            })
            console.log(obj_preg)

            if (error == false) {
                $("#error").html("")
                const resp = await fetch("../../../Controllers/test_controller_fetch.php", {
                    method: "post",
                    body: JSON.stringify(obj_preg)
                })

                const data = await resp.text()

                if (data == "Listo") {
                    location.href = "test_view.php";

                } else {
                    $("#error").html("Error: No se pudo guardar el test, algo fallo.")
                    return
                }
            }



        }

        $(document).ready(() => {
            $("#guardar_test").on("click", guardar_test)
        })
    </script>

</head>

<body>
    <header>Configurar test</header>
    <div class="contenedor">
        <div class='contenedor_participante' style="justify-content: flex-start;">
            <div class="test_info">
                <h2>Asignada por:</h2>
                <span>Prof. <?php echo $_GET['profesor'] ?></span>
            </div>
        </div>
        <ul id="preguntas">
        </ul>
        <div class="agregar_preg">
            <div class="texto_agregar_preg"><strong>+</strong> Agregar pregunta</div>
            <button class="opciones_preg" id="opc_preg_corta" onclick="crear_preg_corta()">Pregunta corta</button>
            <button class="opciones_preg" id="opc_par" onclick="crear_par()">Párrafo</button>
            <button class="opciones_preg" id="opc_sel_mul" onclick="crear_sel_mul()">Selección multiple</button>
        </div>

        <div id="error"></div>

        <div id="buttons">
            <form action="#" method="post" id="form_volver">
                <input type="text" name="id_test" style="display: none;" value="<?php echo $_GET['id_test'] ?>">
                <input class="volver" type="submit" value="Volver" form="form_volver">


                <button class="guardar_test" id="guardar_test" type="button">Guardar test</button>
            </form>
        </div>
    </div>
</body>

</html>