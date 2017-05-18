 <? 
////caisa conflito com o script gmaps//////
 
      if(!isset($_SESSION['cidade']) AND  !isset($_SESSION['estado']) ){



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
x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
window.location='?ip=onload';
  exit();
break;
case error.TIMEOUT:
x.innerHTML="O tempo da requisição expirou."
x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
window.location='?ip=onload';
  exit();
break;
case error.UNKNOWN_ERROR:
x.innerHTML="Algum erro desconhecido aconteceu."
x.innerHTML="Usuário rejeitou a solicitação de Geolocalização."
window.location='?ip=onload';
  exit();
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
include("class.ipdetails.php");
   

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
    $_SESSION['lat']=trim($ipdetails->get_latitude());
    $_SESSION['log']=trim( $ipdetails->get_longitude());
}
if (isset($_GET['long'])){
 ///////////abre if get ip/////
	 $_SESSION['lat']=number_format(trim($_GET['lat']), 6, '.', ' ');
	 $_SESSION['log']=number_format(trim($_GET['long']), 6, '.', ' ');
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

	 
	

}
?>
<?
////////////////////////////ERRO HTML5 fim /////////////////////////////////

@$sessin_estado_sair= trim(tirarAcentos($_SESSION['estado']));
@$sessin_cidade_sair=trim( tirarAcentos($_SESSION['cidade']));
@$sessin_estado= trim($_SESSION['estado']);
@$sessin_cidade=trim($_SESSION['cidade']);
@$get_cidade=trim($_GET['l']);
@$get_cidade=trim($_GET['l']);
@$sessin_lat= trim($_GET['l']);

@$get_city=$_GET['cidade']  ;
	
//$get_estado = substr($_GET['e'], 0, strpos($_GET['e'], '?'));

if(isset($_GET['e'])){ $get_estado=$_GET['e'];
  if(isset($_GET['pagina'])){ $pagina='&&pagina='.$_GET['pagina'];
  @$get_estado = str_replace( $pagina, "",$_GET['e']);

}else{$get_estado = str_replace(" ", "",$_GET['e']);}}

@$_SESSION['endecedo_direto'];
@$lat= number_format($_SESSION['lat'], 6, '.', ' ').'<br>';
@$log=number_format($_SESSION['log'], 6, '.', ' ').'<br>';
?>
      <?
 
  
  $sql2 = "SELECT id FROM  membros 	WHERE  url='".$_SERVER['REQUEST_URI']."' LIMIT 1 ";
  $query_cont_menu = $mysql->query($sql2);
  $query_cont_menu->num_rows;
  ?>
  

<nav class="navbar navbar-default navbar-fixed-top ">
  <div class="container">
    <!-- navbar-fixed-top -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
          <div class="desktop">  <a class="navbar-brand" href="<? echo URL::getBase(); ?>"><img src="/img/lo		goalto.png"  alt="carrobomebarato" class=" img-responsive"></a>  </div>
         <div class="mobile">  <a class="navbar-brand" href="<? echo URL::getBase(); ?>">Carrobomebarato.com</a> </div>
   
     </div>
   <div class="desktop"> 
  <div id="caixa">
<p>Raio de Busca</p>
<?

 if (isset($_GET['r']) and ($_GET['r']=='10') or  ($_SESSION['km']=='10' )){?><a href="?r=10" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">10km &nbsp; </a><? }else {?><a href="?r=10"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">10km &nbsp;  </a><? } ?>
