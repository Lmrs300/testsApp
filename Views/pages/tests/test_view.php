<?php
session_start();

if (!isset($_SESSION['rol'])) {
    //para que si la sesion no esta iniciada te saque al login.
    header('location: http://localhost/testsApp/');
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
    <title>tests</title>
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/listados.css?v=<?php echo (rand()); ?>" />
</head>

<body>
    <?php include("../../navbar.php") ?>
    <div class="titulo">
        <h1>Tests</h1>
    </div>

    <?php if ($_SESSION['rol'] == 2) { ?>
        <div class="agregar">
            <a href="test_agregar.php"><button>Agregar</button></a>
        </div>
    <?php } ?>

    <ul id="tests_ul">
        <?php
        $num = 0;
        while ($row = $resultados->fetch(PDO::FETCH_ASSOC)) {  ?>

            <li class="contenedor_test">

                <?php
                if ($_SESSION['rol'] == 1) {
                    $punt_espec = $datos->listar_punt_espec($row['id_test'], $_SESSION['id_usu']);

                    if ($punt_espec == false) {
                        echo "
                        <div class='test_estado' style='background-color: crimson; color: white;'>
                            <span>" . $row['fecha_limite'] . "</span>
                        </div>";

                        echo "<span>0/" . $row['escala'] . "</span>";
                    } else {
                        echo "
                        <div class='test_estado' style='background-color: green; color: white;'>
                            <span>" . $row['fecha_limite'] . "</span>
                        </div>";

                        echo "<span>" . $punt_espec['puntos'] . "/" . $row['escala'] . "</span>";
                    }
                } else {
                    echo "
                    <div class='test_estado'>
                        <span>" . $row['fecha_limite'] . "</span>
                    </div>";
                }
                ?>

                <span><?php echo $row['tema']; ?></span>
                <span><?php echo $row['materia']; ?></span>
                <span>Asignada por Prof. <?php echo $row['nom_usu']; ?></span>

                <?php if ($_SESSION['rol'] == 2) { ?>
                    <div>
                        <a class="btn_ver-realizar_test" href="test_lista_ver.php?id_test=<?php echo $row['id_test']; ?>&escala=<?php echo $row['escala']; ?>"><button <?php echo $row['nom_usu'] != $_SESSION['nombre'] ? "title='No puede revisar los tests de otro profesor' disabled" : "" ?>>Ver tests</button></a>
                    </div>
                <?php } else { ?>
                    <div>
                        <a class="btn_ver-realizar_test" href="test_realizar.php?id_test=<?php echo $row['id_test']; ?>"><button <?php echo $punt_espec != false ? "title='Ya realizaste este test.' disabled" : ""; ?>>Realizar test</button></a>
                    </div>

                <?php
                }
                if ($_SESSION['rol'] == 2) {
                    include("test_modal_eliminar.php");
                }
                $num++
                ?>
            </li>

        <?php }
        ?>
    </ul>

</body>

</html>