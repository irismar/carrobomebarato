<?php
$server = "localhost";
    $user = "u791463690_carro";
    $senha = "  ";
    $base = "u791463690_carro";
    $conexao = mysql_connect($server, $user, $senha) or   die("Erro na conexao!");
    mysql_select_db($base);
 function tempoExecucao($start = null) {
    // Calcula o microtime atual
    $mtime = microtime(); // Pega o microtime
    $mtime = explode(' ',$mtime); // Quebra o microtime
    $mtime = $mtime[1] + $mtime[0]; // Soma as partes montando um valor inteiro

    if ($start == null) {
        // Se o parametro não for especificado, retorna o mtime atual
        return $mtime;
    } else {
        // Se o parametro for especificado, retorna o tempo de execução
        return round($mtime - $start, 6);
    }
}// Define uma constante contendo o microtime atual
define('mTIME', tempoExecucao());
 session_start();
$hora = date('Y-m-d H:i:s');
$data = date('Y-m-d');
#/ Conex�o com o MySQL
// ========================
$_BS['MySQL']['servidor'] = "localhost";
$_BS['MySQL']['usuario'] = "u791463690_carro";
$_BS['MySQL']['senha'] = "  ";
$_BS['MySQL']['banco'] = "u791463690_carro";
$mysql = new MySQLi($_BS['MySQL']['servidor'], $_BS['MySQL']['usuario'], $_BS['MySQL']['senha'], $_BS['MySQL']['banco']);
if ($mysql->error) { die($mysql->errno . ' - ' . $mysql->error); }
mysql_connect($_BS['MySQL']['servidor'], $_BS['MySQL']['usuario'], $_BS['MySQL']['senha']);
mysql_select_db($_BS['MySQL']['banco']);
// ====(Fim da conex�o)====
$MySQL = array(
	'servidor' => 'localhost',	// Endereço do servidor
	'usuario' => 'u791463690_carro',		// Usuário
	'senha' => '  ',				// Senha
	'banco' => 'u791463690_carro'		// Nome do banco de dados
);

$MySQLi = new MySQLi($MySQL['servidor'], $MySQL['usuario'], $MySQL['senha'], $MySQL['banco']);

// Verifica se ocorreu um erro e exibe a mensagem de erro
if (mysqli_connect_errno())
    trigger_error(mysqli_connect_error(), E_USER_ERROR);
	
function IsLoggedIn()
{
	return (@$_SESSION["Status"] == "repasses");
}

function geraTimestamp($data) {
$partes = explode('.', $data);
return @mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}





function som_data($data, $dias)
{
		$data_e = explode(".",$data);
		$data2 = date("m.d.Y", mktime(0,0,0,$data_e[1],$data_e[0] + $dias,$data_e[2]));
		$data2_e = explode(".",$data2);
		$data_final = $data2_e[2] . "-" . $data2_e[0] . "-" . $data2_e[1];
		return $data_final;
}
function FormataData($data) {  
	$novadata = strftime("%d.%m.%Y",strtotime($data));
	return $novadata;
}
function FormataData2($data) {
	$novadata = strftime("%Y-%m-%d",strtotime($data));
	return $novadata;
}
function FormataData3($data) {
	$novadata = strftime("%d/%m/%Y",strtotime($data));
	return $novadata;}
	
  function anti_injection($sql) {
        $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $sql);
        $sql = trim($sql); 
        $sql = strip_tags($sql);
        $sql = addslashes($sql);
        return $sql;
    }
  
function sub_data($data, $dias) {
	$data_e = explode("/",$data);
	$data2 = date("m/d/Y", mktime(0,0,0,$data_e[1],$data_e[0] - $dias,$data_e[2]));
	$data2_e = explode("/",$data2);
	$data_final = $data2_e[1] . "/". $data2_e[0] . "/" . $data2_e[2];
	return $data_final;
}
function modificadata($valor) {
	$novadata = explode("/",$valor);
	$data2 = $novadata[2] . "-" . $novadata[1] . "-" . $novadata[0];
	return $data2;
}
 

	
function getTime(){
	static $tempo;
	if( $tempo == NULL ){
		$tempo = microtime(true);
	}
	else{
		echo 'Tempo (segundos): '.(microtime(true)-$tempo).'';
	}
}

function trancar_pagina($nome){
if (eregi("$nome", $_SERVER['SCRIPT_NAME'])){
die ("<script>alert('Sem permi��o de acesso !')</script>");
}
}
	 

//	 $_SESSION["telefone"] =$dados

 
// Define uma fun��o que poder� ser usada para validar e-mails usando regexp
function validaEmail($email) {
$conta = "^[a-zA-Z0-9\._-]+@";
$domino = "[a-zA-Z0-9\._-]+.";
$extensao = "([a-zA-Z]{2,4})$";

$pattern = $conta.$domino.$extensao;

if (ereg($pattern, $email))

return false;
else
return true;

}

