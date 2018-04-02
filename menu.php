<?php
include("include.inc.php");
 //session_start();
 Global $conn,$ID,$nickname;
 /*$sql2="SELECT documento FROM sesiones WHERE hash='$ID' ";
 $rs2=$conn->Execute($sql2);
 $usuario=$rs2->fields[0];
 $query="SELECT tipo_usuario FROM usuarios WHERE documento='$usuario'";
 $dbq=$conn->Execute($query);
 $idusuario=$usuario;
 $tipo=$dbq->fields[0];*/

echo "<table><tr><td>";
echo "<div id=\"smoothmenu1\" class=\"ddsmoothmenu\">
<ul>";
echo "<li><a href=\"inicio.php\">Inicio</a></li>";
echo "<li><a href=\"votaciones.php\">Votaci&oacute;n</a>";
/*echo "<ul>";	
	echo "<li><a href=\"permisos.php\">Permisos</a></li>";
	echo "<li><a href=\"usuarios.php\">Usuarios</a></li>";
echo "</ul>";*/
echo "</li>";
echo "<li><a href=\"resultados.php\">Resultados Votación</a></li>";
echo "<li><a href=\"#\">Administraci&oacute;n</a>";
echo "<ul>";	
	echo "<li><a href=\"candidatos.php\">Candidatos</a></li>";
	echo "<li><a href=\"partidos.php\">Partidos</a></li>";
echo "</ul>";
echo "</li>";
?>
<li><a href="#">Password</a></li>
<!--password.php   logout.php-->
<li><a href="#">Salir</a></li>
</ul>

<br style="clear: left" />
</div> 
</td><td>
<?php
//echo "<h1><u>$nickname</u></h1>";
?>
</td></tr>
</table>
