        <link href="estilo.css" type="text/css" rel="stylesheet" /> 
<? require_once('Connections/repasses.php');
if(isset($_GET["mapa"])){
$sql = "SELECT * FROM estoque 	WHERE  id_estoque ='".$_GET["mapa"]."'";
}
if(isset($_GET["rumo"])){
	$sql = "SELECT * FROM estoque 	WHERE  id_membro ='".$_GET["rumo"]."'";
}
$query = $mysql->query($sql);
while($row = $query->fetch_assoc()) { 
 $endereco=$row['endereco'];
 $lat=$row['lat'];
 $lon=$row['lon'];
 $foto='<img src="galeriadefotos/peq/'.$row["foto_carro"].'" width="120" height="120">';
 $preco= "R$". '&nbsp;'.  @number_format(trim($row['preco']), 2, ',', '.');
  $modelo=$row['modelotexto'];
 }
 ?>
 
  <style type="text/css">
 body {  }
 #map { width: 1%; height: 0px; float:left; padding: 0px;}
 #map2 { width: 100%; height: 4px; float:left; padding: 0px;}
 #iw-container  .iw-title {
   font-family: 'Open Sans Condensed', sans-serif;
   font-size: 22px;
   font-weight: 400;
   padding: 10px;
   background-color: #48b5e9;
   color: white;
   margin: 1px;
   border-radius: 2px 2px 0 0; /* De acordo com o arredondamento dos cantos da infowindow por padrão. */
}
 </style><link rel="stylesheet" type="text/css" href="/css/estilo.css" />
 </style>
<script src="/Scripts/jquery-1.3.2.min.js" type="text/javascript" language="javascript"></script>
<html>
 <head>

 <script src="http://maps.google.com/maps/api/js?v=3&sensor=true" type="text/javascript"></script>
 
<!-- saved from url=(0060)http://www.botecodigital.info/exemplos/google_maps/mapa4.htm -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">.gm-style .gm-style-mtc label,.gm-style .gm-style-mtc div{font-weight:400}</style><link type="text/css" rel="stylesheet" href="./Exemplo Google Maps_files/css"><style type="text/css">.gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}</style><style type="text/css">@media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}</style><style type="text/css">.gm-style{font-family:Roboto,Arial,sans-serif;font-size:11px;font-weight:400;text-decoration:none}.gm-style img{max-width:none}</style>

    
    
    

<style type="text/css"></style>
    <script type="text/javascript">
		var map = null; 
    	function carregar(){
			var latlng = new google.maps.LatLng(<? echo $lat; ?>,<? echo $lon ; ?>);
			
    		var myOptions = {
      		zoom: 16,
      		center: latlng,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
    		};
		
			//criando o mapa
    		map = new google.maps.Map(document.getElementById("mapa"), myOptions);
    		

    		var praca = new google.maps.LatLng(<? echo $lat; ?>,<? echo $lon ; ?>);
    		marcadorPraca = new google.maps.Marker({
      			position: praca,
      			map: map,
      			title:'<? echo  $endereco; ?>',
  			});
  			
  			
  			var infowindow = new google.maps.InfoWindow({
    			content: '<?php echo $foto ; ?></br><?php echo $modelo ; ?></br><?php echo 'preço:'. $preco ; ?></br><?php echo 'Endereço:'.$endereco ; ?></br>'
			});
  			
  			google.maps.event.addListener(marcadorPraca, 'click', function(event) {
    			infowindow.open(map,marcadorPraca);
  			});
		
    	}
    	
    
  			
  			
  			
			
  	
		
    </script>
</head>
 


<!DOCTYPE html>
<html lang="pt-br">
    <head>
       
        <title>Carro Bome Barato Rota Gmaps</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
 <style type="text/css">
 

 </style>
    <body>
    <div class="container">
    <div class="col-md-6">    <legend>Criar rotas </legend>
                      <legend>este servirviço funciona perfeitamente apenas em celulares e GPS </legend><form method="post" action="map.php?vertora">
                <fieldset>
                    <legend>Criar rotas</legend>
                    
                    <div>
                        Endereço de partida:
                        <input type="text" id="txtEnderecoPartida" name="txtEnderecoPartida" />
                    </div>
                    
                    <div>
                     Endereço de chegada:
                        <input type="text" id="txtEnderecoChegada" name="txtEnderecoChegada"  value="<? echo $endereco;?>"/>
                    </div>
                    
                    <div>
                        <input type="submit" id="btnEnviar" name="btnEnviar" value="Criar Rota" />
                    </div>
                </fieldset>
            </form>
			 <div id="trajeto-texto"></div>  
    </div>
      <div class="col-md-6">
      <div id="mapa2"></div>
      </div>
  </div>
       
       </body></html>
 
        <script src="/js/jquery.min.js"></script>
		
        <!-- Maps API Javascript -->
        
 
        <!-- Arquivo de inicializa??o do mapa -->
		<script>
		var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

function initialize() {	
	directionsDisplay = new google.maps.DirectionsRenderer();
	var latlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo  $lon;?>);
	
    var options = {
        zoom: 10,
		center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	
	var praca = new google.maps.LatLng(<? echo $lat; ?>,<? echo $lon ; ?>);
    		marcadorPraca = new google.maps.Marker({
      			position: praca,
      			map: map,
      			title:'<? echo  $endereco; ?>',
  			});

    map = new google.maps.Map(document.getElementById("mapa2"), options);
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById("trajeto-texto"));
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {

			pontoPadrao = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			map.setCenter(pontoPadrao);
			
			var geocoder = new google.maps.Geocoder();
			
			geocoder.geocode({
				"location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
            },
            function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$("#txtEnderecoPartida").val(results[0].formatted_address);
				}
            });
		});
	}
}

initialize();

$("form").submit(function(event) {
	event.preventDefault();
	
	var enderecoPartida = $("#txtEnderecoPartida").val();
	var enderecoChegada = $("#txtEnderecoChegada").val();
	
	var request = {
		origin: enderecoPartida,
		destination: enderecoChegada,
		travelMode: google.maps.TravelMode.DRIVING
	};
	
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
});</script> 
   
<div id="rodape"> 
  <? include("rodape.php"); ?>
</div>