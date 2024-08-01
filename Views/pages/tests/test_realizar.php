<?php
session_start();

if (!isset($_SESSION['rol'])) {
    //para que si la sesion no esta iniciada te saque al login.
    header('location: http://localhost/testsApp/');
}

require("../../../Controllers/test_controller.php");

$datos = new Test_controller();

$info_test = $datos->ver($_GET['id_test']);

$pregs = $datos->listar_pregs($_GET['id_test']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar test</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/test_config.css?v=<?php echo (rand()); ?>" />
    <script src="../../js/jquery-3.6.4.min.js"></script>
    <script src="../../js/test_config.js"></script>
    <script>
        async function guardar_resps_est() {
            let cont_pregs = document.querySelectorAll(".contenedor_preg")

            let obj_preg = []
            var error = false
            cont_pregs.forEach((cont_preg, index) => {
                let tipo_preg = cont_preg.getAttribute("tipo_preg")

                let id_preg = cont_preg.getAttribute("id_preg")

                let respuesta = "Sin respuesta"

                if (tipo_preg != "pregunta sel mul") {
                    let input_resp = cont_preg.querySelector("#resp")

                    if (input_resp.value != "") {
                        respuesta = input_resp.value
                    }
                } else {

                    let spansResps_radio = cont_preg.querySelectorAll(".radio_contenedor span")

                    spansResps_radio.forEach((spanResps_radio) => {


                        if (spanResps_radio.nextElementSibling.checked) {
                            respuesta = spanResps_radio.innerText
                        }

                    })
                }

                obj_preg.push({
                    resp: respuesta,
                    id_preg: id_preg,
                    id_usu: <?php echo $_SESSION['id_usu'] ?>,
                    id_test: <?php echo $_GET['id_test'] ?>,
                    accion: "guardar_resps_est",
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
                    console.log(data)
                    $("#error").html("Error: No se pudo enviar el test, algo fallo.")
                    return
                }
            }



        }

        $(document).ready(() => {
            $("#guardar_test").on("click", guardar_resps_est)
        })
    </script>

</head>

<body>
    <header>Realizar test</header>
    <div class="contenedor">
        <div class='contenedor_participante'>
            <div class="info_test">
                <h2>Asignada por:</h2>
                <span>Prof. <?php echo $info_test['nom_usu'] ?></span>
            </div>
            <div class="info_test">
                <h2>Tema:</h2>
                <span><?php echo $info_test['tema'] ?></span>
            </div>
            <div class="info_test">
                <h2>Materia:</h2>
                <span><?php echo $info_test['materia'] ?></span>
            </div>
            <div class="info_test">
                <h2>Escala:</h2>
                <span>0/<?php echo $info_test['escala'] ?></span>
            </div>
        </div>
        <div class='contenedor_participante' style="margin-top: -20px;">
            <div class="info_test">
                <h2>Estudiante:</h2>
                <span><?php echo $_SESSION['nombre'] ?></span>
            </div>

            <div class="info_test">
                <h2>Cédula:</h2>
                <span><?php echo $_SESSION['cedula'] ?></span>
            </div>

        </div>
        <ul id="preguntas">
            <?php
            $num = 0;
            while ($preg = $pregs->fetch(PDO::FETCH_ASSOC)) {

                if ($preg['tipo_preg'] == "pregunta corta") { ?>

                    <li class='contenedor_preg contenedor_preg_corta' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta corta' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <input type='text' id='resp' name='resp' class='resp' placeholder='Ingrese su respuesta'>
                    </li>

                <?php } else if ($preg['tipo_preg'] == "pregunta parrafo") { ?>

                    <li class='contenedor_preg contenedor_par' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta parrafo' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <textarea type='text' cols='3' rows='3' id='resp' name='resp' class='resp' placeholder='Ingrese su respuesta'></textarea>
                    </li>

                <?php } else { ?>

                    <li class='contenedor_preg contenedor_par' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta sel mul' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <?php $resp_radio = $datos->listar_resps_radio($preg['id_preg']); ?>
                        <ul class='radios_lista'>
                            <?php while ($resp = $resp_radio->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li class="radio_contenedor">
                                    <span><?php echo $resp['resp_radio'] ?></span>

                                    <input type="radio" id="<?php echo $resp['id_resp_radio'] ?>" name="<?php echo "resp_radio" . $num ?>" class="resp_radio" value="<?php echo $resp['resp_radio'] ?>">
                                    <label for="<?php echo $resp['id_resp_radio'] ?>"></label>
                                </li>
                            <?php } ?>
                        </ul>

                    </li>

                <?php } ?>


            <?php $num++;
            } ?>
        </ul>

        <div id="error"></div>

        <div id="buttons">

            <a href="test_view.php"><button type="button" class="volver">Volver</button></a>

            <button class="guardar_test" id="guardar_test" type="button">Terminar test</button>
        </div>
    </div>
</body>

</html>