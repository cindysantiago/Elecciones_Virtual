<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");
$boton1=$_REQUEST['boton1'];
$op=$_REQUEST['op'];
$idcandidato=$_REQUEST['idcandidato'];

if($boton1=="Guardar" ) //actualizar candidato
{			
	$sql5="UPDATE candidatos SET id_partido='$_REQUEST[partido]',cedula='$_REQUEST[cedula]',nombres='$_REQUEST[nombres]',apellidos='$_REQUEST[apellidos]',activo='$_REQUEST[activo]',fecha_update=now() WHERE id_candidato='$idcandidato' ";
	$rs5=$db->Execute($sql5);    
	if($rs5)
	{
		//guardar url de la foto
		$fichero=$_FILES['file']['name'];	
		if($fichero!="")
		{		
			$extension = end(explode(".", $fichero));
			$ruta="imagenes/perfiles/candidatos/".$idcandidato.".".$extension;
			$fichero_tipo=$extension;
			$allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
			if (( ($fichero_tipo == "jpeg")	|| ($fichero_tipo == "png") || ($fichero_tipo == "jpg")) )   //($fichero_tipo== "gif") ||
			{
				$fichero_tmp=$_FILES['file']['tmp_name'];	
				unlink($ruta);
				if(copy($fichero_tmp, $ruta))
				{
					$sql5="UPDATE candidatos SET foto='$ruta' WHERE id_candidato='$idcandidato' ";
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
			$error=1;
	}
	else
	{
			$error=2;
	}	
}
function menu()
{
	include("menu.php");
}
function contenido()
{
	global $db,$ID,$idcandidato,$error; 	
	$sql1="SELECT id_candidato,id_partido,cedula,nombres,apellidos,foto,activo FROM candidatos WHERE id_candidato='$idcandidato' ";
  	$rs1=$db->execute($sql1)->getRows();
	if($rs1)
	{
		foreach ($rs1 as $linea) 
		{
			$cedula=$linea['cedula'];
			$id_partido=$linea['id_partido'];
			$nombres=$linea['nombres'];
			$apellidos=$linea['apellidos'];
			$foto=$linea['foto'];
			$activo=$linea['activo'];
		}
	}	
	else
		echo "<p align=center>No se encontraron resultados </p>";
	
	if($error==1)
	{
		echo "<p align=center><b><font color=green>El candidato ha sido actualizado!</font></b></p>";
	}  
	if($error==2)
	{
		echo "<p align=center><b><font color=red>Error: el candidato no fue actualizado</font></b></p>";
	} 
	if($error==3)
	{
		echo "<p align=center><b><font color=red>Error: la nueva foto del candidato tiene un formato no permitido</font></b></p>";
	} 
	if($error==4)
	{
		echo "<p align=center><b><font color=red>Error: la nueva foto no pudo ser almacenada</font></b></p>";
	} 
	echo "<h1><a href=candidatos.php><--  Volver a Candidatos </a></h1>";
	echo "<h1>EDITAR CANDIDATO</h1>";
	echo "<form name=form1 id=valform method=post action=candidatos2.php enctype=\"multipart/form-data\">";
	echo "<input type=hidden name=idcandidato value='$idcandidato'>";
	echo "<table class=formtable align=center>";
		echo "<tr>";
		echo "<td>Cédula:</td>
		<td>
		<input type=number name=cedula required size=50 maxlength=12 value='$cedula'>
		<font color=red size=5> * </font></td>
		</tr>";
		echo "<tr>";
		echo "<td>Nombres:</td>
		<td>
		<input type=text name=nombres required size=50 value='$nombres'>
		<font color=red size=5> * </font></td>
		</tr>";	 	  
		echo "<tr>";
		echo "<td>Apellidos:</td>
		<td>
		<input type=text name=apellidos required size=50 value='$apellidos'>
		<font color=red size=5> * </font></td>
		</tr>";
		echo "<tr>";
		echo "<td>Partido político:</td>
		<td> ";	 	  
		$sql3="SELECT id_partido,nombre FROM  partidos ORDER BY nombre";
		$rs3=$db->execute($sql3)->getRows();
		echo "<select name=partido id=partido required>"; 
		foreach ($rs3 as $linea) 	
		{        
			$val=$linea['id_partido'];
			$val2=$linea['nombre'];        
			$ck="";
			if($id_partido==$val)
				$ck="SELECTED";
			echo "<option value=\"$val\" $ck>$val2</option>";    
		}
		echo "</select><font color=red size=5> * </font></td></tr>	";				
		echo "<tr>";
		echo "<td>Foto:</td><td><img src='$foto' width=80px height=60px/></td></tr>";		
			echo "<tr><td>
			<input type=\"file\" id=\"file\" name=\"file\" /></td>
			<td><font color=red> Sólo seleccione si desea modificar </font></td></tr> ";		
		echo "<tr>";
		echo "<td>Activo:</td>
		<td> ";	 			
		echo "<select name=activo id=activo required>";
		$ck1=$ck2="";
		if($activo==1)
			$ck1="SELECTED";	
		else
			$ck2="SELECTED";		
			echo "<option value=\"1\" $ck1>Si</option>";    
			echo "<option value=\"0\" $ck2>No</option>";    		
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
}
include($plantilla);
?>
