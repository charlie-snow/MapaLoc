MapaLoc &nbsp;&nbsp;&nbsp;&nbsp; - Lugares: <?php echo count($lugares) ?> - 
Modo: 
<?php if ($_SESSION['modoprueba'] == 1) {
	echo ('prueba');
} else {
	echo ('administrador');
}
?>
 <a href="admin.modoprueba.cambiar.php">cambiar</a> - 
Usuario: <?php echo $_SESSION['usuario_nombre']; ?> - Tabla: <?php echo $_SESSION['tabla']; ?> <a href="logout.php">logout</a>

---- <a href="https://github.com/tinuzz/wp-plugin-trackserver">TRACKSERVER</a> ----


