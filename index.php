 <? @setcookie();
 require'Connections/repasses.php';
     
         
  
if(!isset($_COOKIE['cidade']) AND  !isset($_COOKIE['estado']) ){
 if (!isset($_GET['ip']) AND (!isset($_GET['long']))  ){ ////se for home e nÃ£o nem get ip nem long buscar latitude ouerro ?>
<body onLoad="getPosition()">
<script> 

 function getPosition(){

  // Verifica se o browser do usuario tem suporte a geolocation

  if ( navigator.geolocation ){

    navigator.geolocation.getCurrentPosition( 

    // sucesso! 

    function( posicao ){

    console.log( posicao.coords.latitude, posicao.coords.longitude );

	window.location='?lat=' +posicao.coords.latitude+'&long='+posicao.coords.longitude+'&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit();

    },

    // erro :(

    function ( erro ){

      var erroDescricao ='Ops, ';

      switch( erro.code ) {

        case erro.PERMISSION_DENIED:

          erroDescricao +='usuÃ¡rio nÃ£o autorizou a Geolocation.';
          
window.location='?ip=onload&&var=notautorize&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit();


        break;

        case erro.POSITION_UNAVAILABLE:

          erroDescricao +='localizaÃ§Ã£o indisponÃ­vel.';
          
window.location='?ip=onload&&var=indisponivel&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit();


        break;

        case erro.TIMEOUT:

          erroDescricao +='tempo expirado.';
          
window.location='?ip=onload&&var=time&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit();


        break;

        case erro.UNKNOWN_ERROR:

         erroDescricao +='nÃ£o sei o que foi, mas deu erro!';
         
window.location='?ip=onload&&var=indefinido&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit();


        break;

      }

      console.log( erroDescricao )

    }

   );

  }
  else{
    window.location='?ip=onload&&var=nosuporte&&resolucaoW='+screen.width+'&&resolucaoH='+screen.height;

	exit(); 
      
  }

}

 

$( document ).ready( function(){

  getPosition();

} );

</script>

<? 
       
}else{

	if (isset($_GET['ip'])) { ///////////abre if get ip/////
   if($_SERVER['SERVER_NAME']=="localhost"){
$ip='177.17.186.232';
}else{
$ip=get22_client_ip();  
       }  //$ip=get22_client_ip();  
$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
 


    $_SESSION['lat']=number_format(trim($query['lat']), 6, '.', ' ');

    $_SESSION['log']=number_format(trim($query['lon']), 6, '.', ' ');
} else { echo "seu localização foi encontrada ";}
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

		


        }

    }

}



   

   }
 if($_SERVER['SERVER_NAME']=="localhost"){
$ip='179.181.117.26';
}else{
$ip=get22_client_ip();  
       } 
      
 $resolucao=@$_GET['resolucaoW']."X".@$_GET['resolucaoH'];
  $sql="INSERT INTO acesso (session_id,ip,cidade,estado,pais,lat,log,cep,condicao,maquina,resolucao) VALUES 
