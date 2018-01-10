<?php require_once('../Connections/manuales7sd.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "ADMIN";
$MM_donotCheckaccess = "false";

$direccion2sd3='/nfs/c05/h03/mnt/69751/domains/aerogal.info/html/';
$sitio='biblioteca';
require $direccion2sd3.$sitio.'/class/Util.php';
require $direccion2sd3.$sitio.'/class/log.php';
require $direccion2sd3.$sitio.'/log/Connections/manuales7sd.php';
$log = New LOGIN($sitio);
$util = New Util($_SESSION);
$util->setDbData($myusername, $mypassword, $database_manuales7sd, $manuales7sd, $SESSION);
$util->setSite($sitio);
$id_perfiles=$_REQUEST["id_perfiles"];
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
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

$MM_restrictGoTo = "index.php?permisonegado=yes";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?"))
        $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {

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
	
	function listado_completo($ruta, $PROFUNDIDAD, $web = '', $carpeta_master = '%',$spaciox="",$padre_id=-1,$ClaseLogin=null) {
        $datatottal34de = "";
        $datatottal12as = "";
        //$this->log_data(889466681233644489440, print_r($this->archivos, true), 'KlActiveDataLog2Z34.log');
		
        IF ($PROFUNDIDAD <= 0) {
            exit;
        }
// abrir un directorio y listarlo recursivo 
        if (is_dir($ruta)) {
			$id_propio=$padre_id++;
            //echo "<ul>";
            if ($dh = opendir($ruta)) {
                $uniko = uniqid('accordion_');
				//$datatottal12as.= $spaciox."<ul>\n";
                while (($file = readdir($dh))) {
					$id_propio++;
                    $coddee = '';
                    if (is_dir($ruta . $file) && $file != "." && $file != "..") {
						$datatottal12as.= $spaciox."<div data-role=\"collapsible\" data-inset=\"false\">";
                        $datatottal12as.= $spaciox."<h3>Directorio: " . utf8_decode($file) . "</h3>";
						echo '<ul data-role="listview">';
						$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Carpeta'.utf8_decode($file) , 'KlArbol2Z34.log');
                        //$datatottal12as.= "<div>";
					    $datatottal12as.="".$spaciox.$this->listado_completo($ruta . $file . "/", $PROFUNDIDAD - 1, $web . $file . '/', $carpeta_master,$spaciox."",$id_propio);
						echo '</ul>';
                        $datatottal12as.= '</div>';
                    } else {

                        if (!$this->flagg) {
                            $coddee = uniqid('manu_') . md5(utf8_encode($file));
                            $this->archivos[$coddee] = array(
                                'file' => $file,
                                'dir' => $web
                            );
                        } else {
                            $coddee = '';
							if(isset($this->archivos))
                            foreach ($this->archivos as $k => &$n) {                                
                                if ($n['file'] == $file) {
                                    $coddee = $k;
                                }
                            }
                        }
                        if (strlen($file) >= 3) {
                            if (stripos(utf8_decode($web), utf8_decode($carpeta_master)) !== FALSE || utf8_decode($carpeta_master) == "%") {
								$datatottal34de.= "<li>" . utf8_decode($file) . " : <a href='?T=DES&nombre=$coddee' class=\"ui-state-default ui-corner-all\" data-ajax=\"false\">Descarga</a></li>";
								$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Archivo'.utf8_decode($file) , 'KlArbol2Z34.log');
                            }
                            //"<li  title=\".ui-icon-disk\"></li>"span
                        }
                        //echo "</li>";
                    }
                }
                //$datatottal12as.=$spaciox."</ul>\n";
                closedir($dh);
                //echo "</ul>";
            }
            $datatottal34de.=$datatottal12as;
        }
        else
            $datatottal34de.= "<br>No es ruta valida";
        return $datatottal34de;
    }

}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	
    $updateSQL = sprintf("UPDATE users_".$sitio_manuales7sd." SET username=%s, password=%s, group_id=%s, modified=CURRENT_DATE, carpeta_master=%s WHERE id=%s", GetSQLValueString($_POST['username'], "text"), GetSQLValueString($_POST['password'], "text"), GetSQLValueString($_POST['group_id'], "text"), GetSQLValueString($_POST['carpeta_master'], "text"), GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_manuales7sd, $manuales7sd);
    //$Result1 = mysql_query($updateSQL, $manuales7sd) or die(mysql_error());
	echo $updateSQL;
    $updateGoTo = "ver.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs_user = "-1";
if (isset($_GET['id'])) {
    $colname_rs_user = $_GET['id'];
}
mysql_select_db($database_manuales7sd, $manuales7sd);
$query_rs_user = sprintf("SELECT * FROM permiso_".$sitio_manuales7sd." WHERE id_perfiles = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $manuales7sd) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);
//echo "<pre>";print_r($row_rs_user);echo "</pre>";
?>
<!DOCTYPE html>
<html>
<head>

  <title>Aerogal Biblioteca Administrador</title>
      
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!---->
  <link rel="stylesheet" type="text/css" href="../../css/Avianca.min.css">
  <link rel="stylesheet" type="text/css" href="../../css/demos.css">
  <link rel="stylesheet" type="text/css" href="../../css/jquery.mobile.icons.min.css">
  <script src="../../js/jquery.mobile.custom.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../js/jquery.mobile.custom.structure.min.css">
  <link rel="stylesheet" type="text/css" href="../../js/jquery.mobile.custom.theme.min.css">  
  
  <!---->
	<link rel="stylesheet" href="http://demos.jquerymobile.com/1.4.5/css/themes/default/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js?rand=12121111"></script>			
  <!---->
  
  
</head><body><div data-role="page">

	<div data-role="header">
		<img src="../../images/logo-avianca.png" width="215" height="50" alt="Avianca">
	</div><!-- /header -->

	<div role="main" class="ui-content">
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table>
                <tr>
					<th>
					Permisos
					</th>	
					<td>
						<?php
									echo "+++<pre>";
									print_r($_REQUEST);
									echo "</pre>---";
									
									?>
							<fieldset data-role="controlgroup">
								<legend>Swatch B:</legend>
								<?php echo "\n".$util->listado_completo_permisos($direccion2sd3.$sitio."/dtos/ENTRENAMIENTO", 10, 'dtos/',$_SESSION['carpeta_master'],"",0,$id_perfiles,$log);
								?>
							</fieldset>
						
					</td>					
				</tr>

                <tr>
                    <td  colspan="2" ><input type="submit" value="Actualizar registro" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_rs_user['id']; ?>" />
        </form>
        </div><!-- /content -->
	<div data-role="footer">
		<div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="<?php echo $logoutAction ?>" data-ajax="false" >Salir</a></div>
	</div><!-- /footer -->
</div><!-- /page -->
	</body></html>
<?php
mysql_free_result($rs_user);
?>
