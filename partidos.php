<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");

if(isset($_POST['boton2'])) //si se recibio algun valor de boton2 (Cancelar edición)
{
	$op="list"; //inicializa la variable $op con el valor list
}

if(!isset($_REQUEST['op'])) // verifico si el input op no ha enviado algun valor
{
	$op="list"; // si no fue enviado,inicializo la variable $op con el valor list
}
else
{
	$op=$_REQUEST['op']; // si si fue enviado, paso el valor que trae a la variable $op
}
//
if(isset($_REQUEST['idpartido'])) // verifico si el valor idpartido ha sido enviado
	$idpartido=$_REQUEST['idpartido']; //si ha sido recibido lo guardo en la variable $idpartido
else
	$idpartido=""; //si no ha sido recibido el valor, inicializo la variable en ""
	
if($op=="delete" && $idpartido!="") // si la opción recibida fue delete y existe un idpartido
{
	$sql6="SELECT logo from partidos where id_partido='$idpartido'"; // busco el valor de logo
	$rs6=$db->Execute($sql6);
	$logo=$rs6->fields[0]; //asigno la ruta de la imagen del logo en la variable $logo
	$sql5="DELETE FROM partidos WHERE id_partido='$idpartido' "; //borro el partido identificado por $idpartido
	$rs5=$db->Execute($sql5);
	
	if($rs5) //si se pudo eliminar el partido
	{
		unlink($logo);//borro el archivo del logo del partido
		$op="list"; //reasigno el valor de la opcion a list
		$msg=7; //envío el mensaje correspondiente
	}
	else //si no se pudo eliminar el partido
		$msg=9;//envío el mensaje correspondiente	
}

if(isset($_REQUEST['boton1'])) //si se recibio algun valor de boton1
{
	$boton1=$_REQUEST['boton1'];
	if($boton1=="Guardar" ) //si el valor recibido fue Guardar
	{	
		$sql4="SELECT max(id_partido) FROM partidos"; //busco el id más alto creado
		$rs4=$db->getOne($sql4);
		$next=$rs4+1; //incremento el id +1
		$nombre=$_REQUEST['nombre']; //asigno el valor recibido en la variable $nombre
		$descripcion = $_REQUEST['descripcion']; //asigno el valor recibido en la variable $descripcion
		$sql5="INSERT INTO partidos (id_partido,nombre,descripcion) VALUES ('$next','$nombre','$descripcion')";
		$rs5=$db->Execute($sql5);  // creo el nuevo partido  
			// echo $sql1;
		if($rs5) //si el partido se pudo crear
		{
			//guardar url de la foto
			$fichero=$_FILES['file']['name'];					
			$tmp = explode(".", $fichero);
			$extension = end($tmp);
			$ruta="imagenes/perfiles/partidos/".$next.".".$extension; //creo la ruta y el nombre del archivo del logo del partido
			$fichero_tipo=strtolower ($extension); //guardo la extension convirtiendo a minuscula los caracteres
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");

			if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )   //($fichero_tipo== "gif") ||
			{
				$fichero_tmp=$_FILES['file']['tmp_name'];	

				if(copy($fichero_tmp, $ruta))//copio el archivo del logo a la carpeta correspondiente del app
				{
					$sql5="UPDATE partidos SET logo='$ruta' WHERE id_partido=$next ";
					$rs5=$db->Execute($sql5);   //agrego la ruta del archivo del logo del partido
					if($rs5)
						$msg=1;//envío el mensaje correspondiente
					else
						$msg=4;//envío el mensaje correspondiente
				}
				else
					$msg=4;//envío el mensaje correspondiente
			}
			else
				$msg=3;//envío el mensaje correspondiente
		}
		else
		{
				$msg=2;//envío el mensaje correspondiente
		}	
	}
	else if ($boton1=="Actualizar" ) //si el valor recibido fue Actualizar
	{
		$nombre=$_REQUEST['nombre']; //asigno el valor recibido en la variable $nombre
		$descripcion = $_REQUEST['descripcion']; //asigno el valor recibido en la variable $descripcion
		$sql5="UPDATE partidos SET nombre='$nombre', descripcion='$descripcion' WHERE id_partido=$idpartido ";
		$rs5=$db->Execute($sql5); //actualizo los campos nombre y descripcion
		
		if ($rs5) //si se pudo actualizar el registro
		{
			//$fichero=$_FILES['file']['name'];
			//if ($fichero!="") //si se seleccionó algun archivo de imagen
			if (!empty($_FILES['file']['name']))
			{
				//Borro el logo actual del hdd
				$sql5="SELECT logo from partidos where id_partido='$idpartido'";
				$rs5=$db->Execute($sql5);
				$logo=$rs5->fields[0]; //se obtiene la ruta y nombre del archivo imagen del logo del partido
				unlink($logo); //se borra la imagen del logo del partido actual

				$fichero=$_FILES['file']['name'];					
				$tmp = explode(".", $fichero); //se obtiene el nombre del archivo de imagen
				$extension = end($tmp); //se obtiene la extension del archivo de imagen
				$ruta="imagenes/perfiles/partidos/".$idpartido.".".$extension; //se guarda la ruta + nombre + extension
				$fichero_tipo=strtolower ($extension); //se guarda la extension del archivo de imagen convirtiendo a minuscula los caracteres
				//$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
				if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )  //se compara si es una extension permitida
				{
					$fichero_tmp=$_FILES['file']['tmp_name'];	
					
											
					if(copy($fichero_tmp, $ruta)) //se copia el nuevo archivo de imagen de logo del partido
					{
						$sql5="UPDATE partidos SET logo='$ruta' WHERE id_partido=$idpartido "; 
						$rs5=$db->Execute($sql5); //se actualiza la ruta y nombre del nuevo archivo de imagen del logo del partido
						if($rs5)
							$msg=5; //envío el mensaje correspondiente
						else
							$msg=4; //envío el mensaje correspondiente
					}
					else
						$msg=4; //envío el mensaje correspondiente
				}
				else
					$msg=3; //envío el mensaje correspondiente
			}
			else
				$msg=5; //envío el mensaje correspondiente
		}
		else
			$msg=6; //envío el mensaje correspondiente 
	}
}


