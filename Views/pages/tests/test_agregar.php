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
$materias = $datos->agregar();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar test</title>
    <link rel="icon" href="../../imgs/test_logo.ico">
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/agreg_edit.css?v=<?php echo (rand()); ?>" />
    <style>
        ul {
            list-style-type: none;
        }

        li {
            cursor: pointer;
        }

        .content-select i {
            top: 50%;
        }

        #div_tel_inc {
            margin-top: 20px;
        }

        .form table {
            margin-top: -30px;
        }
    </style>
</head>
</head>

<body>
    <header>Agregar test</header>

    <div class=form>
        <form action="#" method="post">

            <table>
                <tr>
                    <td colspan="1">
                        <span>Fecha limite:</span><br>
                        <input type="date" name="fecha_limite" id="fecha_limite" max="9999-12-31" required><label for="fecha_limite"></label>
                    </td>
                    <td colspan="2">
                        <div id="div_tel_inc">
                            <input type="text" name="tema" id="tema" required><label for="tema" required><span>Tema:</span></label>
                        </div>

                    </td>

                </tr>
                <tr>
                    <td colspan="2">
                        <div class="content-select"><span>Materia:&nbsp; </span> <select name="id_mat" id="id_mat" required>
                                <?php while ($row = $materias->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id_mat'] . "'>" . $row['materia'] . "</option>";
                                } ?>
                            </select>
                            <i></i>
                        </div>
                    <td>
                        <div class="content-select"><span>Escala:&nbsp; </span> <select name="escala" id="escala" required>

                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20" selected>20</option>
                                <option value="100">100</option>

                            </select>
                            <i></i>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">

                        <input type="text" name="id_usu" id="id_usu" value="<?php echo $_SESSION['id_usu']; ?>" style="display:none;">

                    </td>
                </tr>
                <tr>
                    <td colspan="1">
                        <a href="test_view.php"><button type="button" class="volver">Volver</button></a>
                    </td>


                    <td colspan="5">
                        <input type="reset" name="borrar" id="borrar" value="Borrar">
                    </td>

                    <td colspan="4"><input type="submit" name="siguiente" class="siguientebtn" value="Siguiente"></td>


                </tr>
            </table>
        </form>
    </div>

</body>

</html>