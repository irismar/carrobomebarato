<?php  


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

?> 
 <article class="white-panel">
 
     <div class="col-md-12"> 
      
<div class="bordanotopo">
 <a href="<?php  echo URL::getBase(); ?><?php echo intval( $row_estoque['Id_estoque']); ?>#foto"  onclick="javascript: altera_100('white-panel');">
 <?php if( $row_estoque['video'] <> ''){?>
 <?php $url= $row_estoque['video'];
 $url=str_replace("watch?v=", "embed/",   $url); ?> 
 <iframe  width="100%"  height="340"   src="<?php echo $url;  ?>" frameborder="0" allowfullscreen></iframe></a>
 <?php  } else{ ?>
    
   <img src="/galeriadefotos/capa/<?php if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/capa/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>  
                   <?  } ?>

</div>



       

       <div class="text-xs-center">

          <a href="<?php  echo URL::getBase(); ?><?php echo trim( $row_estoque['url']); ?>">

	<?php if($row_estoque['idfacebook'] <> '' && ($row_estoque['foto_membro']=='facebook')){?>	

    <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture" class="rounded" alt="...">

 


   
         

		<?php } else{?>

      
       

  <img src="/galeriadefotos/novo/<?php if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "avatar.jpg"; } ?>" alt="...">



		

        

		<?php } ?>

		</a>  </div>

       <div id="caixa_redesocial8">

     <br />                                                                                                                                                                                                                                     

       <p class="navbar-text-center"><span class="glyphicon glyphicon-user img-circle img-responsive img-center" aria-hidden="true">

        <a href="<?php  echo URL::getBase(); ?><?php echo trim(  $row_estoque['url']); ?>"class="navbar-link"><?php echo $row_estoque['nome_membro']; ?></a> 

      

            

        <a href="#" class="navbar-link">

		<?php  if($dia=="0"){echo " agora";} 

		elseif($dia=="1"){ echo " 1 Dia";}else{ echo" há "."" .@$dia." "."Dias";} ?></a> 

        

       

    

  <span class="glyphicon glyphicon-map-marker" aria-hidden="true">  <a href="#" class="navbar-link">   <? echo @$distancia= distancia( $row_estoque['lat'], $row_estoque['lon'],$lat, $log) ?> 

         

         KM de Distância </a> 

       </span> </p>

	 

        

        

		<p class="navbar-text-center"><span class=" glyphicon glyphicon-map-marker " aria-hidden="true">

                        <a href="<?php  echo URL::getBase(); ?>map?mapa=<?php echo intval($row_estoque['Id_estoque']) ?>"class="navbar-link"><?php echo trim(  $row_estoque['endereco']); ?></a> </span></p> 

        
        <p class="navbar-text-center"><span class="glyphicon glyphicon-list-alt" aria-hidden="true">

        <a href="#" class="navbar-link">

		<?php echo "anúncios"." ".  $row_estoque['carros'];?></a>&nbsp; </span></p>

	   </div> 

 </div>
    <div id="caixa_redesocial2">

       <?php if( $row_estoque['watapps'] <>""){ ?>

       <div class="tell"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i>

      

        <a href="#" class="navbar-link"><?php echo $row_estoque['watapps'] ?></a>&nbsp; </div>  <?php } ?>

		

		

		     <?php if( $row_estoque['fixo'] <>""){ ?>

             

            <div class="tell"><i class="fa fa-phone fa-2x" aria-hidden="true"></i>

       <a href="tel:+<?php echo $row_estoque['fixo'] ?>"

  

 class="navbar-link"><?php echo $row_estoque['fixo'] ?></a>&nbsp; </p> </div>

        	    

		   <?php } ?>

 </div> 		

  <div class="col-md-12">

   

	<?php if((  @$_SESSION["usuario"]==$row_estoque['nome_membro'])){ ?>

    

     

   	 <a href="editar_veiculos?Id_estoque=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro']) ; ?>" >&nbsp;Editar&nbsp;<span></span> </a>

     

     

  <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" style="color:#396">&nbsp;Vendido&nbsp; </a>

  

   <a href=" acao.php?vendido=<?php echo alphaID( $row_estoque['Id_estoque'] ); ?>&&membro=<?php echo alphaID( $row_estoque['id_membro'] ); ?>" style="color:#F60">&nbsp;&nbsp;Excluir  </a>

<a href="<?  echo URL::getBase(); ?>incorporar?id=<?=$row_estoque['Id_estoque'];?>" style="color:#0003FF">&nbsp;&nbsp;incorporar    <span class="badge"></span></a>
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

            &nbsp;&nbsp;<a href="acao.php?gostei=<?php echo $row_estoque['Id_estoque']; ?>"><i class="fa fa-thumbs-o-up fa-2x" aria-hidden="true"></i>

            <?php echo $row_estoque['gostei']; ?>&nbsp;&nbsp;&nbsp;</a> 

 </div>

   <div class="tell"> <a href="acao.php?naogostei=<?php echo $row_estoque['Id_estoque']; ?>"><i class="fa fa fa-thumbs-o-down fa-2x" aria-hidden="true"></i><?php echo $row_estoque['naogostei']; ?>&nbsp;&nbsp;&nbsp;</a>

   </div>

    <a href="#"><i class="fa fa-facebook-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;

   <a href="#"><i class="fa fa-pinterest-square fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;

   <a href="#"><i class="fa fa-twitter fa-2x" aria-hidden="true"></i></a>&nbsp;&nbsp;

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

	    <p><i class="fa fa-cogs fa-2x " aria-hidden="true"></i><a href="#">&nbsp;<?php echo @$row_estoque['condicoes'];?>  </a></p>

		   <?php } ?>

		<p><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i><a href="/?l=<?php echo trim( $row_estoque['cidade']);?>&e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['cidade']; ?></a>&nbsp;&nbsp;<a href="/?e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['estado']; ?></a>

        <p><a href="#">  <?php



				  

 data22($row_estoque['data_cadastro']);?>

 