<? if (isset($_GET['r']) and ($_GET['r']=='50')or ($_SESSION['km']=='50' ) ){?><a href="?r=50" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">50km &nbsp; </a><? }else {?><a href="?r=50"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">50km &nbsp;  </a><? } ?>
<? if (isset($_GET['r']) and ($_GET['r']=='100')or ($_SESSION['km']=='100' ) ){?><a href="?r=100" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">100km &nbsp; </a><? }else {?><a href="?r=100"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">100km &nbsp;  </a><? } ?>
<? if (isset($_GET['r']) and ($_GET['r']=='500')or ($_SESSION['km']=='500' ) ){?><a href="?r=500" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">500km &nbsp; </a><? }else {?><a href="?r=500"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">500km &nbsp;  </a><? } ?>
<? if (isset($_GET['r']) and ($_GET['r']=='1000')or ($_SESSION['km']=='1000') ){?><a href="?r=1000" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">1000km &nbsp; </a><? }else {?><a href="?r=1000"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">1000km &nbsp;  </a><? } ?>


<? if (isset($_GET['p']) or (@$_GET['r']=='10000')or (@$_SESSION['km']=='10000' ) ){?><a href="?r=10000" style="color:#09F;"> <span class=" glyphicon glyphicon-map-marker" aria-hidden="true">Em Todo O Brasil &nbsp; </a><? }else {?><a href="?r=10000"><span class=" glyphicon glyphicon-map-marker" aria-hidden="true">Em Todo O Brasil &nbsp;  </a><? } ?>


<a href="#"onClick="javascript: altera_display('topo_pesquisar');"style="color:#20a6a6;"> <span class="glyphicon glyphicon-search" aria-hidden="true"></span>Buscar </a>
  </div> 
        </div> </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
 </nav> 
 
 <div class="container">
    <!-- navbar-fixed-top -->
    <div class="navbar-header">
     
         
     </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
 </nav> 
 
 
   <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
      <?php   
 if (!IsLoggedIn()) { ?>
        <li><a href="<? echo URL::getBase(); ?>">Home</a></li>
        <li><a href="<? echo URL::getBase(); ?>cadastro?seja_bem_vindo">Anuncie Grátis</a></li>
        <li>  <a href="<?  echo URL::getBase(); ?>?l=<?php echo acento($_SESSION['cidade']); ?>&e=<?php echo acento($_SESSION['estado']); ?>" > <?php echo @$_SESSION['cidade']; ?></a></li>
        <li> <a href="<?  echo URL::getBase(); ?>?e=<?php echo trim($_SESSION['estado']); ?>" > <?php echo @$_SESSION['estado']; ?></a></li>
        <li> <a href="<?  echo URL::getBase(); ?>?p" ><?=@$_SESSION['pais'];?></a></li>
        
         <li> <a href="<?  echo URL::getBase(); ?>faleconosco" >Fale Conosco</a></li>
         <? }else{ ?>
      
   <li><a href="<?  echo URL::getBase(); ?>">Home</a></li> 
   <li>   <a href="<?  echo URL::getBase(); ?>adicionar">Cadastrar anúncio</a></li> 
   <li>   <a href="<?  echo URL::getBase(); ?>gerente">Adminstrar Anúncios </a></li>
   <li>   <a href="<?  echo URL::getBase(); ?>faleconosco" >Fale conosco</a></li>
   <li>   <a href="<?  echo URL::getBase(); ?>sair">Sair</a></li>
   
   
 
       
         <?  }
      
