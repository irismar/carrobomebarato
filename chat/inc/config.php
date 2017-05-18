<?php 
	/*
		Configurações do site
	*/
	error_reporting(0);

	$dbhost="localhost";
	$dbuser="root";
	$dbpass="";
	$dbname="u386698969_carro";
	$con = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
	$sel = mysql_select_db($dbname);

	if (!isset($_SESSION)) {
		session_start();
	}
?>