<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");
$boton1=$_REQUEST['boton1'];


//metodo para guardar el voto en la base de datos
if($boton1=="Votar") 
{	
	$sql4="SELECT max(id_voto) FROM  votaciones";//
	$rs4=$db->getOne($sql4);
	$next=$rs4+1;
	
	$sql5="INSERT INTO  votaciones (id_voto,id_candidato,id_ciudad,fecha_hora) VALUES ('$next','$_REQUEST[president]','$_REQUEST[ciudad]',now())";
	$rs5=$db->Execute($sql5);    
		
	if($rs5)
	
		$error=1;//Si  se insertan los valores a la base de datos  aviso de confirmaci�n
	else
		$error=2;//Si no, mensaje de no se pudo registrar el voto
			
	
}//Finaliza metodo para guardar los datos del nuevo  voto
// LLamado al script con todos las propiedades del men�
function menu()
{
	include("menu.php");
}
function contenido()
{
	global $db,$ID,$filtro,$pagina,$error; 
	
	if($error==1)//Funci�n que valida e informa al usuario si hubo ingreso de votos para continuar (mensajes)
	{
	
		echo "<p align=center><b><font color=#08779B size='5'>�Gracias por votar!</font></b></p>";
		echo "<br>";
		echo "<h1><p align=center><a href=resultados.php>Ver resulados</a></p></h1>";
		echo "<h1><p align=center>Imprimir Comprobante Electoral</a></p></h1>";
	}
	
	if($error==2)
	{
		echo "<p align=center><font size=3>No se pudo registrar su voto</font></p>";
	}
	
	if($error!=1 && $error!=2)// Funci�n que oculta la tabla se selecci�n del voto
	{

echo "<h1>VOTACI�N PRESIDENCIAL</h1>";

    $sql1 = "SELECT  id_candidato, id_partido, nombres, apellidos,foto  FROM candidatos ORDER BY nombres, apellidos ";// Llama los registros de los candidatos 
    $rs1=$db->execute($sql1)->getRows();
    if($rs1)  // Funci�n que inicializa la tabla en donde se reflejara la consula de candidatos
    {
    echo"<form name=form2 id=form2 method=post action=votaciones.php>";
    echo '<table class="table table-striped table-bordered table-hover" id="dataTable1" align=center>';
		echo "<thead><tr>
		<th>Foto</th>
		<th>Nombre</th>
		<th>Partido</th>		
		</tr></thead>";   
		echo "<ul>\n";
		echo "<tbody>";
		$c=0;
    

      foreach ($rs1 as $dato)//Funci�n que captura los datos de la consulta
      {
      $c++;
		$d=$c%2;
			if ($d == 0) 
				$color="#CEECF5";
			else 	
				$color="#E6E6E6";
			echo "<tr bgcolor='$color'>";      
		
      
   echo "<td><input  type='radio' name='president' value=".$dato['id_candidato']." /> <label ><img src='".$dato['foto']."' width=70px height=80px></label ></td>";
   echo"<td>".$dato['nombres']." ".$dato['apellidos']."</td>";
  $sql2="SELECT logo,nombre FROM partidos WHERE id_partido=".$dato['id_partido'];
	$rs2=$db->execute($sql2)->getRows();
	foreach ($rs2 as $dato2)
	{
	echo "<td align=center><img src='".$dato2['logo']."' width=80px height=60px><br>".$dato2['nombre']."</td>";
	}

   }
   
   echo"</tr></table>"; 
}
	else
		echo "<p align=center>No se encontraron resultados </p>";
	echo "<br><br>";
	
	
   echo "<tr>";
   echo"<td><p align=center>Ciudad o Municipio de Votaci�n:</td> ";
   echo "<td>";
   $sql3="SELECT id_ciudad,descripcion FROM  ciudades ORDER BY descripcion";
   
	$rs3=$db->execute($sql3)->getRows();//Consulta  de las ciudades y muestra en un select
	echo "<select name=ciudad id=ciudad required>"; 
	foreach ($rs3 as $dato3)
	{
		$val=$dato3['id_ciudad'];
		$val2=$dato3['descripcion'];        
			
			echo "<option value=\"$val\">$val2</option></p>";    
	}
   echo "</select><font color=red size=5> * </font></td></p></tr>	";
   
   echo "<tr>
		<td colspan=2><label>
		<div align=center>
		<input type=submit name=boton1 value=Votar>
		</div>
		</label>
		</td>
		</tr>
		</form>";
		
		}
 
}//Finaliza la estructura de lo datos de candidatos para votaci�n
include($plantilla);
?>
