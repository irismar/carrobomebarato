<?php
    include("class.ipdetails.php");
    $ip = $_SERVER['REMOTE_ADDR'];  

$http_client_ip       = $_SERVER['HTTP_CLIENT_IP'];
$http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
$remote_addr          = $_SERVER['REMOTE_ADDR'];
 
/* VERIFICO SE O IP REALMENTE EXISTE NA INTERNET */
if(!empty($http_client_ip)){
    $ip = $http_client_ip;
    /* VERIFICO SE O ACESSO PARTIU DE UM SERVIDOR PROXY */
} elseif(!empty($http_x_forwarded_for)){
    $ip = $http_x_forwarded_for;
} else {
    /* CASO EU NÃO ENCONTRE NAS DUAS OUTRAS MANEIRAS, RECUPERO DA FORMA TRADICIONAL */
    $ip = $remote_addr;
}
 
echo $ip;
 

function get_client_ip() {
     $ipaddress = '';
     if ($_SERVER['HTTP_CLIENT_IP'])
         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
     else if(@$_SERVER['HTTP_X_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
     else if(@$_SERVER['HTTP_X_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
     else if(@$_SERVER['HTTP_FORWARDED_FOR'])
         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
     else if(@$_SERVER['HTTP_FORWARDED'])
         $ipaddress = $_SERVER['HTTP_FORWARDED'];
     else if(@$_SERVER['REMOTE_ADDR'])
         $ipaddress = $_SERVER['REMOTE_ADDR'];
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}
  $ip=get_client_ip();   
    
    $ipdetails = new ipdetails($ip); 
    $ipdetails->scan();
    echo "<b>IP:</b>        ".$ip                        ."<br />"; 
    echo "<b>Pa�s:</b>      ".$ipdetails->get_country()  ."<br />";
    echo "<b>Estado:</b>    ".$ipdetails->get_region()   ."<br />";
    echo "<b>Cidade:</b>    ".$ipdetails->get_city()     ."<br />";
    echo "<b>Latitude:</b>  ".$ipdetails->get_latitude() ."<br />";
    echo "<b>Longitude:</b> ".$ipdetails->get_longitude()."<br />";
    echo "<b>C�digo pa�s:</b> ".$ipdetails->get_countrycode()."<br />";
    echo "<b>C�digo continente:</b> ".$ipdetails->get_continentcode()."<br />";
    echo "<b>C�digo moeda:</b> ".$ipdetails->get_currencycode()."<br />";
    echo "<b>S�mbolo moeda:</b> ".htmlspecialchars_decode($ipdetails->get_currencysymbol())."<br />";
    echo "<b>Cota��o moeda (d�lar):</b> ".$ipdetails->get_currencyconverter()."<br />";    
?>