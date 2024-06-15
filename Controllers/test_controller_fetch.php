<?php

class Test_controller
{
    private $tests;


    public function __construct()
    {
        require("../Models/test_model.php");

        $this->tests = new Test;
    }

    public function guardar_config_test($pregs)
    {
        try {
            foreach ($pregs as $preg) {
                $this->tests->set("pregunta", $preg['pregunta']);
                $this->tests->set("tipo_preg", $preg['tipo_preg']);
                $this->tests->set("id_test", $preg['id_test']);
                $id_preg = $this->tests->add_preg();
                $this->tests->set("id_preg", $id_preg);

                if ($preg["resp"] != 0) {
                    for ($i = 0; $i < count($preg["resp"]); $i++) {
                        $preg["resp"][$i];
                        $this->tests->set("resp_radio", $preg['resp'][$i]);
                        $this->tests->set("seleccionada", $preg['seleccionada'][$i]);
                        $this->tests->add_resp_radio();
                    }
                }
            }
            echo "Listo";
        } catch (Exception $e) {
            echo $e;
            echo "Fallo";
        }
    }

    public function guardar_resps_est($resps)
    {
        try {
            foreach ($resps as $resp) {
                $this->tests->set("resp_est", $resp['resp']);
                $this->tests->set("id_preg", $resp['id_preg']);
                $this->tests->set("id_usu", $resp['id_usu']);
                $this->tests->add_resp_est();
            }
            $this->tests->set("id_test", $resp['id_test']);
            $this->tests->set("puntos", 0);
            $this->tests->add_punt_test();
            echo "Listo";
        } catch (Exception $e) {
            echo $e;
            echo "Fallo";
        }
    }

    public function act_punt_est($info)
    {
        try {

            for ($i = 0; $i < count($info['id_respuestas']); $i++) {
                $this->tests->set("id_resp_est", $info['id_respuestas'][$i]);
                $eval = $info['evaluacion'][$i] == "correcta" ? true : false;
                $this->tests->set("correcta", $eval);
                $this->tests->update_punt_resp_est();
            }

            $this->tests->set("id_test", $info['id_test']);
            $this->tests->set("id_usu", $info['id_usu']);
            $this->tests->set("puntos", bcdiv($info['puntos'], "1", 1));
            $this->tests->update_punt_test();

            echo "Listo";
        } catch (Exception $e) {
            echo $e;
            echo "Fallo";
        }
    }
}

$test_endpoint = new Test_controller;

$req = json_decode(file_get_contents("php://input"), true);

if (isset($req)) {

    if (isset($req[0]["accion"])) {
        if ($req[0]["accion"] == "guardar_config_test") {
            $test_endpoint->guardar_config_test($req);
        }

        if ($req[0]["accion"] == "guardar_resps_est") {
            $test_endpoint->guardar_resps_est($req);
        }
    } else {
        if ($req["accion"] == "act_punt_est") {
            $test_endpoint->act_punt_est($req);
        }
    }
}
