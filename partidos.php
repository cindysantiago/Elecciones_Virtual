<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");
if(!isset($_REQUEST['op']))
{
	$op="list";
}
else
{
	$op=$_REQUEST['op'];
}
if(isset($_REQUEST['idpartido']))
	$idpartido=$_REQUEST['idpartido'];
else
	$idpartido="";
	
if($op=="delete" && $idpartido!="")
{
	$sql6="SELECT * from partidos where id_partido='$idpartido'";
	$rs6=$db->Execute($sql6);
	$logo=$rs6->fields['logo'];
	$sql5="DELETE FROM partidos WHERE id_partido='$idpartido' ";
	$rs5=$db->Execute($sql5);
	
	if($rs5)
	{
		unlink($logo);
		$op="list";
		$error=7;
	}
	else
		$error=8;
}

if(isset($_REQUEST['boton1']))
{
	$boton1=$_REQUEST['boton1'];
	if($boton1=="Guardar" ) //nuevo candidato
	{	
		$sql4="SELECT max(id_partido) FROM partidos";
		$rs4=$db->getOne($sql4);
		$next=$rs4+1;
		$nombre=$_REQUEST['nombre'];
		$descripcion = $_REQUEST['descripcion'];
		$sql5="INSERT INTO partidos (id_partido,nombre,descripcion) VALUES ('$next','$nombre','$descripcion')";
		$rs5=$db->Execute($sql5);    
			// echo $sql1;
		if($rs5)
		{
			//guardar url de la foto
			$fichero=$_FILES['file']['name'];					
			$tmp = explode(".", $fichero);
			$extension = end($tmp);
			$ruta="imagenes/perfiles/partidos/".$next.".".$extension;
			$fichero_tipo=$extension;
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
			if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )   //($fichero_tipo== "gif") ||
			{
				$fichero_tmp=$_FILES['file']['tmp_name'];	

				if(copy($fichero_tmp, $ruta))
				{
					$sql5="UPDATE partidos SET logo='$ruta' WHERE id_partido=$next ";
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
		}
		else
		{
				$error=2;
		}	
	}
	else if ($boton1=="Actualizar" )
	{
		$nombre=$_REQUEST['nombre'];
		$descripcion = $_REQUEST['descripcion'];
		$sql5="UPDATE partidos SET nombre='$nombre', descripcion='$descripcion' WHERE id_partido=$idpartido ";
		$rs5=$db->Execute($sql5);
		if ($rs5)
		{
			$fichero=$_FILES['file']['name'];
			if ($fichero!="")
			{
				//Borro el logo actual del hdd
				$sql5="SELECT * from partidos where id_partido='$idpartido'";
				$rs5=$db->Execute($sql5);
				$logo=$rs5->fields['logo'];
				unlink($logo);

				$fichero=$_FILES['file']['name'];					
				$tmp = explode(".", $fichero);
				$extension = end($tmp);
				$ruta="imagenes/perfiles/partidos/".$idpartido.".".$extension;
				$fichero_tipo=$extension;
				$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
				if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )  
				{
					$fichero_tmp=$_FILES['file']['tmp_name'];	
					
											
					if(copy($fichero_tmp, $ruta))
					{
						$sql5="UPDATE partidos SET logo='$ruta' WHERE id_partido=$idpartido ";
						$rs5=$db->Execute($sql5);   
						if($rs5)
							$error=5;
						else
							$error=4;
					}
					else
						$error=4;
				}
				else
					$error=3;
			}
			else
				$error=6;
		}
	}
}


function menu()
{
	include("menu.php");
}

