<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");
$boton1=$_REQUEST['boton1'];
if($boton1=="Guardar" ) //nuevo candidato
{	
	$sql1="INSERT INTO candidatos (centro) VALUES ('$_REQUEST[nombre]')";
	$rs1=$conn->Execute($sql1);    
	// echo $sql1;
	if($rs1)
		$error=1;
	else
		$error=2;
}
function menu()
{
	include("menu.php");
}
function contenido()
{
	global $db,$ID,$filtro,$pagina,$error; 	
	if($error==1)
	{
		echo "<p align=center>El candidato ha sido ingresado!</p>";
	}  
	if($error==2)
	{
		echo "<p align=center>Error: el candidato no fue guardado</p>";
	}  
	echo "<h1>CREAR CANDIDATO</h1>";
	echo "<form name=form1 id=valform method=post action=candidatos.php>";
	    echo "<table class=formtable align=center>";
	      echo "<tr>";
	    echo "<td>Nombre:</td>
	    <td>
	      <input type=text name=nombre class=\"required\" size=50>
	    <font color=red size=5> * </font></td>
	    </tr>";	 	  
	    echo "<tr>
	    <td colspan=2><label>
	    <div align=center>
	    <input type=submit name=boton1 value=Guardar>
	    </div>
	    </label>
	    </td>
	    </tr>
	    </table>
	    </form><br>";
	
	echo "<h1>GESTIÓN DE CANDIDATOS</h1>";
	$sql1="SELECT id_candidato,id_partido,cedula,nombres,apellidos,foto,activo FROM candidatos ORDER BY apellidos,nombres ";
  	$rs1=$db->execute($sql1)->getRows();
	if($rs1)
	{
	echo '<table class="table table-striped table-bordered table-hover" id="dataTable1" align=center>';
		echo "<thead><tr>
		<th>Foto</th>
		<th>Cedula</th>		
		<th>Nombre</th>
		<th>Partido</th>
		<th>Activo</th>
		<th>Editar</th>
		<th>Eliminar</th>
		</tr></thead>";   
		echo "<ul>\n";
		echo "<tbody>";
		$c=0;
	foreach ($rs1 as $linea) {		
		$c++;
		$d=$c%2;
			if ($d == 0) 
				$color="#CEECF5";
			else 	
				$color="#E6E6E6";
			echo "<tr bgcolor='$color'>";
			//echo "<tr>";
			$idcandidato=$linea['id_candidato'];
			echo "<td><img src='".$linea['foto']."' width=70px height=80px></td>";
			echo "<td>".$linea['cedula']."</td>";
			echo "<td>".$linea['nombres']." ".$linea['apellidos']."</td>";
			$sql2="SELECT logo,nombre FROM partidos WHERE id_partido=".$linea['id_partido'];
			$rs2=$db->execute($sql2)->getRows();
			foreach ($rs2 as $linea2) {
			echo "<td><img src='".$linea2['logo']."' width=80px height=60px><br>".$linea2['nombre']."</td>";
			}
			if($linea['activo']==1)
				echo "<td>Activo</td>";
			else
				echo "<td>Inactivo</td>";
			echo "<td align=right><p align=center><a href=candidatos2.php?idcandidato=$idcandidato title=\"Editar\"><img src=imagenes/iconos/page_edit.png border=0></a>";      
			echo "<td align=right><p align=center><a href=candidatos.php?idcandidato=$idcandidato title=\"Eliminar\"><img src=imagenes/iconos/no.png border=0></a>";      
			//echo "&nbsp;&nbsp;&nbsp;<a href=centros.php?op=elim&idcentro=$idcentro title=\"Eliminar\"><img src=imagenes/iconos/no.png border=0></a>";				
			echo "</p></td>";                  
			echo "</tr>";  
	}
		echo "</tbody>";
		echo "</table>";
	}
	else
		echo "<p align=center>No se encontraron resultados </p>";
	echo "<br><br>";
	 
}
include($plantilla);
?>
