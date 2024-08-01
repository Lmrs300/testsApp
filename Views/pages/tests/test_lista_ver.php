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
$resultados = $datos->listar_punt_gen($_GET['id_test']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tests realizados</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/test_lista_ver.css?v=<?php echo (rand()); ?>" />
</head>

<body>
    <?php include("../../navbar.php") ?>
    <h1 class="h1_comp">Tests completados</h1>

    <div id="cont_volver">
        <a href="test_view.php" class="volver"><button>Volver</button></a>
    </div>

    <?php

    if ($resultados->rowCount() <= 0) {
        echo "<h2  style='text-align:center; margin-top: 40px;'>Ningún estudiante ha completado este test aun.</h2>";
    }
    ?>

    <ul id="lista_comp">

        <?php
        $mitad = $_GET['escala'] / 2;

        while ($row = $resultados->fetch(PDO::FETCH_ASSOC)) {

            if ($row['puntos'] == 0) {
                $color = "";
            } else if ($row['puntos'] < $mitad) {
                $color = "color: red;";
            } else {
                $color = "color: green;";
            }

        ?>

            <li class="test_comp">
                <div class="info">
                    <span><?php echo $row['nom_usu']; ?></span>
                    <span><?php echo $row['ced_usu']; ?></span>
                </div>
                <div class="otro_div">
                    <span><strong style="<?php echo $color; ?>"><?php echo $row['puntos'] ?></strong>/<?php echo $_GET['escala'] ?></span>
                    <a href="test_evaluar.php?id_test=<?php echo $_GET['id_test'] ?>&id_usu=<?php echo $row['id_usu'] ?>&puntos=<?php echo $row['puntos'] ?>" class="btn_evaluar"><button>Evaluar</button></a>
                </div>
            </li>


        <?php } ?>


    </ul>



</body>

</html>