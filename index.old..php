<?php
if (!isset($_SESSION)) {
  session_start();
}
$direccion2sd3='/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/';
$sitio='biblioteca';
require $direccion2sd3.$sitio.'/class/Util.php';
require $direccion2sd3.$sitio.'/class/log.php';
require $direccion2sd3.$sitio.'/log/Connections/manuales7sd.php';
$log = New LOGIN($sitio);
////////////////////////////////////
// username and password sent from form 
$myusername = $_POST['myusername'];
$mypassword = $_POST['mypassword'];
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$usuariosd33ft6 ="";
if (isset($_POST['myusername']))
    if (strlen($myusername) > 0 && strlen($mypassword) > 0) {
		$util_X1 = New Util($_SESSION);
		$util_X1->log_data(8894789152233644489440, "Usuario:\"".$myusername."\" y Clave:\"".$mypassword."\" En:".$util_X1->get_ip_address(), 'KlIngresoLog2Z34.log');		
		$SESSION=$_SESSION;
        $SESSION=$log->login_data($myusername, $mypassword, $database_manuales7sd, $manuales7sd, $SESSION);
		$_SESSION['MM_Username'] = $SESSION['MM_Username'] ;
		$_SESSION['MM_UserGroup'] = $SESSION['MM_UserGroup'];
		$_SESSION['carpeta_master']=$SESSION['carpeta_master'];
		//Echo ">>>>>>>>>>>>>>>>>>>>>".$SESSION['carpeta_master']."<<<<<<<<<<<<<<<<<<<<<";
		$_SESSION['login'] = $SESSION['login'];

        $usuariosd33ft6= "Bienvenido $myusername";
        $_SESSION["login"] = $myusername;
		$util_X1->log_data(8894789152233644489440, "Usuario:\"".$myusername."\" y Clave:\"".$mypassword."\" En:".$util_X1->get_ip_address()."->Exitoso", 'KlIngresoLog2Z34.log');		
    }
if ($_GET['renovar_clave'] == '4M4D3U5') {
	 echo $log->formRecuperaClave($_SERVER['PHP_SELF']);
	 return;
}
if (isset($_POST['myusername_4M4D3U5'])) { 
		echo '<!DOCTYPE html> <html> <head> <title>Aerogal Biblioteca</title>  <meta name="viewport" content="width=device-width, initial-scale=1"> <!----> <link rel="stylesheet" type="text/css" href="css/Avianca.min.css"> <link rel="stylesheet" type="text/css" href="css/demos.css"> <link rel="stylesheet" type="text/css" href="css/jquery.mobile.icons.min.css"><!-- <script src="js/jquery.mobile.custom.min.js">--></script> <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.structure.min.css"> <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.theme.min.css"> <!----> <link rel="stylesheet" href="http://demos.jquerymobile.com/1.4.5/css/themes/default/jquery.mobile-1.4.5.min.css"> <!----> </head><body><div data-role="page"> <div data-role="header"> <img src="images/logo-avianca.png" width="215" height="50" alt="Avianca"> </div><!-- /header --> <div role="main" class="ui-content">';	  
		echo "Recuperando clave en proceso, Correo enviado ";
			
		$SESSION=$_SESSION;
        $SESSION=$log->recuperar_login_data($_POST['myusername_4M4D3U5'],$database_manuales7sd, $manuales7sd, $SESSION);
		$log->recuperaMiclave($_POST['myusername_4M4D3U5'],$SESSION['UsuarioRecuperado']);
		echo '	<script language="JavaScript" type="text/javascript">
						var pagina="/'.$sitio.'/index.php?error=UsuarioRecuperado;"
						function redireccionar() 
						{
						location.href=pagina
						} 
						setTimeout ("redireccionar()", 1000);
						</script>';
		echo "</div><!-- /content --></div><!-- /page --></body></html>";				
		return;	
}
// To protect MySQL injection (more detail about MySQL injection)
////////////////////////////////////
if ($_GET['F'] == 'cHao_2wsejJ') {
    $log->logOUT($_SESSION);
    unset($_SESSION["listas"]);
    unset($_SESSION["flagg"]);
    unset($_SESSION["asdss"]);
    unset($_SESSION["login"]);
    session_destroy();
    Header('Location: index.php');

    echo '<script language="JavaScript">
	function enfocar(){
	window.location.href = \'/'.$sitio.'\';
	}
	enfocar();
	</script>';


    Exit(); //optional
}

