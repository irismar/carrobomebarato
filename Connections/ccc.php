<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_ccc = "localhost";
$database_ccc = "u557658549_conc";
$username_ccc = "root";
$password_ccc = "";
$ccc = mysql_pconnect($hostname_ccc, $username_ccc, $password_ccc) or trigger_error(mysql_error(),E_USER_ERROR); 
?>