<?php
include_once ("include.inc.php");
session_start();
mt_srand((double)microtime()*10000);
$pwd=$_REQUEST['pwd'];
$usr=$_REQUEST['usr'];

$ID = $usr . md5(microtime());
$ID=ereg_replace("/","X",$ID);
$_SESSION['ID']=$ID;


//$txtpass = crypt($pwd,$pwd);

$query = "SELECT documento,login,password FROM usuarios";
$query.= " WHERE login = '$usr'  AND activo=1";
//echo "".$query."";
//die("ZA");
$dbq = $conn->execute($query);
$usuario=$dbq->fields[0];
$nomusr=$dbq->fields[1];
$passwd=$dbq->fields[2];
$nickname=$nomusr;
$_SESSION['usuario']=$usuario;
$_SESSION['nickname']=$nickname;

if ($dbq->RecordCount()==0) {
   Header("Location: index.php?error=1");
}  else {
   
if  (crypt($pwd,$passwd)==$passwd)
{   
         session_register('usuario');
         $dbq->close();
         $REMOTE_ADDR=$_SERVER['REMOTE_ADDR']; 
         $query = "INSERT INTO sesiones (documento,hash,ip,inicio) VALUES 
	           ('$usuario','$ID','$REMOTE_ADDR',NOW())";
	     $dbq = $conn->execute($query);
//echo $query;
//die('a');
       Header("Location: inicio.php");     
	 }
	 else
	 {
  Header("Location: index.php?error=1");
}

}
?>