( '".session_id()."','".@$ip."','".@$cidade."','".@$estado."','".$pais."','".@$_SESSION['lat']."','".@$_SESSION['log']."','".@$cep."','".@$_GET['var']."','".@$_SESSION['navegador']."','".@$resolucao."')"  ;
$sql=$mysql->query($sql); 
 $cookie_endereco= @$rua.'&nbsp;&nbsp;'.@$cidade.'&nbsp;&nbsp;'.@$estado.'&nbsp;&nbsp;'.@$pais.'&nbsp;&nbsp;'.@$cep;
 @$_SESSION['endereco1']= @$rua.'&nbsp;&nbsp;'.@$cidade.'&nbsp;&nbsp;'.@$estado.'&nbsp;&nbsp;'.@$pais.'&nbsp;&nbsp;'.@$cep;
 setcookie("endereco1",$cookie_endereco,time()+3600*24*30*12*6);
 setcookie("rua",$rua,time()+3600*24*30*12*6);
 setcookie("cidade",$cidade,time()+3600*24*30*12*6);
 setcookie("estado",$estado,time()+3600*24*30*12*6);
 setcookie("pais",$pais,time()+3600*24*30*12*6);
 setcookie("cep",$cep,time()+3600*24*30*12*6);
 setcookie("lat",$_SESSION['lat'],time()+3600*24*30*12*6);
 setcookie("log",$_SESSION['log'],time()+3600*24*30*12*6); 
 
 $mensagem ="Usuario acessou a pagina com sucesso" .@$_SESSION['rua'].'&nbsp;&nbsp;'.@$_SESSION['cidade'].'&nbsp;&nbsp;'.@$_SESSION['estado'].'&nbsp;&nbsp;'.@$_SESSION['pais'].'&nbsp;&nbsp;'.@$_SESSION['cep'];
 	  salvaLog($mensagem);
     }

}
if(isset($_SESSION['endereco1']) or isset($_COOKIE['endereco1']) ){
////////////////////////////ERRO HTML5 fim /////////////////////////////////?>
<script>
function  mostrar(ID){
	document.getElementById(ID).style.display = "block";

}
function  ocultar(ID){
	document.getElementById(ID).style.display = "none";
	$("#dive").hide("slow");
}
function altera_display(id) {
	// OpÃ§Ãµes para o atributo display - block, inline e none
	if(document.getElementById(id).style.display=="none") {
		document.getElementById(id).style.display = "block";
	}
	else {
		document.getElementById(id).style.display = "none";
	}
}

function altera_100(id) {
	// OpÃ§Ãµes para o atributo display - block, width:80%} inline e none
	if(document.getElementById(id).style.width=="100px") {
		document.getElementById(id).style.width = "100px";
	}
	else {
		document.getElementById(id).style.width = "100px";
	}
}
</script>
    
 <?php @session_start();
 if(isset($_COOKIE['endereco1'])&&($_COOKIE['endereco1']!='')){
  $endereco=$_COOKIE['endereco1'];  
}else{
  $endereco=$_SESSION['endereco1'];  
}
 
 if(isset($_COOKIE['lat'])&&($_COOKIE['lat']!='')){
  $lat=$_COOKIE['lat'];  
}else{
  $lat=$_SESSION['lat'];  
}
if(isset($_COOKIE['log'])&&($_COOKIE['log']!='')){
  $log=$_COOKIE['log'];  
}else{
  $log=$_SESSION['log'];  
}
if(isset($_COOKIE['cidade'])&&($_COOKIE['cidade']!='')){
  $menu_cidade=$_COOKIE['cidade'];  
}else{
 $menu_cidade=$_SESSION['cidade'];  
}
if(isset($_COOKIE['estado'])&&($_COOKIE['estado']!='')){
  $menu_estado=$_COOKIE['estado'];  
}else{
   $menu_estado=$_SESSION['estado'];  
}
if(isset($_COOKIE['pais'])&&($_COOKIE['pais']!='')){
  $menu_pais=$_COOKIE['pais'];  
}else{
 $menu_pais=$_SESSION['pais'];  
}
 if(isset($_GET['horizon'])) {
     unset($_SESSION['horizon']);
      //$_SESSION['horizon']="horizon";
    }
 if(isset($_GET['grid'])) {
  unset($_SESSION['horizon']);
  //$_SESSION['horizon']="grid";
 }

 require "links.php";  
 $request = $_SERVER['REQUEST_URI'];
 
   if($request=="/sair"){ include_once"sair.php"; exit(); }
    if($request=="/sair2"){ include_once"sair2.php"; exit(); }
   if($request=="/acao"){ include_once"acao.php"; exit(); }
  
 require "log.php"; 
 require "meta.php";  
     ?>
</body>
</html>  
<?php

   $modulo=trim(Url::getURL( 0 ));
   $modulo = str_replace("%C3%A9", "?",   $modulo);
   $modulo = str_replace("%C3%A3", "?",   $modulo);
   $modulo = str_replace("%C3%AD", "?",   $modulo);
   $modulo = str_replace("%C3%A3o", "?o",   $modulo);
   $modulo = str_replace("%20", " ",   $modulo);
   $modulo = str_replace("?", "Ã©",   $modulo);
   $modulo = str_replace("?o", "Ã£o",   $modulo);
   $modulo = str_replace("%C3%A1", "Ã¡",   $modulo); 
   $link =urldecode($_SERVER['REQUEST_URI']);
	 
    @$ex = explode('/', $link);
    $link1 = $ex[count($ex)-2];
    @$link2 = $ex[count($ex)-1];
    $link3 = $ex[count($ex)-1];
    @$ex2 = explode("?",$link);
    @$link11 = $ex2[count($ex2) -1];
    @$link12 = $ex2[count($ex2)-1];
    @$link13 = $ex2[count($ex2)-3];

/////para ajustar a paginaÃ§Ã£o ///////
 $script =trim(  str_replace("/", "",   $_SERVER['REQUEST_URI']));
/////para ajustar a paginaÃ§Ã£o ///////

if(isset($_GET['l']) || isset($_GET['e']) )
{
	

}else{
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=10" );
if ($pos != false) {
  
  $_SESSION['km']='10';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=50" );
if ($pos != false) {
  
  $_SESSION['km']='50';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=100" );
if ($pos != false) {
  
  $_SESSION['km']='100';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=500" );
if ($pos != false) {
  
  $_SESSION['km']='500';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=1000" );
if ($pos != false) {
  
  $_SESSION['km']='1000';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "r=10000" );
if ($pos != false) {
  
  $_SESSION['km']='10000';
}
@$pos = strpos( $_SERVER['REQUEST_URI'], "?p" );
if ($pos != false) {
  
  $_SESSION['km']='100000';
}}


  if(@$_GET["ordem"]){
    if($_GET["ordem"]=="maiorpreco"){$ordem='preco DESC ';$ordem21="sim";$ordem2="Maisbarato";}
    if($_GET["ordem"]=="menorpreco"){$ordem='preco  ASC';$ordem22="sim";}
    if($_GET["ordem"]=="novo"){$ordem='ano2 DESC ';$ordem23="sim"; }
    if($_GET["ordem"]=="seminovo"){$ordem='ano2 ASC ';$ordem24="sim"; }
    }else{ $ordem='Id_estoque DESC';}
   		require "menu.php"; 
		
		
   		if( file_exists("$modulo.php")){
   		include_once("$modulo.php");exit();
  }if(@$_GET["mapa"]){
	 include_once("map.php");exit();}
	 
	 
	 
	 
	 $sql ="SELECT id FROM  membros 	WHERE  url='".$modulo."' LIMIT 1 ";
     $query = $mysql->query($sql);
     $query->num_rows;
	 if ($query->num_rows  == '1') { 
     unset($_SESSION['buscar']); 
	 $_SESSION['buscar']= "WHERE url="."'".$modulo."'"; 
	 require_once"membro.php";
	 exit();
	 
	 }else{
	 $sql ="SELECT  nome FROM  membros 	WHERE  nome='".$modulo."' LIMIT 1 ";
     $query = $mysql->query($sql);
     $query->num_rows;
	 if($query->num_rows  == '1') { 

	unset($_SESSION['buscar']); 
	 $_SESSION['buscar']= "WHERE nome_membro="."'".$modulo."'"; 
	require_once"membro.php";
	exit();	
		
		
	}
	 }
 	
	if(is_numeric	($modulo)){
 $sql="SELECT * FROM estoque WHERE Id_estoque='".$modulo."' ORDER BY Id_estoque ASC";
 $query = $mysql->query($sql);
  if($query->num_rows  == '1') { 

	unset($_SESSION['buscar']); 
	
	require_once"membro2.php";
	exit();	
		
		
	}}
	///////////////////////////////////busca organica marca ///////////////////////////////////////////////////
	
	
	////////////////////////////////////////bisca organica por marca ///////////////////////////////////////////////
	
	  if(isset($_GET['l'])){ 
	  $sql2 ="SELECT Id_estoque FROM estoque	WHERE    estado='".$_GET['e']."' AND cidade='".$_GET['l']."' AND exibir='1'";
    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
	 $_SESSION['buscar']= "WHERE  estado="."'".$_GET['e']."'". " AND cidade="."'".$_GET['l']."'"." AND exibir=" ."'1' "; 
	require_once"membro.php";	exit(); } else{
	///////////////////codigo//////////pesquisar marca modelo por raio ////////////////////////////////////
   $sql ="SELECT marcatexto FROM estoque	WHERE   marcatexto LIKE '%".$modulo."%'	AND estado='".$_GET['e']."'   AND exibir='1' ORDER BY Id_estoque DESC LIMIT 999";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
	$_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " AND estado="."'".$get_estado."'"." AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); } }
	
	///////////////////fim////////////////////
	
	  }
	
	
	
	/////////////////////////////////////////////////////////////////////////////////
	if(isset($_GET['e'])){ 
	
    $sql ="SELECT Id_estoque FROM estoque	WHERE     estado='".$_GET['e']."' AND exibir='1'";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
    $_SESSION['buscar']= "WHERE  estado="."'".$_GET['e']."'  and exibir='1'"; 
	require_once"membro.php";	exit(); } else{ 
	////se naÃµ hover modelos vamos testar marcas //////////
	////////////////////comeÃ§o //////////////////////////
	
	
	 }	}
	
	//////////////////////fim///////////////// //////////
	///////se naÃµ hover modelos vamos testar marcas //////////
	
	if(isset($_GET['p'])){ 
	  $sql ="SELECT Id_estoque FROM estoque	WHERE   marcatexto LIKE '%".$modulo."%' or  modelotexto LIKE '%".$modulo."%' and exibir='1'	";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
		$_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'  and exibir='1'";  
	require_once"membro.php";	exit(); }
	else{ 
	 $sql ="SELECT modelotexto FROM estoque	WHERE   modelotexto LIKE '%".$modulo."%'and exibir='1'	 ORDER BY Id_estoque DESC LIMIT 999";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
	$_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%' and exibir='1'"; 
	require_once"membro.php";	exit(); }
	} }	// fim if(isset($_GET['p']))
if(isset($_GET['ip']) || isset($_GET['lat']) ) {
     unset($_SESSION['km']);
      //$_SESSION['horizon']="horizon";
    }
if( $_SERVER['REQUEST_URI']=="/"){
    
     unset($_SESSION['km']);
      //$_SESSION['horizon']="horizon";
   
}

 
        ////////////////////////////////////se ja $_session use por favor //////////////////////////////////////////////////
if(isset($_SESSION['km'])){    $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < ".$_SESSION['km']."
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
             
         
         
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }      
        
	
}///////////////////////////////////////////////////////////////////////////////////////
   $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10
";    $query = $mysql->query($sql2);
    $query->num_rows;
	if ($query->num_rows >'0') { 
           
         
         $_SESSION['km']="10";
           
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";      
	require_once"membro.php";	exit(); }
         $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 50
";    $query = $mysql->query($sql2);
    $query->num_rows;
	if ($query->num_rows >'0') { 
             
         $_SESSION['km']="50";
         
	  $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";   
	require_once"membro.php";	exit(); }

        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 100
";    $query = $mysql->query($sql2);

     $query->num_rows;
	if ($query->num_rows >'0') { 
             if(!isset($_SESSION['km'])){
         $_SESSION['km']="100";
            }
	  $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";   
	require_once"membro.php";	exit(); }


        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 500
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            if(!isset($_SESSION['km'])){
         $_SESSION['km']="500";
          }
	  $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }
        
 $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 1000
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
             if(!isset($_SESSION['km'])){
         $_SESSION['km']="1000";
          }
	  $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }        

$sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' OR modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10000
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
             if(!isset($_SESSION['km'])){
         $_SESSION['km']="10000";
          }
	  $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " OR  modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }        
	
        } else{   include 'meta.php';  $sql = "select Id_estoque  FROM estoque ";
	 $query = $mysql->query($sql);
         $query->num_rows;
         
         $sql2 = "select id  FROM membros ";
	 $query2 = $mysql->query($sql2);
         $query2->num_rows;
        ?> 

  <div class="container">
  <img src="img/logoindex.png" >
 

 
  <ul><li class="text-center"><img src="img/loding.gif"><br> Aguarde estamos configurando o site ...</span></li>
      <li class="dropdown" role="presentation" class="active">
          <a href="#" class="dropdown-toggle active" data-toggle="dropdown">Anunciantes <span class="fa fa-users fa-3x"> &nbsp;<?=$query2->num_rows;?></span></a> 
     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <a href="#" class="dropdown-toggle active" data-toggle="dropdown">Anúncios  <span class="fa fa-car fa-3x">&nbsp;<?=$query->num_rows;?>&nbsp;</span></a> 
    <? echo $_COOKIE['endereco1'];?>
     
    
 </li> 
      </ul>   </div>

            <?      }
	 
?> 