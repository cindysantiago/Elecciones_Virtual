<?php 
	/*
	session_start();
	$ID=$_SESSION['ID'];
	include("verificar.php");
	*/
	include("include.inc.php");
	include "fpdf/fpdf.php";
	date_default_timezone_set('America/Bogota');
	setlocale(LC_ALL, "es-CO");
	
	//Inicio las variables cedula, nombres, apellidos, fecha, id_certificado
	$cedula="";
	$nombres="";
	$apellidos="";
	$fecha="";
	$id_certifica="";
	 /* 
	 //Obtiene el id del usuario desde el hash de la sesion

	 $sql1="SELECT id_usuario FROM sesiones WHERE hash='$ID' ";
	 $rs1=$db->Execute($sql1);
	 $usuario=$rs1->fields[0];

	//Obtiene la cedula, nombres y apellidos del ciudadano desde la tabla ciudadanos a través de id_usuario

	 $sql2="SELECT cedula, nombres, apellidos FROM ciudadanos WHERE id_usuario='$usuario'";
	 $rs2=$db->Execute($sql2);
	 $cedula=$rs2->fields[0];
	 $nombres=$rs2->fields[1];
	 $apellidos=$rs2->fields[2];
	 */

	 //Si el sistema de login no esta presente, genera datos de prueba para hacer un certificado de prueba
	 if (($cedula=="")&&($nombres=="")&&($apellidos==""))
	 {
	 	$cedula="1.234.567.890";
	 	$nombres= "XXXXXXXX XXXXXXXX";
	 	$apellidos= "YYYYYYYY YYYYYYYY";
	 	$fecha="00-00-0000";
	 	$id_certifica="9999999999";
	 }
	 //-------------------------------------------------------------------------------------------------------------
	
	 //creo el encabezado del certificado
	Class certifica  extends FPDF 
	{
		public function Header()
		{
			global $tiquete;
			$this->SetTitle('Certificado Electoral');	
   			$this->Image('imagenes/perfiles/certificado/header.png',0,0,-255);
		}


	}
	//---------------------------------------------------------------------------------------------------------------
	//creo el cuerpo del certificado
	$mipdf= new certifica('L','mm',array(100,60));
	$mipdf-> addPage();
	$mipdf->SetFillColor(255,255,255);

	//$mipdf->AddFont('Comfortaa-Light','','Comfortaa-Light.php');
	$mipdf->SetFont('Arial','',6);
	$x=65;
	$y=13;
	
	$mipdf->SetY($y);
	$mipdf->SetX($x);
	$mipdf->Cell (62, 4, "Certificado Electoral: ".$id_certifica, 0, 2, 'L'); //imprime el numero del certificado
	$x=2;
	$mipdf->SetX($x);
	$mipdf->Cell (21, 4, "Cédula: ".$cedula, 0, 0, 'L'); // imprime la cédula del ciudadano logueado
	$x+=23;
	$mipdf->SetX($x);
	$mipdf->Cell (35, 4, "Nombres: ".$nombres, 0, 0, 'L'); // imprime los nombres del ciudadano logueado
	$x+=35;
	$mipdf->SetX($x);
	$mipdf->Cell (35, 4, "Apellidos: ".$apellidos, 0, 2, 'L'); // imprime los apellidos del ciudadano logueado

	$mipdf->Output();	
?>