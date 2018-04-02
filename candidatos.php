<?php 
include("include.inc.php");

if(isset($_REQUEST['boton1'])  || isset($_REQUEST['op']))
{
$boton1=$_REQUEST['boton1'];
$op=$_REQUEST['op'];
$idcandidato=$_REQUEST['idcandidato'];
}
else
{
	$boton1="";
	$op="";
}
/*Inicia metodo para eliminar el registro del candidato*/
if($op=="delete" && $idcandidato!="")
{
	//Evaluar que no existan votos registrados para ese candidato
	$sql7="SELECT count(*) FROM  votaciones WHERE id_candidato='$idcandidato' ";
	$rs7=$db->getOne($sql7);
	if($rs7>0) //El candidato tiene votos asociados
		$error=8;
	else //El candidato NO tiene votos asociados
	{
		$sql6="SELECT foto FROM candidatos WHERE id_candidato='$idcandidato' ";
		$rs6=$db->execute($sql6)->getRows();
		foreach ($rs6 as $linea) 
		{
			$foto=$linea['foto'];
		}
		$sql5="DELETE FROM candidatos WHERE id_candidato='$idcandidato' ";
		$rs5=$db->Execute($sql5);
		if($rs5)
		{
			$error=6;
			unlink($foto);
		}
		else
			$error=7;
	}
}
/*Finaliza metodo para eliminar el registro del candidato*/
/*Inicia metodo para guardar los datos del nuevo  candidato*/
if($boton1=="Guardar" ) 
{	
	//Evaluar que no exista un candidato con el numero de cedula que se desea ingresar en la actualizaci�n
	$sql6="SELECT cedula FROM  candidatos WHERE cedula='$_REQUEST[cedula]' ";
	$rs6=$db->getOne($sql6);
	if($rs6) //Si existe otro candidato con el mismo n�mero de c�dula
		$error=5;
	else //No existe otro candidato con el mismo n�mero de c�dula
	{	
		$sql4="SELECT max(id_candidato) FROM  candidatos";
		$rs4=$db->getOne($sql4);
		$next=$rs4+1;
		
		$sql5="INSERT INTO candidatos (id_candidato,id_partido,cedula,nombres,apellidos,activo,fecha_ingreso,fecha_update) VALUES ('$next','$_REQUEST[partido]','$_REQUEST[cedula]','$_REQUEST[nombres]','$_REQUEST[apellidos]','$_REQUEST[activo]',now(),now())";
		$rs5=$db->Execute($sql5);    
			// echo $sql1;
		if($rs5)
		{
			/* Inicia el proceso de guardar la url de la foto, actualizando el campo del registro del candidato */
			$fichero=$_FILES['file']['name'];								
			$extension = end(explode(".", $fichero));
			$ruta="imagenes/perfiles/candidatos/".$next.".".$extension;
			$fichero_tipo=$extension;
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG", "JPEG");
			if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )   //($fichero_tipo== "gif") ||
			{
				$fichero_tmp=$_FILES['file']['tmp_name'];	
				if(copy($fichero_tmp, $ruta))
				{
					$sql5="UPDATE candidatos SET foto='$ruta' WHERE id_candidato=$next ";
					$rs5=$db->Execute($sql5);   
					if($rs5)
						$error=1;
					else
						$error=4;
				}
				else
					$error=4;
			}
			else
				$error=3;
			/* Finaliza el proceso de guardar la url de la foto, actualizando el campo del registro del candidato */
		}
		else
		{
				$error=2;
		}	
	}
}
/*Finaliza metodo para guardar los datos del nuevo  candidato*/
function menu()
{
	include("menu.php");
}
function contenido()
{
	global $db,$ID,$filtro,$pagina,$error; 	
	if($error==1)
	{
		echo "<p align=center><b><font color=green>El candidato ha sido ingresado!</font></b></p>";
	}  
	if($error==2)
	{
		echo "<p align=center><b><font color=red>Error: el candidato no fue guardado</font></b></p>";
	} 
	if($error==3)
	{
		echo "<p align=center><b><font color=red>Error: la foto del candidato tiene un formato no permitido</font></b></p>";
	} 
	if($error==4)
	{
		echo "<p align=center><b><font color=red>Error: la foto no pudo ser almacenada</font></b></p>";
	} 
	if($error==5)
	{
		echo "<p align=center><b><font color=red>Error: ya existe un candidato con ese n�mero de c�dula</font></b></p>";
	}
	if($error==6)
	{
		echo "<p align=center><b><font color=green>El candidato ha sido eliminado!</font></b></p>";
	} 
	if($error==7)
	{
		echo "<p align=center><b><font color=red>Error: El candidato no pudo ser eliminado</font></b></p>";
	} 
	if($error==8)
	{
		echo "<p align=center><b><font color=red>Error: el candidato no puede ser eliminado, porque tiene votos asociados</font></b></p>";
	} 
	/*Inicia la Estructura de formulario que el usuario puede ver y usar para ingresar los datos del nuevo candidato*/
	echo "<h1>CREAR CANDIDATO</h1>";	
	echo "<form name=form1 id=valform method=post action=candidatos.php enctype=\"multipart/form-data\">";
	echo "<table class=formtable align=center>";
		echo "<tr>";
		echo "<td>C�dula:</td>
		<td>
		<input type=number name=cedula required size=50 maxlength=12>
		<font color=red size=5> * </font></td>
		</tr>";
		echo "<tr>";
		echo "<td>Nombres:</td>
		<td>
		<input type=text name=nombres required size=50>
		<font color=red size=5> * </font></td>
		</tr>";	 	  
		echo "<tr>";
		echo "<td>Apellidos:</td>
		<td>
		<input type=text name=apellidos required size=50>
		<font color=red size=5> * </font></td>
		</tr>";
		echo "<tr>";
		echo "<td>Partido pol�tico:</td>
		<td> ";	 	  
		$sql3="SELECT id_partido,nombre FROM  partidos ORDER BY nombre";
		$rs3=$db->execute($sql3)->getRows();
		echo "<select name=partido id=partido required>"; 
		//echo "<option selected value=\"\"><- Todos -></option>";
		foreach ($rs3 as $linea) 	
		{        
			$val=$linea['id_partido'];
			$val2=$linea['nombre'];   
			echo "<option value=\"$val\">$val2</option>";    
		}
		echo "</select><font color=red size=5> * </font></td></tr>	";
				
		echo "<tr>";
		echo "<td>Foto:</td>
		<td>
		<input type=\"file\" id=\"file\" name=\"file\" required/>
		<font color=red size=5> * </font></td>
		</tr>";
		echo "<tr>";
		echo "<td>Activo:</td>
		<td> ";	 	  
		
		echo "<select name=activo id=activo required>";		
			echo "<option value=\"1\">Si</option>";    
			echo "<option value=\"0\">No</option>";    
		
		echo "</select><font color=red size=5> * </font></td></tr>	";
		
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
	/*Finaliza la Estructura de formulario que el usuario puede ver y usar para ingresar los datos del nuevo candidato*/
	
	/*Inicia la tabla de consulta con los candidatos registrados en el sistema, con las opciones de editar y eliminar */
	echo "<h1>GESTI�N DE CANDIDATOS</h1>";
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
		foreach ($rs1 as $linea) 
		{		
			$c++;
			$d=$c%2;
				if ($d == 0) 
					$color="#CEECF5";
				else 	
					$color="#E6E6E6";
				echo "<tr bgcolor='$color'>";
				//echo "<tr>";
				$idcandidato=$linea['id_candidato'];
				echo "<td align=center><img src='".$linea['foto']."' width=70px height=80px></td>";
				echo "<td>".$linea['cedula']."</td>";
				echo "<td>".$linea['nombres']." ".$linea['apellidos']."</td>";
				$sql2="SELECT logo,nombre FROM partidos WHERE id_partido=".$linea['id_partido'];
				$rs2=$db->execute($sql2)->getRows();
				foreach ($rs2 as $linea2) {
				echo "<td align=center><img src='".$linea2['logo']."' width=80px height=60px><br>".$linea2['nombre']."</td>";
				}
				if($linea['activo']==1)
					echo "<td>Activo</td>";
				else
					echo "<td>Inactivo</td>";
				echo "<td align=right><p align=center><a href=candidatos2.php?idcandidato=$idcandidato title=\"Editar\"><img src=imagenes/iconos/page_edit.png border=0></a>";      
				echo "<td align=right><p align=center><a href=candidatos.php?idcandidato=$idcandidato&op=delete title=\"Eliminar\"><img src=imagenes/iconos/no.png border=0></a>";      
				echo "</p></td>";                  
				echo "</tr>";  
		}
		echo "</tbody>";
		echo "</table>";
	}
	else
		echo "<p align=center>No se encontraron resultados </p>";
	/*Finaliza la tabla de consulta con los candidatos registrados en el sistema, con las opciones de editar y eliminar */
	echo "<br><br>";	 
}
include($plantilla);
?>