?> 
          </ul>
           
         
         <div class="desktop">  <ul>  <div class="col-md-4"></div></div>   <ul class="nav navbar-nav navbar-right2"><? 
  
   if(($modulo !="adm_adicionar") and ($modulo !="novoendereco") and ($modulo !="cadastro")  and ($modulo !="adminstrar") and ($modulo !="gerente")and ($modulo !="adicionar")){
 if ($query_cont_menu->num_rows =='1') { 
    ?>

	
     
 <input type="text"  name="txtnome"   onKeyUp="getDados()" aria-describedby="basic-addon3" class="autocomplet" id="txtnome" placeholder=" <?php  echo"Buscar Carros no Estoque de" ." ". $modulo;?>"  >

<?	} 
if ($query_cont_menu->num_rows =='0') { 

 ?>


 <input type="text"  name="txtnome"  onKeyUp="getDados()" aria-describedby="basic-addon3" class="form-control"  id="txtnome" placeholder=" Buscar Carros Modelos Marcas "  ><? }
 
 } ?>
         
          
         <div id="Resultado"></div>
          
          </ul>
        </li>
     
     
      <ul class="nav navbar-nav navbar-right3">
         <?php if (@$_SESSION['Status'] <> "repasses") { ?>
          <li>
          <ul class="nav nav-pills" role="tablist">         
                <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>cadastro?seja_bem_vindo"  style="background-color:rgba(66, 139, 202, 0.78);">Anúncie Grátis Agora <span class="badge"></span></a></li>
                
                 <li role="presentation" class="active"><a href="#"  style="background-color:#20a6a6; width:167px;" onClick="javascript: altera_display('menutexto');">&nbsp;Entrar&nbsp; <span class="badge"></span></a></li>
 <div id="menutexto" style="display:none;">
	  <form action="<? echo URL::getBase(); ?>login.php?acao=login" method="post" enctype="application/x-www-form-urlencoded" name="log" id="log" >
      <input name="email" placeholder="E-mail" name id="email" placeholder="E-mail" name id="email"  required  id="Email"/>
      <input type="hidden" name="segure" value="<? echo  $_SESSION['segure']?>">
      <input name="senha" placeholder="Senha"placeholder="Senha" name id="email" id="senha" required  id="Senha" type="password" />
	   
    <input name="Entrar" type="submit" class="botao2" id="imageField"  value="Entrar" />
      </form> 
        
 
       <ul class="nav nav-pills" role="tablist">    
   <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>cadastro?seja_bem_vindo"  style="background-color:rgba(66, 139, 202, 0.78);">Esquecir a Senha <span class="badge"></span></a></li>
   <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>cadastro?seja_bem_vindo"  style="background-color:rgba(66, 139, 202, 0.78);">Acesso Via Facebook<span class="badge"></span></a></li>
  </ul></div> </ul>
       </li>
        
  

  
  <ul class="dropdown-menu">
  
  
  
  
  
  
 <div id="menutexto">
	  <form action="login.php?acao=login" method="post" enctype="application/x-www-form-urlencoded" name="log" id="log" >
      <input name="email" placeholder="E-mail" name id="email" placeholder="E-mail" name id="email"  required  id="Email"/>
      <input type="hidden" name="segure" value="<? echo  $_SESSION['segure']?>">
      <input name="senha" placeholder="Senha"placeholder="Senha" name id="email" id="senha" required  id="Senha" type="password" />
	   
    <input name="Entrar" type="submit" class="botao2" id="imageField"  value="Entrar" />
      </form> 
        
 
    </div> 
    <a href="#">Esquecir a senha </a>
    <h1><a href="#">Acessar Via Facebook</a></h1>
  </ul>
       </li>
        
       <? }else{ ?>
       <li>
          <ul class="nav nav-pills" role="tablist">         
                
  <div class="col-md-5"> <div class="text-xs-topo">
<? if( isset($_SESSION['id_facebook'])){ ?> 
   <a href=" /<?= $_SESSION['usuario']?>" > <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture"></a> 
   <? }else{ ?> 
     <a href=" /<?= $_SESSION['usuario']?>" > <img src="/galeriadefotos/novo/<?php if (( $_SESSION['foto'] <> '') and ((file_exists("galeriadefotos/novo/". @$_SESSION['foto'])))) { echo  @$_SESSION['foto']; } else { echo "avatar.jpg"; } ?>"></a> 
 
   <? } ?>
 </div> </div> <div class="col-md-7">
<div id="menuopcao">
       <p> <?php echo $_SESSION['usuario']; ?></p>
      <p><?php echo $_SESSION['email']; ?></p> 

               
               
           <p>  <a href="<?  echo URL::getBase(); ?>adminstrar" >Editar</a></p> 
 </div> </div>
       </li>
       
       
    <? } ?>
      </ul>
        </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
  </div> </div>
   <nav class="navbar navbar-default">
   <div class="container">
 
  	


<!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
  </div> </div>
 