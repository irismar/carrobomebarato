<?php
require'Connections/repasses.php';

$session=get22_client_ip();
$cidade=trim($_POST['cidade']);
$rua=trim($_POST['rua']); 
$estado=trim($_POST['estado']);
$pais=trim($_POST['pais']);
$cep=trim($_POST['endereco']);
$lat=number_format(trim($_POST['lat']), 6, '.', ' ');
$log=number_format(trim($_POST['log']), 6, '.', ' ');


	
if($_SERVER['SERVER_NAME']=="localhost"){
$conect= new mysqli('localhost','root','', 'u386698969_carro');
}else{
$conect= new mysqli('mysql.hostinger.com.br','u488834649_carro','irisMAR100', 'u488834649_carro');  
}
  
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

$sql="INSERT INTO acesso (session_id,cidade,estado,pais,lat,log,cep) VALUES 
( '".$session."','".$cidade."','".$estado."','".$pais."','".$lat."','".$log."','".$cep."')"  ;
$sql=$conect->query($sql); 

$_SESSION['local']=$_POST['cidade'];
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

