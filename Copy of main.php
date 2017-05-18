 <?php 
  $_SESSION["vertical"]="ok";
 $row_estoque["modelotexto"]; $modelo1 = explode(" ",$row_estoque["modelotexto"]);
   $modelo1[0]; 
  $sql_opcionais = "SELECT A.acessorios FROM acessorios_carros AS AC 
  INNER JOIN acessorios AS A ON (A.id = AC.id_acessorios)
  WHERE id_estoque ='".$row_estoque['Id_estoque']."'";
   $query = $mysql->query($sql_opcionais);
$totalRows_opcionais = $query->num_rows;  
  if (isset( $_GET['responder_proposta'])){ 
  $id_resposta= alphaID($_GET['responder_proposta'] ); 
$mysql->query = "UPDATE propostas SET resposta='".$_POST['resposta']."' ,data_resposta='".$hora."'  WHERE id = ".$id_resposta."";

  } if (IsLoggedIn()){ 
   $sql2 ="SELECT * FROM acessos WHERE  visitado ='" . $_SESSION['usuario']. "'";
  $query2 = $mysql->query($sql2);
 $totalRows_acessos =$query2->num_rows;
 }
$data_inicial =FormataData($row_estoque['data_cadastro']);
$data_final = date('d.m.Y');
// Cria uma fun??o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun??o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen?a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen?a de dias
 $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
$dia=trim($dias);
// Exibe uma mensagem de resultado:
        if($row_estoque['vendido']=="NAO"){ 
	    if( ( $dia < "90")||(  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?><title>carrobomebarato.com</title>   
       <article class="white-panel">
 <div id="caixa_estoque"> 
<? if((@$_GET["horizontal"]) or (@$_SESSION["horizontal"]) && !isset($_GET["vertical"]) ){  
 $_SESSION["horizontal"]="ok";
unset($_SESSION["vertical"]); ?>
<?  
}elseif ((@$_GET["vertical"]) or (@$_SESSION["vertical"] && !isset($_GET["horizontal"])) ){  
 $_SESSION["vertical"]="ok";
unset($_SESSION["horizontal"]); ?>

  <div id="caixa_foto">

<a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['Id_estoque']); ?>">
		
<img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>
</div>	<div id="caixa_estoque89">  <a href="/<? echo trim( $row_estoque['nome_membro']); ?>"><img src="/galeriadefotos/peq/<? if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "avatar.jpg"; } ?>" class="caixa_estoque80"   ></a> 
        <div id="caixa_user">
		 <p><img src="images/remetente.png"> <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['nome_membro']); ?>"><? echo $row_estoque['nome_membro']; ?></a></p>
		 <p><img src="images/mapa.png" > <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['endereco']); ?>"><? echo $row_estoque['endereco']; ?> </a> <a href="?mapa=<? echo $row_estoque['Id_estoque'] ?>" style="color:#da251d; " >ver mapa </a> </p>
		
		 </div>  </div> <? } else { ?>
		 <div id="caixa_foto">
  <a href="<?  echo URL::getBase(); ?><? echo intval( $row_estoque['Id_estoque']); ?>">
<? if( $row_estoque['video'] <> ''){?>
 <? $url= $row_estoque['video'];
$url = str_replace("watch?v=", "embed/",   $url);

 ?> 
 <iframe  width="100%"  height="340"   src="<? echo $url;  ?>" frameborder="0" allowfullscreen></iframe></a>
				<? }else { ?>
		  <img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>
		<? } ?></div> 
		<div id="caixa_estoque89">  <a href="/<? echo trim( $row_estoque['nome_membro']); ?>">
	<? if($row_estoque['idfacebook'] <> '' && ($row_estoque['foto_membro']=='facebook')){?>	
		<img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture" class="caixa_estoque80"  >
		<? } else{?>
		<img src="/galeriadefotos/peq/<? if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "avatar.jpg"; } ?>" class="caixa_estoque80"  >
		<? } ?>
		</a> 
       <div id="caixa_user">eeeeeeeeeeeeeeeeeeeeeee
		 <p><img src="images/remetente.png"> <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['nome_membro']); ?>"><? echo $row_estoque['nome_membro']; ?></a></p>
		 <p><img src="images/mapa.png" > <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['endereco']); ?>"><? echo $row_estoque['endereco']; ?> </a> <a href="?mapa=<? echo intval($row_estoque['Id_estoque']) ?>" style="color:#da251d; " >Ver Mapa </a> </p>
	  
	   <p><img src="img/estoque.png" > <a href="<?  echo URL::getBase(); ?><? echo trim(  $row_estoque['nome_membro']); ?>">Veja todos os Carros </a></p>
	   </div>   <div id="caixa_telefone">
		 <? if( $row_estoque['watapps'] <>""){ ?>
		   <p> <img src="img/icone-whatsapp10.png" > <a href="#" style="color:#da251d; "><? echo mascara_string("(##)#####-####", $row_estoque['watapps']); ?> </a>  </p>
		   <? } ?>   
		 <? if( $row_estoque['oi'] <>""){ ?>
		   <p> <img src="img/icone_oi10.png" > <a href="#" style="color:#da251d; "><? echo $row_estoque['oi']; ?> </a>  </p>
		   <? } ?>
		     <? if( $row_estoque['tim'] <>""){ ?>
	      <p> <img src="img/icone_tim10.png"  > <a href="#" style="color:#da251d; "><? echo $row_estoque['tim']; ?> </a>  </p>
		   <? } ?>
		     <? if( $row_estoque['vivo'] <>""){ ?>
		   <p> <img src="img/17-mascoteVIVO10.png" width="19" height="20"  > <a href="#" style="color:#da251d; "><? echo $row_estoque['fixo']; ?> </a>  </p>
		   <? } ?> 
		     <? if( $row_estoque['claro'] <>""){ ?>
		   <p> <img src="img/claro-logo-510.png"  > <a href="#" style="color:#da251d; "><? echo $row_estoque['claro']; ?> </a>  </p>
		   <? } ?>
		     <? if( $row_estoque['fixo'] <>""){ ?>
	     <p> <img src="img/icon-tel10.png"  > <a href="#" style="color:#da251d; "><? echo $row_estoque['fixo']; ?> </a>  </p>
		   <? } ?>
		</div>  </div> 
