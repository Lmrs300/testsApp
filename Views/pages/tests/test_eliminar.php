<?php
//session_start();
//TODO: Esto hay que arreglarlo cunado las sesiones esten listas.
// if (!isset($_SESSION['rol'])) {
//     //para que si la sesion no esta iniciado te saque al login.
//     header('location: http://localhost/testsApp/');
//} else {
require("../../../Controllers/test_controller.php");
$datos = new Test_controller();
$id_test = $_GET['id_test'];
$datos->eliminar($id_test);
header("location: test_view.php");
//}
