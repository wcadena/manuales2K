<?php
if (!isset($_SESSION)) {
  session_start();
}
require '/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/biblioteca/class/Util.php';
require '/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/biblioteca/class/log.php';
require '/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/biblioteca/log/Connections/manuales7sd.php';
$log = New LOGIN();
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
		echo "Recuperando clave en proceso, Correo enviado ";
			
		$SESSION=$_SESSION;
        $SESSION=$log->recuperar_login_data($_POST['myusername_4M4D3U5'],$database_manuales7sd, $manuales7sd, $SESSION);
		$log->recuperaMiclave($_POST['myusername_4M4D3U5'],$SESSION['UsuarioRecuperado']);
		echo '	<script language="JavaScript" type="text/javascript">
						var pagina="/biblioteca/index.php?error=UsuarioRecuperado;"
						function redireccionar() 
						{
						location.href=pagina
						} 
						setTimeout ("redireccionar()", 1000);
						</script>';
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
	window.location.href = \'/biblioteca\';
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
echo '<!DOCTYPE html><!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]--><meta name="viewport" content="width=320; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=1;" /><head><title>Manuales de Aerogal</title>
	<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">-->
	<link rel="stylesheet" href="css/themes/base/jquery.ui.all.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="js/jquery-1.8.3.js"></script>
	<script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.accordion.js"></script>
	<link rel="stylesheet" href="css/demos.css">
	
	
	</head><body class="internal">';
//presenta arbol
	echo "<h3>".$usuariosd33ft6.'</h3>';
    echo '<h2 class="demoHeaders">Raiz</h2>';
	echo "<h3><a class='logout' style=\"float:right\" href='?F=cHao_2wsejJ&Salir=Si' title='Salir del Sistema'>Salir>></a></h3>";
    //echo '<!DOCTYPE html><!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]--><meta name="viewport" content="width=320; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=1;" /><head><title>Manuales de Aerogal</title></head><body class="internal">';
    //echo "<div id=\"accordion\">";
	echo $util->listado_completo("/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/biblioteca/dtos/", 10, 'dtos/',$_SESSION['carpeta_master']);
	//echo "</div>";
    echo '</body></html>';
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
    //$log = New LOGIN();
    ?>
    <!DOCTYPE html><!--[if gt IE 8]><!--> <html lang="es"> <!--<![endif]--><meta name="viewport" content="width=320; initial-scale=1.0; minimum-scale=1.0; maximum-scale=1.0; user-scalable=1;" /><head><title>Manuales de Aerogal</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
	</head><body class="internal">
					 			
            <?php echo $log->formLogin($_SERVER['PHP_SELF']); ?>
            <script language="JavaScript">
                function enfocar(){
                    document.form1.myusername.focus(); 
                }
                enfocar();
            </script>
        </body></html>
    <?php
}
/* echo '<pre>';
  print_r($_SESSION);
  echo '</pre>'; */
?> 


