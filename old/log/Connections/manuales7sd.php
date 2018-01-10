<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_manuales7sd = "internal-db.s69751.gridserver.com";
$database_manuales7sd = "db69751_manuales";
$username_manuales7sd = "db69751_manuales";
$password_manuales7sd = "ajUjsO98!hjnno";
$manuales7sd = mysql_pconnect($hostname_manuales7sd, $username_manuales7sd, $password_manuales7sd) or trigger_error(mysql_error(),E_USER_ERROR); 
?>