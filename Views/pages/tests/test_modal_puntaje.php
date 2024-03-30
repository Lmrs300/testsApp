<link rel="stylesheet" href="../../css/modal_puntaje.css?v=<?php echo (rand()); ?>">

<div class="modal-fade-punt" id="modal-fade-punt" style="display: none;">

    <div class="modal-contenedor-punt" id="modal-contenedor-punt">

        <h1>Puntaje final</header>

            <h2 id="h2_puntaje"></h2>

            <span id="modal_span_nom"><?php echo $info_est['nom_usu'] ?></span>

            <div id="cont_salir">
                <a href="test_lista_ver.php?id_test=<?php echo $_GET['id_test'] ?>&escala=<?php echo $info_test['escala'] ?>"><button class="salir" type="button">Salir</button></a>
            </div>
    </div>

</div>