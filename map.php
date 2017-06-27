<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="http://getbootstrap.com/favicon.ico">

        <title>GMAPS_TESTE</title>

        <style type="text/css">
            html, body { height: 100%; margin: 0; padding: 0; }
            #map { height: 100%; }
        </style>


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">



        <!-- Custom styles for this template -->
        <link href="starter-template.css" rel="stylesheet">



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>









        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>


        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://getbootstrap.com/examples/starter-template/#">Project name</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="http://getbootstrap.com/examples/starter-template/#">Home</a></li>
                        <li><a href="http://getbootstrap.com/examples/starter-template/#about">About</a></li>
                        <li><a href="http://getbootstrap.com/examples/starter-template/#contact">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="starter-template">
                        <h1>Google Maps teste com Bootstrap</h1>                        
                        <p>Powered by Igor Alves</p>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10">
                    <div id="map"></div>
                </div>
                <div class="col-md-1">
                </div>
            </div>

        </div>

        <footer class="footer">
            <p>© 2015 Company, Inc.</p>
        </footer>


        <!-- Include Google Maps JS API -->
        <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=A_SUA_CHAVE&sensor=false">
        </script>

    <script type="text/javascript">





       $(window).resize(function () {
             var h = $(window).height(),
                     offsetTop = 60; // Calculate the top offset
             $('#map').css('height', (h - offsetTop));
         }).resize();//Fazer o display de GMAPS dentro de Bootstrap




//Inicializa um mapa 
var map;

function initMap() {


                  var myLatLng = new google.maps.LatLng(-12.9464758, -38.4474323);

                   map = new google.maps.Map(document.getElementById('map'), {
                    center: myLatLng,
                    zoom: 13
                    });



<?php


$con=mysqli_connect("localhost","my_user","my_password","my_db");
// Testa conexao
if (mysqli_connect_errno())
  {
  echo "Falha de conexao ao MySQL: " . mysqli_connect_error();
  }

$sql="SELECT * FROM tabelaPontosInfo";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $arrayInfo[]=["name"=>$row["name"],"content"=>$row["content"],"latLong"=>$row["lat"].",".$row["Long"],"iconPath"=>$row["iconPath"];
    }
} else {
    echo "nenhum resultado";
}
$conn->close();



//Aqui nesse ponto vc tera a sua array de informações para gerar o mapa com os pontos
$arrayInfo

//Agora vejamos exemplos de informações dentro dessa array:



//O que pode ser guardado dentro de content exemplos:
$strHtmlcontent1="<div style=\'margin: 5px;border: 2px solid    #000000;height:200px; width: 300px; overflow:hidden; \'><a href=\'https://igoralves1.github.io\' target=\'_blank\'><img src=\'fotop1.jpg\' width=\'300\' height=\'200\' ></a></div><div style=\'padding: 15px;text-align: center;\'><h2>Algum texto p1</h2></div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div>";
$strHtmlcontent2="<div style=\'margin: 5px;border: 2px solid    #000000;height:200px; width: 300px; overflow:hidden; \'><a href=\'https://igoralves1.github.io\' target=\'_blank\'><img src=\'fotop2.jpg\' width=\'300\' height=\'200\' ></a></div><div style=\'padding: 15px;text-align: center;\'><h2>Algum texto p2</h2></div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div><div style=\'padding: 15px;text-align: center;\'>Add a description of the image here</div>";

//Exemplo da array:
$arrayInfo = [

     [
        "name"=>"Ponto 1",
        "content"=>"$strHtmlcontent1",
        "latLong"=>"-12.142105, -40.362556",
        //"iconPath"=>"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|00ff00|000000" //http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker
        //"iconPath"=>"http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|00ff00|000000"
        "iconPath"=>"p1.gif"
    ],
     [
        "name"=>"Ponto 2",
        "content"=>"$strHtmlcontent2",
        "latLong"=>"-12.139101, -40.360639",
        "iconPath"=>"p2.png"
    ],
     [
        "name"=>"Ponto 3",
        "content"=>"$strHtml",
        "latLong"=>"-13.005904, -38.532634",
        "iconPath"=>"p3.gif"
    ]
];  



//Aqui vc percorre sua array e monta seus objetos:
$i=1;

foreach ($arrayInfo as $val) { 

 echo "var marker$i='';";
 echo "\n";
 echo "var infowindow$i='';";
 echo "\n";

       $str .=<<<EOF

                 marker$i = new google.maps.Marker({
                        position: new google.maps.LatLng({$val["latLong"]}),
                        map: map,
                        optimized:false,
                        icon: '{$val["iconPath"]}',
                        title: '{$val["name"]}'
                    });


                    infowindow$i = new google.maps.InfoWindow({
                        content: '{$val["content"]}'
                    });


                    google.maps.event.addListener(marker$i, 'click', function() {
                        infowindow$i.open(map, marker$i);
                    });



EOF;

$i++;        
}


echo $str;  

///////////////////////////////////////////////////////////////////////
?>

}         


google.maps.event.addDomListener(window, 'load', initMap);



        </script>

        <!-- 
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzI2SrfmCSWlwCezs4QBwGYwClrC0qtMk&callback=initMap">
        </script>
        -->

        <!-- Bootstrap core JavaScript
        ================================================== -->


        <!-- Latest compiled JavaScript -->
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


    </body>


</html>