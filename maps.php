<!DOCTYPE html>
<html>
<body>
<?  require_once('Connections/repasses.php'); ?>
<?php
 include 'classMapsAPI.php';

?>


 <style type="text/css">
 body {overflow-x:hidden;
overflow-y:hidden; font: normal 8pt Helvetica, Arial; }
 #map_canvas {overflow-x:hidden;
overflow-y:hidden; width: 195px; height: 200px; border: 0px; padding: 0px; }
 </style>

  <?php  
 $query = mysql_query("SELECT * FROM poi_example ");
 while ($row = mysql_fetch_array($query)){

 $lat=$row['lat'];
 $lon=$row['lon'];
 $desc='<img src="/images/5ddaaa8daeb63c9d275fd03fc7ec3cff.png">';
 $val=$desc;}

 @$gmaps = new MapsAPI();
@$dados = $gmaps->getEndereco($lat,$lon);
 ?>
<section id="wrapper">

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <article>
      <span id="status" style=" size:12px;" ></span>
    </article>
<script>
function success(position) {
  var s = document.querySelector('#status');

  if (s.className == 'success') {
    return;
  }

  s.innerHTML = '<?=@$dados?>';
  s.className = 'success';

  var mapcanvas = document.createElement('div');
  mapcanvas.id = 'mapcanvas';
  mapcanvas.style.height = '100%';
  mapcanvas.style.width = '100%';

  document.querySelector('article').appendChild(mapcanvas);

  var latlng = new google.maps.LatLng(<?php echo $lat?>,<?php echo  $lon?>);
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeControl: false,
    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

   
           
  var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  var image = '/images/5ddaaa8daeb63c9d275fd03fc7ec3cff.png';
  var marker = new google.maps.Marker({
      position: latlng,
      map: map,
      title:"Você Estar Aqui!",
	   icon: image
  });
}

function error(msg) {
  var s = document.querySelector('#status');
  s.innerHTML = typeof msg == 'string' ? msg : "failed";
  s.className = 'fail';

  // console.log(arguments);
}

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(success, error);
} else {
  error('not supported');
}

</script>
</section>



<body onLoad="initialize()" >
 <? 
    if (!isset($_SESSION["telefone"])) { 
   if (!isset($_GET['center'])) { ;?>
<script type="text/javascript" src="http://j.maxmind.com/app/geoip.js" async></script>
<script>
(function(){

  var info = document.getElementById('info');
  var lat = geoip_latitude();
  var lon = geoip_longitude();
  var city = geoip_city();
  var out = '<h3>Informaçoes de usa localização:</h3>'+
            '<ul>'+
            '<li>Latitude: ' + lat + '</li>'+
            '<li>Longitude: ' + lon + '</li>'+
            '<li>Cidade: ' + city + '</li>'+
            '<li>Cód. Região: ' + geoip_region() + '</li>'+
            '<li>Região: ' + geoip_region_name() + '</li>'+
            '<li>Código do País: ' + geoip_country_code() + '</li>'+
            '<li>Nome do País: ' + geoip_country_name() + '</li>'+
            '</ul>';
 window.location= '?center='+
            lat+',&lat='+lon+'&sensor=false&size=300x300&maptype=roadmap&key='+
            'ABQIAAAAijZqBZcz-rowoXZC1tt9iRT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQQBCa'+
            'F1R_k1GBJV5uDLhAKaTePyQ&markers=color:blue|label:I|'+lat+
            ','+lon+'6&visible='+lat+','+lon+'|'+(+lat+1)+','+(+lon+1);
  

})();
</script><? }} ?>