function menu()
{
	include("menu.php"); //se invoca al menu
}

function contenido()
{
	global $db,$ID,$filtro,$pagina,$msg,$op,$idpartido;

	switch ($msg) //se crean los casos de mensajes de resultados
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
 		case '9':
 			echo "<p align=center><b><font color=red>Error: El partido político esta siendo usado y no pudo ser eliminado</font></b></p>";
 			break;
 		default:
 			break;
 	} 	
	

	//Formulario para edición de datos

	if ($op=="edit" && $idpartido!="") //si el valor de $op es edit, mostrar formulario de edicion de partidos
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
		echo "<td>Logo del partido:</td>
		<td align=left><img src='".$rs2->fields['logo']."' width=70px height=80px></td>
		</tr>
		<tr>
		<td>
		<input type=\"file\" id=\"file\" name=\"file\" />
		<font color=red size=5> </font></td>
		</tr>";

		
		echo "<tr>
		<td colspan=2><label>
		<div align=center>
		<input type=submit name=boton1 value=Actualizar>
		<input type=submit name=boton2 value=Cancelar>
		</div>
		</label>
		</td>
		</tr>
		</table>
		</form><br>";
	}
	if ($op=="list") //si el valor de $op es list, mostrar la lista de partidos y el formulario de crear nuevo partido
	{
			echo "<center><h1>CREAR PARTIDO POLÍTICO</h1></center>"; // Genera el formulario crear partido
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
			echo "<td>Logo del partido:</td>
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
			
			// Genera el listado de partidos en pantalla
			echo "<center><h1>GESTIÓN DE PARTIDOS POLÍTICOS</h1></center>";
			$sql1="SELECT id_partido,nombre,descripcion,logo FROM partidos ORDER BY nombre";
		  	$rs1=$db->execute($sql1)->getRows();
			if($rs1) //si encuentra partidos creados
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
				foreach ($rs1 as $linea) //lista registro por registro de cada partido encontrado en la BD
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
			else //si no encuentra ningun partido creado
				echo "<p align=center>No se encontraron resultados </p>";
			echo "<br><br>";	 
		}
	}
	include($plantilla);
?>
