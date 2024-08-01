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

$info_test = $datos->ver($_GET['id_test']);

$pregs = $datos->listar_pregs($_GET['id_test']);

$info_est = $datos->ver_usuario($_GET['id_usu']);

$resps_est = $datos->listar_resps_est($_GET['id_test'], $_GET['id_usu']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluar test</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/test_config.css?v=<?php echo (rand()); ?>" />
    <script src="../../js/jquery-3.6.4.min.js"></script>
    <script src="../../js/confetti.browser.js"></script>
    <script src="../../js/test_config.js?v=<?php echo (rand()); ?>"></script>
    <script>
        function resp_correcta(e) {
            e.target.parentElement.setAttribute("evaluacion", "correcta")
            e.target.style.filter = "grayscale(0)"
            e.target.style.scale = "1.2"
            e.target.nextElementSibling.style.filter = "grayscale(1)"
            e.target.nextElementSibling.style.scale = "1"
        }

        function resp_incorrecta(e) {
            e.target.parentElement.setAttribute("evaluacion", "incorrecta")
            e.target.style.filter = "grayscale(0)"
            e.target.style.scale = "1.2"
            e.target.previousElementSibling.style.filter = "grayscale(1)"
            e.target.previousElementSibling.style.scale = "1"
        }

        function school_confetti() {
            var end = Date.now() + (5 * 1000);

            // go Buckeyes!
            var colors = ['#bb0000', '#ffffff'];

            (function frame() {
                confetti({
                    particleCount: 2,
                    angle: 60,
                    spread: 55,
                    origin: {
                        x: 0
                    },
                    colors: colors
                });
                confetti({
                    particleCount: 2,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1
                    },
                    colors: colors
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        }

        function simple_confetti() {
            jsconfetti = new JSConfetti()

            jsconfetti.addConfetti()
        }

        function ver_punt_final(puntos = 0, escala = 20) {
            let h2_punt = $("#h2_puntaje")

            h2_punt.html(`<span id='modal_h2_span'>0</span>/${escala}`)

            let span = document.querySelector("#h2_puntaje #modal_h2_span")

            element = document.getElementById("modal-fade-punt");

            element.style.display = 'flex';

            let num = 0
            let result = 0

            setTimeout(() => {

                const timer = setInterval(() => {

                    if (result.toString().includes(puntos + ".0")) {
                        result = Math.floor(result)
                    }

                    span.innerHTML = result

                    num = num + 0.1

                    result = num.toFixed(1)



                    if (result > puntos) {
                        clearInterval(timer)

                        setTimeout(() => {
                            if (puntos < (escala / 2)) {
                                span.style.color = "red"
                            } else {
                                span.style.color = "green"

                                simple_confetti()
                            }
                        }, 300)
                    }

                }, 20)

            }, 500);
        }


        async function guardar_resps_est() {
            let conts_evaluar = document.querySelectorAll(".evaluar")
            let conts_evaluado = document.querySelectorAll(".evaluado")

            let obj_preg = {}
            let error = false
            let evaluacion = []
            let id_respuestas = []
            let puntos = 0;
            let escala = <?php echo $info_test['escala'] ?>;
            let punt_por_preg = escala / (conts_evaluado.length + conts_evaluar.length)
            conts_evaluar.forEach((cont_evaluar) => {

                let id = cont_evaluar.getAttribute("id_resp_est")
                let eval = cont_evaluar.getAttribute("evaluacion")

                id_respuestas.push(id)
                evaluacion.push(eval)
            })

            conts_evaluado.forEach((cont_evaluar) => {

                let id = cont_evaluar.getAttribute("id_resp_est")
                let eval = cont_evaluar.getAttribute("evaluacion")

                id_respuestas.push(id)
                evaluacion.push(eval)
            })

            if (evaluacion.includes("no evaluada")) {
                $("#error").html("Error: Hay una pregunta sin evaluar.")
                return
            }

            evaluacion.forEach((eval) => {
                if (eval == "correcta") {
                    puntos = puntos + punt_por_preg

                }
            })

            obj_preg = {
                id_respuestas: id_respuestas,
                evaluacion: evaluacion,
                puntos: puntos,
                id_usu: <?php echo $_GET['id_usu'] ?>,
                id_test: <?php echo $_GET['id_test'] ?>,
                accion: "act_punt_est",
            }


            console.log(obj_preg)

            if (error == false) {
                $("#error").html("")
                const resp = await fetch("../../../Controllers/test_controller_fetch.php", {
                    method: "post",
                    body: JSON.stringify(obj_preg)
                })

                const data = await resp.text()

                if (data == "Listo") {
                    ver_punt_final(puntos, escala)
                    //location.href = "test_lista_ver.php";

                } else {
                    console.log(data)
                    $("#error").html("Error: No se pudo enviar el test, algo fallo.")
                    return
                }
            }
        }

        $(document).ready(() => {
            $("#guardar_test").on("click", guardar_resps_est)

            $(".btn_check").on("click", resp_correcta)

            $(".btn_x").on("click", resp_incorrecta)

        })
    </script>

</head>

<body>
    <?php include("../../navbar.php") ?>
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
                <span><?php echo $_GET['puntos'] . "/" . $info_test['escala'] ?></span>
            </div>
        </div>
        <div class='contenedor_participante' style="margin-top: -20px;">
            <div class="info_test">
                <h2>Estudiante:</h2>
                <span><?php echo $info_est['nom_usu'] ?></span>
            </div>

            <div class="info_test">
                <h2>Cédula:</h2>
                <span><?php echo $info_est['ced_usu'] ?></span>
            </div>

        </div>
        <ul id="preguntas">
            <?php
            $num = 0;
            while ($preg = $pregs->fetch(PDO::FETCH_ASSOC)) {

                if ($preg['tipo_preg'] == "pregunta corta") { ?>

                    <li class='contenedor_preg contenedor_preg_corta' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta corta' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <div class="div_resp">
                            <h3 class="h3_resp">Respuesta:</h3>
                            <p class="p_resp">
                                <?php
                                foreach ($resps_est as $resp_est) {

                                    if ($resp_est['id_preg'] == $preg['id_preg']) {
                                        echo $resp_est['resp_est'];
                                        $id_resp = $resp_est['id_resp_est'];
                                    }
                                }
                                ?>
                            </p>
                        </div>
                        <div class='evaluar' id_resp_est='<?php echo $id_resp; ?>' evaluacion='no evaluada'>
                            <img class="btn_check" src='../../imgs/Check.png' style="bottom:-5px;">
                            <img class="btn_x" src='../../imgs/x.png' style="bottom:-5px;">
                        </div>
                    </li>

                <?php } else if ($preg['tipo_preg'] == "pregunta parrafo") { ?>

                    <li class='contenedor_preg contenedor_par' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta parrafo' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <div class="div_resp">
                            <h3 class="h3_resp">Respuesta:</h3>
                            <p class="p_resp">
                                <?php
                                foreach ($resps_est as $resp_est) {

                                    if ($resp_est['id_preg'] == $preg['id_preg']) {
                                        echo $resp_est['resp_est'];
                                        $id_resp = $resp_est['id_resp_est'];
                                    }
                                }
                                ?>
                            </p>
                        </div>

                        <div class='evaluar' id_resp_est='<?php echo $id_resp; ?>' evaluacion='no evaluada'>
                            <img class="btn_check" src='../../imgs/Check.png' style="bottom:-5px;">
                            <img class="btn_x" src='../../imgs/x.png' style="bottom:-5px;">
                        </div>

                    </li>

                <?php } else { ?>

                    <li class='contenedor_preg contenedor_par' id_preg='<?php echo $preg['id_preg']; ?>' tipo_preg='pregunta sel mul' style='--animation_name_dur: aparecer 1s;'>

                        <h3 class="h3_preg"><?php echo $preg['pregunta']; ?></h3>

                        <h3 class="h3_resp">Respuesta:</h3>
                        <?php
                        foreach ($resps_est as $resp_est) {

                            if ($resp_est['id_preg'] == $preg['id_preg']) {
                                $resp_usu = $resp_est['resp_est'];
                                $resp_id = $resp_est['id_resp_est'];
                            }
                        }

                        $resp_radio = $datos->listar_resps_radio($preg['id_preg']);
                        ?>

                        <ul class='radios_lista'>
                            <?php while ($resp = $resp_radio->fetch(PDO::FETCH_ASSOC)) { ?>
                                <li class="radio_contenedor">
                                    <span><?php echo $resp['resp_radio'] ?></span>

                                    <?php

                                    if ($resp['resp_radio'] == $resp_usu) {
                                        if ($resp['seleccionada'] == 1) {
                                            echo "<input type='radio' id='" . $resp['id_resp_radio'] . "' name='resp_usu" . $num . "' class='resp_radio correcta' value='" . $resp['resp_radio'] .  "'  checked disabled>
                                    
                                        <label for='" . $resp['id_resp_radio'] . "' title='Respuesta correcta del usuario'></label>";
                                            $evaluar = "Check.png";
                                        } else {
                                            echo "<input type='radio' id='" . $resp['id_resp_radio'] . "' name='resp_usu" . $num . "' class='resp_radio incorrecta' value='" . $resp['resp_radio'] .  "' checked disabled>
                                    
                                            <label for='" . $resp['id_resp_radio'] . "' title='Respuesta incorrecta del usuario'></label>";

                                            $evaluar = "x.png";
                                        }
                                    } else if ($resp['seleccionada'] == 1) {
                                        echo "<input type='radio' id='" . $resp['id_resp_radio'] . "' name='resp_radio" . $num . "' class='resp_radio' value='" . $resp['resp_radio'] .  "' checked disabled>
                                    
                                        <label for='" . $resp['id_resp_radio'] . "' title='Respuesta correcta'></label>";
                                    } else {
                                        echo "<input type='radio' id='" . $resp['id_resp_radio'] . "' name='resp_radio" . $num . "' class='resp_radio ' value='" . $resp['resp_radio'] .  "' disabled>
                                    
                                        <label for='" . $resp['id_resp_radio'] . "' title='Respuesta incorrecta'></label>";
                                    }
                                    ?>

                                </li>
                            <?php } ?>
                        </ul>
                        <div class='evaluado' id_resp_est='<?php echo $resp_id ?>' evaluacion='<?php echo $evaluar == "Check.png" ? "correcta" : "incorrecta"; ?>'><img src='../../imgs/<?php echo $evaluar; ?>'></div>
                    </li>

                <?php } ?>


            <?php $num++;
            } ?>
        </ul>

        <div id="error"></div>

        <div id="buttons">

            <a href="test_lista_ver.php?id_test=<?php echo $_GET['id_test'] ?>&escala=<?php echo $info_test['escala'] ?>"><button type="button" class="volver">Volver</button></a>

            <button class="guardar_test" id="guardar_test" type="button">Evaluar test</button>
        </div>
    </div>
    <?php include("test_modal_puntaje.php") ?>
</body>

</html>