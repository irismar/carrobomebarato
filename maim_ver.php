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
  ('".$row_estoque['Id_estoque']."','".$row_estoque['foto_carro']."','".$row_estoque['nome_membro']."','".$hora."','".$row_estoque['marcatexto']."','".$row_estoque['modelotexto']."','".$_COOKIE['cidade']."','".$_COOKIE['estado'] ."','".$_COOKIE['endereco1']."','".$row_estoque['preco']."')";
 $sql= $mysql->query($sql); 

 }}
if(basename($_SERVER["PHP_SELF"])==basename(__FILE__) )
exit("<script>alert('Nao permitido')</script>\n<script>window.location=('http://www.carrobomebarato.com')</script>");
?>
  <?  if (isset( $_GET['responder_proposta'])){ 
  $id_resposta= alphaID($_GET['responder_proposta'] ); 
  $mysql->query("UPDATE propostas SET resposta='".$_POST['resposta']."' ,data_resposta='".$hora."'  WHERE id = ".$id_resposta."");

  } ?>   <div class="container">

             <div id="caixa_estoque88"> 
		   
               
				
                 <div class="col-md-9">
                   <? 
                   $totalRows_foto_unica =$query_fotos->num_rows;
                   $row_foto_unica =$query_fotos->fetch_assoc();
                    if(!isset($_GET['imagem'] )){   
				?> 
                     
                     
                     <img src="/galeriadefotos/capa/<? if (($row_foto_unica['imagem'] <> '') and ((file_exists("galeriadefotos/capa/".$row_foto_unica['imagem'])))) { echo $row_foto_unica['imagem']; } else { echo "semimagem.png"; } ?>" class="img-responsive"    ></a>
                   
                                     
                                     
                                     <? } else{ ?> <img src="/galeriadefotos/grd/<? if (($_GET['imagem'] <> '') and ((file_exists("galeriadefotos/grd/".$_GET['imagem'])))) { echo $_GET['imagem']; } else { echo "semimagem.png"; } ?>"  ></a>
           
                                     <?  }?></a>
                 
                 </div>
         
       <? if ($totalRows_foto_unica > 1) { ?>
                           <div class="col-md-2"><ul>  <?					
					
$sql2 = "SELECT * FROM fotos WHERE id_estoque = $modulo ORDER BY Id ASC";
  $fotos = $mysql->query($sql2);
  
    $row_foto= $fotos->fetch_assoc(); 


          
					do { ?>  <?
					$imagem = $row_foto['imagem'];
					$caminho = "galeriadefotos/peq/$imagem";
					echo "<a href=\"?imagem=$imagem#foto\"  >";
                                        ?><img src="<?=$caminho;?>"  class='img-thumbnail'></a> 
					<? } while ($row_foto = $fotos->fetch_assoc()); {
					} } ?>  </ul>  </div></div></div></section>
                  
                   <div class="container">
	
             <div class="col-md-6">
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

  

   

   

   

   

     
 	 
<p><i class="fa fa-car fa-1x" aria-hidden="true"><a href="<?php  echo URL::getBase(); ?><?php echo  $modelo1[0]; ?>"><?php echo   $row_estoque['modelotexto']; ?></a>
</i> </p>

