<?php
	include_once("include.inc.php");
	session_start();

	$ID=$_SESSION['ID'];
	$usuario=$_SESSION['usuario'];
	$nickname=$_SESSION['nickname'];
	$query="SELECT tipo_usuario FROM usuarios WHERE documento='$usuario'";
	$dbq=$conn->Execute($query);
	$idusuario=$usuario;
//	echo $dbq->RecordCount();
	if ($dbq->RecordCount()==0)
	{
	   header("Location: index.php?error=2"); 
	   
		echo "no hay sesion <a href=index.php>iniciar</a>";
	}
	//$script=basename($_SERVER['PHP_SELF']);
	//$tipo=$dbq->fields[0];	
	
	$expire=time()-60;
	setcookie("sql","",$expire);
?>
