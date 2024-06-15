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
$resultados = $datos->listar();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
    <link rel="icon" href="../../imgs/logo_UPTAMCA.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/listados.css?v=<?php echo (rand()); ?>" />
</head>

<body>
    <?php include("../../navbar.php") ?>
    <div class="titulo">
        <h1>Tests</h1>
    </div>


    <div class="agregar">
        <a href="test_agregar.php"><button>Agregar</button></a>
    </div>


    <ul id="tests_ul">
        <?php
        $num = 0;
        while ($row = $resultados->fetch(PDO::FETCH_ASSOC)) {

            if ($row['nom_usu'] == $_SESSION['nombre']) {
        ?>
                <li class="contenedor_test">

                    <?php
                    echo "
                    <div class='test_estado'>
                        <span>" . $row['fecha_limite'] . "</span>
                    </div>";

                    ?>
                    <div class="sec_cont">
                        <span class="span_tema"><?php echo $row['tema']; ?></span>
                        <span class="span_materia" style="margin-top: -5px;"><?php echo $row['materia']; ?></span>

                        <div>
                            <a class="btn_ver-realizar_test" href="test_lista_ver.php?id_test=<?php echo $row['id_test']; ?>&escala=<?php echo $row['escala']; ?>"><button>Ver tests</button></a>
                        </div>

                        <?php

                        include("test_modal_eliminar.php");

                        $num++
                        ?>
                    </div>
                </li>

        <?php
            }
        }
        ?>
    </ul>

</body>

</html>