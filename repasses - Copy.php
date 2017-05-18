<?php 
header('Content-Type: text/html; charset=utf-8');
 @session_start();
$hora = date('Y-m-d H:i:s');
$data = date('Y-m-d');


// Conecta-se ao banco de dados MySQL
//$mysql= new mysqli('utf8','root','', 'carros');
$mysql= new mysqli('utf8','root','', 'u386698969_carro');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

/**
 * PHP e MySQL para iniciantes
 *
 * Arquivo que faz a conex�o com o banco de dados utilizando MySQLi
 *
 * PHP 5+, MySQL 4.1+
 *
 * @author Thiago Belem <contato@thiagobelem.net>
 * @link /mysql/php-e-mysql-para-iniciantes-consulta-simples/
 */

// Dados de acesso ao servidor MySQL

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
		$data_extenso = date("m.d.Y", mktime(0,0,0,$data_e[1],$data_e[0] + $dias,$data_e[2]));
		$data_extenso_e = explode(".",$data_extenso);
		$data_final = $data_extenso_e[2] . "-" . $data_extenso_e[0] . "-" . $data_extenso_e[1];
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
	$data_extenso = date("m/d/Y", mktime(0,0,0,$data_e[1],$data_e[0] - $dias,$data_e[2]));
	$data_extenso_e = explode("/",$data_extenso);
	$data_final = $data_extenso_e[1] . "/". $data_extenso_e[0] . "/" . $data_extenso_e[2];
	return $data_final;
}
function modificadata($valor) {
	$novadata = explode("/",$valor);
	$data_extenso = $novadata[2] . "-" . $novadata[1] . "-" . $novadata[0];
	return $data_extenso;
}
 
/////////////////////////////////função para calcular distancia entre duas cordenadas ///////////
function freegeoip_locate($ip) {
    $url = "http://freegeoip.net/json/".$ip;
    $geo = json_decode(file_get_contents($url), true);
    return $geo;
}
// Get Distance between two lat/lng points using the Haversine function
// First published by Roger Sinnott in Sky & Telescope magazine in 1984 (“Virtues of the Haversine”)
//
function distancia( $lat1, $lon1, $lat2, $lon2) 
{
    $R = 6371;  // Radius of the Earth in Km

  // Convert degress to radians and get the distance between the latitude and longitude pairs
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

  // Calculate the angle between the points
    @ $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $R * $c;

  // Distance in Kilometers
    return $d;
}


///////////////verção functin public 
class HaverSign {

     public static function getDistance($latitude1, $longitude1, $latitude2, $longitude2) {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
}
}

///////////////////////////////////fim funcao para calcular distancia///////////////////////////
	
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
die ("<script>alert('Sem permi??o de acesso !')</script>");
}
}


//	 $_SESSION["telefone"] =$dados

 
// Define uma fun??o que poder? ser usada para validar e-mails usando regexp
function validaEmail($email){
    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
    if (preg_match($er, $email)){
	return true;
    } else {
	return false;
    }
}