<? } 
//////////qunado nada for usado//     inicio if                            //////?>
<? if ((@$_GET["vertical"]) or (@$_SESSION["vertical"] && !isset($_GET["horizontal"])) ){  
 $_SESSION["vertical"]="ok";
unset($_SESSION["horizontal"]); ?>
   <h1>
  <a href="<?  echo URL::getBase(); ?><? echo $row_estoque['marcatexto']; ?>">
	
	   <? echo $row_estoque['marcatexto']; ?>
	 
	  </a>  &nbsp;&nbsp;
	
	  <?
	  if(@$ordem21){ ?>
	<a href="<?php echo $link; ?>&&ordem=menorpreco"  >- <? echo  acento('Preço'); ?></a>
	<? }  
	elseif(@$ordem22){ ?>
	<a href="<?php echo $link; ?>&&ordem=maiorpreco"  >+ <? echo  acento('Preço'); ?></a>
	<? }
	 else{  ?>
	
	<a href=" <?php echo $link; ?>&&ordem=menorpreco"  >- <? echo  acento('Preço'); ?></a>
	<? }  
	
	
	  
	  if(@$ordem23){ ?>
	<a href="<?php echo $link; ?>&&ordem=seminovo"  > <? echo  acento('- Novo'); ?></a>
	<? }  
	elseif(@$ordem24){ ?>
	<a href="<?php echo $link; ?>&&ordem=novo"> <? echo  acento('+ Novo'); ?></a>
	<? }
	 else{  ?>
	
	<a href=" <?php echo $link; ?>&&ordem=novo"  > <? echo  acento('Novo'); ?></a>
	<? }  ?>
	 
	 &nbsp;&nbsp; <a href="?l=<? echo $row_estoque['cidade'];?>&&e=<?php echo $row_estoque['estado']; ?>"  ><? echo  removeAcentos($row_estoque['cidade']);?></a> <a href="?e=<?php echo  $row_estoque['estado']; ?>"  ><?php echo acento($row_estoque['estado']);?></a> <a href="?p=Brasil"><?php echo 'Brasil';?></a></h1>

<div id="caixa_gostei"> 

	<? if((  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?>
	<div id="caixa_telefone">  
		  <a href="editar_veiculos?Id_estoque=<? echo alphaID($row_estoque['Id_estoque']); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" ><img src="images/edit.gif"> </a>
  <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>"><img src="images/dinheiro.png">Vendido </a>
   <h1> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');">
<img src="/images/logo_facebook_arrendodado.png"></a><space></h1>
 <h1>  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://carrobomebarato.com/'".$row_estoque['Id_estoque']."'") ;?>"><img src="/images/logo_twitter_arrendodado.png"></a><space></h1>
 <h1>  <a href="#"><img src="/images/instagram.png"></a></h1>

<h1>  <a href="#"><img src="/images/tumblr.png"></a></h1>    </div>  <? }  else{ ?>    
<h1>
 <a href="acao.php?gostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handUp.png"> <space><? echo $row_estoque['gostei']; ?></a> </h1>
 <h1>  <a href="acao.php?naogostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handDown.png"> <space><? echo $row_estoque['naogostei']; ?></a></h1>
    <h1> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato..com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');">
								
							<img src="/images/logo_facebook_arrendodado.png"></a></h1>
<h1>  <a href="#"><img src="/images/instagram.png"></a></h1>
<h1>  <a href="#"><img src="/images/tumblr.png"></a></h1>
<h1>  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://www.criarweb.com/css em CriarWeb.com.");?>"><img src="/images/logo_twitter_arrendodado.png" ></a><space></h1>
 				 	  
        
     <? }
	/////// fim if /////
	 
	  ?>  
	 
	 </div>


 <? }  elseif ((!isset($_GET["vertical"])) or (!isset($_SESSION["vertical"]) && !isset($_GET["horizontal"])) ){  
 if(@!isset($_GET["horizontal"]) && (@!isset($_SESSION["horizontal"] ))){ 
  ?>

 <h1>
 
  
 <?  if ($modulo==""){ ?><a href="?l=<? echo $row_estoque['cidade'];?>&&e=<?php echo $row_estoque['estado']; ?>&&ordem=menorpreco"  >- <? echo   acento('Preço'); ?></a> <? } else{
	  if(@$ordem21){ ?>
	<a href="<?php echo $link; ?>&&ordem=menorpreco"  >- <? echo   acento('Preço'); ?></a>
	<? }  
	elseif(@$ordem22){ ?>
	<a href="<?php echo $link; ?>&&ordem=maiorpreco"  >+ <? echo   acento('Preço'); ?></a>
	<? }
	 else{  ?>
	
	<a href=" <?php echo $link; ?>&&ordem=menorpreco"  >- <? echo   acento('Preço'); ?></a>
	<? }}  ?>
	
	&nbsp;&nbsp;
	<?  if ($modulo==""){ ?><a href="?l=<? echo $row_estoque['cidade'];?>&&e=<?php echo $row_estoque['estado']; ?>&&ordem=novo"  > <? echo acento('+ Novo'); ?></a> <? } else{
	  if(@$ordem23){ ?>
	<a href="<?php echo $link; ?>&&ordem=seminovo"  > <? echo  acento('- Novo'); ?></a>
	<? }  
	elseif(@$ordem24){ ?>
	<a href="<?php echo $link; ?>&&ordem=novo"> <? echo  acento('+ Novo'); ?></a>
	<? }
	
	 else{  ?>
	
	<a href=" <?php echo $link; ?>&&ordem=novo"  > <? echo  acento('Novo'); ?></a>
	<? }  } ?>
	&nbsp;&nbsp; <a href="?l=<? echo $row_estoque['cidade'];?>&&e=<?php echo  $row_estoque['estado']; ?>"  ><? echo corigir($row_estoque['cidade']);?></a>&nbsp;&nbsp; <a href="?e=<?php echo $row_estoque['estado']; ?>"  ><?php echo trim($row_estoque['estado']);?></a>&nbsp;&nbsp;<a href="?p=Brasil"><?php echo 'Brasil';?></a></h1>
 <div id="caixa_gostei"> 
	<? if((  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?> 
		 <div id="caixa_telefone"> 
		 <h2> <a href="editar_veiculos?Id_estoque=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" ><img src="images/edit.gif"> </a></h4>
 <h4> <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>"><img src="images/dinheiro.png">Vendido </a></h4>
  <h4> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');"><img src="/images/logo_facebook_arrendodado.png"></a></h4>
<h4> <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://carrobomebarato.com/".$row_estoque['Id_estoque']."") ;?>"><img src="/images/logo_twitter_arrendodado.png"></a></h4>
<h4> <a href="#"><img src="/images/instagram.png" border="0"></a></h4>

<h4>  <a href="#"><img src="/images/tumblr.png" border="0"></a></h4>   </div>  
<? }  else{ ?>    
  <div id="caixa_telefone"> 
  <? if(file_exists("marcas/".$row_estoque['marcatexto'].".png")){ ?>
   <a href="/<? echo trim( $row_estoque['marcatexto']); ?>"> <img src="/marcas/<? if (($row_estoque['marcatexto'].".png"<> '') and ((file_exists("marcas/".$row_estoque['marcatexto'].".png")))) { echo $row_estoque['marcatexto'].".png"; } else { echo $row_estoque['marcatexto']; } ?>"></a>
		
  
  <? } ?>
  
 <h4><a href="acao.php?gostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handUp.png"> <space><? echo $row_estoque['gostei']; ?></a> </h4>
 <h4>  <a href="acao.php?naogostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handDown.png"> <space><? echo $row_estoque['naogostei']; ?></a></h4>
    <h4> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');">
								
							<img src="/images/logo_facebook_arrendodado.png"></a></h4>
<h4>  <a href="#"><img src="/images/instagram.png"></a></h4>
<h4>  <a href="#"><img src="/images/tumblr.png"></a></h4>
<h4>  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://www.carrobomebarato.com");?>"><img src="/images/logo_twitter_arrendodado.png" ></a><space></h4>
 				 	  
        
   </div>   <? } ?>  </div>

<? } } ?>  
		   
	 
	 
	 
	
		   </div> 
		   <? if((@$_GET["horizontal"]) or (@$_SESSION["horizontal"]) && !isset($_GET["vertical"]) ){  
 $_SESSION["horizontal"]="ok";
unset($_SESSION["vertical"]); ?>
<div id="caixa_estoque89">  <a href="/<? echo trim( $row_estoque['nome_membro']); ?>"><img src="/galeriadefotos/peq/<? if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "avatar.jpg"; } ?>"  class="caixa_estoque80"  ></a> 
       <div id="caixa_user">
		 <p><img src="images/remetente.png"> <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['nome_membro']); ?>"><? echo $row_estoque['nome_membro']; ?></a></p>
		 <p><img src="images/email.png" > <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['nome_membro']); ?>"><? echo @$row_estoque['email']; ?></a></p>
		 <p><img src="images/phone.png" > <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['endereco']); ?>"  style="color:#da251d; font-size:12px " ><? echo $row_estoque['carros']; ?> </a>
		 <p><img src="images/remetente.png"> <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['nome_membro']); ?>"><? echo $row_estoque['nome_membro']; ?></a></p>
		 <p><img src="images/mapa.png" > <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['endereco']); ?>"><? echo $row_estoque['endereco']; ?> </a> <a href="?mapa=<? echo intval($row_estoque['Id_estoque']) ?>" style="color:#da251d; font-size:12px " >ver mapa </a> </p>
		
  </div>
		   </div>
		 <div class="hoverzoom">ffffffffffff
		
  <a href="<?  echo URL::getBase(); ?><? echo trim( $row_estoque['Id_estoque']); ?>">
				
		  <img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']."llll"; } else { echo "semimagem.png"; } ?>"></a>
		</div> <div id="caixa_gostei"> <h1>
 
    
	 <a href="<?  echo URL::getBase(); ?><? echo $row_estoque['marcatexto']; ?>">
	 
	 <? if (file_exists("images/".$row_estoque['marcatexto'].".png")){ ?>
	  <img src="images/<? if (($row_estoque['marcatexto'].".png" <> '') and ((file_exists("images/".$row_estoque['marcatexto'].".png")))) { echo $row_estoque['marcatexto'].".png"; } else { echo "avatar.jpg"; } ?>">
	   <? } else { ?>
	   <? echo 'Marca:'. $row_estoque['marcatexto']; ?>
	  <? }?>
	  </a> </h1>   
	<? if((  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?> 
		  
  <a href="editar_veiculos?Id_estoque=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro']) ; ?>" ><img src="images/edit.gif"> </a>
  <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>"><img src="images/dinheiro.png">Vendido </a>
   <h1> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.890.com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');">
<img src="/images/logo_facebook_arrendodado.png"></a><space></h1>
 <h1>  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://carrobomebarato.com/'".$row_estoque['Id_estoque']."'") ;?>"><img src="/images/logo_twitter_arrendodado.png"></a><space></h1>
 <h1>  <a href="#"><img src="/images/instagram.png"></a></h1>

<h1>  <a href="#"><img src="/images/tumblr.png"></a></h1>     <? }  else{ ?>    
   <h2>
 <a href="?ordem=preco"  ><? echo  acento('Preço'); ?></a> &nbsp;&nbsp;<a href="?ordem=ano"  ><? echo  acento('Ano'); ?></a>&nbsp;&nbsp; <a href="/<? echo $row_estoque['cidade'];?>"  ><? echo $row_estoque['cidade'];?></a></a> <a href="estado=<? echo $row_estoque['estado']; ?>"  ><? echo $row_estoque['estado'];?></a></h2>
  <h1>
 <a href="acao.php?gostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handUp.png"> <space><? echo $row_estoque['gostei']; ?></a> </h1>
 <h1>  <a href="acao.php?naogostei=<? echo $row_estoque['Id_estoque']; ?>"><img src="/images/handDown.png"> <space><? echo $row_estoque['naogostei']; ?></a></h1>
    <h1> <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>" onclick="return open_facebook('http://carrobomebarato.com/<? echo $row_estoque['Id_estoque'];?>');">
								
							<img src="/images/logo_facebook_arrendodado.png"></a></h1>
<h1>  <a href="#"><img src="/images/instagram.png"></a></h1>
<h1>  <a href="#"><img src="/images/tumblr.png"></a></h1>
<h1>  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://www.criarweb.com/css em CriarWeb.com.");?>"><img src="/images/logo_twitter_arrendodado.png" ></a><space></h1>
 				 	  
        
     <? } ?>  </div>
<?  }?>

	  <div id="caixa_descricao"> 

			  
    <p> <a href="<?  echo URL::getBase(); ?><? echo  $modelo1[0]; ?>" style="color:#387DC2; font-size:12px"><? echo   $row_estoque['modelotexto']; ?></a>
