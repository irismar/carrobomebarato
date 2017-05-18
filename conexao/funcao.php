<?php 
  
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Araguaina');
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
$data_extenso= strftime('%A, %d de %B de %Y', strtotime('today'));
$data_extenso=utf8_encode( $data_extenso);
$_UP['extensoes'] = array('jpg', 'png', 'gif','pdf','mp3','doc','xml','mp4','jpeg', 'GIF', 'PNG', 'Bitmap', 'TIFF', 'RAW', 'SVG' );
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
function tamanhoArquivo($arquivo){
 $patch = "arquivos/";
              
       $tamanho = filesize($patch.$arquivo);
   
       $kb = 1024;
       $mb = 1048576;
       $gb = 1073741824;
      $tb = 1099511627776;

       if($tamanho<$kb){
    
         echo($tamanho." bytes");
  
       }else if($tamanho>=$kb&&$tamanho<$mb){
 
         $kilo = number_format($tamanho/$kb,2);
    
         echo($kilo." KB");
  
       }else if($tamanho>=$mb&&$tamanho<$gb){
     
        $mega = number_format($tamanho/$mb,2);
  
         echo($mega." MB");
  
       }else if($tamanho>=$gb&&$tamanho<$tb){
      
        $giga = number_format($tamanho/$gb,2);
     
        echo($giga." GB");
      }

  } 


?><? function IsLoggedIn()
{
	return (@$_SESSION["Status"] == "repasses");
}


function som_data($data, $dias)
{
		$data_e = explode(".",$data);
		$data2 = date("m.d.Y", mktime(0,0,0,$data_e[1],$data_e[0] + $dias,$data_e[2]));
		$data2_e = explode(".",$data2);
		$data_final = $data2_e[2] . "-" . $data2_e[0] . "-" . $data2_e[1];
		return $data_final;
}
function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
function conta_dias($data_inicial){
$data_final =  date('d/m/Y');

$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferença de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferença de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
// Exibe uma mensagem de resultado:
 "A diferença entre as datas ".$data_inicial." e ".$data_final." é de <strong>".$dias."</strong> dias";
// A diferença entre as datas 23/03/2009 e 04/11/2009 é de 225 dias
return $dias;
}
function FormataData($data) {  
	$novadata = strftime("%d.%m.%Y",strtotime($data));
	return $novadata;
}
function data($data,$formato=24){
    $hora = $formato == 12 ? "h" : "H";
    $am_pm = (date("H",strtotime($data)) < 12) ? " AM" : " PM";
    $am_pm = $formato == 24 ? "" : $am_pm;
    if(date('d/m/Y', strtotime($data)) == date('d/m/Y')){
        return "Hoje às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else if(date('m/Y', strtotime($data)) == date('m/Y') && date("d", strtotime($data)) == date("d")-1){
        return "Ontem às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else if(date('m/Y', strtotime($data)) == date('m/Y') && date("d", strtotime($data)) == date("d")+1){
        return "Amanha às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else{ 
        return date("d/m/Y",strtotime($data));
    }
}
function FormataData2($data) {
	$novadata = strftime("%d/%m/%Y",strtotime($data));
	return $novadata;
}
function FormataData4($data){
    return  date("Y-m-d",strtotime($data));//formata para a-m-d
}
function FormataData3($data) {
	$novadata = strftime("%y/%m/%d",strtotime($data));
	return $novadata;}
