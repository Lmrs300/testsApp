<?php

class Test
{
    private $id_test;
    private $tema;
    private $fecha_limite;
    private $escala;
    private $id_mat;
    private $id_usu;

    //tabla preguntas
    private $id_preg;
    private $pregunta;
    private $tipo_preg;

    //tabla resp_radio
    private $id_resp_radio;
    private $resp_radio;
    private $seleccionada;

    //tabla resp_est
    private $id_resp_est;
    private $resp_est;
    private $correcta;

    //tabla puntuaciones_test
    private $id_pun_test;
    private $puntos;



    //tabla materias
    private $materia;


    private $con;


    public function __construct()
    {
        require("base_datos.php");
        $this->con = Base_datos::connect();
    }

    public function set($atributo, $contenido)
    {
        $this->$atributo = $contenido;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function index()
    {
        $sql = "SELECT * FROM materias RIGHT OUTER JOIN tests ON materias.id_mat=tests.id_mat LEFT OUTER JOIN usuarios ON tests.id_usu=usuarios.id_usu";
        $datos = $this->con->query($sql);
        return $datos;
    }

    public function index_pregs()
    {
        $sql = "SELECT * FROM preguntas WHERE id_test=:id_test";
        $datos = $this->con->prepare($sql);
        $datos->execute([":id_test" => $this->id_test]);
        return $datos;
    }

    public function index_resps_radio()
    {
        $sql = "SELECT * FROM resp_radio WHERE id_preg=:id_preg";
        $datos = $this->con->prepare($sql);
        $datos->execute([":id_preg" => $this->id_preg]);
        return $datos;
    }

    public function index_resps_est()
    {
        $sql = "SELECT id_resp_est,resp_est, preguntas.id_preg FROM resp_est INNER JOIN preguntas ON resp_est.id_preg=preguntas.id_preg INNER JOIN tests ON preguntas.id_test=tests.id_test WHERE tests.id_test=:id_test AND resp_est.id_usu=:id_usu";
        $datos = $this->con->prepare($sql);
        $datos->execute([":id_test" => $this->id_test, ":id_usu" => $this->id_usu]);
        $rows = $datos->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function index_materias()
    {
        $sql = "SELECT * FROM materias ORDER BY materia ASC";
        $datos = $this->con->query($sql);
        return $datos;
    }

    public function index_punt_espec()
    {
        $sql = "SELECT * FROM puntuaciones_tests WHERE id_test=:id_test AND id_usu=:id_usu";
        $datos = $this->con->prepare($sql);

        if ($datos->execute([":id_test" => $this->id_test, ":id_usu" => $this->id_usu])) {
            $row = $datos->fetch(PDO::FETCH_ASSOC);
            return $row;
        }
        return false;
    }

    public function index_punt_gen()
    {
        $sql = "SELECT * FROM puntuaciones_tests INNER JOIN usuarios ON puntuaciones_tests.id_usu=usuarios.id_usu WHERE id_test=:id_test";
        $datos = $this->con->prepare($sql);

        if ($datos->execute([":id_test" => $this->id_test])) {
            return $datos;
        }
        return false;
    }

    public function add()
    {
        $sql = "INSERT INTO tests (id_test, tema, fecha_limite, escala, id_mat, id_usu) VALUES(null,:tema,:fecha_limite, :escala, :id_mat, :id_usu);";
        $query = $this->con->prepare($sql);

        $query->execute(array(":tema" => $this->tema, ":fecha_limite" => $this->fecha_limite, ":escala" => $this->escala, ":id_mat" => $this->id_mat, ":id_usu" => $this->id_usu));

        return $this->con->lastInsertId();
    }

    public function add_preg()
    {
        $sql = "INSERT INTO preguntas VALUES(null,:pregunta, :tipo_preg, :id_test);";
        $query = $this->con->prepare($sql);

        $query->execute([":pregunta" => $this->pregunta, ":tipo_preg" => $this->tipo_preg, ":id_test" => $this->id_test]);

        return $this->con->lastInsertId();
    }

    public function add_resp_radio()
    {
        $sql = "INSERT INTO resp_radio VALUES(null, :resp_radio, :seleccionada, :id_preg);";
        $query = $this->con->prepare($sql);

        $query->execute([":resp_radio" => $this->resp_radio, ":seleccionada" => $this->seleccionada, ":id_preg" => $this->id_preg]);
    }

    public function add_resp_est()
    {
        $sql = "INSERT INTO resp_est VALUES(null, :resp_est, 0, :id_preg, :id_usu);";
        $query = $this->con->prepare($sql);

        $query->execute([":resp_est" => $this->resp_est, ":id_preg" => $this->id_preg, ":id_usu" => $this->id_usu]);
    }

    public function add_punt_test()
    {
        $sql = "INSERT INTO puntuaciones_tests (id_pun_test, puntos, id_usu, id_test) VALUES(null, :puntos, :id_usu, :id_test);";
        $query = $this->con->prepare($sql);

        $query->execute(array(":puntos" => $this->puntos, ":id_usu" => $this->id_usu, ":id_test" => $this->id_test));
    }

    public function edit()
    {
        $sql = "UPDATE tests SET fecha_limite=:fecha_limite, escala=:escala, id_mat=:id_mat, id_usu=:id_usu WHERE id_test=:id_test";
        $query = $this->con->prepare($sql);
        $query->execute([":fecha_limite" => $this->fecha_limite, ":escala" => $this->escala, ":id_mat," => $this->id_mat, ":id_usu" => $this->id_usu, ":id_test" => $this->id_test]);
    }

    public function update_punt_resp_est()
    {
        $sql = "UPDATE resp_est SET correcta=:correcta WHERE id_resp_est=:id_resp_est";
        $query = $this->con->prepare($sql);
        $query->execute([":correcta" => $this->correcta, ":id_resp_est" => $this->id_resp_est]);
    }

    public function update_punt_test()
    {
        $sql = "UPDATE puntuaciones_tests SET puntos=:puntos WHERE id_usu=:id_usu AND id_test=:id_test";
        $query = $this->con->prepare($sql);
        $query->execute([":puntos" => $this->puntos, ":id_usu" => $this->id_usu, ":id_test" => $this->id_test]);
    }

    public function delete()
    {
        $sql = "DELETE FROM tests WHERE id_test=:id_test";
        $query = $this->con->prepare($sql);
        $query->execute([":id_test" => $this->id_test]);
    }

    public function view()
    {
        $sql = "SELECT * FROM materias RIGHT OUTER JOIN tests ON materias.id_mat=tests.id_mat LEFT OUTER JOIN usuarios ON tests.id_usu=usuarios.id_usu WHERE id_test=:id_test";
        $datos = $this->con->prepare($sql);
        $datos->execute([":id_test" => $this->id_test]);
        $row = $datos->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function view_usuario()
    {
        $sql = "SELECT nom_usu, ced_usu FROM usuarios WHERE id_usu=:id_usu";
        $datos = $this->con->prepare($sql);
        $datos->execute([":id_usu" => $this->id_usu]);
        $row = $datos->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
