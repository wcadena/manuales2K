<?php require_once('../Connections/manuales7sd.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "ADMIN";
$MM_donotCheckaccess = "false";

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

}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
    $updateSQL = sprintf("UPDATE users_".$sitio_manuales7sd." SET username=%s, password=%s, group_id=%s, modified=CURRENT_DATE, carpeta_master=%s WHERE id=%s", GetSQLValueString($_POST['username'], "text"), GetSQLValueString($_POST['password'], "text"), GetSQLValueString($_POST['group_id'], "text"), GetSQLValueString($_POST['carpeta_master'], "text"), GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_manuales7sd, $manuales7sd);
    $Result1 = mysql_query($updateSQL, $manuales7sd) or die(mysql_error());
	//echo $updateSQL;
    $updateGoTo = "ver.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $updateGoTo));
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//echo "<pre>1</pre>";
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";
if ((isset($_REQUEST["MM_delete"])) && ($_REQUEST["MM_delete"] == "form2")) {
	echo "<pre>2</pre>";
    $borratabla="perfiles_usuario_".$sitio_manuales7sd;
	$delPermisoSQL = sprintf("delete from ".$borratabla." WHERE id_users=%s", 
	GetSQLValueString($_REQUEST['id'], "int"));
    mysql_select_db($database_manuales7sd, $manuales7sd);
	$Result1 = mysql_query($delPermisoSQL, $manuales7sd) or die(mysql_error());
	//echo $delPermisoSQL;
	
	$updateSQL = sprintf("UPDATE users_".$sitio_manuales7sd." SET username=%s, password=%s, group_id=%s, modified=CURRENT_DATE, carpeta_master=%s WHERE id=%s", GetSQLValueString($_POST['username'], "text"), GetSQLValueString($_POST['password'], "text"), GetSQLValueString($_POST['group_id'], "text"), GetSQLValueString($_POST['carpeta_master'], "text"), GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_manuales7sd, $manuales7sd);
	foreach ($_REQUEST as $key => $value)  
    {  
		$value = mysql_real_escape_string( $value );  
		$value = addslashes($value);  
		$value = strip_tags($value);  
		if($value != ""){$requestnumber ++;}  
		//echo $key. ' - '.$value.'</br>';     
		
		$mystring = $key;
		$findme   = 'heckbox-v';
		$pos = strpos($mystring, $findme);
		//echo "==================>".$pos;
		if($pos){
			//echo $pos."!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n";
			$id_idtrounfg = str_replace("checkbox-v-", "", $mystring);
			$updateSQL = sprintf("INSERT INTO `perfiles_usuario_".$sitio_manuales7sd."`(`id_perfiles`, `id_users`) VALUES (%s,%s)", GetSQLValueString($id_idtrounfg, "text"), GetSQLValueString($_REQUEST['id'], "text"));
			mysql_select_db($database_manuales7sd, $manuales7sd);			
			$Result1 = mysql_query($updateSQL, $manuales7sd) or die(mysql_error());
			//echo $updateSQL ."\n";
		} 
		
		
    }  
	
	
    
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$colname_rs_user = "-1";
if (isset($_GET['id'])) {
    $colname_rs_user = $_GET['id'];
}
mysql_select_db($database_manuales7sd, $manuales7sd);
$query_rs_user = sprintf("SELECT * FROM users_".$sitio_manuales7sd." WHERE id = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $manuales7sd) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);
//echo "<pre>";print_r($row_rs_user);echo "</pre>";

//////////////////////////////////////////para los permisos////////////////////////////////////////////


$colname_rs_user = "-1";
if (isset($_GET['id'])) {
    $colname_rs_user = $_GET['id'];
}

mysql_select_db($database_manuales7sd, $manuales7sd);
$query_Recordset1 = "SELECT * FROM perfiles_".$sitio_manuales7sd." ";
$Recordset1 = mysql_query($query_Recordset1, $manuales7sd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
function dardato($database_manuales7sd, $manuales7sd,$sitio_manuales7sd,$colname_rs_user,$id_perfiles){
	mysql_select_db($database_manuales7sd, $manuales7sd);
	$query_rs_user = sprintf("SELECT * FROM perfiles_usuario_".$sitio_manuales7sd." WHERE id_users = %s and id_perfiles = %s", 
	GetSQLValueString($colname_rs_user, "int"),GetSQLValueString($id_perfiles, "int")	);
	$rs_user = mysql_query($query_rs_user, $manuales7sd) or die(mysql_error());
	$row_rs_user = mysql_fetch_assoc($rs_user);
	$totalRows_rs_user = mysql_num_rows($rs_user);
	//echo "".$query_rs_user.";(".$totalRows_rs_user.")<br />";
	return $totalRows_rs_user; 
}

 
/////////////////////////////////////////fin de los permisos////////////////////////////////////////////

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
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1"  data-ajax="false" >
            <table>
                <tr>
                    <th>Usuario:</th>
                    <td><input type="email" name="username" value="<?php echo htmlentities($row_rs_user['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" required /></td>
                </tr>
                <tr>
                    <th data-priority="1">Clave:</th>
                    <td><input type="password" name="password" value="<?php echo htmlentities($row_rs_user['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr>
                    <th>Permiso:</th>
                    <td>
                        <select name="group_id">                            
<option value="ADMIN" <?php if (!(strcmp("ADMIN", htmlentities($row_rs_user['group_id'], ENT_COMPAT, 'utf-8')))) {
    echo "selected=\"selected\"";
} ?>>ADMIN</option>
                            <option value="USER" <?php if (!(strcmp("USER", htmlentities($row_rs_user['group_id'], ENT_COMPAT, 'utf-8')))) {
    echo "selected=\"selected\"";
} ?>>USER</option>
                        </select></td>
                </tr>
                <tr>
                    <th>Carpetas Master:(Todas las carpetas usar %), <br/>una carpeta Solo Escribir <b>ESTACIÓN LIMA</b><br/>, Tal como está en la carpeta</th>
                    <td><input type="carpeta_master" name="carpeta_master" value="<?php echo htmlentities($row_rs_user['carpeta_master'], ENT_COMPAT, 'utf-8'); ?>" size="32" required /></td>
                </tr>

                <tr>
                    <td  colspan="2" ><input type="submit" value="Actualizar registro" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_rs_user['id']; ?>" />
        </form>
		<h3>Permisos</h3>
		<form action="<?php echo $editFormAction; ?>" method="get" name="form2" id="form2">
			<fieldset data-role="controlgroup">
				<legend>Permisos de usuario:</legend>
				<?php 
				do { 
				//echo "<pre>";print_r($row_Recordset1);echo "</pre>";/***/   
				$checketd990="";
				if(dardato($database_manuales7sd, $manuales7sd,$sitio_manuales7sd,$colname_rs_user,$row_Recordset1['id'])>0){
					$checketd990="checked";
				}
				?>
				<input name="checkbox-v-<?php echo $row_Recordset1['id'];?>" id="checkbox-v-<?php echo $row_Recordset1['id'];?>" type="checkbox" <?php echo $checketd990;?>>
				<label for="checkbox-v-<?php echo $row_Recordset1['id'];?>"><?php echo $row_Recordset1['perfil_nombre'];?>
						
				</label>
				<?php 				
				 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
				?>								
			</fieldset>
			<input type="hidden" name="MM_delete" value="form2" /> 
			<input type="submit" value="Actualizar Permisos" />
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
