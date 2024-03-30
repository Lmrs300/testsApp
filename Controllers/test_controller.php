<?php

class Test_controller
{
    private $tests;


    public function __construct()
    {
        require("../../../Models/test_model.php");

        $this->tests = new Test;
    }

    public function listar()
    {
        $datos = $this->tests->index();

        return $datos;
    }

    public function listar_pregs($id_test)
    {
        $this->tests->set("id_test", $id_test);
        $datos = $this->tests->index_pregs();

        return $datos;
    }

    public function listar_resps_radio($id_preg)
    {
        $this->tests->set("id_preg", $id_preg);
        $datos = $this->tests->index_resps_radio();

        return $datos;
    }

    public function listar_resps_est($id_test, $id_usu)
    {
        $this->tests->set("id_test", $id_test);
        $this->tests->set("id_usu", $id_usu);
        $datos = $this->tests->index_resps_est();

        return $datos;
    }

    public function listar_punt_espec($id_test, $id_usu)
    {
        $this->tests->set("id_test", $id_test);
        $this->tests->set("id_usu", $id_usu);
        $datos = $this->tests->index_punt_espec();

        return $datos;
    }

    public function listar_punt_gen($id_test)
    {
        $this->tests->set("id_test", $id_test);
        $datos = $this->tests->index_punt_gen();
        return $datos;
    }

    public function agregar()
    {
        if (!$_POST) {
            $materias = $this->tests->index_materias();
            return $materias;
        } else {

            $this->tests->set("fecha_limite", $_POST['fecha_limite']);
            $this->tests->set("tema", $_POST['tema']);
            $this->tests->set("id_mat", $_POST['id_mat']);
            $this->tests->set("escala", $_POST['escala']);
            $this->tests->set("id_usu", $_POST['id_usu']);
            $id_test = $this->tests->add();
            $usuario = $this->tests->view_usuario();

            header("Location: test_config.php?id_test=$id_test&profesor=" . $usuario['nom_usu']);
        }
    }


    public function eliminar($id_test)
    {
        $this->tests->set("id_test", $id_test);
        $this->tests->delete();
    }

    public function eliminar_volver($id_test)
    {
        $this->tests->set("id_test", $id_test);
        $this->tests->delete();

        header("Location: test_agregar.php");
    }

    public function ver($id_test)
    {
        $this->tests->set("id_test", $id_test);
        $info_test = $this->tests->view();
        return $info_test;
    }

    public function ver_usuario($id_usu)
    {
        $this->tests->set("id_usu", $id_usu);
        $datos = $this->tests->view_usuario();
        return $datos;
    }
}
