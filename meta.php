 <? @header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');  
   @header('Last Modified: '. gmdate('D, d M Y H:i:s') .' GMT');  
   @header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');  
   @header('Pragma: no-cache');  
   @header("Cache: no-cache");    
   @header('Expires: 0'); ?><!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
 <meta http-equiv="Content-Type" content="text/html; />
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta http-equiv = "X-UA-Compatible" content = "IE = 9" /> 
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/favicon.ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="/css/bootstrap.css?<?php echo microtime();?>"  media='all' rel="stylesheet">
     <link href="/css/ie.css?<?php echo microtime();?>"  media='all' rel="stylesheet">
         
  <!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script>
<![endif]-->


<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jsbood.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.js"></script>
<?php 
  if (IsLoggedIn()) {

  ?>
<meta itemprop="name" content="Título ou nome“>
<meta itemprop="description" content="Descrição da página“>
<meta itemprop="image" content="img/logo.jpg“>
<!– para o Twitter Card–>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="Conta do Twitter do site (incluindo arroba)“>
<meta name="twitter:title" content="Título da página“>
<meta name="twitter:description" content="Carrobomebarato.com melhor site para encontrar seu carro“>
<meta name="twitter:creator" content="Conta do Twitter do autor do texto (incluindo arroba)“>
<– imagens largas para o Twitter Summary Card precisam ter pelo menos 280x150px –>
<meta name="twitter:image" content="img/logo.jpg“>
<!– para o sistema Open Graph–>
<meta property="og:title" content="carrobomebarato" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://www.carrobomebarato.com/" />
<meta content="http://www.carrobomebarato.com/images/baner.png" property="og:image" />
<meta property="og:description" content="Carrobomebarato" />
<meta property="og:site_name" content="Carrobomebarato" />
<meta property="article:published_time" content="2013-09-17T05:59:00+01:00" />
<meta property="article:modified_time" content="2013-09-16T19:08:47+01:00" />
<meta property="article:section" content="Seção do artigo" />
<meta property="article:tag" content="Tags do artigo" />
<meta property="fb:admins" content="Facebook numeric ID" />
	 <meta http-equiv="Content-Type" content="text/html;  />
<meta name="p:domain_verify" content="2c1c1eb693d92d7e100a7314b6950daa"/>
<meta name="language" content="pt-br">
	<meta name="resource-type" content="document">
 	<meta name="revisit-after" content="1">
	<meta name="rating" content="General">
	<meta name="author" content="carrobomebarato.com">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta name="distribution" content="global">
	<meta name="category" content="shopping">
	<meta name="ms.locale" content="pt-br">
	<title>carrobomebarato.com/<? echo @$modulo;?></title>
    <meta name="title" content="Para Vender para comprar <? echo trim($_SESSION["usuario"]);?> é o Lugar ">
    <meta name="description" content="Em <? echo $_SESSION["cidade"];?> só carrobomebarato.com/<? echo trim($_SESSION["usuario"]);?> tem os melhores carros  ">
    <meta name="keywords" content="carrobomebarato.com/<? echo $_SESSION["usuario"];?>,<? echo $_SESSION["usuario"]; ?>,classificados carros ,anuncio gratis">
        <link rel="icon" type="image/jpg" href="img/favicon.ico"  "> 
	<? } else { ?>
	
 <meta http-equiv="Content-Type" content="text/html;  />
	<meta name="language" content="pt-br">
	<meta name="resource-type" content="document">
 	<meta name="revisit-after" content="1">
	<meta name="rating" content="General">
	<meta name="author" content="carrobomebarato.com">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta name="distribution" content="global">
	<meta name="category" content="shopping">
	<meta name="ms.locale" content="pt-br">
	<title>carrobomebarato.com/<? echo @$modulo;?></title>
    <meta name="title" content="Para Vender para comprar aqui é  Lugar ">
    <meta name="description" content="Em todo Brasil só carrobomebarato.com tem os melhores carros ">
    <meta name="keywords" content="carrobomebarato.com,classificados carros,carros usados,usados,gol usado,fiet usado,uno usasado ,anuncio gratis,carro,bom,barato,celta ,corsa ,preisma">
     <link rel="icon" type="image/jpg" href="img/logo.jpg"  sizes="36x36"> 
<? } ?> 