<p><i class="fa fa-money fa-2x" aria-hidden="true"></i> <a href="#">
    <?php if (isset($row_estoque['preco'])){ ?>
    <?php echo "R$". '&nbsp;'.  @number_format(trim($row_estoque['preco']), 2, ',', '.');
?></a>  <?php } else { echo " R$ A  combinar" ; } ?> </p>
  
        <p><i class="fa fa-calendar-o fa-2x" aria-hidden="true"></i> <a href="#"> <?php echo $row_estoque['ano'];?> /<?php echo $row_estoque['ano2'];?></a></p>
        <p><i class="fa fa-tachometer fa-2x" aria-hidden="true"></i><a href="#"><?php echo"KM". '&nbsp;'. @number_format( $row_estoque['km'], 0, '.', '.') ;?></a></p>
 
    <?php    if((@$_SESSION['usuario']==@$row_estoque['nome_membro'])){ ?> 	
        <p><i class="fa fa-user-secret fa-2x" aria-hidden="true"></i><a href="gerente/acessos#gerente">Acessos &nbsp;<?php echo $row_estoque['acessos'];?> Ver Relatório </a></p>
    <?php }else{  ?>
	    <p><i class="fa fa-cogs fa-2x" aria-hidden="true"></i><a href="#">&nbsp;<?php echo @$row_estoque['condicoes'];?>  </a></p>
		   <?php } ?>
		<p><i class="fa fa-map-marker fa-2x" aria-hidden="true"></i><a href="/?l=<?php echo trim( $row_estoque['cidade']);?>&e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['cidade']; ?></a>&nbsp;&nbsp;<a href="/?e=<?php echo  trim($row_estoque['estado']);?>"><?php echo $row_estoque['estado']; ?></a>
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
 ?>   <div id="caixa_gostei">     <?php  echo $row_estoque['descricao'];	?></div>   
  <? /////codigo para exibir mensagem ////
 ////se não estiver logado exibir formulario app_from e exibir ajax appmensagem.php
 
 echo $_SERVER["REQUEST_URI"];
 if (IsLoggedIn()){ 
 if( $row_estoque['id_membro']=$_SESSION['id']){
echo $row_estoque['id_membro'] .$_SESSION['id'];
     /////////se eu estiver logado exibir app_mensagen vendor ajax e exibir app_resposta.php ?>
    <div class="col-md-12">
        <section id="<?=$row_estoque['Id_estoque'];?>">
   <div id="lista_<?=$row_estoque['Id_estoque']?>">
</div>
    </section>
    <div class="col-md-12">   
     
 </div>
    
    </div>
        
   
    <script type="text/javascript">
        function atualizar_<?=$row_estoque['Id_estoque']?>() {
           // aqui voce passa o id do usuario
           var url="<?  echo URL::getBase(); ?>appmensagem_vendedor.php?id=<?=$row_estoque['Id_estoque']?>&&id_membro=<?=$row_estoque['id_membro']?>&&url=<?=$_SERVER["REQUEST_URI"]?>";
            jQuery("#lista_<?=$row_estoque['Id_estoque']?>").load(url);
        }
         setInterval("atualizar_<?=$row_estoque['Id_estoque']?>()",1000);
         
 </script> 
 
 
 
      
 <? }


 }else { ?>
  <div class="col-md-12">
 
     
     <div id="lista_<?=$row_estoque['Id_estoque']?>">
</div></div>
 <div class="col-md-12">
    <? if (!IsLoggedIn()){ ?>
     <? if(isset($_SESSION['nome_visita'])&& ($_SESSION['nome_visita']!='')){?>
     <iframe src="app_from.php?app_memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $row_estoque['foto_membro']; ?>&&marca=<?php echo $row_estoque['marcatexto']; ?>&&modelo=<?php echo $row_estoque['modelotexto']; ?>&&preco=<?php echo $row_estoque['preco']; ?>&&endereco1=<?php echo $endereco; ?>" class="col-md-12" height="150" ></iframe>
     <? }else{ ?>
     <iframe src="app_from.php?app_memsagem=<?php echo $row_estoque['nome_membro'] ?>&&id=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $row_estoque['foto_membro']; ?>&&marca=<?php echo $row_estoque['marcatexto']; ?>&&modelo=<?php echo $row_estoque['modelotexto']; ?>&&preco=<?php echo $row_estoque['preco']; ?>&&endereco1=<?php echo $endereco; ?>" class="col-md-12" height="350" ></iframe>
     <? } }  ?>

 </div> 
 </section>
       
        <script type="text/javascript">
        function atualizar_<?=$row_estoque['Id_estoque']?>() {
           // aqui voce passa o id do usuario
           var url="appmensagem.php?id=<?=$row_estoque['Id_estoque']?>&&segure=<? echo $_SESSION['segure'];?>&&id_membro=<?=$row_estoque['id_membro']?>&&id_estoque=<?php echo $row_estoque['Id_estoque']; ?>";
            jQuery("#lista_<?=$row_estoque['Id_estoque']?>").load(url);
        }
        setInterval("atualizar_<?=$row_estoque['Id_estoque']?>()", 1000);
        </script>       
 <? } ?>  
 </div>
 </article>	  
         
        
        