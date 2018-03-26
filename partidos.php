<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
if(!isset($_REQUEST['op']))
{
	$op="list";
}
else
{
	$op=$_REQUEST['op'];
}

include("include.inc.php");
if(isset($_REQUEST['idpartido']))
	$idpartido=$_REQUEST['idpartido'];

//if(isset($_REQUEST['op']))
//{

	
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
		$error=6;
	}
	else
		$error=7;
}
//}

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
			//$fichero="";					
			/*foreach ($array as &$valor) 
			{
				$fichero=$fichero.$valor;
			}*/					
			$extension = end(explode(".", $fichero));
			$ruta="imagenes/perfiles/partidos/".$next.".".$extension;
			$fichero_tipo=$extension;
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
			if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )   //($fichero_tipo== "gif") ||
			{
				$fichero_tmp=$_FILES['file']['tmp_name'];	
				/*$fichero_tmp="";					
				foreach ($array_tmp as &$valor) 
				{
					$fichero_tmp=$fichero_tmp.$valor;
				}	*/					
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
}


function menu()
{
	include("menu.php");
}

	function contenido()
	{
		global $db,$ID,$filtro,$pagina,$error,$op,$idpartido; 	
		if($error==1)
		{
			echo "<p align=center><b><font color=green>El partido político ha sido ingresado!</font></b></p>";
		}  
		if($error==2)
		{
			echo "<p align=center><b><font color=red>Error: el partido político no fue guardado</font></b></p>";
		} 
		if($error==3)
		{
			echo "<p align=center><b><font color=red>Error: el logo del partido político tiene un formato no permitido</font></b></p>";
		} 
		if($error==4)
		{
			echo "<p align=center><b><font color=red>Error: el logo del partido político no pudo ser almacenado</font></b></p>";
		} 
		if($error==6)
		{
			echo "<p align=center><b><font color=green>El partido político ha sido eliminado!</font></b></p>";
		} 
		if($error==7)
		{
			echo "<p align=center><b><font color=red>Error: El partido político no pudo ser eliminado</font></b></p>";
		} 
if ($op=="edit" && $idpartido!="")
{
	echo "<center><h1>EDITAR PARTIDO POLÍTICO</h1></center>";
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
			<input type=text name=descripcion required size=50>
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
			<input type=submit name=boton1 value=Editar>
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
			<input type=text name=descripcion required size=50>
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
		echo '<table class="table table-striped table-bordered table-hover" id="dataTable1" align=center>';
			echo "<thead><tr>
			<th>Logo</th>
			<th>Nombre</th>		
			<th>Descripcion</th>
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
