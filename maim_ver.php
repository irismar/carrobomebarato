   <? 
 if(!isset( $_SESSION["id_user1"])OR ($_SESSION["id_user1"]!==$modulo) ){
 if((@$_SESSION['usuario']!==@$row_estoque['nome_membro'])){     
$mysql->query("UPDATE estoque SET acessos = acessos + 1 WHERE Id_estoque = ".$modulo."");
$mysql->query("UPDATE  membros SET acessos = acessos + 1 WHERE id =". $row_estoque['id_membro']."");
$mysql->query( "UPDATE membros SET alvit=alvit + 1  WHERE id =". $row_estoque['id_membro']."");

 $sessin= $row_estoque['nome_membro'];
 $_SESSION["id_user1"]=$row_estoque['Id_estoque'];
 ///////////grava acesso////
 $sql="INSERT INTO acessos (id_estoque,foto_carro, visitado,data,marca,modelo,cidade,estado,endereco,preco
 ) VALUES 
  ('".$row_estoque['Id_estoque']."','".$row_estoque['foto_carro']."','".$row_estoque['nome_membro']."','".$hora."','".$row_estoque['marcatexto']."','".$row_estoque['modelotexto']."','".$_SESSION['cidade']."','".$_SESSION['estado'] ."','".$_SESSION['endereco1']."','".$row_estoque['preco']."')";
 $sql= $mysql->query($sql); 

 }}
