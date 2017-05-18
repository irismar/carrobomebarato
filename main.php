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

//Exibe uma mensagem de resultado:

 //se usuario setar pais exibir todos os carros////
?><title>carrobomebarato.com</title>  
 <article class="white-panel">




 <div id="caixa_estoque"> 
<div class="bordanotopo">
 <a href="<?php  echo URL::getBase(); ?><?php echo intval( $row_estoque['Id_estoque']); ?>"  onclick="javascript: altera_100('white-panel');">
 <?php if( $row_estoque['video'] <> ''){?>
 <?php $url= $row_estoque['video'];
 $url=str_replace("watch?v=", "embed/",   $url); ?> 
 <iframe  width="100%"  height="340"   src="<?php echo $url;  ?>" frameborder="0" allowfullscreen></iframe></a>
 <?php }else {?>
		  <img src="/galeriadefotos/capa/<?php if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/capa/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>
		<?php } ?></div>
 

       
       <div class="text-xs-center">
          <a href="<?php  echo URL::getBase(); ?><?php echo trim( $row_estoque['url']); ?>">
	<?php if($row_estoque['idfacebook'] <> '' && ($row_estoque['foto_membro']=='facebook')){?>	
    <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture" class="rounded" alt="...">
 

         
		<?php } else{?>
        
       
  <img src="/galeriadefotos/novo/<?php if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "avatar.jpg"; } ?>" alt="...">

		
        
		<?php } ?>
		</a> </div>
       <div id="caixa_redesocial8">
     <br />                                                                                                                                                                                                                                     
       <p class="navbar-text-center"><span class="glyphicon glyphicon-user img-circle img-responsive img-center" aria-hidden="true">
        <a href="<?php  echo URL::getBase(); ?><?php echo trim(  $row_estoque['url']); ?>"class="navbar-link"><?php echo $row_estoque['nome_membro']; ?></a> 
      
            
        <a href="#" class="navbar-link">
		<?php  if($dia=="0"){echo " agora";} 
		elseif($dia=="1"){ echo " 1 Dia";}else{ echo" há "."" .@$dia." "."Dias";} ?></a> 
        
       
     <?= $row_estoque['exibir'] ;?>
  <span class="glyphicon glyphicon-map-marker" aria-hidden="true">  <a href="#" class="navbar-link">   <? echo @$distancia= distancia( $row_estoque['lat'], $row_estoque['lon'],$_SESSION['lat'], $_SESSION['log']) ?> 
         
         KM de Distância </a> 
       </span> </p>
	 
        
        
		<p class="navbar-text-center"><span class=" glyphicon glyphicon-map-marker " aria-hidden="true">
                        <a href="<?php  echo URL::getBase(); ?>map?mapa=<?php echo intval($row_estoque['Id_estoque']) ?>"class="navbar-link"><?php echo trim(  $row_estoque['endereco']); ?></a> </span></p> 
        
        
        
     
        
	 
    
     
        <p class="navbar-text-center"><span class="glyphicon glyphicon-list-alt" aria-hidden="true">
        <a href="#" class="navbar-link">
		<?php echo "anúncios"." ".  $row_estoque['carros'];?></a> </span></p>
	   </div> 
 </div>
    <div id="caixa_redesocial2">
   
   
       <?php if( $row_estoque['watapps'] <>""){ ?>
       <div class="tell"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i>
      
        <a href="#" class="navbar-link"><?php echo $row_estoque['watapps'] ?></a> </div>  <?php } ?>
		
		
		     <?php if( $row_estoque['fixo'] <>""){ ?>
             
            <div class="tell"><i class="fa fa-phone fa-2x" aria-hidden="true"></i>
       <a href="tel:+<?php echo $row_estoque['fixo'] ?>"
  
 class="navbar-link"><?php echo $row_estoque['fixo'] ?></a> </p> </div>
        	    
		   <?php } ?>
 </div> 		
  <div class="col-md-12">
   
	<?php if((  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?>
    
     
   	 <a href="editar_veiculos?Id_estoque=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro']) ; ?>" >&nbsp;Editar&nbsp;<span></span> </a>
     
     
  <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" style="color:#396">&nbsp;Vendido&nbsp; </a>
  
   <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" style="color:#F60">&nbsp;&nbsp;Excluir Anuncio </a>
  </div> <div class="col-md-12">
  
  
 
   <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<?php echo trim(intval( $row_estoque['Id_estoque']));?>" onclick="return open_facebook('http://carrobomebarato.com/<?php echo trim(intval( $row_estoque['Id_estoque']));?>');">
<img src="/images/logo_facebook_arrendodado.png"></a>&nbsp;
  <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://carrobomebarato.com/'".$row_estoque['Id_estoque']."'") ;?>"><img src="/images/logo_twitter_arrendodado.png"></a>&nbsp;
   <a href="#"><img src="/images/instagram.png"></a>&nbsp;

  <a href="#"><img src="/images/tumblr.png"></a>     <?php }  else{ ?>  
 
  
                 <div class="tell">  
 	                    <a href="<?php  echo URL::getBase(); ?><?php echo $row_estoque['marcatexto']; ?>">
	                    <?php if (file_exists("images/".$row_estoque['marcatexto'].".png")){ ?>
	                    <img src="images/<?php if (($row_estoque['marcatexto'].".png" <> '') and ((file_exists("images/".                        $row_estoque['marcatexto'].".png")))) { echo $row_estoque['marcatexto'].".png"; } else { echo "avatar.jpg"                        ; } ?>">
	                    <?php } else {  echo 	$row_estoque['marcatexto'];  }?></a> 
                 </div>
      <div class="tell">  
            <a href="acao.php?gostei=<?php echo $row_estoque['Id_estoque']; ?>"><i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>
            <?php echo $row_estoque['gostei']; ?></a> 
 </div>
   <div class="tell"> <a href="acao.php?naogostei=<?php echo $row_estoque['Id_estoque']; ?>"><i class="fa fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i><?php echo $row_estoque['naogostei']; ?></a>
   </div>
    <a href="#"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>
   <a href="#"><i class="fa fa-pinterest-square fa-2x" aria-hidden="true"></i></a>
   <a href="#"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>
   <a href="#"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
  
   
   
   
   
     
   <?php } ?>  </div> 
     
     
    <div id="caixa_redesocial8">  
        <div class=" col-md-6"> <br />
<p> <a href="<?php  echo URL::getBase(); ?><?php echo  $modelo1[0]; ?>" style="color:#387DC2; font-size:12px"><?php echo   $row_estoque['modelotexto']; ?></a>
</p>


    <?php if (isset($row_estoque['preco'])){ ?>
        <p><i class="fa fa-money fa-2x" aria-hidden="true"></i> <a href="#"> <?php echo  '&nbsp;'.  @number_format(trim($row_estoque['preco']), 2, ',', '.');
?></a>
   
  <?php } else { ?>
    <p><i class="fa fa-money fa-2x" aria-hidden="true"></i><a href="#"></a></p>
    
    
    <? } ?> 
  
        <p><i class="fa fa-calendar-o fa-2x" aria-hidden="true"></i> <a href="#"> <?php echo $row_estoque['ano'];?> /<?php echo $row_estoque['ano2'];?></a></p>
        <p> <i class="fa fa-tachometer fa-2x" aria-hidden="true"></i><a href="#"><?php echo"KM". '&nbsp;'. @number_format( $row_estoque['km'], 0, '.', '.') ;?></a></p>
 
    <?php    if((@$_SESSION['usuario']==@$row_estoque['nome_membro'])){ ?> 	
		<p><i class="fa fa-line-chart fa-2x" aria-hidden="true"></i><a href="gerente/acessos#gerente">Acessos &nbsp;<?php echo $row_estoque['acessos'];?>  </a></p>
    <?php }else{  ?>
	    <p><i class="fa fa-heartbeat fa-2x" aria-hidden="true"></i><a href="#">&nbsp;<?php echo @$row_estoque['condicoes'];?>  </a></p>
		   <?php } ?>
		<p><i class="fa fa-map fa-2x" aria-hidden="true"></i><a href="/?l=<?php echo trim( $row_estoque['cidade']);?>&e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['cidade']; ?></a>&nbsp;&nbsp;<a href="/?e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['estado']; ?></a>
        <p><a href="#">  <?php

				  
 calculardias($row_estoque['data_cadastro']);?>
 

</a>

				  
	 </div> 
 <?php  if($row_estoque['exibir']=="0" && (isset($_SESSION['usuario']) && $_SESSION['usuario']==@$row_estoque['nome_membro'] ) ){  ?> <div class=" col-md-6">  <ul class="nav nav-pills" role="tablist">
         <li role="presentation" class="active"><a href="">Dias Anunciados <span class="badge"><?=$dia?></span></a></li>
          <h1>Seu Anúncio tem mais de 90 dias e não estar mas visivel no site <br> </h1>
          <li role="presentation" class="active"><a href="acao.php?90dias=<?php echo  alphaID ( $row_estoque['Id_estoque']); ?>">Quer mais 90 dias Grátis  <span class="badge">Clik aqui </span></a></li>
            </h1>;
         </ul></div><?php }else {
?>
	          
		  <div class=" col-md-6"> 
		
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
<?php		   if(isset($row_estoque['taxa']) && ($row_estoque['taxa']!="0")){ ?>
           <p> Entrada  <?php echo  @number_format($conta_entrada, 2, ',', '.');?></p>
           <p>Restante de   <?php echo  @number_format($conta_valor, 2, ',', '.');?></p>
         
         
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
<?php } } else { ?> </br>  <a href=""> R$  Preço á Combinar</a></p> <?php }  }
 ?>
	 <div id="caixa_gostei">   
 	<?php if ($totalRows_opcionais != 0){ ?>      <?php 
	
	do {   echo @utf8_encode($row_opcionais['acessorios'])."&nbsp;&nbsp;&nbsp;";  
		    
     } while($row_opcionais =  $query->fetch_assoc());
        

	?>  </div> 
	
	
 <?php } 
 ?>  <div id="caixa_gostei">     <?php  echo $row_estoque['descricao'];	?></div>   