function contenido()
{
	global $db,$ID,$filtro,$pagina,$error,$op,$idpartido;

	switch ($error) 
	{
 		case '1':
 			echo "<p align=center><b><font color=green>El partido político ha sido ingresado!</font></b></p>";
 			break;
 		case '2':
 			echo "<p align=center><b><font color=red>Error: el partido político no fue guardado</font></b></p>";
 			break;
 		case '3':
 			echo "<p align=center><b><font color=red>Error: el logo del partido político tiene un formato no permitido</font></b></p>";
 			break;
 		case '4':
 			echo "<p align=center><b><font color=red>Error: el logo del partido político no pudo ser almacenado</font></b></p>";
 			break;
 		case '5':
 			echo "<p align=center><b><font color=red>El partido político ha sido Actualizado!</font></b></p>";
 			break;
 		case '6':
 			echo "<p align=center><b><font color=red>El partido político no pudo ser Actualizado!</font></b></p>";
 			break;
 		case '7':
 			echo "<p align=center><b><font color=green>El partido político ha sido eliminado!</font></b></p>";
 			break;
 		case '8':
 			echo "<p align=center><b><font color=red>Error: El partido político no pudo ser eliminado</font></b></p>";
 			break;
 		default:
 			break;
 	} 	
	

	//Formulario para edición de datos

	if ($op=="edit" && $idpartido!="")
	{
		$sql2 ="SELECT * FROM partidos WHERE id_partido='$idpartido'";
		  	$rs2=$db->execute($sql2);
		echo "<center><h1>EDITAR PARTIDO POLÍTICO</h1></center>";
		echo "<form name=form1 id=valform method=post action=partidos.php?idpartido=$idpartido enctype=\"multipart/form-data\">";
		echo "<table class=formtable align=center>";
			
		echo "<tr>";
		echo "<td>Nombre del partido:</td>
		<td>
		<input type=text name=nombre value='".$rs2->fields['nombre']."' size=50>
		</td>
		</tr>";

		echo "<tr>";
		echo "<td>Descripcion del partido:</td>
		<td>
		<textarea cols='50' rows='5' name=descripcion >".$rs2->fields['descripcion']."</textarea>
		</td>
		</tr>";
			
		echo "<tr>";
		echo "<td>Foto:</td>
		<td>
		<input type=\"file\" id=\"file\" name=\"file\" />
		<font color=red size=5> </font></td>
		</tr>";

		
		echo "<tr>
		<td colspan=2><label>
		<div align=center>
		<input type=submit name=boton1 value=Actualizar>
		</div>
		</label>
		</td>
		</tr>
		</table>
		</form><br>";
	}
	if ($op=="list")
	{
			echo "<center><h1>CREAR PARTIDO POLÍTICO</h1></center>";
			echo "<form name=form1 id=valform method=post action=partidos.php enctype=\"multipart/form-data\">";
			echo "<table class=formtable align=center>";
				
			echo "<tr>";
			echo "<td>Nombre del partido:</td>
			<td>
			<input type=text name=nombre required size=50>
			<font color=red size=5> * </font></td>
			</tr>";

			echo "<tr>";
			echo "<td>Descripcion del partido:</td>
			<td>
			<textarea cols='53' rows='5' name=descripcion required></textarea>
			<font color=red size=5> * </font></td>
			</tr>";
				
			echo "<tr>";
			echo "<td>Foto:</td>
			<td>
			<input type=\"file\" id=\"file\" name=\"file\" />
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
			
			echo "<center><h1>GESTIÓN DE PARTIDOS POLÍTICOS</h1></center>";
			$sql1="SELECT id_partido,nombre,descripcion,logo FROM partidos ORDER BY nombre";
		  	$rs1=$db->execute($sql1)->getRows();
			if($rs1)
			{
				echo '<table class="table table-striped table-bordered table-hover" id="dataTable1" width="900px" align=center >';
				echo "<thead><tr>
				<th >Logo</th>
				<th >Nombre</th>		
				<th >Descripcion</th>
				<th >Editar</th>
				<th >Eliminar</th>
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
					$idpartido=$linea['id_partido'];
					echo "<td align=center><img src='".$linea['logo']."' width=70px height=80px></td>";
					echo "<td>".$linea['nombre']."</td>";
					echo "<td>".$linea['descripcion']."</td>";

					echo "<td align=right><p align=center><a href=partidos.php?idpartido=$idpartido&op=edit title=\"Editar\"><img src=imagenes/iconos/page_edit.png border=0></a>";      
					echo "<td align=right><p align=center><a href=partidos.php?idpartido=$idpartido&op=delete title=\"Eliminar\"><img src=imagenes/iconos/no.png border=0></a>";      			
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
	}
	include($plantilla);
?>