if(basename($_SERVER["PHP_SELF"])==basename(__FILE__) )
exit("<script>alert('Nao permitido')</script>\n<script>window.location=('http://www.carrobomebarato.com')</script>");
?>
  <?  if (isset( $_GET['responder_proposta'])){ 
  $id_resposta= alphaID($_GET['responder_proposta'] ); 
  $mysql->query("UPDATE propostas SET resposta='".$_POST['resposta']."' ,data_resposta='".$hora."'  WHERE id = ".$id_resposta."");

  } ?>   <div class="container">
 <section id="foto">
             <div id="caixa_estoque88"> 
		   
               
				
                 <div id="caixa_foto1">
                   <? 
                   $totalRows_foto_unica =$query_fotos->num_rows;
                   $row_foto_unica =$query_fotos->fetch_assoc();
                    if(!isset($_GET['imagem'])){ ?>  
				
				 <img src="/galeriadefotos/grd/<? if (($row_foto_unica['imagem'] <> '') and ((file_exists("galeriadefotos/grd/".$row_foto_unica['imagem'])))) { echo $row_foto_unica['imagem']; } else { echo "semimagem.png"; } ?>"    ></a>
                   <? } else{ ?>
	 <img src="/galeriadefotos/grd/<? if (($_GET['imagem'] <> '') and ((file_exists("galeriadefotos/grd/".$_GET['imagem'])))) { echo $_GET['imagem']; } else { echo "semimagem.png"; } ?>"  ></a>
           
 <? }?></a></div>
         
       <? if ($totalRows_foto_unica > 1) { ?>
                           <div id="Resultado3"><ul><div class="caixa_estoque88">  <?					
					
$sql2 = "SELECT * FROM fotos WHERE id_estoque = $modulo ORDER BY Id ASC";
  $fotos = $mysql->query($sql2);
  
    $row_foto= $fotos->fetch_assoc(); 


          
					do { ?>  <?
					$imagem = $row_foto['imagem'];
					$caminho = "galeriadefotos/peq/$imagem";
					echo "<a href=\"?imagem=$imagem#foto\"  >";
					echo "<img src=\"$caminho\" ></a>";
					} while ($row_foto = $fotos->fetch_assoc()); {
					} } ?></div>  </ul>  </div></div></div></section>
                    
                     <div class="container">
                    <? 	if (IsLoggedIn()) { ///se eu tiver logado
                $sql2 = "SELECT * FROM propostas WHERE id_estoque = '" .  $row_estoque['Id_estoque']. "'  AND Destinatario = '"                   .$_SESSION['usuario']. "'
   ORDER BY id DESC LIMIT 99"; 
  $query2= $mysql->query($sql2); 
  
       if ($query2->num_rows != 0) { 
  
 
  ?> <div class="col-md-12">
  
 <?   while($query_conta= $query2->fetch_assoc()) { ?>
 <div class="col-md-6">
                   <? 			   if (@$query_conta['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_conta['foto'] ;?>" width="50" height="60"> 
                              <? } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.png" width="50" height="60"> 
                              <?   } ?> 
                              
                                <a href="#"><strong class="cinza_11px"><? echo  $query_conta['mensagem']; ?></strong></a><BR>
                               <a href=""><img src="/images/remetente.png" width="20" height="22"> <? echo  $query_conta['remetene']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=""><img src="/images/calendario.png" width="23" height="27">&nbsp;
                                                                      <? echo  calculardias($row_estoque['data_cadastro']);?>	</a> 
	                           <a href="?deletar=<?php echo alphaID($query_conta['id'], true ); ?>"><strong class="vermelho_11px"><img src="/images/lixo.png" width="22" height="24" />Apagar 
                               esta Mensagem</strong></a> </div> 
	                                  <? if (isset( $query_conta['resposta'])){ ?>
	                                  <div id="caixa_estoque3">
									  <div id="ver_descricao_foto"> <img src="/galeriadefotos/peq/<? echo $row_estoque['foto_membro']?>" width="30" height="40"></div>
	                                <a href="#"><strong class="cinza_11px"><? echo  $query_conta['resposta']; ?></strong></a><BR>
                                      <a href=""><img src="/images/remetente.png" width="20" height="22"> <? echo  $query_conta['Destinatario']; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href=""><img src="/images/calendario.png" width="23" height="27">&nbsp;<? echo  $query_conta['data_resposta']; ?> </a> 
	                                 </div></div>
	                                  <?  } ?>
                 
	                                            <? }?></div>
                                          <? }  else{?> 


 <div class="container"> <div class="col-md-12">
<?  if (isset($_GET['memsagem']) && $_GET['id']==$row_estoque['Id_estoque']) {  ?> Mensagem enviada com sucesso   <? }  
else { ?>

<div class="col-md-12">
 
  <?
	               
				   if (file_exists("galeriadefotos/peq/".@$_SESSION['foto'])) { ?>
 <div class="col-md-3"> <img src="/galeriadefotos/novo/<?php echo @$_SESSION['foto'];?>"  class="img-responsive"> 
  <? } else{ ?>
  <img src="/galeriadefotos/peq/avatar.png" width="40" height="50"> 
  <?   } ?><p><?php  echo @$_SESSION['usuario']; ?></p>
 
 </div><div class="col-md-8">
     <form action="acao.php?memsagem=<? echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo $row_estoque['telefone']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" cols="12" rows="1"></textarea></div>
      <input name="enviar" type="submit" class="botao2"value="enviar">
      
                    </form></div>  </div>   <?  }?>


      
      
      <? }   
  
  
	  
		
	
                    
                }else{?>   <div class="col-md-12">
 <? if (isset($_GET['memsagem']) && $_GET['id']==$row_estoque['Id_estoque']) {  ?> <h1> Mensagem enviada com sucesso </h1> ; <? }   

 
     else{ ?>	

 
 

 <div class="col-md-6">
     <form action="acao.php?memsagem=<? echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
    <input type="text"placeholder="Seu nome" name="nome" required  id="nome" />
     <input type="number" name="email"placeholder="número do telefone" required   name="email" id="email" />
      <textarea name="memsagem"placeholder="Mensagem" cols="22" rows="1"></textarea>
       <input name="enviar" type="submit" class="botao2"value="enviar">
      
    </form>
  </div>
                <? }?>
				 <div class="col-md-6">
				<? } ?>
                
                
                
	 <div class="col-md-12">
 	 <a href="<?php  echo URL::getBase(); ?><?php echo $row_estoque['marcatexto']; ?>">
	 <?php if (file_exists("images/".$row_estoque['marcatexto'].".png")){ ?>
	  <img src="images/<?php if (($row_estoque['marcatexto'].".png" <> '') and ((file_exists("images/".$row_estoque['marcatexto'].".png")))) { echo $row_estoque['marcatexto'].".png"; } else { echo "avatar.jpg"; } ?>">
	   <?php } else { ?>
	   <?php echo 'Marca:'. $row_estoque['marcatexto']; ?>
	  <?php }?>
	  </a> 
      
      
      </div>
      <div class="col-md-12">
 <a href="acao.php?gostei=<?php echo $row_estoque['Id_estoque']; ?>"><img src="/images/handUp.png"> <space><?php echo $row_estoque['gostei']; ?></a> 
 