</div></div>
 <?php

  if ($row_estoque['avisado']=="N"){ ?>
    <div id="caixa_estoque88">   
  <?php
	  
	   
	   if (IsLoggedIn()){ 
	     if( $_SESSION['usuario']== $row_estoque['nome_membro']) { 
		 
		 //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //////////////////////////////codigo mensagem//////////////////////////////////////////////////////////////
	 $sql2  = "SELECT * FROM propostas WHERE id_estoque ='" .  $row_estoque['Id_estoque']. "'	 AND Destinatario='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql2);
@$totalRows_propostas = $query2->num_rows;
  if ( $totalRows_propostas != 0) { ?>
  <div id="ver_descricao_estoque">  <a href="acao.php?deletartudo=<?php echo alphaID($row_estoque['Id_estoque'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar todas estas Mensagem</a>
                 <?php while ($query_cont= $query2->fetch_assoc()) {  ?>
                  <div id="caixa_estoque1">
                 <div id="ver_descricao_foto22"><?php
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/novo/<?php echo $query_cont['foto'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <?php } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg"  class="caixa_estoque80"  width="50" height="60"> 
                              <?php   } ?> </div>
                             <div id="caixa_respostas"><p><a href="#"><strong class="vermelho_11px"><?php echo  $query_cont['mensagem']; ?></strong></a></p></br>
                            <a href=""><?php echo  $query_cont['remetene']; ?></a>
							<a href=""><?php echo  @$query_cont['watappss']; ?></a> 
							 <a href=""><?php echo calculardias( $query_cont['data']); ?> </a>  </p>
 	                         <p>  <a href="acao.php?deletar_eudestinatario=<?php echo alphaID($query_cont['id'] ); ?>">Deletar</a></p>   <?php
							 if (@$query_cont['respondido']=="1")  {  
							
 $sql= "SELECT * FROM propostas WHERE resposta ='" . $query_cont['id']. "'	 AND remetene='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql);
 @$totalRows_propostas33 =$query2->num_rows;
 if ( $totalRows_propostas33 != 0) { ?> </div>
  <div id="ver_descricao_estoque">
                 <?php while ($query_cont33 =  $query2->fetch_assoc()) {  ?>
                  <div id="caixa_estoque_resposta">
                 
                               

                               <div id="ver_descricao_foto2">
                              </br> <a href="#"><strong class="azul_resposta"><?php echo  $query_cont33['mensagem']; ?></strong></a>
                               </div> <div id="ver_descricao_foto"><?php
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/novo/<?php echo $query_cont33['foto'] ;?>"   width="50" height="60"> 
                              <?php } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg"   width="50" height="60"> 
                              <?php   } ?> </div><div id="caixa_respostas">
                           <p> <a href="">&nbsp;<?php echo calculardias( $query_cont33['data']); ?> </a>  
	                      <a href="acao.php?deletar=<?php echo alphaID($query_cont33['id'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a></p>
                           </div></div> <?php } ?>  <?php } } else {?><?php 	}					
							   if (@$query_cont['foto']) {  ?> 
							     <div id="caixa_redesocial">
   <form action="acao.php?responder=<?php echo  $query_cont['remetene']; ?>&&id_estoque=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>&&resposta=<?php echo  $query_cont['id']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo @$row_estoque['email']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" ></textarea>
      <input name="enviar" type="submit" class="botao2"value="enviar">
      
                    </form> </div>
                      <?php   } ?>
	                                  
    </div>  <?php }?>
            </div></div>  <?php }
		 
		
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 //////////////////////////////fom codigo mensagem///////////////////////////////////////////////////////////// 
		 
		 
		   //////////////////////////////////////INICIO/////////////////////////////////////////////////////////////////
		 //////////////////////////////Codigo Visita se usuario tiver visita /////////////////////////////////////////////////////////////
		 if( $row_estoque['acessos']!="0"){
		  $sql2 =  "SELECT * FROM acessos WHERE  visitado ='" . $_SESSION['usuario']. "' AND id_estoque='". $row_estoque['Id_estoque']."' ORDER BY id DESC  ";  
  $query2 = $mysql->query($sql2);
	if ($query2->num_rows != 0) { 
    
            ?></div><div id="caixa_estoque"><a href="acao.php?deletartudo=<?php echo alphaID($row_estoque['Id_estoque'] ); ?>"><strong class="vermelho_11px"><img src="/images/lixo.png" width="22" height="24" />Deletar Visitas</strong></a> </div><?php
		 while($query_vicitas= $query2->fetch_assoc()) {  
	   ?>
 
       <div id="caixa_estoque1">            
    <div id="ver_descricao_foto22">
	<?php if (@ $query_vicitas['foto_carro']) { ?>
                          	  <img src="/galeriadefotos/novo/<?php echo $query_vicitas['foto_carro'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <?php } else{ ?>
                             <img src="/galeriadefotos/peq/avatar.jpg"   class="caixa_estoque80"  width="50" height="60"> 
                              <?php   } ?> 
	</div>
    <div id="caixa_respostas"><h1><?php echo  $query_vicitas['marca'].'&nbsp;'.$query_vicitas['modelo']; ?></a> </h1>
        <a href="" class=">" &nbsp;&nbsp; <?php   echo $query_vicitas['endereco'];  ?>  </h2>
  <p> <a href="">&nbsp;&nbsp;<?php echo calculardias($query_vicitas['data']); ?>  </p>
      </a></h1> 
    
    </div> </div>
    
    <?php  } 	} }
		 
		    ///////////////////////////////////////FIM///////////////////////////////////////////////////////////
		 //////////////////////////////Codigo Visita se usuario tiver visita /////////////////////////////////////////////////////////////
		 
		 
		 
		   }

       else{ 
	   //////////////////////////////////////////////////////////exibir mensagem que eu enviei ///////////////////////
	       //////////////////////////////////////////////////////////comelo////////////////////////////////////////////////
	    ?> <?php
	  $sql2 = "SELECT * FROM propostas WHERE id_estoque ='" .  $row_estoque['Id_estoque']. "'	 AND remetene='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99";   
      $query2 = $mysql->query($sql2);
	  @$totalRows_propostas = $query2->num_rows;
      if ( $totalRows_propostas != 0) { ?>
  <div id="ver_descricao_estoque">  <a href="acao.php?DTM=<?php echo alphaID($row_estoque['Id_estoque']); ?>"><strong class="vermelho_11px"><img src="/images/lixo.png" width="22" height="24" />Deletar todas esta Mensagem</strong></a>
              <?php  while($query_cont= $query2->fetch_assoc()) {    ?>
                  <div id="caixa_estoque1">
                  <div id="ver_descricao_foto"><?php
                     if (@$query_cont['foto']) { ?>
                     <img src="/galeriadefotos/peq/<?php echo $query_cont['foto'] ;?>" class="caixa_estoque80" width="50" height="60"> 
                     <?php } else{ ?>
                     <img src="/galeriadefotos/peq/avatar.jpg" class="caixa_estoque80" width="50" height="60"> 
                     <?php   } ?> </div>
                     <div id="caixa_respostas"><a href="#"><strong class="vermelho_11px"><?php echo  $query_cont['mensagem']; ?></strong></a></div> <div class="caixa_estoque">  
         <a href="#"><?php echo  $query_cont['remetene']; ?>
                   
         &nbsp; <?php echo 'Tell'. @$query_cont['email']; ?>
          
          
           &nbsp;<?php echo calculardias( $query_cont['data']); ?></a>
           
           
             <a href="acao.php?deletar_euremetente=<?php echo alphaID($query_cont['id']); ?>" style="color:#F33;">&nbsp;&nbsp;&nbsp;&nbsp;Deletar</a> 
                  </div>
                
							 
	                                  
    </div><?php
	 if (@$query_cont['respondido']="1")  { 
 $sql2 = "SELECT * FROM propostas WHERE resposta ='" . $query_cont['id']. "'	 AND Destinatario='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
  $query2 = $mysql->query($sql2);
	  @$totalRows_propostas = $query2->num_rows;
  if ( $totalRows_propostas != 0) { ?>
 <div id="ver_descricao_estoque">
      <?php while ($query_cont = $query2->fetch_assoc()) {  ?>
          <div id="caixa_estoque_resposta"> 
  <div id="ver_descricao_foto2"><a href="#"><strong class="azul_resposta"><?php echo  @$query_cont['mensagem']; ?></strong></a></div>
           <div id="ver_descricao_foto"><?php
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_cont['foto'] ;?>" class="caixa_estoque80" width="50" height="60"> 
                              <?php } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.jpg" class="caixa_estoque80" width="50" height="60"> 
                              <?php   } ?> </div>      
   <div id="caixa_respostas">             
     <p> <a href=" "><img src="/images/remetente.png" width="20" height="22"> <?php echo  $query_cont['remetene']; ?></p></br>
    <p><a href=" "> <?php echo  @$query_cont['email']; ?></a>  </p>
    <p> <a href=" "> &nbsp;<?php echo @calculardias( $query_cont['data']); ?> </a> </p>
	<p>  <a href="acao.php?deletar=<?php echo alphaID($query_cont['id'] ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a>  </p>
							 
	                                  
   
                            </div> </div>  <?php } ?> </div> <?php	}} //////////////////////////////////////////////////////////////////fim resposta//////////////////
							  //////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	  }?>
            </div></div>  <?php } 
	    //////////////////////////////////////////////////////////exibir mensagem que eu enviei ///////////////////////
	      //////////////////////////////////////////////////////////fim////////////////////////////////////////////////  
	   
	    if (@$_SESSION["mens_id_estoque"]==$row_estoque['nome_membro']) {  ?><div id="caixa_estoque99">
		<?php   if (file_exists("galeriadefotos/peq/".@$_SESSION['foto'])) { ?>
  <img src="/galeriadefotos/peq/<?php echo @$_SESSION['foto'];?>" width="40" height="50" "> 
  <?php } else{ ?>
  <img src="/galeriadefotos/peq/avatar.jpg" width="40" height="50" class="caixa_estoque80"> 
  <?php   } ?>Mensagem Enviada com sucesso para <?php echo $row_estoque['nome_membro']; ?> </div><?php }   
                       // se ja tiver enviado mensagem não exibir o formulario//               
       
     else { 
	      ///////////inicio//////se estiver logado nas são for for dono do anuncio///////
			?> <div id="caixa_redesocial">  <div id="caixa_estoque99"><?php   if (file_exists("galeriadefotos/peq/".@$_SESSION['foto'])) { ?>
<img src="/galeriadefotos/peq/<?php echo @$_SESSION['foto'];?>" width="40" height="50" class="caixa_estoque80"> 
  <?php } else{ ?>
  <img src="/galeriadefotos/peq/avatar.jpg" width="40" height="50" class="caixa_estoque80"> 
  <?php   } ?>
   <form action="acao?memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo $row_estoque['watapps']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" cols="22" rows="1"></textarea>
      <input name="enviar" type="submit" class="botao2"value="enviar">
      </form> </div></div><?php
 /////////////////se estiver logado nas são for for dono do anuncio//fim/////
} ?><?php  }
  
		  
		  } else { 
		  
		             // se ja tiver enviado mensagem não exibir o formulario//
					
		            if (@$_SESSION["mens_id_estoque"]==$row_estoque['Id_estoque']) {  ?><div id="caixa_estoque88"><a href="#"  style="color:#387DC2; font-size:12px">    Carro bom e barato informa Mensagem enviada com sucesso para <?php echo $row_estoque['nome_membro']; ?></a> </div><?php }   
                       // se ja tiver enviado mensagem não exibir o formulario//               
                else { 


                      // codigo referente a mensagem usuario nao logado//
					  // codigo referente a mensagem usuario nao logado//
					 ?> <div> <div id="caixa_redesocial"> <?    
$sql2 = "SELECT  * FROM  online  WHERE  id_user='".trim($row_estoque['id_membro'])."' LIMIT 1 ";
  $query2 = $mysql->query($sql2);
    if ($query2->num_rows == 1 ) { 
 
    while($row_time = $query2->fetch_assoc()) { 
   $time=time()-$row_time['time']; 
 




           if ($time <'600'){ echo 'O anunciante estar on-line ';?>
					 
					 
					 
					<iframe name="interno" width="100%" height="100%" src="chat/bb.php?id_estoque=<?=$row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro'] ?>&&nome_membro=<?php echo $row_estoque['nome_membro'] ?>"><br><br><br><br></iframe>

					</div> <? }} }else{ ?>
                     
                     
     <form action="acao.php?memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input  placeholder="Seu nome" name="nome" required  id="nome" />
     <input  name="email"placeholder="Telefone" required   name="email" id="email" />
     <textarea name="memsagem"placeholder="Mensagem" cols="22" rows="1"></textarea>
     <input name="enviar" type="submit" class="botao2"value="enviar">
     </form>
 </div>  <?php  } } 
                      //codigo modificado para arender IE//
                      /*/*
<iframe src="framer_maim.php?id_estoque=<?php echo $row_estoque['Id_estoque']; ?>&&nome_membro=<?php echo $row_estoque['nome_membro'];?>&&foto_membro=<?php echo $row_estoque['foto_membro'];?>&&id_membro=<?php echo $row_estoque['id_membro'];?>&&carros=<?php echo $row_estoque['carros'];?> " width="25%"  height="210px"  scrolling="No" id="centro_topo" ></iframe>//
     /*/
       } }  ?>
       
       </article>