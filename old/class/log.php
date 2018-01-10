<?php

class LOGIN {

    public function __construct() {
        
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

    function login_data($myusername, $mypassword,$database_manuales7sd, $manuales7sd,$SESSION) {
        if (isset($myusername)) {
            $loginUsername = $myusername;
            $password = $mypassword;
            $MM_fldUserAuthorization = "group_id";
            $MM_redirectLoginSuccess = "correcto!!!!.php";
            $MM_redirectLoginFailed = "error.usuarioerrado.php";
            $MM_redirecttoReferrer = false;
            mysql_select_db($database_manuales7sd, $manuales7sd);

            $LoginRS__query = sprintf("SELECT username, password, group_id,carpeta_master FROM users_biblioteca WHERE username=%s AND password=%s", $this->GetSQLValueString($loginUsername, "text"), $this->GetSQLValueString($password, "text"));

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
				$carpeta_master='%';
				
				while ($fila = mysql_fetch_assoc($resultado)) {
					$carpeta_master= $fila['carpeta_master'];
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
						var pagina="/biblioteca/index.php?error=UsuarioIncorrecto;"
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
		$dddato23="";
		$mmmensahje="";
			
			if ($_GET['error'] == 'UsuarioIncorrecto;') {$mmmensahje='<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario o clave Incorrecta.</p>
	</div></div>';}
			if ($_GET['error'] == 'UsuarioIncorrectoInexistente;') {$mmmensahje='<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario no Existe.</p>
	</div></div>';}
	        if ($_GET['error'] == 'UsuarioRecuperado;') {$mmmensahje='<div class="ui-widget">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>&iexcl;Mensaje de Sistema!</strong> Contrase&ntilde;a Recuperada, revise su correo.</p>
	</div>
</div>';}
	
		 
            $dddato23='
			'.$mmmensahje.'
			<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                <form name="form1" method="POST" action="'.$loginFormAction.'">
                    <td>
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong>Igreso de Usuarios ('.date("d/m/Y H:i").')</strong></td>
                            </tr>
                            <tr>
                                <td width="78">Usuario</td>
                                <td width="6">:</td>
                                <td width="294">
								<input type="email" name="myusername" id="myusername" placeholder="tu.nombre@avianca.com" value="'.$myusername.'" required>								
                            </tr>
                            <tr>
                                <td>Clave</td>
                                <td>:</td>
                                <td>
								<input type="password" name="mypassword" placeholder="password" id="mypassword" required>
								</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input type="submit" name="Submit" value="Login"></td>
                            </tr>
                        </table>
                    </td>
                </form>				
            </tr>
			<tr>
                <td>
					<a href="/biblioteca/index.php?renovar_clave=4M4D3U5">Recuperar Clave>></a>
				</td>
			<tr>
            </table>
			
			';
            return $dddato23;
        }
		public $MM_authorizedUsers = "ADMIN,USER";
		function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
		/*echo "===>".$strUsers;
		echo "===>".$strGroups;
		echo "===>".$UserName;
		echo "===>".$UserGroup;*/
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

function logOUT($_SESSION) { 
     $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  /*$logoutGoTo = "index.php?salir=yes";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
  */
  }
  function formRecuperaClave($loginFormAction) {
		$dddato23="";
		$mmmensahje="";
			
			if ($_GET['error'] == 'UsuarioIncorrecto;') {$mmmensahje='<div class="ui-widget"><div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<strong>Alert:</strong> Usuario No existente.</p>
	</div></div>';}
		 
            $dddato23='
			'.$mmmensahje.'
			<table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                <tr>
                <form name="form1" method="POST" action="'.$loginFormAction.'">
                    <td>
                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                            <tr>
                                <td colspan="3"><strong>Recupera Clave</strong></td>
                            </tr>
                            <tr>
                                <td width="78">Usuario</td>
                                <td width="6">:</td>
                                <td width="294"><input name="myusername_4M4D3U5" type="text" id="myusername_4M4D3U5" value="'.$myusername.'"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><input type="submit" name="Submit" value="Recuperar"></td>
                            </tr>
                        </table>
                    </td>
                </form>				
            </tr>
            </table>
			
			';
            return $dddato23;
        }
		function recuperaMiclave($correo,$clave){
			//$clave="Tu_clave"
			//ALERTA LLEGO IPN 
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$cabeceras .= 'From:Aerogal<biblioteca@aerogal.com.ec>' . "\r\n";
			$cabeceras .= 'From:  biblioteca@aerogal.com.ec' . "\r\n".'X-Mailer: PHP/' . phpversion();


			$subject = 'Recuperar tu clave de Manuales ';
			$to = $correo;    //  your email
			$body =  "<b>Recuperar tu clave</b><br>";
			$body .= "De biblioteca@aerogal.com.ec el ".date('m/d/Y');
			$body .= " a las ".date('g:i A')."<br><br>Tu clave es <b>\"".$clave."\"</b><br>";
			
			mail($to, $subject, $body,$cabeceras); 
		}
		function recuperar_login_data($myusername,$database_manuales7sd, $manuales7sd,$SESSION) {
        if (isset($myusername)) {
            $loginUsername = $myusername;
            
            $MM_fldUserAuthorization = "group_id";
            $MM_redirectLoginSuccess = "correcto!!!!.php";
            $MM_redirectLoginFailed = "error.usuarioerrado.php";
            $MM_redirecttoReferrer = false;
            mysql_select_db($database_manuales7sd, $manuales7sd);

            $LoginRS__query = sprintf("SELECT username, password, group_id FROM users_biblioteca WHERE username=%s", $this->GetSQLValueString($loginUsername, "text") );

            $LoginRS = mysql_query($LoginRS__query, $manuales7sd) or die(mysql_error());
            $loginFoundUser = mysql_num_rows($LoginRS);
            if ($loginFoundUser) {

                /////////////////////////////////////////////////////////
				if ($fila = mysql_fetch_assoc($LoginRS)) {
					//echo $fila['password'];	
					$SESSION['UsuarioRecuperado']=$fila['password'];
				}
				//////////////////////////////////////////////////////////
                //header("Location: " . $MM_redirectLoginSuccess);				
            } else {
                //header("Location: " . $MM_redirectLoginFailed);
				echo '	<script language="JavaScript" type="text/javascript">
						var pagina="/biblioteca/index.php?error=UsuarioIncorrectoInexistente;"
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
  
}