<a href="acao.php?naogostei=<?php echo $row_estoque['Id_estoque']; ?>"><img src="/images/handDown.png"> <space><?php echo $row_estoque['naogostei']; ?></a>

 <a  rel="nofollow" title="Compartilhar pelo Facebook" target="_blank" href="http://www.facebook.com/sharer.php?t=&amp;u=http://carrobomebarato.com/<?php echo trim(intval( $row_estoque['Id_estoque']));?>" onclick="return open_facebook('http://carrobomebarato.com/<?php echo trim(intval( $row_estoque['Id_estoque']));?>');">
<img src="/images/logo_facebook_arrendodado.png"></a>


<a href="#"><img src="/images/instagram.png"></a>



 <a href="#"><img src="/images/tumblr.png"></a>

 <a href="http://twitter.com/home?status=<?php echo urlencode("Lendo http://www.criarweb.com/css em CriarWeb.com.");?>"><img src="/images/logo_twitter_arrendodado.png" ></a>


 

 	  </div>
     
     
  <div class="col-md-6">
<p> <a href="<?php  echo URL::getBase(); ?><?php echo  $modelo1[0]; ?>" style="color:#387DC2; font-size:12px"><?php echo   $row_estoque['modelotexto']; ?></a>
</p>

<p><img src="images/dinheiro.png" > <a href="#">
    <?php if (isset($row_estoque['preco'])){ ?>
    <?php echo "R$". '&nbsp;'.  @number_format(trim($row_estoque['preco']), 2, ',', '.');
?></a>  <?php } else { echo " R$ A  combinar" ; } ?> </p>
  
        <p><img src="/images/calendario.png"> <a href="#"> <?php echo $row_estoque['ano'];?> /<?php echo $row_estoque['ano2'];?></a></p>
        <p> <img src="images/roda-0.png"><a href="#"><?php echo"KM". '&nbsp;'. @number_format( $row_estoque['km'], 0, '.', '.') ;?></a></p>
 
    <?php    if((@$_SESSION['usuario']==@$row_estoque['nome_membro'])){ ?> 	
		<p><img src="images/outros-0.png"><a href="gerente.php?ver_visita">Acessos &nbsp;<?php echo $row_estoque['acessos'];?> Ver Relatório </a></p>
    <?php }else{  ?>
	    <p><img src="images/horario_icone.png"><a href="#">&nbsp;<?php echo @$row_estoque['condicoes'];?>  </a></p>
		   <?php } ?>
		<p><img src="images/local.png"><a href="/?l=<?php echo trim( $row_estoque['cidade']);?>&e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['cidade']; ?></a>&nbsp;&nbsp;<a href="/?e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['estado']; ?></a>
        <p><a href="#">  <?php

				  
 calculardias($row_estoque['data_cadastro']);?>
 

</a>

				  
	 </div> 
      

	          
		<div class="col-md-6">
		
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
<?php } else { ?> <p>  <a href=""> R$  Preço á Combinar</a></p> <?php }  }
 ?>
	</div> <div id="caixa_gostei">   
 	<?php if ($totalRows_opcionais != 0){ ?>      <?php 
	
	do {   echo @utf8_encode($row_opcionais['acessorios'])."&nbsp;&nbsp;&nbsp;";  
		    
     } while($row_opcionais =  $query->fetch_assoc());
        

	?>  </div> 
	
	
 <?php } 
 ?> </div>  <div id="caixa_gostei">     <?php  echo $row_estoque['descricao'];	?></div>   
                
                
               

	 </div> 
	  
         
        
        