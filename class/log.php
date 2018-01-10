<?php

class LOGIN {
	
	private $sitio;
	private $correosupport;

    public function __construct($sitio) {
        $this->sitio=$sitio;
		$this->db=$sitio;
		$this->correosupport="biblioteca@aerogal.com.ec";
    }

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }

// *** Validate request to login to this site.

    function login_data($myusername, $mypassword, $database_manuales7sd, $manuales7sd, $SESSION) {
        if (isset($myusername)) {
            $loginUsername = $myusername;
            $password = $mypassword;
            $MM_fldUserAuthorization = "group_id";
            $MM_redirectLoginSuccess = "correcto!!!!.php";
            $MM_redirectLoginFailed = "error.usuarioerrado.php";
            $MM_redirecttoReferrer = false;
            mysql_select_db($database_manuales7sd, $manuales7sd);

            $LoginRS__query = sprintf("SELECT username, password, group_id,carpeta_master FROM users_".$this->db." WHERE username=%s AND password=%s", $this->GetSQLValueString($loginUsername, "text"), $this->GetSQLValueString($password, "text"));

            $LoginRS = mysql_query($LoginRS__query, $manuales7sd) or die(mysql_error());
            $loginFoundUser = mysql_num_rows($LoginRS);
            if ($loginFoundUser) {

                $loginStrGroup = mysql_result($LoginRS, 0, 'group_id');

                //if (PHP_VERSION >= 5.1) {
                //    session_regenerate_id(true);
                //} else {
                //    session_regenerate_id();
                //}
                //declare two session variables and assign them
                ///////////////////////////////////////////////////////////////////
                // Ejecutar la consulta
                $resultado = mysql_query($LoginRS__query);

                // Usar el resultado
                // Si se intenta imprimir $resultado no será posible acceder a la información del recurso
                // Se debe usar una de las funciones de resultados de mysql
                // Consulte también mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
                $carpeta_master = '%';

                while ($fila = mysql_fetch_assoc($resultado)) {
                    $carpeta_master = $fila['carpeta_master'];
                }
                $SESSION['carpeta_master'] = $carpeta_master;
                ///////////////////////////////////////////////////////////////////
                $SESSION['MM_Username'] = $loginUsername;
                $SESSION['MM_UserGroup'] = $loginStrGroup;

                if (isset($SESSION['PrevUrl']) && false) {
                    $MM_redirectLoginSuccess = $SESSION['PrevUrl'];
                }
                //header("Location: " . $MM_redirectLoginSuccess);				
            } else {
                //header("Location: " . $MM_redirectLoginFailed);
                echo '	<script language="JavaScript" type="text/javascript">
						var pagina="/'.$this->sitio.'/index.php?error=UsuarioIncorrecto;"
						function redireccionar() 
						{
						location.href=pagina
						} 
						setTimeout ("redireccionar()", 100);
						</script>';
                exit;
            }
            return $SESSION;
        }
    }

    function formLogin($loginFormAction) {
        $dddato23 = "";
        $mmmensahje = "";

        if ($_GET['error'] == 'UsuarioIncorrecto;') {
            $mmmensahje = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario o clave Incorrecta.</p>
	</div></div>';
        }
        if ($_GET['error'] == 'UsuarioIncorrectoInexistente;') {
            $mmmensahje = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario no Existe.</p>
	</div></div>';
        }
        if ($_GET['error'] == 'UsuarioRecuperado;') {
            $mmmensahje = '<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>&iexcl;Mensaje de Sistema!</strong> Contrase&ntilde;a Recuperada, revise su correo.</p>
	</div>
</div>';
        }


        $dddato23 = '
			' . $mmmensahje . '			
                <form name="form1" method="POST" action="'. $loginFormAction . '" data-ajax="false">                    
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong>Ingreso de Usuarios</strong></td>
                            </tr>
                            <tr>
                                <td width="78">Usuario</td>
                                <td width="6">:</td>
                                <td width="294">
								<input type="email" name="myusername" id="myusername" placeholder="tu.nombre@avianca.com" value="' . $myusername . '" required>								
                            </tr>
                            <tr>
                                <td>Clave</td>
                                <td>:</td>
                                <td>
								<input type="password" name="mypassword" placeholder="password" id="mypassword" required>
								</td>
                            </tr>
                            <tr>
                                <td colspan="3"><button class=" ui-btn ui-btn-a ui-icon-star ui-btn-icon-left ui-shadow ui-corner-all" data-icon="star" data-theme="a" data-form="ui-btn-up-a" type="submit">Ingresar</button></td>
                            </tr>
                        </table>
                </form>				
            </tr>
				';
        return $dddato23;
    }

    public $MM_authorizedUsers = "ADMIN,USER";

    function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
        /* echo "===>".$strUsers;
          echo "===>".$strGroups;
          echo "===>".$UserName;
          echo "===>".$UserGroup; */
        // For security, start by assuming the visitor is NOT authorized. 
        $isValid = False;

        // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
        // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
        if (!empty($UserName)) {
            // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
            // Parse the strings into arrays. 
            $arrUsers = Explode(",", $strUsers);
            $arrGroups = Explode(",", $strGroups);
            if (in_array($UserName, $arrUsers)) {
                $isValid = true;
            }
            // Or, you may restrict access to only certain users based on their username. 
            if (in_array($UserGroup, $arrGroups)) {
                $isValid = true;
            }
            if (($strUsers == "") && false) {
                $isValid = true;
            }
        }
        return $isValid;
    }

    function logOUT($_SESSION1) {
        $_SESSION1['MM_Username'] = NULL;
        $_SESSION1['MM_UserGroup'] = NULL;
        $_SESSION1['PrevUrl'] = NULL;
        unset($_SESSION1['MM_Username']);
        unset($_SESSION1['MM_UserGroup']);
        unset($_SESSION1['PrevUrl']);

        /* $logoutGoTo = "index.php?salir=yes";
          if ($logoutGoTo) {
          header("Location: $logoutGoTo");
          exit;
          }
         */
    }

    function formRecuperaClave($loginFormAction) {
        $dddato23 = "";
        $mmmensahje = "";

        if ($_GET['error'] == 'UsuarioIncorrecto;') {
            $mmmensahje = '<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario No existente.</p>
	</div></div>';
        }

        $dddato23 = ''.$mmmensahje . '<!DOCTYPE html>
<html>
<head>

  <title>Aerogal Biblioteca</title>
      
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!---->
  <link rel="stylesheet" type="text/css" href="css/Avianca.min.css">
  <link rel="stylesheet" type="text/css" href="css/demos.css">
  <link rel="stylesheet" type="text/css" href="css/jquery.mobile.icons.min.css">
  <script src="js/jquery.mobile.custom.min.js"></script>
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.structure.min.css">
  <link rel="stylesheet" type="text/css" href="js/jquery.mobile.custom.theme.min.css">  
  
  <!---->
	<link rel="stylesheet" href="http://demos.jquerymobile.com/1.4.5/css/themes/default/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    		
  <!---->
  
  
</head><body><div data-role="page">

	<div data-role="header">
		<img src="images/logo-avianca.png" width="215" height="50" alt="Avianca">
	</div><!-- /header -->

	<div role="main" class="ui-content">
			<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                <form name="form1" method="post" action="' . $loginFormAction . '" data-ajax="false" >
                    <td>
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong>Recupera Clave</strong></td>
                            </tr>
                            <tr>
                                <td width="78">Usuario</td>
                                <td width="6">:</td>
                                <td width="294"><input name="myusername_4M4D3U5" type="email" id="myusername_4M4D3U5" value="' . $myusername . '" placeholder="tu.nombre@avianca.com" required></td>
                            </tr>
                            <tr>
                                <td colspan="3">
								<button type="submit" name="submit" value="submit" data-theme="b">Recuperar</button>
								</td>
                            </tr>
                        </table>
                    </td>
                </form>				
            </tr>
            </table>
			</div><!-- /content -->	
</div><!-- /page -->
	</body></html>
			';
        return $dddato23;
    }

    function recuperaMiclave($correo, $clave) {
        //$clave="Tu_clave"
        //ALERTA LLEGO IPN 
        $cabeceras = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $cabeceras .= 'From:Aerogal<'.$this->correosupport.'>' . "\r\n";
        $cabeceras .= 'From:  '.$this->correosupport.'' . "\r\n" . 'X-Mailer: PHP/' . phpversion();


        $subject = 'Recuperar tu clave de Manuales ';
        $to = $correo;    //  your email
        $body = "<b>Recuperar tu clave</b><br>";
        $body .= "De ".$this->correosupport." el " . date('m/d/Y');
        $body .= " a las " . date('g:i A') . "<br><br>Tu clave es <b>\"" . $clave . "\"</b><br>";

        mail($to, $subject, $body, $cabeceras);
    }

    function recuperar_login_data($myusername, $database_manuales7sd, $manuales7sd, $SESSION) {
        if (isset($myusername)) {
            $loginUsername = $myusername;

            $MM_fldUserAuthorization = "group_id";
            $MM_redirectLoginSuccess = "correcto!!!!.php";
            $MM_redirectLoginFailed = "error.usuarioerrado.php";
            $MM_redirecttoReferrer = false;
            mysql_select_db($database_manuales7sd, $manuales7sd);

            $LoginRS__query = sprintf("SELECT username, password, group_id FROM users_".$this->db." WHERE username=%s", $this->GetSQLValueString($loginUsername, "text"));

            $LoginRS = mysql_query($LoginRS__query, $manuales7sd) or die(mysql_error());
            $loginFoundUser = mysql_num_rows($LoginRS);
            if ($loginFoundUser) {

                /////////////////////////////////////////////////////////
                if ($fila = mysql_fetch_assoc($LoginRS)) {
                    //echo $fila['password'];	
                    $SESSION['UsuarioRecuperado'] = $fila['password'];
                }
                //////////////////////////////////////////////////////////
                //header("Location: " . $MM_redirectLoginSuccess);				
            } else {
                //header("Location: " . $MM_redirectLoginFailed);
                echo '	<script language="JavaScript" type="text/javascript">
						var pagina="/'.$this->sitio.'/index.php?error=UsuarioIncorrectoInexistente;"
						function redireccionar() 
						{
						location.href=pagina
						} 
						setTimeout ("redireccionar()", 100);
						</script>';
                exit;
            }
            return $SESSION;
        }
    }
	function regeneraArbol($myusername, $mypassword, $database_manuales7sd, $manuales7sd, $SESSION,$id, $archivos_id, $nombre,$identificacion,$tipo,$email){
		$insertSQL = sprintf("INSERT INTO archivos_".$this->db." (id, archivos_".$this->db."_id, nombre,identificacion,tipo,email,created_at) VALUES (%s, %s, %s,%s, %s, %s, CURRENT_DATE)", 
		$this->GetSQLValueString($id, "text"), //1
		$this->GetSQLValueString($archivos_id, "text"), //2
		$this->GetSQLValueString($nombre, "text"), //3
		$this->GetSQLValueString($identificacion, "text"), //4
		$this->GetSQLValueString($tipo, "text"), //5
		$this->GetSQLValueString($email, "text")//6
		);

		mysql_select_db($database_manuales7sd, $manuales7sd);
		$Result1 = mysql_query($insertSQL, $manuales7sd) or die(mysql_error());

		$this->log_data(77777777777777777777,$insertSQL , 'KlSQLArbol2Z34.log');
	}

}