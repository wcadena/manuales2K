<?php require_once('../Connections/manuales7sd.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
    session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .="&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
    //to fully log out a visitor we need to clear the session varialbles
    $_SESSION['MM_Username'] = NULL;
    $_SESSION['MM_UserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;
    unset($_SESSION['MM_Username']);
    unset($_SESSION['MM_UserGroup']);
    unset($_SESSION['PrevUrl']);

    $logoutGoTo = "../index.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}
?>
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

$MM_restrictGoTo = "../index.php?negado=yes";
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

mysql_select_db($database_manuales7sd, $manuales7sd);
$query_Recordset1 = "SELECT * FROM users_".$sitio_manuales7sd." ORDER BY username ASC";
$Recordset1 = mysql_query($query_Recordset1, $manuales7sd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
    <?php if ($_SESSION['MM_UserGroup'] == 'ADMIN') {
        ?>
		<a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a"  data-theme="a" href="ver_subir.php" data-ajax="false" >Subir archivo</a>
		<?php 
    }?>	
    <div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="new.php" data-ajax="false" >Nuevo</a></div>
    
                        
                        
                        <table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive table-stroke">
                        <thead>
                            <tr>
                                <th data-priority="1">ID</th>
                                <th>Usuario</th>
                                <th data-priority="3">Clave</th>

                                <th data-priority="4">Permiso</th>
								<th data-priority="7">Historial</th>
                                <th data-priority="5">Creado</th>
                                <th data-priority="6">Modificado</th>
                                <th data-priority="persist">Editar</th>
                            </tr>
                        </thead>    
<?php do { ?>
                                <tr>
                                    <td><?php echo $row_Recordset1['id']; ?></td>
                                    <td><?php echo $row_Recordset1['username']; ?></td>

                                    <td>*<?php if ($row_Recordset1['group_id'] != 'ADMIN') {
        echo $row_Recordset1['password'];
    } else {
        echo '************';
    } ?>*</td>

                                    <td><?php echo $row_Recordset1['group_id']; ?>
										<div class="act4r" data-id="<?php echo $row_Recordset1['id']; ?>" id="acct4r_<?php echo $row_Recordset1['id']; ?>" >Perfiles... Cargando, espere por favor.</div>
									</td>
									<td>
										<div class="acct4h" data-id="<?php echo $row_Recordset1['username']; ?>" id="acct4h_<?php echo $row_Recordset1['id']; ?>" >Historial... Cargando, espere por favor.</div>
										<a href="ver_historial.php?username=<?php echo $row_Recordset1['username']; ?>" data-rel="dialog" data-transition="slide" class="ui-btn ui-corner-all ui-shadow ui-btn-inline">Historial</a>
									</td>
                                    <td><?php echo date_format(date_create($row_Recordset1['created']), 'd/m/Y');?>
</td>
                                    <td><?php echo date_format(date_create($row_Recordset1['modified']), 'd/m/Y');?></td>
                                    <td><a role="button" class="ui-link ui-btn ui-btn-b ui-icon-edit ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all" href="edit.php?id=<?php echo $row_Recordset1['id']; ?>" data-role="button" data-icon="edit" data-iconpos="notext" data-theme="b" data-inline="true">Borrar</a>
                                    
                                    <a role="button" class="ui-link ui-btn ui-btn-b ui-icon-delete ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all" href="del.php?sdfreID=<?php echo $row_Recordset1['id']; ?>" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="b" data-inline="true">Borrar</a>
                                    </td>
                                </tr>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                        </table>
                        
                    </div><!-- /content -->
	<div data-role="footer">
		<div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="<?php echo $logoutAction ?>" data-ajax="false" >Salir</a></div>
	</div><!-- /footer -->
</div><!-- /page -->
	</body>
	<script>
/*para mandar a cargar todas las tablas*/	
function foo(){
$( ".act4r" ).each(function() {		

		var ids2=$( this ).attr('data-id');
		//alert(ids2);
		$( this ).load( "ajax_action_user.php?id="+ids2, { id: ids2 }, function() {
			$( this ).html(data); 			
		});
});
/////////////////
$( ".acct4h" ).each(function() {		

		var ids2=$( this ).attr('data-id');		
		$( this ).load( "ajax_history_user.php?id="+ids2, { id: ids2 }, function() {
			alert(data);
			$( this ).html(data); 			
		});
});
///////////////
}
foo(); 

</script>
	</html>	
<?php
mysql_free_result($Recordset1);
?>
