<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
define('CLIENT_LONG_PASSWORD', 1);
$hostname_manuales7sd = $_ENV['DATABASE_SERVER'] ; 
$database_manuales7sd = "db69751_manuales";
$username_manuales7sd = "db69751_manuales";
$password_manuales7sd = '';//SET PASSWORD=PASSWORD('Wajasdij2!my_passwo@.rd0');
$sitio_manuales7sd = "biblioteca";//aufijo database
$manuales7sd = mysql_pconnect($hostname_manuales7sd, $username_manuales7sd, $password_manuales7sd) or trigger_error(mysql_error(),E_USER_ERROR); 
/*
SET SESSION old_passwords=FALSE;
SET PASSWORD = PASSWORD('Wajasdij2!my_passwo@.rd0');
*/
?>