function acento($modulo) {
   $modulo = str_replace("%C3%A9", "e",   $modulo);
   $modulo = str_replace("%C3%A3", "a",   $modulo);
   $modulo = str_replace("%C3%AD", "i",   $modulo);
    $modulo = str_replace("&atilde;o", "ao",$modulo);
	  $modulo = str_replace("%C3%A9", "?",   $modulo);
   $modulo = str_replace("%C3%A3", "?",   $modulo);
   $modulo = str_replace("%C3%AD", "?",   $modulo);
   $modulo = str_replace("%C3%A3o", "?o",   $modulo);
    $modulo = str_replace("%20", " ",   $modulo);
	$modulo = str_replace("?", "e",   $modulo);
	$modulo = str_replace("?o", "ao",   $modulo);
	$modulo = str_replace("%C3%A1", "",   $modulo);
	$modulo = str_replace("ð", "u",   $modulo);
  $modulo = str_replace("?", "a",   $modulo);
  $modulo = str_replace("?", "a",   $modulo);
    $modulo = str_replace("�", "a",   $modulo);
  $modulo = str_replace("�", "a",   $modulo);
  $modulo = str_replace("?", "",   $modulo);
  $modulo = str_replace(" ç?", "�",   $modulo);
  $modulo = str_replace("é?", "�",   $modulo);
  $modulo = str_replace("ã?", "�",   $modulo);
  $modulo = str_replace("ê?", "�",   $modulo);
   $modulo = str_replace("a%A3?", "�",   $modulo);
 
   
  //Ford    - Preço    + Novo    Santa Inês Maranhao Brasil
  
    return $modulo;
}
function corigir($texto){
  $map = array(
   "ê" => "�",
	 
);
 return strtr($texto,$map);
}
function retira_acentos($texto){
  $map = array(
    '�' => 'a',
    '�' => 'a',
    '�' => 'a',
    '�' => 'a',
    '�' => 'e',
    '�' => 'e',
    '�' => 'i',
    '�' => 'o',
    '�' => 'o',
    '�' => 'o',
    '�' => 'u',
    '�' => 'u',
    '�' => 'c',
    '�' => 'A',
    '�' => 'A',
    '�' => 'A',
    '�' => 'A',
    '�' => 'E',
    '�' => 'E',
    '�' => 'I',
    '�' => 'O',
    '�' => 'O',
    '�' => 'O',
    '�' => 'U',
    '�' => 'U',
    '�' => 'C',
     'A?'=>'a',
     '?o'=>'ao',
     '�' => ''
	 
);
 return strtr($texto,$map);
}
function removeAcentos($string, $slug = false) {
  $string = strtolower($string);
  // C�digo ASCII das vogais
  $ascii['a'] = range(224, 230);
  $ascii['e'] = range(232, 235);
  $ascii['i'] = range(236, 239);
  $ascii['o'] = array_merge(range(242, 246), array(240, 248));
  $ascii['u'] = range(249, 252);
  // C�digo ASCII dos outros caracteres
  $ascii['b'] = array(223);
  $ascii['c'] = array(231);
  $ascii['d'] = array(208);
  $ascii['n'] = array(241);
  $ascii['y'] = array(253, 255);
  foreach ($ascii as $key=>$item) {
    $acentos = '';
    foreach ($item AS $codigo) $acentos .= chr($codigo);
    $troca[$key] = '/['.$acentos.']/i';
  }
  $string = preg_replace(array_values($troca), array_keys($troca), $string);
  // Slug?
  if ($slug) {
    // Troca tudo que n�o for letra ou n�mero por um caractere ($slug)
    $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
    // Tira os caracteres ($slug) repetidos
    $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
    $string = trim($string, $slug);
  }
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
function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
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
throw new Exception( "Formato de data inv?lido");
break;
}
return checkdate($m, $d, $a);
}
$map = array(
    '�' => 'a',
    '�' => 'a',
    '�' => 'a',
    '�' => 'a',
    '�' => 'e',
    '�' => 'e',
    '�' => 'i',
    '�' => 'o',
    '�' => 'o',
    '�' => 'o',
    '�' => 'u',
    '�' => 'u',
    '�' => 'c',
    '�' => 'A',
    '�' => 'A',
    '�' => 'A',
    '�' => 'A',
    '�' => 'E',
    '�' => 'E',
    '�' => 'I',
    '�' => 'O',
    '�' => 'O',
    '�' => 'O',
    '�' => 'U',
    '�' => 'U',
    '�' => 'C'
);

/**
* Traduz n?meros para texto e vice-e-versa
*
* Traduz qualquer n?mero (at? 9007199254740992)
* para uma vers?o menor, usando letras:
* 9007199254740989 --> PpQXn7COf
*
* Especificando o segundo par?metro como true temos:
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
// Letras que ser?o usadas no ?ndice textual
$index = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$base  = strlen($index);
if ($to_num) {
// Tradu??o de texto para n?mero
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
// Tradu??o de n?mero para texto
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
* Fun??o para gerar senhas aleat?rias
*
* @author    Thiago Belem <contato@thiagobelem.net>
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se ter? letras mai?sculas
* @param boolean $numeros Se ter? n?meros
* @param boolean $simbolos Se ter? s?mbolos
*
* @return string A senha gerada
*/
function geraSenha($tamanho =" 3", $maiusculas = true, $numeros = true, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234';
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
function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}

function mascara_string($mascara,$string)
{
   $string = str_replace(" ","",$string);
   for($i=0;$i<strlen($string);$i++)
   {
      $mascara[strpos($mascara,"#")] = $string[$i];
   }
   return $mascara;
}
?>	