function FormataData5($data){
    return  date("Y-m-d",strtotime($data));//formata para a-m-d
}	
function FormataData6($data){
    return  date("d-m-Y H:i:s",strtotime($data));//formata para a-m-d
}	
function anti_sql_injection($str) {
    if (!is_numeric($str)) {
        $str = get_magic_quotes_gpc() ? stripslashes($str) : $str;
        $str = function_exists('mysql_real_escape_string') ? mysql_real_escape_string($str) : mysql_escape_string($str);
    }
    return $str;
}
  function anti_injection($sql) {
	
 
	  
	  
        
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
   $modulo = str_replace("&eac", "é",   $modulo);
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
   "ê" => "e",
   "ó" => "o",
   "í" => "i",
   "nº" => "n",
   "," => "",
   "," => "",
   "í" => "i",
   "ç" => "c",
   "ã" => "a",
	"ê" => "e",
   "é" => "e",
   "í" => "i" 
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
function palavras( $contar_silabas) {
$vogais = array('a','e','i','o','u');
$consoantes = array('b','c','d','f','g','h','nh','lh','ch',
'j','k','l','m','n','p','qu','r','rr',
's','ss','t','v','w','x','y','z',);

$palavra = '';
$tamanho_palavra = rand(2,5);
$contar_silabas ;
while($contar_silabas < $tamanho_palavra){
   $vogal = $vogais[rand(0,count($vogais)-1)];
   $consoante = $consoantes[rand(0,count($consoantes)-1)];
   $silaba = $consoante.$vogal;
   $palavra .=$silaba;
   $contar_silabas++;
   unset($vogal,$consoante,$silaba);
}
echo "<h3> $palavra</h3>";
unset($vogais,$consoantes,$palavra,$tamanho_palavra,$contar_silabas);
}
function geraSenha($tamanho ="50", $maiusculas = false, $numeros = false, $simbolos = false)
{
$lmin = 'abcdefghijklmnopqrstuvwxyz';
$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num = '1234';
$simb = '';
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
/**
 * Valida CPF
 *
 * @author Luiz Otávio Miranda <contato@todoespacoonline.com/w>
 * @param string $cpf O CPF com ou sem pontos e traço
 * @return bool True para CPF correto - False para CPF incorreto
 *
 */
function valida_cpf( $cpf = false ) {
    // Exemplo de CPF: 025.462.884-23
    
    /**
     * Multiplica dígitos vezes posições 
     *
     * @param string $digitos Os digitos desejados
     * @param int $posicoes A posição que vai iniciar a regressão
     * @param int $soma_digitos A soma das multiplicações entre posições e dígitos
     * @return int Os dígitos enviados concatenados com o último dígito
     *
     */
    if ( ! function_exists('calc_digitos_posicoes') ) {
        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
            // Faz a soma dos dígitos com a posição
            // Ex. para 10 posições: 
            //   0    2    5    4    6    2    8    8   4
            // x10   x9   x8   x7   x6   x5   x4   x3  x2
            //   0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
                $posicoes--;
            }
     
            // Captura o resto da divisão entre $soma_digitos dividido por 11
            // Ex.: 196 % 11 = 9
            $soma_digitos = $soma_digitos % 11;
     
            // Verifica se $soma_digitos é menor que 2
            if ( $soma_digitos < 2 ) {
                // $soma_digitos agora será zero
                $soma_digitos = 0;
            } else {
                // Se for maior que 2, o resultado é 11 menos $soma_digitos
                // Ex.: 11 - 9 = 2
                // Nosso dígito procurado é 2
                $soma_digitos = 11 - $soma_digitos;
            }
     
            // Concatena mais um dígito aos primeiro nove dígitos
            // Ex.: 025462884 + 2 = 0254628842
            $cpf = $digitos . $soma_digitos;
            
            // Retorna
            return $cpf;
        }
    }
    
    // Verifica se o CPF foi enviado
    if ( ! $cpf ) {
        return false;
    }
 
    // Remove tudo que não é número do CPF
    // Ex.: 025.462.884-23 = 02546288423
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
 
    // Verifica se o CPF tem 11 caracteres
    // Ex.: 02546288423 = 11 números
    if ( strlen( $cpf ) != 11 ) {
        return false;
    }   
 
    // Captura os 9 primeiros dígitos do CPF
    // Ex.: 02546288423 = 025462884
    $digitos = substr($cpf, 0, 9);
    
    // Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
    $novo_cpf = calc_digitos_posicoes( $digitos );
    
    // Faz o cálculo dos 10 dígitos do CPF para obter o último dígito
    $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
    
    // Verifica se o novo CPF gerado é idêntico ao CPF enviado
    if ( $novo_cpf === $cpf ) {
        // CPF válido
        return true;
    } else {
        // CPF inválido
        return false;
    }
}
?>	
<script type="text/javascript">

function limita(str,limite) {
   nova='';
   for(i=0;i<limite;i++) {
      nova+=str.substr(i,1);
   }
   return nova;
}
</script>
<?  

function filtro($mensagem)
{
if ($mensagem) {
	$mysql= new mysqli('localhost','root','', 'u557658549_conc');
// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

$sql = "SELECT * FROM filtro_palavras";
$query = $mysql->query($sql);
while ($mostra = $query->fetch_assoc()) {
$mensagem= str_replace($mostra['MsgErrada'], $mostra['MsgCorreta'], $mensagem);
}
}
return $mensagem;
}

	
	 ?>