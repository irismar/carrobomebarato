<?
 require_once('Connections/repasses.php');
if (!isset($_GET['lat'])){ ?>
<body onLoad="getPosition()"><script>  function getPosition(){
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
      var erroDescricao = 'Ops, ';
      switch( erro.code ) {
        case erro.PERMISSION_DENIED:
          erroDescricao += 'usuário não autorizou a Geolocation.';
        break;
        case erro.POSITION_UNAVAILABLE:
          erroDescricao += 'localização indisponível.';
        break;
        case erro.TIMEOUT:
          erroDescricao += 'tempo expirado.';
        break;
        case erro.UNKNOWN_ERROR:
         erroDescricao += 'não sei o que foi, mas deu erro!';
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
 $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".trim($_GET['lat']).",".trim($_GET['long'])."&sensor=true?key=AIzaSyBrUxPCMJ9d_ki8jMz12Wh6xcTg_FHVK5k";
      $data = @file_get_contents($url);
    $jsondata = json_decode($data,true);
    if(is_array($jsondata) && $jsondata['status'] == "OK")
    {
     // street
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("route", $address["types"])) {
       $rua = $address["long_name"];
        }
    }
}
// city
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("locality", $address["types"])) {
     $cidade = $address["long_name"];
		
        }
    }
}
// country
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("administrative_area_level_1", $address["types"])) {
      $estado= $address["long_name"];
	
	  $estado = str_replace("State of", " ",   $estado);
	          }
    }
}

foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("country", $address["types"])) {
        $pais= $address["long_name"];
        }
    }
}
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("postal_code", $address["types"])) {
       $cep= $address["long_name"];
        }
    }
}

   
   }
       
  
     }
     
     if(isset($_SESSION['id'])){
if(isset($_GET['novo_endereco'])){   
   $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".trim($_GET['lat']).",".trim($_GET['long'])."&sensor=true?key=AIzaSyBrUxPCMJ9d_ki8jMz12Wh6xcTg_FHVK5k";
      $data = @file_get_contents($url);
    $jsondata = json_decode($data,true);
    if(is_array($jsondata) && $jsondata['status'] == "OK")
    {
     // street
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("route", $address["types"])) {
      $rua = $address["long_name"];
        }
    }
}
// city
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("locality", $address["types"])) {
      $cidade = $address["long_name"];
		
        }
    }
}
// country
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("administrative_area_level_1", $address["types"])) {
      $estado= $address["long_name"];
	
	 $estado = str_replace("State of", " ",   $estado);
	          }
    }
}

foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("country", $address["types"])) {
        $pais= $address["long_name"];
        }
    }
}
foreach ($jsondata["results"] as $result) {
    foreach ($result["address_components"] as $address) {
        if (in_array("postal_code", $address["types"])) {
       $cep= $address["long_name"];
        }
    }
}

   
   } 
    $_SESSION['id'];
   $_GET['novo_endereco'];
        
     $mysql->query( "UPDATE membros SET endereco='".$_GET['novo_endereco']."' ,  cidade='".$cidade."',  estado='".$estado."' ,lat='".$_GET['lat']."' ,log='".$_GET['long']."'  WHERE id =".$_SESSION['id']."");
     $mysql->query( "UPDATE estoque SET endereco='".$_GET['novo_endereco']."' ,  cidade='".$cidade."',  estado='".$estado."' ,lat='".$_GET['lat']."' ,lon='".$_GET['long']."'  WHERE id_membro =".$_SESSION['id']."");
    $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "alterou sue endereços com sucesso ";
    @salvaLog($mensagem);
   ?> <script language= "JavaScript">
location.href="<?  echo URL::getBase().$_SESSION['usuario']; ?>"
</script><?
	exit();
  
    
     }}	 
	 ?>
