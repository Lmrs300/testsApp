<?php
session_start();

if (!isset($_SESSION['rol'])) {
    //para que si la sesion no esta iniciada te saque al login.
    header('location: http://localhost/testsApp/');
} else {
    if ($_SESSION['rol'] != 1) {
        //para que si no eres un usuario autorizado para estar en esta pagina te saque al login.
        header('location: http://localhost/testsApp/');
    }
}
require("../../../Controllers/test_controller.php");

$datos = new Test_controller();
$resultados = $datos->listar();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/listados.css?v=<?php echo (rand()); ?>" />
</head>

<body>
    <?php include("../../navbar.php") ?>
    <div class="titulo">
        <h1>Tests</h1>
    </div>

    <ul id="tests_ul">
        <?php
        $num = 0;
        while ($row = $resultados->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <li class="contenedor_test">

                <?php
                $punt_espec = $datos->listar_punt_espec($row['id_test'], $_SESSION['id_usu']);

                if ($punt_espec == false) {
                    echo "
                        <div class='test_estado' style='background-color: crimson; color: white;'>
                            <span>" . $row['fecha_limite'] . "</span>
                            <span class='punt_espec'>0/" . $row['escala'] . "</span>
                        </div>";
                } else {
                    echo "
                        <div class='test_estado' style='background-color: green; color: white;'>
                            <span>" . $row['fecha_limite'] . "</span>
                            <span class='punt_espec'>" . $punt_espec['puntos'] . "/" . $row['escala'] . "</span>
                        </div>";
                }

                ?>
                <div class="sec_cont">
                    <span class="span_tema"><?php echo $row['tema']; ?></span>
                    <span class="span_materia"><?php echo $row['materia']; ?></span>
                    <span class="span_prof">Asignada por Prof. <?php echo $row['nom_usu']; ?></span>
                </div>



                <div>
                    <a class="btn_ver-realizar_test" href="test_realizar.php?id_test=<?php echo $row['id_test']; ?>"><button <?php echo $punt_espec != false ? "title='Ya realizaste este test.' disabled" : ""; ?> style="border-radius: 0px 0px 5px 5px">Realizar test</button></a>
                </div>

            </li>

        <?php

        }
        ?>
    </ul>

</body>

</html>