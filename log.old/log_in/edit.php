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

if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
    echo "El Usuario " . $_POST['username'] . " debe ser un correo.";
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1") && filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
    $updateSQL = sprintf("UPDATE users_".$sitio_manuales7sd." SET username=%s, password=%s, group_id=%s, modified=CURRENT_DATE, carpeta_master=%s WHERE id=%s", GetSQLValueString($_POST['username'], "text"), GetSQLValueString($_POST['password'], "text"), GetSQLValueString($_POST['group_id'], "text"), GetSQLValueString($_POST['carpeta_master'], "text"), GetSQLValueString($_POST['id'], "int"));

    mysql_select_db($database_manuales7sd, $manuales7sd);
    $Result1 = mysql_query($updateSQL, $manuales7sd) or die(mysql_error());

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
$query_rs_user = sprintf("SELECT * FROM users_".$sitio_manuales7sd." WHERE id = %s", GetSQLValueString($colname_rs_user, "int"));
$rs_user = mysql_query($query_rs_user, $manuales7sd) or die(mysql_error());
$row_rs_user = mysql_fetch_assoc($rs_user);
$totalRows_rs_user = mysql_num_rows($rs_user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Documento sin título</title>
    </head>

    <body>
        <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
            <table align="center">
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Username:</td>
                    <td><input type="text" name="username" value="<?php echo htmlentities($row_rs_user['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Password:</td>
                    <td><input type="password" name="password" value="<?php echo htmlentities($row_rs_user['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Group_id:</td>
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
                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Carpetas Master:(Todas las carpetas usar %), <br/>una carpeta Solo Escribir <b>ESTACIÓN LIMA</b><br/>, Tal como está en la carpeta</td>
                    <td><input type="carpeta_master" name="carpeta_master" value="<?php echo htmlentities($row_rs_user['carpeta_master'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
                </tr>

                <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td><input type="submit" value="Actualizar registro" /></td>
                </tr>
            </table>
            <input type="hidden" name="MM_update" value="form1" />
            <input type="hidden" name="id" value="<?php echo $row_rs_user['id']; ?>" />
        </form>
        <p>&nbsp;</p>
    </body>
</html>
<?php
mysql_free_result($rs_user);
?>
