<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
session_start();
$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
   // username and password sent from form 

   $myusername = $_POST['username'];
   $mypassword = $_POST['password'];

   require_once("clases/clase.usuario.php");
   $claseusuario = new usuario;

   if($claseusuario->acceso_permitido($myusername, $mypassword)) {
     
      $claseusuario->nombre = $myusername;
      $claseusuario->get_datos_nombre();
      $_SESSION['usuario_id'] = $claseusuario->id;
      $_SESSION['usuario_nombre'] = $claseusuario->nombre;
      $_SESSION['usuario_nivel'] = $claseusuario->nivel;

      header("location: index.php");
   } else {
      header("location: login.form.php?error='Usuario o Password maal'");
   }
}
?>
