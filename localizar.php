<? if(!isset($_SESSION['cidade']) AND  !isset($_SESSION['estado']) ){



 if (!isset($_GET['ip']) AND (!isset($_GET['long']))  ){ ////se for home e não nem get ip nem long buscar latitude ouerro ?>
<body onLoad="getLocation()">
<p id="demo"></p>
<button onClick="getLocation()"></button>
<div id="mapholder"></div>
<script>
var x=document.getElementById("demo");
function getLocation()
{
if (navigator.geolocation)
{
navigator.geolocation.getCurrentPosition(showPosition,showError);
}
else{x.innerHTML="Geolocation is not supported by this browser.";}
}

function showPosition(position)
{
var latlon=position.coords.latitude+","+position.coords.longitude;
window.location='?lat=' +posicao.coords.latitude+'&long='+posicao.coords.longitude;
	exit();
}

function showError(error)
{
switch(error.code)
{
case error.PERMISSION_DENIED:
x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
window.location='?ip=onload';
	exit();
break;
case error.POSITION_UNAVAILABLE:
x.innerHTML="Localização indisponível."
break;
case error.TIMEOUT:
x.innerHTML="O tempo da requisição expirou."
break;
case error.UNKNOWN_ERROR:
x.innerHTML="Algum erro desconhecido aconteceu."
break;
}
}
</script>
</body>
</html>


<script> 
 function getPosition(){
  // Verifica se o browser do usuario tem suporte a geolocation
  if ( navigator.geolocation ){
    navigator.geolocation.getCurrentPosition( 
    // sucesso! 
    function( posicao ){
    console.log( posicao.coords.latitude, posicao.coords.longitude );
	window.location='?lat=' +posicao.coords.latitude+'&long='+posicao.coords.longitude;
	exit();
    },
    // erro :(
    function ( erro ){
      var erroDescricao ='Ops, ';
      switch( erro.code ) {
        case erro.PERMISSION_DENIED:
          erroDescricao +='usuário não autorizou a Geolocation.';
        break;
        case erro.POSITION_UNAVAILABLE:
          erroDescricao +='localização indisponível.';
        break;
        case erro.TIMEOUT:
          erroDescricao +='tempo expirado.';
        break;
        case erro.UNKNOWN_ERROR:
         erroDescricao +='não sei o que foi, mas deu erro!';
        break;
      }
      console.log( erroDescricao )
    }
   );
  }
}
 
$( document ).ready( function(){
  getPosition();
} );
</script>


<? 
}else{

	if (isset($_GET['ip'])) { ///////////abre if get ip/////

    include_once('netgeo.class.php'); 

    netGeo::getNetGeo(); 
   @$_SESSION['lat']=trim(netGeo::$Latitude);
	  @$_SESSION['log']=trim( netGeo::$Longitude);
}
if (isset($_GET['long'])){
 ///////////abre if get ip/////
	 $_SESSION['lat']=number_format(trim($_GET['lat']), 6, '.', ' ');
	@$_SESSION['log']=number_format(trim($_GET['long']), 6, '.', ' ');

    
}

 @$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".$_SESSION['lat'].",".$_SESSION['log']."&sensor=true?key=AIzaSyBrUxPCMJ9d_ki8jMz12Wh6xcTg_FHVK5k";
      $data = @file_get_contents($url);
    $jsondata = json_decode($data,true);
    if(is_array($jsondata) && $jsondata['status'] == "OK")
    {
     // street
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("route", $address["types"])) {
         $rua = trim($address["long_name"]);
        }
    }
}
// city
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("locality", $address["types"])) {
        $cidade = trim($address["long_name"]);
		 $_SESSION['cidade']= $cidade;
        }
    }
}
// country
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("administrative_area_level_1", $address["types"])) {
      $estado= $address["long_name"];
	  $estado = trim(str_replace("State of", " ",   $estado));
	  $_SESSION['estado']= $estado ;
	          }
    }
}

foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("country", $address["types"])) {
        $_SESSION['pais']=$pais= trim($address["long_name"]);
        }
    }
}




foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("postal_code", $address["types"])) {
         $cep=trim( $address["long_name"]);
		  @$_SESSION['endereco1']= $_SESSION['rua'].'&nbsp;&nbsp;'.$_SESSION['cidade'].'&nbsp;&nbsp;'.$_SESSION['estado'].'&nbsp;&nbsp;'.$_SESSION['pais'].'&nbsp;&nbsp;'.$_SESSION['cep'];

        }
    }
}

   
   }
       
  
     }

	 
	

} ?>