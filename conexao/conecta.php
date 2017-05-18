<?php 
include'funcao.php';
header('Content-Type: text/html; charset=utf-8');
 @session_start();
 session_id();
  $ip=getrealip();
    $request = $_SERVER['REQUEST_URI'];
  $hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
$data = date('Y-m-d');
  @mysql_query("SET NAMES 'utf8'");
  @mysql_query('SET character_set_connection=utf8');
  @mysql_query('SET character_set_client=utf8');
  @mysql_query('SET character_set_results=utf8');
  ini_set('default_charset','utf-8');
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_extenso= strftime('%A, %d de %B de %Y', strtotime('today'));
$data_extenso=utf8_encode( $data_extenso);
// Conecta-se ao banco de dados MySQL
//$mysql= new mysqli(' ','root',' ', 'carros');
$mysql= new mysqli('localhost','root','', 'u557658549_conc');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
 $conect= new mysqli('localhost','root','', 'u557658549_conc');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

$lista_navegadores = array("MSIE","Windows NT", "Firefox", "Chrome", "Safari", "OPR");
$navegador_usado = $_SERVER["HTTP_USER_AGENT"];

foreach($lista_navegadores as $valor_verificar)
{
if(strrpos($navegador_usado, $valor_verificar))
{
echo $navegador = $valor_verificar;

$posicao_inicial = strpos($navegador_usado, $navegador) + strlen($navegador);
$versao = substr($navegador_usado, $posicao_inicial, 5);
}
}
 @$naveg=$navegador."".$versao;


function salvaLog($mensagem) {
$lista_navegadores = array("MSIE","Windows NT", "Firefox", "Chrome", "Safari", "OPR");
 $navegador_usado = $_SERVER["HTTP_USER_AGENT"];

foreach($lista_navegadores as $valor_verificar)
{
if(strrpos($navegador_usado, $valor_verificar))
{
@$navegador = $valor_verificar;

$posicao_inicial = strpos($navegador_usado, $navegador) + strlen($navegador);
$versao = substr($navegador_usado, $posicao_inicial, 5);
}
}
 $naveg=$navegador."".$versao;
  $ip=getrealip();
  $hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
  @$endereco=$_SESSION['endereco1'];
  @$cidade=$_SESSION['cidade'];
  @$estado=$_SESSION['estado'];
  @$id=@$_SESSION['id'];
  @$nome=@$_SESSION['usuario'];
  $conect= new mysqli('localhost','root','', 'u557658549_conc');
// Caso algo tenha dado errado, exibe uma mensagem de erro
  if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
  @mysql_query("SET NAMES 'utf8'");
  @mysql_query('SET character_set_connection=utf8');
  @mysql_query('SET character_set_client=utf8');
  @mysql_query('SET character_set_results=utf8');
  ini_set('default_charset','utf-8');
  $sql="INSERT INTO log (data,ip,mensagem,maquina,endereco) VALUES 
( '".$hora."','".$ip."','". $mensagem."','".$navegador_usado."','".$endereco."')"  ;
$sql=$conect->query($sql); 
if ($sql) {
return true;
} else {
return false;
}
}


 function colaborador($mensagem) {
	 
	 
$lista_navegadores = array("MSIE", "Firefox", "Chrome", "Safari", "OPR");
$navegador_usado = $_SERVER["HTTP_USER_AGENT"];

foreach($lista_navegadores as $valor_verificar)
{
if(strrpos($navegador_usado, $valor_verificar))
{
$navegador = $valor_verificar;

$posicao_inicial = strpos($navegador_usado, $navegador) + strlen($navegador);
$versao = substr($navegador_usado, $posicao_inicial, 5);
}
}
 $naveg=$navegador."".$versao;

  $ip=getrealip();
  $hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
  @$endereco=$_SESSION['endereco1'];
  @$cidade=$_SESSION['cidade'];
  @$estado=$_SESSION['estado'];
  @$id=@$_SESSION['id'];
  @$nome=@$_SESSION['usuario'];
  @$nome=@$_SESSION['nome'];
  @$cpf=@$_SESSION['cpf'];
  
 $conect= new mysqli('localhost','root','', 'u557658549_conc');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
@mysql_query("SET NAMES 'utf8'");
@mysql_query('SET character_set_connection=utf8');
@mysql_query('SET character_set_client=utf8');
@mysql_query('SET character_set_results=utf8');
ini_set('default_charset','utf-8');
$sql="INSERT INTO log_colaborador (data,ip,maquina,acao,user,cpf,endereco) VALUES 
( '".$hora."','".$ip."','".$navegador_usado."','". $mensagem."','". $nome."','". $cpf."','".$endereco."')"  ;
$sql=$conect->query($sql); 
if ($sql) {
return true;
} else {
return false;
}
}
    ?>    
