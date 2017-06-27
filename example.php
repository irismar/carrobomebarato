<!DOCTYPE html>
<html>
    <head>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js"></script>
        
        <title>Geolocation</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <style>
        html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        #map{
                height: 100%;
        }
        </style>
    </head>
    <body>
       

        <script type='text/javascript'>

            var lati = '';
            var long = '';
            var cidade = '';
            var estado = '';
            var pais = '';
            var cep = '';
            var dadosajax = '';

            navigator.geolocation.getCurrentPosition(function (posicao) {
                var url = "http://nominatim.openstreetmap.org/reverse?lat=" + posicao.coords.latitude + "&lon=" + posicao.coords.longitude + "&format=json&json_callback=preencherDados";

                var script = document.createElement('script');
                script.src = url;
                document.body.appendChild(script);
                lati = posicao.coords.latitude;
                long = posicao.coords.longitude;
               
               

            });
 
            function preencherDados(dados) {
                cidade = dados.address.city;
                estado = dados.address.state;
                pais = dados.address.country;
              
                
               
                


                dadosajax = {'cidade':cidade, 'estado':estado, 'pais':pais,'lat':lati,'log':long};
                SalvarLocal(cidade,estado,pais);
                $("#localizacao").submit(function (e) {
                    e.preventDefault();
                    alert(dadosajax);
                    $.ajax({
                        type: "POST",
                        url: "teste6.php",
                        data: dadosajax

                    });
                });




            }
            ;
function SalvarLocal(cidade,estado,pais,lat,log){
            $(function(){
               
               $.ajax({
                
                    data: { 'cidade' : cidade, 'estado' : estado, 'pais' : pais,'lat' : lati,'log':long },
                    type : "POST",
                    url  : "teste6.php",
            
                });
                
            });
        }
        </script>
    </body>
</html>