function remover_caracter($string) {
    $string = preg_replace(" /[����������]/", "a", $string);
    $string = preg_replace("/[������]/", "e", $string);
    $string = preg_replace("/[����]/", "i", $string);
    $string = preg_replace("/[����������]/", "o", $string);
    $string = preg_replace("/[������]/", "u", $string);
    $string = preg_replace("/��/", "c", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    $string = preg_replace("/�/", "c", $string);
    $string = preg_replace("/�/", "e", $string);
    $string = preg_replace("/�/", "a", $string) ;       
    $string = preg_replace("/ /", "_", $string);
    $string = preg_replace("/ç /", "�", $string);

    $string = strtolower($string);
   
    return $string;
}
$permitidos = array('index.php', 'estoque.php', 'ad.php', 'empresa.php');
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "date":
      case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
	   case "datetime":
      case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

/**
* Validate a date
*
* @param    string    $data
* @param    string    formato
* @return    bool
*/
function validaData($data, $formato = 'DD/MM/AAAA') {
switch($formato) {
case 'DD-MM-AAAA':
case 'DD/MM/AAAA':
list($d, $m, $a) = preg_split('/[-./ ]/', $data);
break;

case 'AAAA/MM/DD':
case 'AAAA-MM-DD':
list($a, $m, $d) = preg_split('/[-./ ]/', $data);
break;

case 'AAAA/DD/MM':
case 'AAAA-DD-MM':
list($a, $d, $m) = preg_split('/[-./ ]/', $data);
break;

case 'MM-DD-AAAA':
case 'MM/DD/AAAA':
list($m, $d, $a) = preg_split('/[-./ ]/', $data);
break;

case 'AAAAMMDD':
$a = substr($data, 0, 4);
$m = substr($data, 4, 2);
$d = substr($data, 6, 2);
break;

case 'AAAADDMM':
$a = substr($data, 0, 4);
$d = substr($data, 4, 2);
$m = substr($data, 6, 2);
break;
default:
throw new Exception( "Formato de data inv�lido");
break;
}
return checkdate($m, $d, $a);
}

/**
* Traduz n�meros para texto e vice-e-versa
*
* Traduz qualquer n�mero (at� 9007199254740992)
* para uma vers�o menor, usando letras:
* 9007199254740989 --> PpQXn7COf
*
* Especificando o segundo par�metro como true temos:
* PpQXn7COf --> 9007199254740989
*
* @author    Kevin van Zonneveld <kevin@vanzonneveld.net>
* @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
* @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
* @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
*
* @param mixed   $in     String or long input to translate
* @param boolean $to_num Reverses translation when true
* @param mixed   $pad_up Number or boolean padds the result up to a specified length
*
* @return mixed string or long
*/
function alphaID($in, $to_num = false, $pad_up = false) {
// Letras que ser�o usadas no �ndice textual
$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$base  = strlen($index);
if ($to_num) {
// Tradu��o de texto para n�mero
$in  = strrev($in);
$out = 0;
$len = strlen($in) - 1;
for ($t = 0; $t <= $len; $t++) {
$bcpow = bcpow($base, $len - $t);
$out   = $out + strpos($index, substr($in, $t, 1)) * $bcpow;
}
if (is_numeric($pad_up)) {
$pad_up--;
if ($pad_up > 0) {
$out -= pow($base, $pad_up);
}
}
} else {
// Tradu��o de n�mero para texto
if (is_numeric($pad_up)) {
$pad_up--;
if ($pad_up > 0) {
$in += pow($base, $pad_up);
}
}
$out = "";
for ($t = floor(log10($in) / log10($base)); $t >= 0; $t--) {
$a   = floor($in / bcpow($base, $t));
$out = $out . substr($index, $a, 1);
$in  = $in - ($a * bcpow($base, $t));
}
$out = strrev($out);
}
return $out;
}
/**
* Fun��o para gerar senhas aleat�rias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se ter� letras mai�sculas
* @param boolean $numeros Se ter� n�meros
* @param boolean $simbolos Se ter� s�mbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234567890';
$simb = '!@#$%*-';
$retorno = '';
$caracteres = '';
$caracteres .= $lmin;
if ($maiusculas) $caracteres .= $lmai;
if ($numeros) $caracteres .= $num;
if ($simbolos) $caracteres .= $simb;
$len = strlen($caracteres);
for ($n = 1; $n <= $tamanho; $n++) {
$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}
function criarurl($valor){
setcookie('url', '$valor');
}
require_once('log.php');
?>