</p>

<p><img src="images/dinheiro.png" > <a href="#">
    <? if (isset($row_estoque['preco'])){ ?>
    <? echo "R$". '&nbsp;'.  @number_format(trim($row_estoque['preco']), 2, ',', '.');
?></a>  <? } else { echo " R$ A  combinar" ; } ?> </p>
  
        <p><img src="/images/calendario.png"> <a href="#"> <? echo $row_estoque['ano'];?> /<? echo $row_estoque['ano2'];?></a></p>
        <p> <img src="images/roda-0.png"><a href="#"><? echo"KM". '&nbsp;'. @number_format( $row_estoque['km'], 0, '.', '.') ;?></a></p>
 
    <?    if((@$_SESSION['usuario']==@$row_estoque['nome_membro'])){ ?> 	
		<p><img src="images/outros-0.png"><a href="gerente.php?ver_visita">Acessos &nbsp;<? echo $row_estoque['acessos'];?> Ver Relatório </a></p>
    <? }else{  ?>
	    <p><img src="images/horario_icone.png"><a href="#">&nbsp;<? echo @$row_estoque['condicoes'];?>  </a></p>
		   <? } ?>
		<p><img src="images/local.png"><a href="/<? echo $row_estoque['cidade']; ?>"><? echo $row_estoque['cidade']; ?></a>&nbsp;&nbsp;<a href="e=<? echo  $row_estoque['estado']; ?>"><? echo $row_estoque['estado']; ?></a>
        <p><a href="#">  <?

				  
