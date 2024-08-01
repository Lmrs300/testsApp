<link rel="stylesheet" type="text/css" id="link_general" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/testsApp/Views/css/general.css?v=<?php echo (rand()); ?>" />
<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/testsApp/Views/css/navbar.css?v=<?php echo (rand()); ?>" />

<script src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/testsApp/Views/js/jquery-3.6.4.min.js"></script>

<nav>

	<h1>TestsApp</h1>

	<img src="../../imgs/menu.png" class="menu_nav">

	<a class="cerrar_sesion" href="../../../cerrar_sesion.php">Cerrar sesión</a>
</nav>

<script type="text/javascript">
	let menu_nav = document.querySelector('.menu_nav');
	let nav = document.querySelector('nav');

	menu_nav.onclick = function() {
		nav.classList.toggle('open');
	}
</script>