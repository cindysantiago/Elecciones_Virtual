<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
		<meta name="author" content="ISA unal - unillanos " />
		<meta name="description" content="Votaciones Virtuales" />
		<meta name="keywords" content="Votaciones virtuales, UNAL" />
		<link href="main.css" rel="stylesheet" type="text/css" />
		<title>Sistema de votaciones Virtuales</title>		

<link rel="stylesheet" type="text/css" href="menu/ddsmoothmenu.css" />
<link rel="stylesheet" type="text/css" href="menu/ddsmoothmenu-v.css" />


<link type="text/css" href="css/jquery/jquery.css" rel="stylesheet" />	
<link type="text/css" href="css/jquery/pnotify.css" rel="stylesheet" />	


<script type="text/javascript" src="menu/ddsmoothmenu.js" >

/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="js/jquery-1.6.2.js" ></script>
<script type="text/javascript" src="js/jquery-ui.js" ></script>
<script type="text/javascript" src="js/jquery-datepicker-es.js" ></script>
<script type="text/javascript" src="js/jquery.validate.js" ></script>
<script type="text/javascript" src="js/jquery.pnotify.js" ></script>
<script type="text/javascript" src="js/ventana.js" ></script>
                                                            
<script type="text/javascript" >
		
		
		function error_msg(titulo,texto)
				{
				 $.pnotify({
					pnotify_title: titulo,
					pnotify_text: texto,
					pnotify_type: 'error',
					pnotify_error_icon: 'ui-icon ui-icon-alert'
				});
				};
		function nota_msg(titulo,texto)
				{
				 $.pnotify({
					pnotify_title: titulo,
					pnotify_text: texto,
					pnotify_type: 'notice',
					pnotify_notice_icon: 'ui-icon ui-icon-info'
				});
				};			
	         function info_msg(titulo,texto)
				{
				 $.pnotify({
					pnotify_title: titulo,
					pnotify_text: texto,
					pnotify_type: 'notice',
					pnotify_opacity: .9,
					pnotify_nonblock: true,
					pnotify_nonblock_opacity: .2,
					pnotify_notice_icon: 'ui-icon ui-icon-comment'
				});
				};	


     $(document).ready(function(){
                             $("#valform").validate({success: "valid"});
                             $("#form1").validate({success: "valid"});

		               $.datepicker.setDefaults( $.datepicker.regional[ "es" ] );
		               $( "#datepicker" ).datepicker( $.datepicker.regional[ "es" ] );
	                       $("a[rel='pop-up']").click(function () {
      	                               var caracteristicas = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
      	                                nueva=window.open(this.href, 'Popup', caracteristicas);
      	                                return false;
                		});
				
			var dialog1=$( "#dialog" ).dialog({
			autoOpen: false,
			show: "highlight",
			hide: "drop" ,
			height: 300,
			width: 500,
			cache:false,
			 close: function() {
			 $("#dialog").html("<p><img src=imagenes/ajaxloaderh.gif border=0></p>");
			 window.location.reload() 
			 }
			});
  var dialog2=$( "#dialog2" ).dialog({
                        autoOpen: false,
                        show: "highlight",
                        hide: "drop" ,
                        height: 300,
                        width: 500,
                        cache:false,
                         close: function() {
                         $("#dialog2").html("<p><img src=imagenes/ajaxloaderh.gif border=0></p>");
  				} 
                        });


		$( ".abrir" ).click(function() {
			 dialog1.load(this.href).dialog('open');
			//$( "#dialog" ).dialog( "open" );
			return false;
		});
	 	$( ".abrir2" ).click(function() {
                         dialog2.load(this.href).dialog('open');
                        //$( "#dialog" ).dialog( "open" );
                        return false;
                });

var tabs=$("#tabs").tabs({
   cache:false,
   selected:1,
   load: function (e, ui) {
     $(ui.panel).find(".tab-loading").remove();
     $('a', ui.tab).click(function() {
                    $(ui.panel).load(this.href);
                    return true;
                });
   },
     
   select: function (e, ui) {
     var $panel = $(ui.panel);
     if ($panel.is(":empty")) {
         $panel.append("<div class='tab-loading' align=center><img border=0 src=imagenes/ajaxloaderh.gif></div>")
     }
    }
 });	
        // var tabs=$("#tabs").tabs(); 
             	$("#tipo").change(function(){
		$.post("consultapermiso.php",{ id:$(this).val() },function(data){$("#scripte").html(data);})
		});
	 $('input').filter('.fecha').datepicker(
       { dateFormat: 'yy-mm-dd',
                showOn: 'button',  
                buttonImage: 'imagenes/calendar.gif', 
                buttonImageOnly: true,
                changeMonth: true,
                changeYear: true,
		yearRange: "-50:+0"      
//          maxDate: (new Date())
        }, 
        $.datepicker.regional['es']);
});
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})


 </script>
 		<style type="text/css" >
#valform label.error {
	padding-left:16px;
	padding-bottom:2px;
	font-weight:bold;
	color:#EA5200;
	background-image:url(css/jquery/images/error.png);
	background-repeat-x:no-repeat;
	background-repeat-y:no-repeat;
	background-repeat:no-repeat;
	background-attachment:initial;
	background-position:initial initial;
	background-position-x:initial;
	background-position-y:initial;
	background-origin:initial;
	background-clip:initial;
}

#valform label.valid {
	padding-left:16px;
	padding-bottom:2px;
	color:#008000;
	background-image:url(css/jquery/images/ok.png);
	background-repeat-x:no-repeat;
	background-repeat-y:no-repeat;
	background-repeat:no-repeat;
	background-attachment:initial;
	background-position:initial initial;
	background-position-x:initial;
	background-position-y:initial;
	background-origin:initial;
	background-clip:initial;
}

#valform input.error {
	border:1px solid #FF0000;
}

#form1 label.error {
	padding-left:16px;
	padding-bottom:2px;
	font-weight:bold;
	color:#EA5200;
	background-image:url(css/jquery/images/error.png);
	background-repeat-x:no-repeat;
	background-repeat-y:no-repeat;
	background-repeat:no-repeat;
	background-attachment:initial;
	background-position:initial initial;
	background-position-x:initial;
	background-position-y:initial;
	background-origin:initial;
	background-clip:initial;
}

#form1 label.valid {
	padding-left:16px;
	padding-bottom:2px;
//	color:#008000;
	background-image:url(css/jquery/images/ok.png);
	background-repeat-x:no-repeat;
	background-repeat-y:no-repeat;
	background-repeat:no-repeat;
	background-attachment:initial;
	background-position:initial initial;
	background-position-x:initial;
	background-position-y:initial;
	background-origin:initial;
	background-clip:initial;
}

#form1 input.error {
	border:1px solid #FF0000;
}

</style>


	</head>
	<body style="" >
<div id="area0" > <div id="ISA unal-unillanos" ></div><?php menu(); ?></div>
<div id="area1" >	
	<nav id="Votaciones virtuales" ></nav>
	
	<nav id="area2" > </nav>
</div>
<nav id="area3" style="" > 
<br/>
 <?php contenido(); ?>

</nav>

</body></html>