echo calculardias($row_estoque['data_cadastro']);?>
 

</a>

				  
	 </div> 
 <?  if($dia >'90'){  ?><div id="caixa_taxa"> 
          <h1>Seu Anúncio tem mais de 90 dias e não estar mas visivel no site se você ja vendeu clik<a href="acao.php?vendido=<? echo alphaID ( $row_estoque['Id_estoque']); ?>"> AQUI</a><br> Se quer mais 90 dias gratis clik <a href="acao.php?90dias=<? echo  alphaID ( $row_estoque['Id_estoque']); ?>">AQUI</a><br> <h1>Seu  anuncio não estar visivel no site </h1>;
</h1></div><? }else {
?>
	          
		<div id="caixa_taxa"> 
		
                 <?php
				 
				if( $row_estoque['preco'] !=""){
$tx_fin_A = $row_estoque['taxa'];
$tx_fin_B =$row_estoque['taxa'];
$valor = $row_estoque['preco'];
$fin = $tx_fin_B;
$entrada = $row_estoque['entrada'];

$ameses = array('12','24','36','42','60');



$valor = str_replace(".","",$valor);
$valor = str_replace(",",".",$valor);


if ($fin == "a") {
$tx_juros = "$tx_fin_A";
} else {
$tx_juros = "$tx_fin_B";
}
$conta_valor = $valor - ($valor * $entrada);
$conta_entrada = $valor - $conta_valor;
$valor_entrada = number_format($conta_entrada, 2, ',', '.');


?>

        
         <p>  <a href=""> R$  <?php echo @number_format($valor, 2, ',', '.');?></a></p>
<?		   if(isset($row_estoque['taxa']) && ($row_estoque['taxa']!="0")){ ?>
           <p> Entrada  <? echo  @number_format($conta_entrada, 2, ',', '.');?></p>
           <p>Restante de   <? echo  @number_format($conta_valor, 2, ',', '.');?></p>
         
         
<?php

for ($n = 0; $n < count($ameses); $n++) {
$conta_valor = $valor - ($valor * $entrada);
$conta_entrada = $valor - $conta_valor;
$conta_taxa = ($tx_juros / 100);
$conta = pow((1 + $conta_taxa), $ameses[$n]);
$conta = (1 / $conta);
$conta = (1 - $conta);
$conta = ($conta_taxa / $conta);
$parcela = ($conta_valor * $conta);
$total_geral = $conta_entrada + ($parcela * $ameses[$n]);
$total_geral = number_format($total_geral, 2, ',', '.');
$conta_valor = number_format($conta_valor, 2, ',', '.');
?>
       
        <p><?php echo $ameses[$n];?> X
         R$ <?php echo number_format($parcela, 2, ',', '.');?></p>
        
      
<?php  
}

$juros = ($conta_taxa * 100);
$juros = number_format($juros, 2, ',', '.');
?>


      
         
          <?php  $juros;?>
<? } } else { ?> <p>  <a href=""> R$  Preço á Combinar</a></p> <? }  }
 ?>
	</div> <div id="caixa_gostei">   
 	<? if ($totalRows_opcionais != 0){ ?>      <? 
	
	do {   echo @$row_opcionais['acessorios']."&nbsp;&nbsp;&nbsp;";  
		    
     } while($row_opcionais =  $query->fetch_assoc());
        

	?>  </div> 
	
	
 <? } 
 ?> <div id="caixa_gostei">     <?  echo $row_estoque['descricao'];	?></div>   
    <div id="caixa_estoque88">   
  <?
	  
	   
	   if (IsLoggedIn()){ 
	     if( $_SESSION['usuario']== $row_estoque['nome_membro']) { 
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //////////////////////////////codigo mensagem//////////////////////////////////////////////////////////////
	 $sql2  = "SELECT * FROM propostas WHERE id_estoque ='" .  $row_estoque['Id_estoque']. "'	 AND Destinatario='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql2);
@$totalRows_propostas = $query2->num_rows;
  if ( $totalRows_propostas != 0) { ?>
  <div id="ver_descricao_estoque">  <a href="acao.php?deletartudo=<?php echo alphaID($row_estoque['Id_estoque'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar todas estas Mensagem</a>
                 <? while ($query_cont= $query2->fetch_assoc()) {  ?>
                  <div id="caixa_estoque1">
                 <div id="ver_descricao_foto22"><?
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_cont['foto'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <? } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg"  class="caixa_estoque80"  width="50" height="60"> 
                              <?   } ?> </div>
                             <div id="ver_descricao_foto2"><h1> <a href="#"><strong class="vermelho_11px"><? echo  $query_cont['mensagem']; ?></strong></a></h1>
                             <h1><a href="">&nbsp;&nbsp; <? echo  $query_cont['remetene']; ?><a href="">&nbsp;&nbsp;<? echo  @$query_cont['watappss']; ?></a> <a href="">&nbsp;&nbsp;<?php echo calculardias( $query_cont['data']); ?> </a>  </h1>
 	                         <h1>  <a href="acao.php?deletar_eudestinatario=<?php echo alphaID($query_cont['id'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a></h1>   <?
							 if (@$query_cont['respondido']=="1")  {  
							
 $sql= "SELECT * FROM propostas WHERE resposta ='" . $query_cont['id']. "'	 AND remetene='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql);
 @$totalRows_propostas33 =$query2->num_rows;
 if ( $totalRows_propostas33 != 0) { ?> </div>
  <div id="ver_descricao_estoque">
                 <? while ($query_cont33 =  $query2->fetch_assoc()) {  ?>
                  <div id="caixa_estoque_resposta">
                 
                               

                               <div id="ver_descricao_foto2">
                              </br> <a href="#"><strong class="azul_resposta"><? echo  $query_cont33['mensagem']; ?></strong></a>
                               </div> <div id="ver_descricao_foto"><?
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_cont33['foto'] ;?>"   width="50" height="60"> 
                              <? } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg"   width="50" height="60"> 
                              <?   } ?> </div><div id="ver_descricao_foto2">
                           <h1><p> <a href="">&nbsp;<?php echo calculardias( $query_cont33['data']); ?> </a> 
	                       </p>&nbsp;&nbsp; <a href="acao.php?deletar=<?php echo alphaID($query_cont33['id'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a>  </h1>
                           </div></div> <? } ?>  <? } } else {?><? 	}					
							   if (@$query_cont['foto']) {  ?> 
							     <div id="caixa_redesocial">
   <form action="acao.php?responder=<? echo  $query_cont['remetene']; ?>&&id_estoque=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>&&resposta=<?php echo  $query_cont['id']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo @$row_estoque['email']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" ></textarea>
      <input name="enviar" type="submit" class="botao2"value="enviar">
      
                    </form> </div>
                      <?   } ?>
	                                  
    </div>  <? }?>
            </div></div>  <? }
		 
		
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //////////////////////////////fom codigo mensagem///////////////////////////////////////////////////////////// 
		 
		 
		   //////////////////////////////////////INICIO/////////////////////////////////////////////////////////////////
		 //////////////////////////////Codigo Visita se usuario tiver visita /////////////////////////////////////////////////////////////
		 if( $row_estoque['acessos']!="0"){
		  $sql2 =  "SELECT * FROM acessos WHERE  visitado ='" . $_SESSION['usuario']. "' AND id_estoque='". $row_estoque['Id_estoque']."' ORDER BY id DESC  ";  
  $query2 = $mysql->query($sql2);
	if ($query2->num_rows != 0) { 
    
 ?><div id="caixa_estoque"><a href="acao.php?deletartudo=<?php echo alphaID($row_estoque['Id_estoque'] ); ?>"><strong class="vermelho_11px"><img src="/images/lixo.png" width="22" height="24" />Deletar Visitas</strong></a> </div><?
		 while($query_vicitas= $query2->fetch_assoc()) {  
	   ?>
 
       <div id="caixa_estoque1">            
    <div id="ver_descricao_foto22">
	<? if (@ $query_vicitas['foto_carro']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_vicitas['foto_carro'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <? } else{ ?>
                             <img src="galeriadefotos/peq/avatar.jpg"   class="caixa_estoque80"  width="50" height="60"> 
                              <?   } ?> 
	</div>
    <div id="ver_descricao_foto2"><h1><? echo  $query_vicitas['marca'].'&nbsp;'.$query_vicitas['modelo']; ?></a> </h1>
     <a href="">&nbsp;&nbsp; <?   echo $query_vicitas['endereco'].'&nbsp;'.$query_vicitas['cidade'].'&nbsp;'.$query_vicitas['estado'];  ?></a> 
   <a href="">&nbsp;&nbsp;<? echo calculardias($query_vicitas['data']); ?> 
      </a></h1> 
    
    </div> </div>
    
    <?  } 	} }
		 
		    ///////////////////////////////////////FIM///////////////////////////////////////////////////////////
		 //////////////////////////////Codigo Visita se usuario tiver visita /////////////////////////////////////////////////////////////
		 
		 
		 
		   }

       else{ 
	   //////////////////////////////////////////////////////////exibir mensagem que eu enviei ///////////////////////
	       //////////////////////////////////////////////////////////comelo////////////////////////////////////////////////
	    ?> <?
	  $sql2 = "SELECT * FROM propostas WHERE id_estoque ='" .  $row_estoque['Id_estoque']. "'	 AND remetene='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99";   
      $query2 = $mysql->query($sql2);
	  @$totalRows_propostas = $query2->num_rows;
      if ( $totalRows_propostas != 0) { ?>
  <div id="ver_descricao_estoque">  <a href="acao.php?DTM=<?php echo alphaID($row_estoque['Id_estoque']); ?>"><strong class="vermelho_11px"><img src="/images/lixo.png" width="22" height="24" />Deletar todas esta Mensagem</strong></a>
              <?  while($query_cont= $query2->fetch_assoc()) {    ?>
                  <div id="caixa_estoque1">
                  <div id="ver_descricao_foto"><?
                     if (@$query_cont['foto']) { ?>
                     <img src="/galeriadefotos/peq/<?php echo $query_cont['foto'] ;?>" class="caixa_estoque80" width="50" height="60"> 
                     <? } else{ ?>
                     <img src="/galeriadefotos/peq/avatar.jpg" class="caixa_estoque80" width="50" height="60"> 
                     <?   } ?> </div>
                     <div id="ver_descricao_foto2"><h1><a href="#"><strong class="vermelho_11px"><? echo  $query_cont['mensagem']; ?></strong></a></h1>
                     <h1>  <a href="">Nome:&nbsp; <? echo  $query_cont['remetene']; ?> </a>&nbsp;&nbsp;<a href="">Telefone:&nbsp;<? echo  @$query_cont['email']; ?></a> &nbsp;&nbsp;  <a href="">&nbsp;&nbsp;<?php echo calculardias( $query_cont['data']); ?> </a>  </h1>
	                 <h1>  <a href="acao.php?deletar_euremetente=<?php echo alphaID($query_cont['id']); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a>  </h1>
							 
	                                  
    </div><?
	 if (@$query_cont['respondido']="1")  { 
 $sql2 = "SELECT * FROM propostas WHERE resposta ='" . $query_cont['id']. "'	 AND Destinatario='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql2);
	  @$totalRows_propostas = $query2->num_rows;
  if ( $totalRows_propostas != 0) { ?>
 <div id="ver_descricao_estoque">
      <? while ($query_cont = $query2->fetch_assoc()) {  ?>
          <div id="caixa_estoque_resposta"> 
  <div id="ver_descricao_foto2"><a href="#"><strong class="azul_resposta"><? echo  @$query_cont['mensagem']; ?></strong></a></div>
           <div id="ver_descricao_foto"><?
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_cont['foto'] ;?>" class="caixa_estoque80" width="50" height="60"> 
                              <? } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg" class="caixa_estoque80" width="50" height="60"> 
                              <?   } ?> </div>      
   <div id="ver_descricao_foto2">             
     <h1> <a href=" "><img src="/images/remetente.png" width="20" height="22"> <? echo  $query_cont['remetene']; ?>
   <a href=" ">&nbsp; <? echo  @$query_cont['email']; ?></a>&nbsp; 
  <a href=" "> &nbsp;<?php echo @calculardias( $query_cont['data']); ?> </a>  </h1>
	<h1>  <a href="acao.php?deletar=<?php echo alphaID($query_cont['id'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a>  </h1>
							 
	                                  
   
                            </div> </div>  <? } ?> </div> <?	}} //////////////////////////////////////////////////////////////////fim resposta//////////////////
							  //////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	  }?>
            </div></div>  <? } 
	    //////////////////////////////////////////////////////////exibir mensagem que eu enviei ///////////////////////
	      //////////////////////////////////////////////////////////fim////////////////////////////////////////////////  
	   
	    if (@$_SESSION["mens_id_estoque"]==$row_estoque['nome_membro']) {  ?><div id="caixa_estoque99">
		<?   if (file_exists("galeriadefotos/peq/".@$_SESSION['foto'])) { ?>
  <img src="/galeriadefotos/peq/<?php echo @$_SESSION['foto'];?>" width="40" height="50" "> 
  <? } else{ ?>
  <img src="/galeriadefotos/peq/avatar.jpg" width="40" height="50" class="caixa_estoque80"> 
  <?   } ?>Mensagem Enviada com sucesso para <?php echo $row_estoque['nome_membro']; ?> </div><? }   
                       // se ja tiver enviado mensagem não exibir o formulario//               
       
     else { 
	      ///////////inicio//////se estiver logado nas são for for dono do anuncio///////
			?> <div id="caixa_redesocial">  <div id="caixa_estoque99"><?   if (file_exists("galeriadefotos/peq/".@$_SESSION['foto'])) { ?>
<img src="/galeriadefotos/peq/<?php echo @$_SESSION['foto'];?>" width="10" height="10" class="caixa_estoque80"> 
  <? } else{ ?>
  <img src="/galeriadefotos/peq/avatar.jpg" width="40" height="50" class="caixa_estoque80"> 
  <?   } ?>
   <form action="acao.php?memsagem=<? echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo $row_estoque['watapps']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" cols="22" rows="1"></textarea>
      <input name="enviar" type="submit" class="botao2"value="enviar">
      </form> </div></div><?
 /////////////////se estiver logado nas são for for dono do anuncio//fim/////
} ?><?  }
  
		  
		  } else { 
		  
		             // se ja tiver enviado mensagem não exibir o formulario//
					
		            if (@$_SESSION["mens_id_estoque"]==$row_estoque['Id_estoque']) {  ?><div id="caixa_estoque88"><a href="#"  style="color:#387DC2; font-size:12px">    Carro bom e barato informa Mensagem enviada com sucesso para <?php echo $row_estoque['nome_membro']; ?></a> </div><? }   
                       // se ja tiver enviado mensagem não exibir o formulario//               
       
     else { 


                      // codigo referente a mensagem usuario nao logado//
					  // codigo referente a mensagem usuario nao logado//
					 ?> <div> <div id="caixa_redesocial">     
     <form action="acao.php?memsagem=<? echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input  placeholder="Seu nome" name="nome" required  id="nome" />
     <input type="number" name="email"placeholder="Telefone" required   name="email" id="email" />
     <textarea name="memsagem"placeholder="Mensagem" cols="22" rows="1"></textarea>
     <input name="enviar" type="submit" class="botao2"value="enviar">
     </form>
 </div>  <?   } 
                      //codigo modificado para arender IE//
                      /*/*
<iframe src="framer_maim.php?id_estoque=<? echo $row_estoque['Id_estoque']; ?>&&nome_membro=<? echo $row_estoque['nome_membro'];?>&&foto_membro=<? echo $row_estoque['foto_membro'];?>&&id_membro=<? echo $row_estoque['id_membro'];?>&&carros=<? echo $row_estoque['carros'];?> " width="25%"  height="210px"  scrolling="No" id="centro_topo" ></iframe>//
     /*/
      } } }?>	