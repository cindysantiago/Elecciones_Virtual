<?php 
/*session_start();
$ID=$_SESSION['ID'];
$usuario=$_SESSION['usuario'];*/
include("include.inc.php");
//include("verificar.php");
function menu()
{
	include("menu.php");
}
function contenido()
{
echo "<p align=center> Bienvenido al aplicativo VOTACIONES VIRTUALES </p>
<br> Prueba de rama desarrolo";
//header("Location: $redireccion");
}
include($plantilla);
?>
