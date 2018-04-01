<?php 
/*session_start();
$ID=$_SESSION['ID'];
include("verificar.php");*/
include("include.inc.php");


function menu()
{
	include("menu.php");
}
function contenido()
{
	global $db,$ID,$filtro,$pagina,$error; 

$sql4="SELECT COUNT(id_voto) as votos, id_candidato as candidato  FROM votaciones ";
$rs4=$db->execute($sql4)->getRows();

foreach ($rs4 as $cantidad)
{
$total=$cantidad['votos'];
echo " <p align=center><b><font color=#08779B size='3'>Total de votos: ".$cantidad['votos']."</font></b></p>";
 echo "<br>";
}

$sql="SELECT COUNT(id_voto) as votos, id_candidato   FROM votaciones GROUP BY id_candidato";
$rs=$db->execute($sql);


if($rs)
{
echo '<table class="table table-striped table-bordered table-hover" id="dataTable1" align=center>';
	echo "<thead><tr>
	<th>Votos</th>
	<th>Porcentaje</th>
	<th>Candidato</th>	
	<th>Foto</th>
	<th>Partido</th>
	</tr></thead>";   
	echo "<ul>\n";
	echo "<tbody>";
	$c=0;
foreach ($rs as $voto)
{
$c++;
		$d=$c%2;
			if ($d == 0) 
				$color="#CEECF5";
			else 	
				$color="#E6E6E6";
			echo "<tr bgcolor='$color'>";
			
			$id_voto=$voto['votos'];
			$id_candidato=$voto['id_candidato'];

			echo "<th><p align=center>$id_voto</th>";
			$porcentaje=($id_voto/$total)*100;
			$totalp=round($porcentaje);
			
			echo "<th><p align=center>$totalp%</th>";
			
			$sql2="SELECT   id_candidato,id_partido,nombres,apellidos,foto  FROM candidatos WHERE id_candidato='$id_candidato' ORDER BY nombres, apellidos ";
			$rs2=$db->execute($sql2)->getRows();
				foreach ($rs2 as $voto2)
				{
				//$idpartido=$voto2[''];
				echo "<td>".$voto2['nombres']." ".$voto2['apellidos']."</td>";
				echo "<td align=center><img src='".$voto2['foto']."' width=80px height=60px></td>";
				}
			
			$sql3="SELECT logo,nombre FROM partidos WHERE id_partido=".$voto2['id_partido'];
			$rs3=$db->execute($sql3)->getRows();
			foreach ($rs3 as $foto)
			{
			echo "<td align=center><img src='".$foto['logo']."' width=80px height=60px><br>".$foto['nombre']."</td>";
			}
				
				
				echo "</p></td></tr>";  
		


	}
	echo "</tbody>";
		echo "</table>";
		
		
}
else
	echo  "<p align=center>No se encontraron resultados</p>";
	echo "<br><br>";
}
include($plantilla);
?>
