<?php
  include_once("include.inc.php");
  session_start();

  header("Location: inicio.php");
  $expire=time()-60;
  setcookie("sql","",$expire);  
  
     function menu()
     {
     } 
        function contenido()
        {     
	global $conn,$error;	

	if($error==2)
	{
		echo "<p align=center>Error: No tiene permiso para acceder a esta pagina. Por favor inicie sesion.</p>";
	}
	if($error==1)
	{
		echo "<p align=center>Error: El usuario o la contraseña son incorrectas.</p>";
	}
	//$clave=crypt("12345");
           echo '<tr> 
          <td height="10" colspan="2"  class="text"><table width="90%" align="center" class="text">
              <tr> 
                <td> <br> 
                  <h1>Bienvenido a VOTACIONES VIRTUALES. </h1>
                  <P><B>Debe iniciar sesion para continuar : </b></p>
                   <p><string><b> .: Inicio de Sesion :. </strong></b></p>';
	   
		if (isset($error))
			{
			
			 echo "<p>Error en la autentificacion. 
			 Por favor ingrese sus datos.</p>";
			}
	    
                echo "  <form name=form1 id=valform method=\"post\" action=\"login.php\" >
                    <p align=\"center\"> 
                    <table width=300 border=0 align=\"center\" class=text>
                      <tr> 
                        <td><strong><B><font  size=2>Usuario</font></b></strong></td>
                        <td> <input name=\"usr\" type=\"text\" id=\"usuario\" class=required> </td>
                      </tr>
                      <tr> 
                        <td><strong><B><font size=2>Contrase&ntilde;a</font></b></strong></td>
                        <td><input name=\"pwd\" type=\"password\" id=\"password\" class=required></td>
                      </tr>
                      <tr> 
                        <td colspan=2> <div align=\"center\"> 
                            <input name=\"submit\" type=\"submit\" value=\"Entrar\">
                          </div></td>
                      </tr>
                    </table>
                    <p>&nbsp;</p>
                  </form></td>
              </tr>
            </table> </td>
        </tr>";
             }        
  
   include($plantilla);                        
?>
                        

                  
