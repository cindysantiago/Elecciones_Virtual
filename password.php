<?php 
include("include.inc.php");
include("verificar.php");
session_start();
$ID=$_SESSION['ID'];
$usuario=$_SESSION['usuario'];
$boton=$_REQUEST['boton'];
$newpass=$_REQUEST['newpass'];
$newpass2=$_REQUEST['newpass2'];
if (isset($boton))
{
$err=10;
if ($newpass2!=$newpass)
  $err=1;
else
{
 if (strlen($newpass2)<4)
  $err=2;
 else
 {
   $q="SELECT documento,password FROM usuarios WHERE documento='$usuario' ";
   $rs=$conn->Execute($q);
   $oldpass=$rs->fields[1];
   $passwd=$_REQUEST['passwd'];
   
   if ($rs->RecordCount()==0)
    $err=3;
   else
   {
     if (crypt($passwd,$oldpass)==$oldpass)
     {
     $newpass=crypt($_REQUEST['newpass']);
     $conn->Execute("UPDATE usuarios SET password='$newpass' WHERE documento='$usuario'");
     }
     else
      $err=3;
   } 
 } 
}  
}
function menu()
{
include("menu.php");
}
function contenido()
{
	global $nickname,$resultado,$err,$boton;
	 echo '<div class="article">';
	 echo "<h1>CAMBIO DE PASSWORD</h2>";
	 echo "<p><strong>";

if (isset($boton))
{	 
	 if ($err==10)
	   echo "<p><strong>El password se ha actualizado</p>";
	 else
	 {
   	 echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">';
	 echo  '<p><span class="ui-icon ui-icon-alert" style="float: left; margin-righ : .3em;"></span>';
	 if ($err==1)
	   echo "<strong>Error, los passwords no coinciden</strong>";
	 if ($err==2)
	   echo "<strong>El password nuevo es muy corto</strong>";
	 if ($err==3)
	   echo "<strong>El password anterior esta errado</strong>";

	   echo "</p></div>";
	 }
}  
     echo 'Aqui puede realizar el cambio de password';
    	
	 echo "<form id=valform name=form1 action=password.php method=post>";
	 echo "<table class=formtable>";
	 echo "<tr><td>Password Anterior</td>";
	 echo "<td><input type=password name=passwd class=\"required\"></td>";
	 echo "</tr>";
	 echo "<tr><td>Password Nuevo</td>";
	 echo "<td><input type=password name=newpass id=pass1 class=\"required\" minlength=\"4\"></td>";
	 echo "</tr>";
	 echo "<tr><td>Confirmar Password Nuevo</td>";
	 echo "<td><input type=password name=newpass2 class=\"required\" equalTo=\"#pass1\"></td>";
	 echo "</tr>";

	 echo "<tr>";
	 echo "<td colspan=2 align=center><input type=submit name=boton value=Actualizar class=\"ui-state-default ui-corner-all\"></td>";
	 echo "</tr>";
	 
	 echo "</table>";
	 echo "</form>";
	 
     echo "</strong></p></div>";
   
}
include($plantilla);
?>
