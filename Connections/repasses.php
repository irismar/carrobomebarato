<?  /* ### <a href="http://charlescorrea.com.br/blog/tag/gravando-log-de-erro">GRAVANDO LOG DE ERRO</a>  ### */
mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');
 
/* ### GRAVANDO LOG DE ERRO  ### */
header('Content-Type: text/html; charset=utf-8');
 @session_start();
 
 if( !isset($_SESSION['segure'])){
$_SESSION['segure']= md5(time()); }

$hora = date('Y-m-d H:i:s');
$data = date('Y-m-d');
// Conecta-se ao banco de dados MySQL
//$mysql= new mysqli('localhost','root','', 'carros');
$mysql= new mysqli('localhost','root','', 'u386698969_carro');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());
/*Define constant to connect to database */
DEFINE('DATABASE_USER', 'root');
DEFINE('DATABASE_PASSWORD', '');
DEFINE('DATABASE_HOST', 'localhost');
DEFINE('DATABASE_NAME', 'u386698969_carro');



// Make the connection:
$dbc = @mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD,
    DATABASE_NAME);

if (!$dbc) {
    trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}


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
    $distancia=number_format($d, 1, ',','.');
	
	return $distancia;
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
/////////////remover acento/////////////
function url($variavel){

trim($variavel);

$string = strtolower( ereg_replace("[^a-zA-Z0-9-]", "", strtr(utf8_decode(trim($variavel)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC")) );

  return $string;
}// ceu-azul

/////////////remover acento fim////////
 
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
function removeAcentos($string) {
	$string= trim($string);
	
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "a", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`&#@]/", "", $string);
    $string = preg_replace("/ /", "", $string);

	
    return $string;
}
function tirarAcentos1($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(Ç|ç)/","/[][><}{)(:;,!?*%~^`&#@]/","/ /"),explode(" ","a A e E i I o O u U n N c "),$string);
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

function checkTagPHP($linhas){
   $php = NULL; 
   foreach ($linhas as $linha) {
      $aber = strrpos($linha, '<?php');
      $fech = strrpos($linha, '?>');

      if ($aber > -1 && $fech > -1)
        $php = ($fech < $aber);
      else if ($aber > -1)
        $php = TRUE;
      else if ($fech > -1)
        $php = FALSE;
   }
   return $php;
}
//$php = checkTagPHP($arrayDeLinhasDoCodigo);
// Após o loop
// $php == NULL  -> Não existe tag PHP no código
// $php == TRUE  -> Tag PHP aberta
// $php == FALSE -> Tag PHP Fechada

    function verificaPalavroes($string){

        // Retira espaços, hífens e pontuações da String

        $arrayRemover = array( '.', '-', ' ' );

        $arrayNormal = array( "", "", "" );

        $normal = str_replace($arrayRemover, $arrayNormal, $string);

        

        // Remove os acentos da string

        $de = 'àáãâéêíóõôúüç';

        $para   = 'aaaaeeiooouuc';

        $string_final = strtr(strtolower($normal), $de, $para);

        

        // Array em Filtro de Palavrões

        $array = array('arrombado',

                       'arrombada',

                       'buceta',

                       'boceta',

                       'bocetao',

                       'bucetinha',

                       'bucetao',

                       'bucetaum',

                       'blowjob',

                       '#@?$%~',

                       'caralinho',

                       'caralhao',

                       'caralhaum',

                       'caralhex',

                       'c*',

                       'cacete',

                       'cacetinho',

                       'cacetao',

                       'cacetaum',

                       'epenis',

                       'foder',

                       'f****',

                       'fodase',

                       'fodasi',

                       'fodassi',

                       'fodassa',

                       'fodinha',

                       'fodao',

                       'fodaum',

                       'foda1',

                       'fodona',

                       'f***',

                       'fodeu',

                       'fodasse',

                       'fuckoff',

                       'fuckyou',

                       'fuck',

                       'filhodaputa',

                       'filhadaputa',

                       'gozo',

                       'gozar',

                       'gozada',

                       'gozadanacara',

                       'm*****',

                       'merdao',

                       'merdaum',

                       'merdinha',

                       'vadia',

                       'vasefoder',

                       'venhasefoder',

                       'voufoder',

                       'vasefuder',

                       'venhasefuder',

                       'voufuder',

                       'vaisefoder',

                       'vaisefuder',

                       'venhasefuder',

                       'vaisifude',

                       'v****',

                       'vaisifuder',

                       'vasifuder',

                       'vasefuder',

                       'vasefoder',
                       'Viado',' tu é um viado ',' vai tomar no cú caralho','tu é um viado ',


                       'pirigueti',

                       'piriguete',

                       'p****',

                       'porraloca',

                       'porraloka',

                       'porranacara',

                       '#@?$%~',

                       'putinha',

                       'putona',

                       'putassa',

                       'putao',

                       'punheta',

                       'putamerda',

                       'putaquepariu',

                       'putaquemepariu',

                       'putaquetepariu',

                       'putavadia',

                       'pqp',

                       'putaqpariu',

                       'putaqpario',

                       'putaqparil',

                       'peido',

                       'peidar',

                       'xoxota',

                       'xota',

                       'xoxotinha',

                       'xoxotona'

            );



        if(in_array($string_final, $array)){

            return true;

        } else {

            return false;

        }

    }

function distancia2($lat1, $lon1, $lat2, $lon2, $unit) {

$theta = $lon1 - $lon2;
$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
$dist = acos($dist);
$dist = rad2deg($dist);
$miles = $dist * 60 * 1.1515;
$unit = strtoupper($unit);

if ($unit == "K") {
return ($miles * 1.609344);
} else if ($unit == "N") {
return ($miles * 0.8684);
} else {
return $miles;
}
}
function getrealip()
{
if (isset($_SERVER)){
if(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
if(strpos($ip,",")){
$exp_ip = explode(",",$ip);
$ip = $exp_ip[0];
}
}else if(isset($_SERVER["HTTP_CLIENT_IP"])){
$ip = $_SERVER["HTTP_CLIENT_IP"];
}else{
$ip = $_SERVER["REMOTE_ADDR"];
}
}else{
if(getenv('HTTP_X_FORWARDED_FOR')){
$ip = getenv('HTTP_X_FORWARDED_FOR');
if(strpos($ip,",")){
$exp_ip=explode(",",$ip);
$ip = $exp_ip[0];
}
}else if(getenv('HTTP_CLIENT_IP')){
$ip = getenv('HTTP_CLIENT_IP');
}else {
$ip = getenv('REMOTE_ADDR');
}
}
return $ip; 
}
function segurancastring($s) {
$s = addslashes($s);
$s = htmlspecialchars($s);
$s = mysql_escape_string($s);
$s = str_ireplace("SELECT","",$s);
$s = str_ireplace("FROM","",$s);
$s = str_ireplace("WHERE","",$s);
$s = str_ireplace("INSERT","",$s);
$s = str_ireplace("UPDATE","",$s);
$s = str_ireplace("DELETE","",$s);
$s = str_ireplace("DROP","",$s);
$s = str_ireplace("*","",$s);
$s = str_ireplace("&","",$s);
$s = str_ireplace("=","",$s);
$s = str_ireplace("DATABASE","",$s);
$s = str_ireplace("USE","",$s);
return $s;}
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
  $conect= new mysqli('localhost','root','', 'u386698969_carro');
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
function calculardias($data) {
          $data_inicial =FormataData($data);
$data_final = date('d.m.Y');
// Cria uma fun��o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun��o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen�a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen�a de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
// Exibe uma mensagem de resultado:


if($dias == 0) {return "Hoje";}
	if($dias == 1) {return "Ontem";}
   


	if($dias < 7 ) {
		return $dias . " dias ";
	}
	else {
		if($dias < 30) {
			return round($dias / 7) . " semana(s) ";
		}
		else {
			if($dias < 365) {
				return round($dias / 30) . " mês(es) ";
			}
			else {
				return round($dias / 365) . " ano(s) ";
			}
		}
	}

}
function calculardiasvenda($data,$datavenda) {
          $data_inicial =FormataData($data);
$data_final =FormataData($datavenda);
// Cria uma fun��o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun��o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen�a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen�a de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
// Exibe uma mensagem de resultado:

 echo "Vendido em"."&nbsp;" .$dias ."&nbsp;". "DIAS";
}
function deletarmensagem_eurementente($delet,$usuario,$id_usuario){

       $deletar = "DELETE FROM propostas WHERE id = ".$delet." AND remetene='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error());
       }
function deletarmensagem_eudestinatario($delet,$usuario,$id_usuario){

       $deletar = "DELETE FROM propostas WHERE id = ".$delet." AND Destinatario='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error());
       }	   
	   function deletartodasmensagem($delet,$usuario,$id_usuario){
       $deletar = "DELETE FROM propostas WHERE id_estoque = ".$delet." AND Destinatario='".$usuario."' OR   remetene='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error()); }	
	   function deletartodasvisitas($delet){
       $deletar = "DELETE FROM acessos WHERE id_estoque = ".$delet." ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());}	
function maisdias($vendido){ 
 $data = date('Y-m-d');
 $view = "UPDATE estoque SET data_cadastro='".$data."'  WHERE Id_estoque = ".$vendido."";
 $executa = mysql_query($view) or die(mysql_error());
	
  } 
function gostei($busca){ 
$atualizar=$mysql->query("UPDATE estoque SET gostei= gostei+1 WHERE  Id_estoque=". $busca."");
	  } 
	  function naogostei($busca){ 
$mysql->query("UPDATE estoque SET naogostei = naogostei+1 WHERE  Id_estoque=". $busca."");
	  } //grama a função vendido//	      
function vendido($vendido,$quem){
$data = date('Y-m-d');
       $mysql->query=( "UPDATE estoque SET  vendido='SIM',datavenda='".$data."'  WHERE Id_estoque = ".$vendido." ");
       $mysql->query=( "UPDATE membros SET carros= -1 WHERE id = ".$quem."");
       
}
function faleconosco($nome,$email,$mensagem,$setor){
  $data=date('Y-m-d');
$updateSQL = "INSERT INTO faleconosco(nome,email,mensagem,setor,hora )
		VALUES ('".$nome."','".$email."','".$mensagem."','".$setor."','".$hora."')";
		 $Result2 = mysql_query($updateSQL) or die(mysql_error());
		
if($updateSQL) {
    echo "Mensagem enviada com sucesso ";
    $mensagem =$_POST['nome'] ."Enviou mensagem para administrador com sucesso" ;
	@salvaLog($mensagem);
    header("Location: enviar.php?prok");
	exit();				

	 }
}
function selecionar ($tabela,$ordem){
     $query_login =   "SELECT *  FROM  '".$tabela."'	 ORDER BY '".$ordem."' DESC";
	 $login = mysql_query($query_login) or die(mysql_error());
	 $row_selecionar = mysql_fetch_assoc($login);
	 $totalRows_login = mysql_num_rows($login);}
	 
	 
function verificar($tabele, $linha,$criterio1,$criterio2,$criterio3){
$sql = "SELECT ".$linha." FROM ".$tabele."	WHERE   modelotexto LIKE '%".$modulo."%'	AND estado= '".$_SESSION['estado']."' AND cidade='".$_SESSION['cidade']."' ORDER BY Id_estoque DESC LIMIT 999";
  $query = $mysql->query($sql);
  $query->num_rows;
	if ($query->num_rows  != '0') { 
	$_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". " AND estado="."'".$_SESSION['estado']."'". " AND cidade="."'".$_SESSION['cidade']."'"; 
	require_once"membro.php";	exit(); }
}	 
       ?>
