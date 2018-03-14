<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");
$op=$_REQUEST['op'];
$permiso=$_REQUEST['permiso'];
if($op=="votar" AND $idcandidato!="")
{
	   /* $sql6="DELETE FROM permisos WHERE permiso='$permiso'";
	    $rs6=$conn->Execute($sql6); */
	    //echo $sql6;
	    $error=2;
}
function menu()
{
	include("menu.php");
}
function contenido()
{
	global $conn,$ID,$filtro,$pagina,$error; 
	$pagina=$_REQUEST['pagina'];
	$filtro=$_REQUEST['filtro'];
	$tam_pagina=10; 
	$condi="";
	if (!isset($filtro)) $filtro=$_REQUEST['filtro']; 
	if($error==2)
	{
		echo "<p align=center>Gracias por votar</p>";
	}  
	echo "<h1>VOTACIÓN</h1>";
	echo "<form name=form2 id=form2 method=post action=votaciones.php>";
	echo "<table class=formtable>";
	echo "<tr><td>";
	//aqui debe ir la lista de candidatos con opcion de seleccion unica
	echo "hhhh: ";
	echo "</td>";
	echo "<td>";
	echo "<input type=text name=filtro id=filtro value='$filtro'>"; 
	echo "</td>";
	echo "<td>
	<div align=center>
	    <input type=submit name=Submit value=Votar>
	    </div>    
	    </td>
	    </tr>
	    </table></form>";
 
}
include($plantilla);
?>
