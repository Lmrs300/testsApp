<?php

include("Models/base_datos.php");


session_start();


if (isset($_SESSION['rol'])) {

    //Para que si la sesion esta iniciada, lleve directamente al usuario a su pagina principal respectiva.

    switch ($_SESSION['rol']) {
        case '1':
            header("location: Views/pages/tests/test_view_est.php");
            break;

        case '2':
            header("location: Views/pages/tests/test_view.php");
            break;

        default:
    }
}

if (isset($_POST["nom_usu"]) && isset($_POST["contra"])) {
    //Para validar datos.

    $nom_usu = $_POST["nom_usu"];
    $contra = $_POST["contra"];

    $db = new Base_datos();
    $query = $db->connect()->prepare('SELECT id_usu, nom_usu, ced_usu, id_rol FROM usuarios WHERE nom_usu=:nom_usu AND contra_usu=:contra');
    $query->execute([":nom_usu" => $nom_usu, ":contra" => $contra]);

    $row = $query->fetch(PDO::FETCH_NUM);
    if ($row == true) {
        $_SESSION['id_usu'] = $row[0];
        $_SESSION['nombre'] = $row[1];
        $_SESSION['cedula'] = $row[2];
        $_SESSION['rol'] = $row[3];

        switch ($_SESSION['rol']) {
            case '1':
                header("location: Views/pages/tests/test_view_est.php");
                break;

            case '2':
                header("location: Views/pages/tests/test_view.php");
                break;

            default:
        }
    } else {
        $errorLogin = "La cédula o contraseña son incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="icon" href="<?php echo URL; ?>Views/imgs/test_logo.ico">
    <link rel="stylesheet" id="link_general" href="Views/css/general.css">
    <link rel="stylesheet" href="Views/css/iniciar_sesion.css?v=<?php echo (rand()); ?>" />

</head>

<body>

    <div id="contenedor">

        <div id="img_cont">
            <img src="Views/imgs/test_logo.png" id="logo">
        </div>


        <form action="#" method="post">

            <h1 id="titulo">Iniciar sesión</h1>

            <label for="nom_usu">Nombre:</label>
            <input type="text" name="nom_usu" id="nom_usu" autocomplete="off" required>

            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" id="contra" autocomplete="off" required>

            <input type="submit" id="btn_iniciar_sesión" value="Iniciar sesión">

        </form>
        <div class="error">
            <?php
            if (isset($errorLogin)) {
                echo $errorLogin;
            }
            ?>
        </div>
    </div>

</body>

</html>