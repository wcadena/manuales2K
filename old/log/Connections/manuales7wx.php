<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_manuales7wx = "internal-db.s69751.gridserver.com";
$database_manuales7wx = "db69751_manuales";
$username_manuales7wx = "db69751_manuales";
$password_manuales7wx = "ajUjsO98!hjnno";
$manuales7wx = mysql_pconnect($hostname_manuales7wx, $username_manuales7wx, $password_manuales7wx) or trigger_error(mysql_error(),E_USER_ERROR); 
?>