</a>



				  

	 </div> 

 <?php  if($row_estoque['exibir']=="0" && (isset($_SESSION['usuario']) && $_SESSION['usuario']==@$row_estoque['nome_membro'] ) ){  ?> <div class=" col-md-6">  <ul class="nav nav-pills" role="tablist">

         <li role="presentation" class="active"><a href="">Dias Anunciados <span class="badge"><?=$dia?></span></a></li>

          <h1>Seu Anúncio tem mais de 90 dias e não estar mas visivel no site <br> </h1>

          <li role="presentation" class="active"><a href="acao.php?90dias=<?php echo  alphaID ( $row_estoque['Id_estoque']); ?>">Quer mais 90 dias Grátis  <span class="badge">Clik aqui </span></a></li>

            </h1>;

         </ul><?php }else {

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



        <br>

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

                 </div> <div class="col-md-12" >

 	<?php if ($totalRows_opcionais != 0){ ?>      <?php 

	

	do {   echo trim(@$row_opcionais['acessorios'])."&nbsp;&nbsp;&nbsp;";  

		    

     } while($row_opcionais =  $query->fetch_assoc());
?>  </div> 

	

	

 <?php } 
 
 ?>  <div id="caixa_gostei"> <?php  echo $row_estoque['descricao'];	?></div> 
 <? /////codigo para exibir mensagem ////
 ////se não estiver logado exibir formulario app_from e exibir ajax appmensagem.php
 
 
 if (IsLoggedIn()){ 
 if( $row_estoque['id_membro']=$_SESSION['id']){

     /////////se eu estiver logado exibir app_mensagen vendor ajax e exibir app_resposta.php ?>
    <div class="col-md-12">
        <section id="<?=$row_estoque['Id_estoque'];?>">
   <div id="lista_<?=$row_estoque['Id_estoque']?>">
</div>
    </section>
    <div class="col-md-12">   
     
 </div>
    
    </div>
        
   
    
 
 
 
      
 <? }


 }else { ?>
  <div class="col-md-12">
 
     
     <div id="lista_<?=$row_estoque['Id_estoque']?>">
</div></div>
 <div class="col-md-12">
    <? if (!IsLoggedIn()){ ?>
     <? if(isset($_SESSION['nome_visita'])&& ($_SESSION['nome_visita']!='')){?>
     <iframe src="app_from.php?app_memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $row_estoque['foto_membro']; ?>&&marca=<?php echo $row_estoque['marcatexto']; ?>&&modelo=<?php echo $row_estoque['modelotexto']; ?>&&preco=<?php echo $row_estoque['preco']; ?>&&endereco1=<?php echo $endereco; ?>" class="col-md-12" height="190" ></iframe>
     <? }else{ ?>
     <iframe src="app_from.php?app_memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $row_estoque['foto_membro']; ?>&&marca=<?php echo $row_estoque['marcatexto']; ?>&&modelo=<?php echo $row_estoque['modelotexto']; ?>&&preco=<?php echo $row_estoque['preco']; ?>&&endereco1=<?php echo $endereco; ?>" class="col-md-12" height="390" ></iframe>
     <? } }  ?>

 </div> 
 </section>
       
        <script type="text/javascript">
        function atualizar_<?=$row_estoque['Id_estoque']?>() {
           // aqui voce passa o id do usuario
           var url="appmensagem.php?id=<?=$row_estoque['Id_estoque']?>&&segure=<? echo $_SESSION['segure'];?>&&nome_membro=<?=$row_estoque['nome_membro']?>&&id_membro=<?=$row_estoque['id_membro']?>&&id_estoque=<?php echo $row_estoque['Id_estoque']; ?>";
            jQuery("#lista_<?=$row_estoque['Id_estoque']?>").load(url);
        }
        setInterval("atualizar_<?=$row_estoque['Id_estoque']?>()", 3000);
        </script>       
 <? } 
 if(IsLoggedIn()){?>
  <script type="text/javascript">
        function atualizar_<?=$row_estoque['Id_estoque']?>() {
           // aqui voce passa o id do usuario
           var url="<?  echo URL::getBase(); ?>appmensagem_vendedor.php?id=<?=$row_estoque['Id_estoque']?>&&id_membro=<?=$row_estoque['id_membro']?>&&url=<?=$_SERVER["REQUEST_URI"]?>";
            jQuery("#lista_<?=$row_estoque['Id_estoque']?>").load(url);
        }
       
       
           setInterval("atualizar_<?=$row_estoque['Id_estoque']?>()",3000);
     
 </script>    
<? }


 ?>  
 </div>
 </article>





  
  
