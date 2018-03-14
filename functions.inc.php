<?
 include("include.inc.php");
 function obtener($tabla,$campo,$mostrar,$valor)
 {
  Global $conn;
  $sql="SELECT $mostrar FROM $tabla WHERE $campo='$valor'";
  $rs=$conn->Execute($sql);
  return $rs->fields[0];
 }
 function obtener2($tabla,$campo,$mostrar,$valor)
 {
  Global $conn;
  $sql="SELECT $mostrar FROM $tabla WHERE $campo='$valor'";
  $rs=$conn->Execute($sql);
  $arr=explode(",",$mostrar);
  $s=$rs->fields[0];
  for ($i=1;$i<count($arr);$i++)
   $s=$s."|".$rs->fields[$i];
  return $s;
 }

 function combo($tabla,$resultado,$mostrar,$campo)
 {
  Global $conn; 
  $result=$conn->execute("SELECT $resultado,$mostrar FROM $tabla");
   echo "<select name=$campo>";
   echo "<option value=0>Todos</option>";
   while (!$result->EOF)
   {
    echo "<option value=\"{$result->fields[0]}\">".$result->fields[1].
     "</option>";
    $result->moveNext();
   }
   echo "</select>";
 }
 function combo2($tabla,$resultado,$mostrar,$campo)
 {
  Global $conn;
  $result=$conn->execute("SELECT $resultado,$mostrar FROM $tabla ORDER BY $mostrar");
   echo "<select name=$campo>";
     while (!$result->EOF)
   {
    echo "<option value=\"{$result->fields[0]}\">".$result->fields[1].
     "</option>";
    $result->moveNext();
   }
   echo "</select>";
 }
 function combo3($tabla,$resultado,$mostrar,$campo,$valor)
 {
  Global $conn;
  $result=$conn->execute("SELECT $resultado,$mostrar FROM $tabla ORDER BY $mostrar");
   echo "<select name=$campo>";
     while (!$result->EOF)
   {
    $seleccionado="";
    if ($result->fields[0]==$valor)
       $seleccionado="SELECTED";     
    echo "<option value=\"{$result->fields[0]}\" $seleccionado>".$result->fields[1].
     "</option>";
    $result->moveNext();
   }
   echo "</select>";
 }
 function combo4($tabla,$resultado,$mostrar,$campo,$condicion)
 {
  Global $conn;
  $result=$conn->execute("SELECT $resultado,$mostrar FROM $tabla WHERE $condicion ORDER BY $mostrar");
   echo "<select name=$campo>";
     while (!$result->EOF)
   {
    echo "<option value=\"{$result->fields[0]}\">".$result->fields[1].
     "</option>";
    $result->moveNext();
   }
   echo "</select>";
 }
 function combo5($tabla,$resultado,$mostrar,$campo,$valor,$condicion)
 {
  Global $conn;
  $result=$conn->execute("SELECT $resultado,$mostrar FROM $tabla WHERE $condicion ORDER BY $mostrar");
   echo "<select name=$campo>";
     while (!$result->EOF)
   {
    $seleccionado="";
    if ($result->fields[0]==$valor)
       $seleccionado="SELECTED";     
    echo "<option value=\"{$result->fields[0]}\" $seleccionado>".$result->fields[1].
     "</option>";
    $result->moveNext();
   }
   echo "</select>";
 }
 function num2letras($num, $fem = true, $dec = true)
  { 
  //if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
    $matuni[2]  = "Dos"; 
    $matuni[3]  = "Tres"; 
    $matuni[4]  = "Cuatro"; 
    $matuni[5]  = "Cinco"; 
    $matuni[6]  = "Seis"; 
    $matuni[7]  = "Siete"; 
    $matuni[8]  = "Ocho"; 
    $matuni[9]  = "Nueve"; 
    $matuni[10] = "Diez"; 
    $matuni[11] = "Once"; 
    $matuni[12] = "Doce"; 
    $matuni[13] = "Trece"; 
    $matuni[14] = "Catorce"; 
    $matuni[15] = "Quince"; 
    $matuni[16] = "Dieciseis"; 
    $matuni[17] = "Diecisiete"; 
    $matuni[18] = "Dieciocho"; 
    $matuni[19] = "Diecinueve"; 
    $matuni[20] = "Veinte"; 
    $matunisub[2] = "Dos"; 
    $matunisub[3] = "Tres"; 
    $matunisub[4] = "Cuatro"; 
    $matunisub[5] = "Quin"; 
    $matunisub[6] = "Seis"; 
    $matunisub[7] = "Sete"; 
    $matunisub[8] = "Ocho"; 
    $matunisub[9] = "Nove"; 

    $matdec[2] = "Veint"; 
    $matdec[3] = "Treinta"; 
    $matdec[4] = "Cuarenta"; 
    $matdec[5] = "Cincuenta"; 
    $matdec[6] = "Sesenta"; 
    $matdec[7] = "Setenta"; 
    $matdec[8] = "Ochenta"; 
    $matdec[9] = "Noventa"; 
    $matsub[3]  = 'Mill'; 
    $matsub[5]  = 'Bill'; 
    $matsub[7]  = 'Mill'; 
    $matsub[9]  = 'Trill'; 
    $matsub[11] = 'Mill'; 
    $matsub[13] = 'Bill'; 
    $matsub[15] = 'Mill'; 
    $matmil[4]  = 'Millones'; 
    $matmil[6]  = 'Billones'; 
    $matmil[7]  = 'de Billones'; 
    $matmil[8]  = 'Millones de Billones'; 
    $matmil[10] = 'Trillones'; 
    $matmil[11] = 'de Trillones'; 
    $matmil[12] = 'Millones de Trillones'; 
    $matmil[13] = 'de Trillones'; 
    $matmil[14] = 'Billones de Trillones'; 
    $matmil[15] = 'de Billones de Trillones'; 
    $matmil[16] = 'Millones de Billones de Trillones'; 

    $num = trim((string)@$num); 
    if ($num[0] == '-') 
    { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
    }else 
      $neg = ''; 
    while ($num[0] == '0') $num = substr($num, 1); 
    if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
    $zeros = true; 
    $punt = false; 
    $ent = ''; 
    $fra = ''; 
    for ($c = 0; $c < strlen($num); $c++) 
    { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) 
      { 
         if ($punt) break; 
         else
         { 
            $punt = true; 
            continue; 
         } 

      }
      elseif (! (strpos('0123456789', $n) === false)) 
      { 
        if ($punt) 
        { 
          if ($n != '0') $zeros = false; 
            $fra .= $n; 
        }
        else
        $ent .= $n; 
      }
      else
      break; 

    } 
    $ent = '     ' . $ent; 
    if ($dec and $fra and ! $zeros) 
    { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) 
      { 
        if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' una' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
    }
    else 
     $fin = ''; 
    
    if ((int)$ent === 0) return 'Cero ' . $fin; 
    $tex = ''; 
    $sub = 0; 
    $mils = 0; 
    $neutro = false; 
    while ( ($num = substr($ent, -3)) != '   ') 
    { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem)
      { 
         $matuni[1] = 'una'; 
         $subcent = 'os'; 
      }
      else
      { 
        $matuni[1] = $neutro ? 'un' : 'uno'; 
        $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') 
      { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) 
      { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }
      else
      { 
        $n3 = $num[2]; 
        if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
        $n2 = $num[1]; 
        $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) 
      { 
         $t = ' ciento' . $t; 
      }
      elseif ($n == 5)
      { 
        $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }
      elseif ($n != 0)
      { 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) 
      { 
      }
      elseif (! isset($matsub[$sub])) 
      { 
        if ($num == 1) 
        { 
            $t = ' Mil'; 
        }elseif ($num > 1)
        { 
            $t .= ' Mil'; 
        } 
      }
      elseif ($num == 1) 
      { 
         $t .= ' ' . $matsub[$sub] . 'on'; 
      }
      elseif ($num > 1)
      { 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) 
      { 
        if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
        $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
    } 
    $tex = $neg . substr($tex, 1) . $fin; 
    return ucfirst($tex); 
  } 
  function meses($mes)
  {
    switch($mes)
    {
    case 1:
        $nombre="Enero";
        break;
    case 2:
        $nombre="Febrero";
        break;
    case 3:
        $nombre="Marzo";
        break;
    case 4:
        $nombre="Abril"; 
        break;
    case 5:
        $nombre="Mayo";
        break;
    case 6:
        $nombre="Junio";
        break;
    case 7:
        $nombre="Julio";
        break;
    case 8:
        $nombre="Agosto";
        break;
    case 9:
        $nombre="Septiembre";
        break;
    case 10:
        $nombre="Octubre";
        break;
    case 11:
        $nombre="Noviembre";
        break;
    case 12:
        $nombre="Diciembre";
        break;    
    }
    return $nombre;
  }
  function dia_semana ($dia, $mes, $ano) 
  {
    $dias = array(D,L,M,M,J,V,S);
    return $dias[date("w", mktime(0, 0, 0, $mes, $dia, $ano))];
    }
  
?>