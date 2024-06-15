<link rel="stylesheet" href="./../../css/modal_eliminar.css?v=<?php echo (rand()); ?>">

<script type="text/javascript">
    function showContent<?php echo $num ?>() {
        element = document.getElementById("modal-fade<?php echo $num ?>");
        check = document.getElementById("btn-modal<?php echo $num ?>");
        if (check.checked) {
            element.style.display = 'flex';
        } else {
            element.style.display = 'none';
        }
    }
</script>

<style>
    .boton-modal {
        width: 100%;
        background: red;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        transition: all 300ms ease;
    }

    .boton-modal:hover {
        background-color: rgb(197, 1, 1);
    }

    .boton-modal label {
        background-color: transparent;
    }

    .boton-modal label:hover {
        background-color: transparent;
    }
</style>
<label for="btn-modal<?php echo $num ?>" style="width: 100% ;">
    <div class="boton-modal">
        Eliminar
    </div>
</label>
<input type="checkbox" name="btn-modal<?php echo $num ?>" id="btn-modal<?php echo $num ?>" value="1" style="display: none;" onchange="javascript:showContent<?php echo $num ?>()" />
<div class="modal-fade" id="modal-fade<?php echo $num ?>" style="display: none;">


    <div class="modal-contenedor">
        <header>Confirmación de eliminación</header>
        <p><?php echo "¿Esta seguro que desea eliminar el test sobre <b>'" . $row['tema'] . "'</b>, de la materia: <b>'" . $row['materia'] . "'</b>?" ?></p>


        <div class="btn-cerrar">
            <label for="btn-modal<?php echo $num ?>">Cancelar</label>
        </div>
        <label for="btn-modal<?php echo $num ?>" class="cerrar-modal"></label>

        <a href="test_eliminar.php?id_test=<?php echo $row['id_test'] ?>" class="boton-eliminar"><button type="button">Eliminar</button></a>
    </div>


</div>