$util = New Util($_SESSION);
if (((isset($_SESSION['MM_Username'])) && 
        ($log->isAuthorized("", $log->MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {


// descarga
    if ($_GET['T'] == 'DES') {
		$util->log_data(889466681233644489440, $util->archivos[$_GET['nombre']]['dir'], 'KlActiveDataLog2Z34.log');
		$util->log_data(889466681233644489440, $util->archivos[$_GET['nombre']]['file'], 'KlActiveDataLog2Z34.log');
		$util->log_data(889466681233644489440, $usuariosd33ft6, 'KlActiveDataLog2Z34.log');
        //echo $util->archivos[$_GET['nombre']];
        $util->download_file($util->archivos[$_GET['nombre']]['dir'] . $util->archivos[$_GET['nombre']]['file'], uniqid('Descarga_total_') . "." . Util::extension($util->archivos[$_GET['nombre']]['file']));
		exit();
    }
$util->log_data(889466681233644489440, $usuariosd33ft6, 'KlACCESODataLog2Z34.log');
$util->log_data(889466681233644489440, $util->get_ip_address(), 'KlACCESODataLog2Z34.log');
echo '<!DOCTYPE html>
<html>
<head>

  <title>Aerogal Biblioteca</title>      
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!---->
  <link rel="stylesheet" type="text/css" href="css/Avianca.min.css">
  <link rel="stylesheet" type="text/css" href="css/demos.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.mobile.icons.min.css">
 
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.structure.min.css">
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.theme.min.css">    
  <!---->
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>	
<script>
            $(document).on("mobileinit", function () {
                // Reference: http://jquerymobile.com/demos/1.1.0/docs/api/globalconfig.html
                $.extend($.mobile, {
                    linkBindingEnabled: false,
                    ajaxEnabled: false
                });
				
            });
			
			
        </script>
  <!---->  
</head><body>';
echo '<div data-role="page">

	<div data-role="header">
		<img src="images/logo-avianca.png" width="215" height="50" alt="Avianca">
	</div><!-- /header -->

	<div role="main" class="ui-content">
		';
//presenta arbol
	echo "<h3>".$usuariosd33ft6.'</h3>';
    //echo '<h2 class="demoHeaders">Raiz</h2>';
	echo "<div class=\"ui-last-child\"><a class=\"ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r\" data-form=\"ui-btn-up-a\" data-swatch=\"a\" data-theme=\"a\" href='?F=cHao_2wsejJ&Salir=Si' title='Salir del Sistema' data-ajax=\"false\" >Salir>></a></div>";
    //echo '<!DOCTYPE html><!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]--><meta name="viewport" content="width=320; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=1;" /><head><title>Manuales de Aerogal</title></head><body class="internal">';
    echo "<div data-role=\"collapsible\" data-inset=\"false\">";
    echo "<h3>Raiz</h3>";
	echo '<ul data-role="listview">';
	$util->log_data(77777777777777777777,'Inicio' , 'KlArbol2Z34.log'); 
	$util->setDbData($myusername, $mypassword, $database_manuales7sd, $manuales7sd, $SESSION);
	echo "\n".$util->listado_completo($direccion2sd3.$sitio."/dtos/", 10, 'dtos/',$_SESSION['carpeta_master'],"",0,$log);	
	echo '</ul>';
	echo "</div>";
    echo '	
	</div><!-- /content -->

	<div data-role="footer">
		<h4><a class=\'logout\' style=\"float:right\" href=\'?F=cHao_2wsejJ&Salir=Si\' title=\'Salir del Sistema\' data-ajax=\"false\" >Salir>></a></h4>
	</div><!-- /footer -->
</div><!-- /page -->
	</body></html>';
    if (!isset($_SESSION["flagg"]) && !$_SESSION["flagg"]) {
        $_SESSION["flagg"] = $util->flagg = true;
    }
//solo logeado puede deslogearse

    echo "<a class='logout' href='?F=cHao_2wsejJ&Salir=Si' title='Salir del Sistema'>Salir</a>";

//carga datos de secion
    if (!isset($_SESSION["listas"])) {
        //$_SESSION["listas"] 
        $_SESSION["listas"] = $util->archivos;
        $_SESSION["flagg"] = $util->flagg;
        $_SESSION["asdss"] = uniqid('ased_');
    }
} else {
    /*unset($_SESSION["listas"]);
    unset($_SESSION["flagg"]);
    unset($_SESSION["asdss"]);
    unset($_SESSION["login"]);
    session_destroy();*/
    //$log = New LOGIN($sitio);
    ?>
    <!DOCTYPE html>
<html>
<head>

  <title>Aerogal Biblioteca</title>
      
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!---->
  <link rel="stylesheet" type="text/css" href="css/Avianca.min.css">
  <link rel="stylesheet" type="text/css" href="css/demos.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.mobile.icons.min.css">
  <!--<script src="js/jquery.mobile.custom.min.js"></script>-->
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.structure.min.css">
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.theme.min.css">  
  
  <!---->
	<link rel="stylesheet" href="http://demos.jquerymobile.com/1.4.5/css/themes/default/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js?rand=12121111"></script>			
  <!---->
  <script>
            $(document).on("mobileinit", function () {
                // Reference: http://jquerymobile.com/demos/1.1.0/docs/api/globalconfig.html
                $.extend($.mobile, {
                    linkBindingEnabled: false,
                    ajaxEnabled: false
                });
				
            });
			
			
        </script>
  
</head><body><div data-role="page">

	<div data-role="header">
		<img src="images/logo-avianca.png" width="215" height="50" alt="Avianca">
	</div><!-- /header -->

	<div role="main" class="ui-content">

	<?php echo $log->formLogin($_SERVER['PHP_SELF']); ?>
		
            
        </div><!-- /content -->
	<div data-role="footer">
		<div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="/<?=$sitio?>/index.php?renovar_clave=4M4D3U5" data-ajax="false" >Recuperar Clave</a></div>
	</div><!-- /footer -->
</div><!-- /page -->
	</body></html>
    <?php
}
/* echo '<pre>';
  print_r($_SESSION);
  echo '</pre>'; */
?> 


