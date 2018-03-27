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

    $sql = "select id_candidato, nombres, apellidos  from candidatos order by nombres AND apellidos DESC ";
    $_REQUEST = mysqli_query($sql);

    while ($arreglo = mysqli_fetch_array($_REQUEST))
	echo "<h1>VOTACION</h1>";
	echo "<form name=form2 id=form2 method=post action=votaciones.php>";
	echo "<table class=formtable>";
    echo "<tr><th>";
    echo "Seleccione el Candidato Presidencial";
    echo "</th></tr>";

    echo "<td>";
	//aqui debe ir la lista de candidatos con opcion de seleccion unica
	echo "<input type='radio' name='president' value='p1' id='p1' /> <label for='p1'> Sergio Fajardo</label ><br>";
    echo "<input type='radio' name='president' value='p2' id='p2' /> <label for='p2'> Humberto de la Calle</label ><br>";
    echo "<input type='radio' name='president' value='p3' id='p3' /> <label for='p3'> Piedad Cordoba</label ><br>";
    echo "<input type='radio' name='president' value='p4' id='p4' /> <label for='p4'> Ivan Duque Marquez</label ><br>";
    echo "<input type='radio' name='president' value='p5' id='p5' /> <label for='p5'> Gustavo Petro</label ><br>";
    echo "<input type='radio' name='president' value='p6' id='p6' /> <label for='p6'> German Vargas Lleras</label ><br>";
    echo "<input type='radio' name='president' value='p7' id='p7' /> <label for='p7'> Viviane Morales</label ><br>";
    echo "</td>";
    /*echo "<td>";
	echo "hhhh: ";
	echo "</td>";
	echo "<td>";
	echo "<input type=text name=filtro id=filtro value='$filtro'>"; 
	echo "</td>";
    */
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
