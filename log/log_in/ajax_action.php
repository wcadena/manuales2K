<?php require_once('../Connections/manuales7sd.php'); 
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
$colname_rs_user = "-1";
if (isset($_GET['id'])) {
    $colname_rs_user = $_GET['id'];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//echo "<pre>1</pre>";
//echo "<pre>";
//print_r($_REQUEST);
//echo "</pre>";
if ((isset($_REQUEST["MM_delete"])) && ($_REQUEST["MM_delete"] == "form2")) {
	//echo "<pre>2</pre>";
    $borratabla="archivos_perfiles_".$sitio_manuales7sd;
	$delPermisoSQL = sprintf("delete from ".$borratabla." WHERE id_archivos=%s", 
	GetSQLValueString($_REQUEST['id'], "int"));
    mysql_select_db($database_manuales7sd, $manuales7sd);
	$Result1 = mysql_query($delPermisoSQL, $manuales7sd) or die(mysql_error());
	//echo $delPermisoSQL;
	
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
			$updateSQL = sprintf("INSERT INTO `archivos_perfiles_".$sitio_manuales7sd."`(`id_perfiles`, `id_archivos`) VALUES (%s,%s)", GetSQLValueString($id_idtrounfg, "text"), GetSQLValueString($_REQUEST['id'], "text"));
			mysql_select_db($database_manuales7sd, $manuales7sd);			
			$Result1 = mysql_query($updateSQL, $manuales7sd) or die(mysql_error());
			//echo $updateSQL ."\n";
		} 
		$updateGoTo = "ajax_action.php?id=".$colname_rs_user;
		header(sprintf("Location: %s", $updateGoTo));
		
		
    }  
	
	
    
}
if ((isset($_REQUEST["MM_new"])) && ($_REQUEST["MM_new"] == "form_new")) {
	//echo "<pre>2</pre>";
    $borratabla="archivos_".$sitio_manuales7sd;
	$action3df=1;
	$delPermisoSQL = sprintf("UPDATE ".$borratabla." SET nuevo= nuevo*(-1) , updated_at=NOW() WHERE `id`=%s",
	GetSQLValueString($_REQUEST['id'], "int"));
    mysql_select_db($database_manuales7sd, $manuales7sd);
	$Result1 = mysql_query($delPermisoSQL, $manuales7sd) or die(mysql_error());
	echo "Actualizado";	    
	return ;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////para los permisos////////////////////////////////////////////


$colname_rs_user = "-1";
if (isset($_GET['id'])) {
    $colname_rs_user = $_GET['id'];
}
if($colname_rs_user==-1){ 
	echo "cargando.. (sin parametros)";
	return;
}
mysql_select_db($database_manuales7sd, $manuales7sd);
$query_Recordset1 = "SELECT * FROM perfiles_".$sitio_manuales7sd." ";
$Recordset1 = mysql_query($query_Recordset1, $manuales7sd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
function dardato($database_manuales7sd, $manuales7sd,$sitio_manuales7sd,$colname_rs_user,$id_perfiles){
	mysql_select_db($database_manuales7sd, $manuales7sd);
	$query_rs_user = sprintf("SELECT * FROM archivos_perfiles_".$sitio_manuales7sd." WHERE id_archivos = %s and id_perfiles = %s", 
	GetSQLValueString($colname_rs_user, "int"),GetSQLValueString($id_perfiles, "int")	);
	$rs_user = mysql_query($query_rs_user, $manuales7sd) or die(mysql_error());
	$row_rs_user = mysql_fetch_assoc($rs_user);
	$totalRows_rs_user = mysql_num_rows($rs_user);
	//echo "".$query_rs_user.";(".$totalRows_rs_user.")<br />";
	mysql_free_result($rs_user);
	return $totalRows_rs_user; 
}

 
/////////////////////////////////////////fin de los permisos////////////////////////////////////////////
//echo $colname_rs_user."!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
?>

<?php /*<form action="<?php echo $editFormAction; ?>" method="get" name="form2" id="form2" class="permisos3d4" >*/?>
			<form action="javascript:enviaforma(<?php echo $colname_rs_user;?>);" method="get" name="form2" id="form2<?php echo $colname_rs_user;?>" class="permisos3d4" >
				<table class="defefectyhy67">				
				<?php 
				$contf =1;
				do { 
				//echo "<pre>";print_r($row_Recordset1);echo "</pre>";/***/   
				
				$checketd990="";
				if(dardato($database_manuales7sd, $manuales7sd,$sitio_manuales7sd,$colname_rs_user,$row_Recordset1['id'])>0){
					$checketd990="checked";
				}
				?>  
				<?php ($contf++);if(($contf)%3==0){/*echo "<br />";*/}?>
				<td>
				<input name="checkbox-v-<?php echo $row_Recordset1['id'];?>" id="checkbox-v-<?php echo $row_Recordset1['id'];?>" type="checkbox" <?php echo $checketd990;?>>
				<label for="checkbox-v-<?php echo $row_Recordset1['id'];?>" class="permisos" ><?php echo str_replace(" ", "<br />", $row_Recordset1['perfil_nombre']);?>
						
				</label>
				</td>
				<?php 				
				 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
				?>								
			
			<input type="hidden" name="MM_delete" value="form2" /> 
			<input type="hidden" name="id" value="<?php echo $colname_rs_user;?>" /> 
			<td><input data-icon="save" data-iconpos="right" type="submit" value="Actualizar" class="savePermisos" /></td>			
			</table>
		</form>        
	
<?php

mysql_free_result($Recordset1);
?>
