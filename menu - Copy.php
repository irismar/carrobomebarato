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
   echo @$_SESSION['lat']=trim(netGeo::$Latitude);
	echo  @$_SESSION['log']=trim( netGeo::$Longitude);
}
if (isset($_GET['long'])){
 ///////////abre if get ip/////
	@$_SESSION['lat']=number_format(trim($_GET['lat']), 6, '.', ' ');
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
        $pais= trim($address["long_name"]);
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

	 
	

}




       
  
    

	 
	




////////////////////////////ERRO HTML5 fim /////////////////////////////////

@$sessin_estado_sair= trim(tirarAcentos($_SESSION['estado']));
@$sessin_cidade_sair=trim( tirarAcentos($_SESSION['cidade']));
@$sessin_estado= trim($_SESSION['estado']);
@$sessin_cidade=trim($_SESSION['cidade']);
@$get_cidade=trim($_GET['l']);
@$get_cidade=trim($_GET['l']);
@$sessin_lat= trim($_GET['l']);

@$get_city=trim($_GET['cidade']);
@$get_estado=trim($_GET['e']);

?>
      <?
 
  
  
  
//}?>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Carro bom e Barato</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
      <?php   if (!IsLoggedIn()) { ?>
        <li><a href="<? echo URL::getBase(); ?>">Home</a></li>
        <li><a href="<? echo URL::getBase(); ?>cadastro?seja_bem_vindo">Anuncie Grátis</a></li>
        <li>  <a href="<?  echo URL::getBase(); ?>?l=<?php echo acento($_SESSION['cidade']); ?>&e=<?php echo acento($_SESSION['estado']); ?>" > <?php echo @$_SESSION['cidade']; ?></a></li>
        <li> <a href="<?  echo URL::getBase(); ?>?e=<?php echo trim($_SESSION['estado']); ?>" > <?php echo @$_SESSION['estado']; ?></a></li>
        <li> <a href="<?  echo URL::getBase(); ?>?p" >Brasil</a></li>
        
         <li> <a href="<?  echo URL::getBase(); ?>faleconosco" >Fale Conosco</a></li>
         <? }else{ ?>
      
   <li><a href="<?  echo URL::getBase(); ?>">Home</a></li> 
   <li>   <a href="<?  echo URL::getBase(); ?>adicionar">Cadastrar anúncio</a></li> 
   <li>   <a href="<?  echo URL::getBase(); ?>gerente">Adminstrar Anúncios </a></li>
   <li>   <a href="<?  echo URL::getBase(); ?>faleconosco" >Fale conosco</a></li>
   <li>   <a href="<?  echo URL::getBase(); ?>sair">Sair</a></li>
   
   
 
       
         <?  }?>
          </ul>
        </li>
      </ul>
     
      <ul class="nav navbar-nav navbar-right">
         <?php if (@$_SESSION['Status'] <> "repasses") { ?>
         
         
   
         <li> <ul class="nav nav-pills" role="tablist">
         
         
  <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>adm_adicionar?mapa">Anúncio Rápido <span class="badge"></span></a></li>
 

  <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
 Entrar <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
 <div id="menutexto">
	  <form action="login.php?acao=login" method="post" enctype="application/x-www-form-urlencoded" name="log" id="log" >
      <input name="email" placeholder="E-mail" name id="email" placeholder="E-mail" name id="email"  required  id="Email"/>
      <input name="senha" placeholder="Senha"placeholder="Senha" name id="email" id="senha" required  id="Senha" type="password" />
	   
    <input name="Entrar" type="submit" class="botao2" id="imageField"  value="Entrar" />
      </form> 
        
 
    </div> 
    <a href="">Esquecir a senha </a>
    <p>Acessar Via Facebook</p>
  </ul>
</div>


       </li>
        
       <? }else{ ?>
           <div id="texto">
 <? if( isset($_SESSION['id_facebook'])){ ?> 
   <a href=" /<?= $_SESSION['usuario']?>" > <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture"></a> 
   <? }else{ ?> 
     <a href=" /<?= $_SESSION['usuario']?>" > <img src="/galeriadefotos/peq/<?php if (( $_SESSION['foto'] <> '') and ((file_exists("galeriadefotos/peq/". @$_SESSION['foto'])))) { echo  @$_SESSION['foto']; } else { echo "avatar.jpg"; } ?>"></a> 
 
   <? } ?>
  
       <p> <?php echo $_SESSION['usuario']; ?></p>
      <p><?php echo $_SESSION['email']; ?></p> 

               
               
            <a href="<?  echo URL::getBase(); ?>adminstrar" >Editar</a> 
</div>
         <? } ?>
      </ul>
        </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
  </div> </div>
</nav>
   <nav class="navbar navbar-default ">
   <div class="container">
   <? if (IsLoggedIn())
  
    { ?>
   <br> 
   <? } ?><br>
  <div class="col-md-12">

   <form action="<?  echo URL::getBase(); ?>?txtnome" method="get">
 <input type="text"  name="txtnome"  onKeyUp="getDados()" aria-describedby="basic-addon3" class="autocomplet" id="txtnome" placeholder="Digite marca ou  modelo formulario auto complete"  ></form> 
    <ul class="nav nav-pills" role="tablist">Raio de Busca
  <li role="presentation" ><a href="<?  echo URL::getBase(); ?>gerente?ver"> <span class="badge">10km</span></a></li>
  <li role="presentation" ><a href="<?  echo URL::getBase(); ?>gerente?ver"> <span class="badge">50km</span></a></li>
  <li role="presentation" ><a href="<?  echo URL::getBase(); ?>gerente?ver"> <span class="badge">100km</span></a></li>
  <li role="presentation" ><a href="<?  echo URL::getBase(); ?>gerente?ver"> <span class="badge">500km</span></a></li>
 <li role="presentation" ><a href="<?  echo URL::getBase(); ?>gerente?ver"> <span class="badge">1.000km</span></a></li> 

              
             

</ul>
 <? if (IsLoggedIn())
  
    { ?>
 <?php if( @$_SESSION['usuario']!=$modulo){ ?>
    <?php if (@$_SESSION['alertavisita']<0){  echo $_SESSION['alertavisita'];?>
   <a href="gerente">
  <?php echo @$_SESSION['alertavisita'];?> </a><?php } 
  $sql = "SELECT alertamanesagem,alertamanesagem,alvit,id FROM  membros WHERE id= '".$_SESSION['id']."' ORDER BY id DESC  ";
 $query2 = $mysql->query($sql);
 if ($query2->num_rows != 0) { 
 while($row_estoque3 = $query2->fetch_assoc()) {
	 
	          if($alertamensagem= $row_estoque3['alertamanesagem']!=0)    {?>
              
              <ul class="nav nav-pills" role="tablist">
  <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>gerente?ver">Mensagens <span class="badge"><? echo  $row_estoque3['alertamanesagem'];?></span></a></li>

              
              <? } 
		    if( $alertavisita=$row_estoque3['alvit']!=0)    {?>
             
  <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>gerente?ver_visita">Visitas <span class="badge"><? echo  $row_estoque3['alvit'];?></span></a></li>

</ul>
       <? } ?>
       <?    } } } }?>
   

<?

    include_once('netgeo.class.php'); 

    netGeo::getNetGeo(); 
    
    netGeo::$Latitude.'<br />'; 
     netGeo::$Longitude.'<br />'; 

?> 
<!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
  </div> </div>
</nav>
 <div class="container">
  <div class="col-md-10">
    <div id="Resultado"></div>
  </div>
 
</div>  