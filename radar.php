
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
    var geocoder;
    if (navigator.geolocation) {
        geocoder = new google.maps.Geocoder();
        navigator.geolocation.getCurrentPosition(showPosition, handleError);
    }
 
    function showPosition(position) {
        showMap(position);
        showAddress(position);
    }

    function showMap(position){
        var latlon = position.coords.latitude+ "," +position.coords.longitude; 
       
    }
 
    function showAddress(position){
        var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var city = "";
		var country = ""
		var street_address = "";
		var street_number = "";
        var state = "";
		var postalCode = "";
		var latitude=position.coords.latitude;
		var longitude=position.coords.longitude;
        geocoder.geocode({ 'latLng': latlng }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    for (var i = 0; i < results[0].address_components.length; i++) {
                        for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                            if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                                state = results[0].address_components[i];
                            }
							 if (results[0].address_components[i].types[b] == "locality") {
                                city = results[0].address_components[i];
                            }
                            
							 if (results[0].address_components[i].types[b] == "street_number") {
                                street_number = results[0].address_components[i];
                            }
							if (results[0].address_components[i].types[b] == "route") {
                                street_address = results[0].address_components[i];
                            }
							if (results[0].address_components[i].types[b] == "country") {
                                country = results[0].address_components[i];
                            }
                            if (results[0].address_components[i].types[b] == "postal_code") {
                                postalCode = results[0].address_components[i];
                            }
                         }
                     }
					 var country = country.short_name; 
                     var state = state.long_name;
                     var city = city.short_name;
					 var street_number = street_number.short_name;
					 var street_address = street_address.short_name;
                     var zip = postalCode.short_name;
					



		
					
					 
                      window.location='?latitude=' +latitude+'&longitude='+longitude+'&cidade='+city + '&Pais='+country+'&rua='+street_address+ '&numerorua='+street_number+'&estado=' + state + '&cep=' + zip;
					 exit();
                 }
            }
        });
    }

    function handleError(error) {
        switch(error.code)
        {
            case error.PERMISSION_DENIED:
                alert("Usuário negou o pedido de Geolocalização.");
            break;
            case error.POSITION_UNAVAILABLE:
                alert("Informações sobre a localização está indisponível.");
            break;
			exit();
            case error.TIMEOUT:
                alert("O pedido para obter a localização do usuário expirou.");
            break;
            case error.UNKNOWN_ERROR:
                alert("Ocorreu um erro desconhecido.");
            break;
         }
    }
</script>

 