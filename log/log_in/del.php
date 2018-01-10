<?php require_once('../Connections/manuales7sd.php'); ?>
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

if ((isset($_GET['sdfreID'])) && ($_GET['sdfreID'] != "") && (isset($_GET['sdfreID']))) {
    $deleteSQL = sprintf("DELETE FROM users_".$sitio_manuales7sd." WHERE id=%s", GetSQLValueString($_GET['sdfreID'], "int"));

    mysql_select_db($database_manuales7sd, $manuales7sd);
    $Result1 = mysql_query($deleteSQL, $manuales7sd) or die(mysql_error());

    $deleteGoTo = "ver.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
        $deleteGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $deleteGoTo));
}
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
        <h1>Elemento Borrado</h1>
        </div><!-- /content -->
	<div data-role="footer">
		<div class="ui-last-child"><a class="ui-btn-a ui-btn ui-btn-icon-right ui-icon-carat-r" data-form="ui-btn-up-a" data-swatch="a" data-theme="a" href="<?php echo $logoutAction ?>" data-ajax="false" >Salir</a></div>
	</div><!-- /footer -->
</div><!-- /page -->
	</body></html>