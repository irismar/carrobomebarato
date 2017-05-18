<div class="caixa"><div class="container">
    <div class="navbar navbar-default ">
   <div class="col-md-6">
   
<? if( @$row_estoque1['idfacebook'] <>''){ ?> 
   <a href=" /<?= $_SESSION['usuario']?>" > <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture"></a> 
   <? }else{ ?> 
   <img src="/galeriadefotos/grd/<? if (($row_estoque1['foto'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque1['foto'])))) { echo $row_estoque1['foto']; } else { echo "avatar.jpeg"; } ?>" ></a> 

   <? } ?>
</div>

<div class="col-md-6">
 
<? if (isset($_SESSION["endereco1"])){ ?>
 <iframe width="100%" scrolling="no" height="320" frameborder="0" id="map" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?saddr=<? echo trim($_SESSION["endereco1"]); ?>&daddr=<? echo trim($row_estoque1['endereco']); ?>&output=embed"></iframe>
 <? }else { ?>
<iframe width="100%" scrolling="no" height="320" frameborder="0" id="map" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?saddr=<? echo trim($row_estoque1['endereco']); ?>&output=embed"></iframe>
	

<? } ?> 
</div>
   <div class="col-md-12"> <div id="caixa_redesocial">
  <div class="media">

   
  <div class="tell">  <span class="glyphicon glyphicon-user" aria-hidden="true">
        <a href="#" class="navbar-link"><? echo $row_estoque1['nome'] ?></a> </span> 
         <span class="glyphicon glyphicon-map-marker" aria-hidden="true">
        <a href="#" class="navbar-link"><?=$row_estoque1['endereco']?></a></span> </p>
       </div><? if ( $row_estoque1['watapps']){ ?>  <div class="tell">
  <img src="/img/icone-whatsapp10.png">
        <a href="#" class="navbar-link"><? echo  $row_estoque1['watapps'] ;?></a> </div>
	  <? }  ?>
      <? if ( $row_estoque1['oi']){ ?><div class="tell"> 
        <img src="/img/icone_oi10.png">
        <a href="#" class="navbar-link"><? echo  $row_estoque1['oi'] ;?></a> </div>
	  <? }  ?>
      <? if( $row_estoque1['tim']){ ?> <div class="tell">
       <img src="/img/icone_tim10.png" >
        <a href="#" class="navbar-link"><? echo  $row_estoque1['tim'] ;?></a></div>
	  <? }  ?>
      <? if( $row_estoque1['vivo']){ ?> <div class="tell">
       <img src="/img/17-mascoteVIVO10.png" >
        <a href="#" class="navbar-link"><? echo  $row_estoque1['vivo'] ;?></a> </div>
	  <? }  ?>
       <? if ( $row_estoque1['claro']){ ?><div class="tell"> 
       <img src="/img/claro-logo-510.png">
        <a href="#" class="navbar-link"><? echo  $row_estoque1['claro'] ;?></a> </div>
	  <? }  ?>
      </div> </div>
  
   </div></div>
  <div class="col-md-12"> 
 <ul class="nav nav-pills" role="tablist">
 
   <? 
    if(isset($modulo)&& isset($_SESSION['usuario'])&&    @$modulo==$_SESSION['usuario']){
    
     ?>
    <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>gerente?vendido">Carros anuciados <span class="badge"><?=$row_estoque1['carros_total']?></span></a></li>
	     <? }else{ ?>
          <li role="presentation" class="active"><a href="">Carros anuciados <span class="badge"><?=$row_estoque1['carros_total']?></span></a></li>
         
     <? } ?>
     
     
     
       <?  if(isset($modulo)&& isset($_SESSION['usuario'])&&    @$modulo==$_SESSION['usuario']) {?>
       
       <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>gerente/vendidos#gerente">Carros Vendidos<span class="badge"><?=$row_estoque1['carros_vendido']?></span></a></li>
	     <? }else{ ?>
         <li role="presentation" class="active"><a href="#">Carros Vendidos<span class="badge"><?=$row_estoque1['carros_vendido']?></span></a></li>
         
     <? } ?>
     
     
     
       
 
 
 
  
  <li role="presentation" class="active"><a href="#">Carros  à Venda Hoje<span class="badge"><?=$row_estoque1['carros']?></span></a></li>
 
   <? if(isset($modulo)&& isset($_SESSION['usuario'])&&    @$modulo==$_SESSION['usuario']){?>
	 <li role="presentation"><a href="<?  echo URL::getBase(); ?>gerente/mensagens#gerente">Novas Mensagens <span class="badge"><?=$row_estoque1['alertamanesagem']?></span></a></li>
      <li role="presentation"><a href="<?  echo URL::getBase(); ?>gerente/acessos#gerente">Alerta Acesso  <span class="badge"><?=$row_estoque1['alvit']; ?></span></a></li>
 <? } ?>
 
 
   <? if(isset($modulo)&& isset($_SESSION['usuario'])&&    @$modulo==$_SESSION['usuario']){?>
	 <li role="presentation"  class="active"><a href="<?  echo URL::getBase(); ?>adicionar" style="background-color:#F63;">Criar Anúncio Grátris<span class="badge"></span></a></li>
     <? }else{ ?>
   <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>mapa?rumo=<?= $row_estoque1['id'];?>">Traçar RotaGPS   <span class="badge"></span></a></li>
    <? } ?>
</ul>
  
  </div></div> 