 <link href="/css/bootstrap.css?<?php echo microtime();?>"  media='all' rel="stylesheet">
     <? 
require_once('Connections/repasses.php');
$sql2 = "SELECT  * FROM  estoque	WHERE  Id_estoque='".trim($_GET['carro'])."' LIMIT 1 ";

  $query2 = $mysql->query($sql2);

  

  while($row_estoque = $query2->fetch_assoc()) { 


   if(isset($_GET['medio'])) { ?>
       <p>
<a href="http://localhost/<?=$row_estoque['Id_estoque'] ?>" title="<?=$row_estoque['modelotexto'] ?> <?=$row_estoque['modelotexto'] ?> <?=@$row_estoque['preco'] ?> <?=$row_estoque['endereco'] ?>">
    <img src="/galeriadefotos/capa/<?php if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/capa/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>" class="img-left"></a></p>
 <h2><a href="http://localhost/<?=$row_estoque['Id_estoque'] ?>" title="carros usados" style="font-size:16px; float: left; text-align: left; text-decoration: none;">
          <p> <img src="/galeriadefotos/novo/<?php if (($row_estoque['foto_membro'] <> '') and ((file_exists("galeriadefotos/novo/".$row_estoque['foto_membro'])))) { echo $row_estoque['foto_membro']; } else { echo "semimagem.png"; } ?>" class="img-thumbnail"><?=@$row_estoque['nome_membro'] ?> <?=@$row_estoque['watapps'] ?>   </p> 
                
         <p> <?=@$row_estoque['endereco'] ?></p>
     
    <p> <?=@$row_estoque['preco'] ?> </p>  
     <p><?=@$row_estoque['marcatexto'] ?>  <?=@$row_estoque['modelotexto'] ?>   <?=@$row_estoque['preco'] ?> </p>
     
     </a>
   </h2> 
       <? }else{ ?> 
<p>
<a href="http://localhost/<?=$row_estoque['Id_estoque'] ?>" title="<?=$row_estoque['modelotexto'] ?> <?=$row_estoque['modelotexto'] ?> <?=@$row_estoque['preco'] ?> <?=$row_estoque['endereco'] ?>">
    <img src="/galeriadefotos/capa/<?php if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/capa/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>" class="img-center"></a></p>
 <h2><a href="http://localhost/<?=$row_estoque['Id_estoque'] ?>" title="carros usados" style="font-size:16px; float: left; text-align: center; text-decoration: none;"><?=@$row_estoque['nome_membro'] ?> </br>
         <p><?=@$row_estoque['marcatexto'] ?> <?=@$row_estoque['modelotexto'] ?></p>
         <p> <?=@$row_estoque['preco'] ?> </p>
         <p> <?=@$row_estoque['nome_membro'] ?> <?=@$row_estoque['watapps'] ?>  </p>
         <?=@$row_estoque['endereco'] ?>
     
     </a>
   </h2> <? } } ?>

    
    <? if(isset($_GET['grid'])){
        
        
        
    } ?>
    