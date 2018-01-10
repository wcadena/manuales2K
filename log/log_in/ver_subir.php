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
$query_Recordset1 = "SELECT * FROM archivos_".$sitio_manuales7sd." ORDER BY filedate ASC";
$Recordset1 = mysql_query($query_Recordset1, $manuales7sd) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
////////////////////////////////////////////////////////////////////////////
mysql_select_db($database_manuales7sd, $manuales7sd);
$query_Recordset2 = "SELECT * FROM perfiles_".$sitio_manuales7sd." ORDER BY perfil_nombre ASC";
$Recordset2 = mysql_query($query_Recordset2, $manuales7sd) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

?>
<!DOCTYPE html>
<html>
<head>

  <title>Aerogal Biblioteca Administrador Archivos</title>
      
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
    <?php if ($row_Recordset1['group_id'] == 'ADMIN') {
        ?>
		<a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="subir.php" data-ajax="false" >Subir archivo</a>
		
		<?php 
    }?>
    <div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="load/"  data-ajax="false" target="_blank" onClick="window.open(this.href, this.target, 'width=600,height=400'); return false;" >Nuevo</a></div>
    
                        <div id="h4ft5"></div>
                        
                        <table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive table-stroke">
                        <thead>
                            <tr>
                                <th data-priority="1">ID</th>
                                <th>Nombre</th>
								<th>N</th>
								<th>Permisos</th>
                                <th data-priority="persist">Editar</th>
                            </tr>
                        </thead>    
<?php do { ?>
                                <tr data-id2="<?php echo $row_Recordset1['id']; ?>" >  
                                    <td><?php echo $row_Recordset1['id']; ?></td>
                                    <td><?php echo $row_Recordset1['nombre']; ?></td>  
									<td> <a href="#popupBasic<?php echo $row_Recordset1['id']; ?>" data-rel="popup">Editar Dato(<?php $n7=$row_Recordset1['nuevo']; if($n7==1){echo "N";}else{echo "+";}?>)</a>
										<div data-role="popup" id="popupBasic<?php echo $row_Recordset1['id']; ?>">
											<a id="fghy8p_<?php echo $row_Recordset1['id']; ?>" href="#" class="ui-btn ui-icon-star ui-btn-icon-left" onClick="indicaNuevo(<?php echo $row_Recordset1['id']; ?>)"><?php $n7=$row_Recordset1['nuevo']; if($n7==1){echo "N";}else{echo "+";}?></a>
											<form method="post" action="demoform.asp">
											  <label for="fname">RevisiOn:</label>
											  <input type="text" name="fname" id="fname">
											  <label for="fname">Fecha:</label>
											  <input type="text" name="fname" id="fname">
											  <select name="day" id="day">
												  <optgroup label="Weekdays">
													<option value="mon">Monday</option>
													<option value="tue">Tuesday</option>
													<option value="wed">Wednesday</option>
												  </optgroup>
												  <optgroup label="Weekends">
													<option value="sat">Saturday</option>
													<option value="sun">Sunday</option>
												  </optgroup>
												</select>
											
											  <input type="button" value="S"  data-icon="check">
											</form>
										</div>
									</td>			
									<td><div class="act4r" data-id="<?php echo $row_Recordset1['id']; ?>" id="acct4r_<?php echo $row_Recordset1['id']; ?>" >Permisos... Cargando, espere por favor.</div></td>	
                                    <td><a role="button" class="ui-link ui-btn ui-btn-b ui-icon-delete ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all" href="http://www.aerogal.info/biblioteca/log/log_in/load/files.php?delfile=<?php echo $row_Recordset1['nombre']; ?>" data-role="button" data-icon="delete" data-iconpos="notext" data-theme="b" data-inline="true" target="_blank" onClick="window.open(this.href, this.target, 'width=600,height=400'); return false;">Borrar</a></td>
                                </tr>
                    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                        </table>
                        
                    </div><!-- /content -->
	<div data-role="footer">
		<div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="<?php echo $logoutAction ?>" data-ajax="false" >Salir</a></div>
	</div><!-- /footer -->
</div><!-- /page -->
	</body></html>
	<script>
/*para mandar a cargar todas las tablas*/	
function foo(){
$( ".act4r" ).each(function() {		
		var ids2=$( this ).attr('data-id');
		$( this ).load( "ajax_action.php?id="+ids2, { id: ids2 }, function() {
			$( this ).html(data);
		});
});
}
foo(); 
/*para actulazcion de datos*/
function enviaforma(idForm){	 	
	data2= $('#form2'+idForm).serialize();
	$('#form2'+idForm).html("<h3>Enviado</h3>");
	 $.ajax({
        url: 'ajax_action.php',
        type: 'get',        
        data: data2,
        success: function(data) {
                   //alert("listo"); 
				   $('#form2'+idForm).html("<h3>Actualizado</h3>");
				   $('#form2'+idForm).load( "ajax_action.php?id="+idForm, { id: idForm }, function() {
						$('#form2'+idForm).html(data);
					});
                 }
    });
	
}

function indicaNuevo(idForm){	 		
	$('#fghy8p_'+idForm).html("<h3>Enviado</h3>");
	 $.ajax({
        url: 'ajax_action.php?MM_new=form_new&id='+idForm,
        type: 'get',        
        data: "MM_new=form_new",
        success: function(data) {                   
				   $('#fghy8p_'+idForm).html("<h3>"+data+"</h3>");	
					
                 }
    });
	
}

</script>
<?php
mysql_free_result($Recordset1);
?>
