<?php
 include_once 'adodb/adodb.inc.php';
//$db = ADOnewConnection('mysqli'); 
$db = newAdoConnection("mysqli");
$server = 'localhost';
 $user = 'root';
 $namedb = 'votaciones';
$password = '';
$db->Connect($server,$user,$password,$namedb);

 $plantilla="plantilla.php";
if (!function_exists('logger')) 
{
function logger($texto)
{
$texto=date("Y-m-d h:i:s").$texto;
$fp = fopen('/tmp/log.txt', 'a');
fwrite($fp, $texto);
fwrite($fp, "\n");
fclose($fp);
}
}
if (!function_exists('session_register')) 
   {
   function session_register(){
        $args = func_get_args();
        foreach ($args as $key){
            $_SESSION[$key]=$GLOBALS[$key];
        }
        }
        function session_is_registered($key){
        return isset($_SESSION[$key]);
    }
    function session_unregister($key){
        unset($_SESSION[$key]);
    }
    }

 ini_set("display_errors",0);

    foreach ($_REQUEST as $key => $value) {
    $value = addslashes($value);
    $value = str_replace(";","",$value);
    $_REQUEST[$key] = $value;
  } 
?>
