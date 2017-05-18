 <style>

#blog-landing {
position: relative;
max-width: 100%;
width: 100%;

}#blog-landing {
  margin-top: 450px;}
img {
}
.white-panel { position:absolute;
margin: 5px;
  background: whitesmoke;
border: rgba(253, 253, 253, 1) solid 1px;
}

.white-panel:hover {
box-shadow: 1px 1px 10px rgba(0,0,0,0.5);
margin: 5px;
}
</style> <?php
 $ordem='Id_estoque DESC';
    
 if (!IsLoggedIn()) {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
  //require_once('memsagem.php');
    require_once('meta.php');
  if (isset( $_GET['deletar'])){ 

 $delet= alphaID($_GET['deletar']);
	$deletar = "DELETE FROM propostas WHERE id = ".$delet." ";
	 $Result1 = mysql_query($deletar) or die(mysql_error());
	$mensagem=$_SESSION['usuario']."Deleteou memsagem ".$delet;
	@salvaLog($mensagem);
	 }  
 if (IsLoggedIn()) {

}
 $sql2 =  "SELECT * FROM propostas WHERE  Destinatario ='". $_SESSION['usuario']."' "; 
  $querypropostas = $mysql->query($sql2);
	 @$totalRows_propostas=$querypropostas->num_rows; 
    

 $sql = "SELECT * FROM acessos WHERE  visitado = '" . $_SESSION['usuario']. "'";
  $queryacessos = $mysql->query($sql);
	  $totalRows_acessos=$queryacessos->num_rows; 

 
 
 $sql = "SELECT * FROM vendido WHERE id_membro ='". $_SESSION['id']. "'   "; 
 
    $queryvendido = $mysql->query($sql);
	echo  @$totalRows_vendidos=$queryvendido->num_rows; 
	
?>
<!DOCTYPE html>
<html>
<head>
<? include("meta.php"); ?>


<script src="Scripts/funcoes.js" type="text/javascript"></script>
<script src="Scripts/ajax.js" type="text/javascript"></script>
<script>
function Mensagem(msg) {
	
	
	if (msg == 3) {
		alert("Veï¿½culo editado com sucesso!");
	}
	if (msg == 4) {
		alert("Os dados foram editados com sucesso!");
	}
	if (msg == 5) {
		alert("Imagem do veï¿½culo editada com sucesso!");
	}
}
</script>
<script type="text/javascript">
function exibe(id) {
	if(document.getElementById(id).style.display=="none") {
		document.getElementById(id).style.display = "inline";
	}
	else {
		document.getElementById(id).style.display = "none";
	}
}
</script>
     
</head>


 
 <?  $sql = "SELECT idfacebook, nome,carros,carros_total,carros_vendido,alertamanesagem,alvit ,foto,watapps,claro,oi,tim,vivo,fixo,email,cidade,estado,lat,log,endereco,data FROM  membros 	WHERE  nome= '".$_SESSION['usuario']."' LIMIT 1 ";
 $query_modelos = $mysql->query($sql);
	 $totalRows_modelos=$query_modelos->num_rows; 
	if ($totalRows_modelos != 0) { ?>
<style>
@media (min-width: 960px){
#blog-landing {
  margin-top: 17%;}}
@media screen and (min-width:50px) and (max-width: 589px) {
#blog-landing {  margin-top: 335%!important;}
@media screen and (min-width:590px) and (max-width:959px) {
#blog-landing {  margin-top: 135%!important;}
</style> 
	<?  while ($row_estoque1  = $query_modelos->fetch_assoc()) { 
	$estado_se0=$row_estoque1['estado'];
	?><script type="text/javascript">
        function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="get.php?id=<?=$_SESSION['id']; ?>";
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()", 1000);
        </script> 
	<?
	include"menu_baixo.php";
	 ?>
     </div>
    
<? 
  	 }/////////////fim do wale
	   }////////////fim do n////////////////////////////////////////////////////
	   ////////////fim do n////////////////////////////////////////////////////
	   ////////////fim do n////////////////////////////////////////////////////
	   ////////////fim do n/////consultar se fez venda///////////////////////////////////////////////
	    ?><section id="gerente"> <div class="container">   <? if( (Url::getURL(1)) && (Url::getURL(1)=="vendidos") ){ ?>     
<? $sql2 = "SELECT  * FROM vendido 	WHERE  id_membro='". $_SESSION['id']."' ORDER BY id DESC";
  $query2 = $mysql->query($sql2);
   $ok_paguser=$query2->num_rows;
  if ($query2->num_rows != 0) { 
  ////////////se vendeu algum carro exibir relarorio////// ?>
   
	 
  
  
  
  <p><?="&nbsp;  ";?></p>

  
 <div class="col-md-12">
  <div class="navbar navbar-default ">



 
   <? while($query_vendidos= $query2->fetch_assoc()) { ?>
	  
  <div id="caixa_redesocial8">
<p><?="&nbsp;  ";?></p>
      
    <div class="col-md-3">
    <? if(@$query_vendidos['foto']){ ?>
    <img src="/galeriadefotos/vendidos/<? echo trim($query_vendidos['foto']) ?>"  >
    <? } else{ ?> 
     <img src="/galeriadefotos/vendidos/avatar.png"  >    
        <?} ?>
    </div>
    <div id="ver_descricao_foto2"> 
	<a href="#"><strong class="cinza_11px"><? echo  $query_vendidos['marca'].'&nbsp;'.$query_vendidos['modelo']; ?></strong></a>
	
   
	<br>&nbsp;<a href=""  class="vermelho_11px_upper">Vendido em &nbsp;<? echo @trim($query_vendidos['dias']); ?>&nbsp; dias</a> 
	<br><a href="" > <? echo "R$". '&nbsp;'. @number_format(trim($query_vendidos['preco']), 2, ',', '.'); ?></a><br>
    
    <? if(isset($query_vendidos['acessos']) && ($query_vendidos['acessos']!=0)) { 

  $sql23 = "SELECT  * FROM  acessos 	WHERE  id_estoque='".$query_vendidos['id_estoque']."' ";
  $query24 = $mysql->query($sql23);
  $query24->num_rows;
  if ($query24->num_rows != 0) { 
    while($acesso_vendido = $query24->fetch_assoc()) {  ?>
      
      
       <? echo @$acesso_vendido['endereco'].'&nbsp;'.@$acesso_vendido['cidade'].'&nbsp;'.@$acesso_vendido['estado'];?>
       <? echo @FormataData3($acesso_vendido['data']); ?><br>
   <? }} } ?>
  
   </div> </div>
    <? } } ?>    </div>   </div>  <? } ?>
	   
   	
   <?    
      ///////////////////////exibir memsagem///////////////////////////////////////
	  /////////////////////////////////////////////////////////////////////////////
	  ////////////////////////////////////////////////////////////////////////////
	   if(  (Url::getURL(1)=="mensagens") ){ 
	 $sql2 =  "SELECT * FROM propostas WHERE  Destinatario ='". $_SESSION['usuario']."' "; 
      $query24 = $mysql->query($sql2);
      $query24->num_rows;
      if ($query24->num_rows != 0) { 
	  
	  ////se maior que 0 exibir div
	?>  <div class="col-md-12">
  <div class="navbar navbar-default ">
  

     <?
	  
	  ///atualizar usuario apaga alerta mensagem///////////
	  $mysql->query=( "UPDATE membros SET alertamanesagem=0  WHERE id = '".$_SESSION['id']."'");
 
       $mensagem=$_SESSION['usuario']." Leu Suas Memsagems";
	   salvaLog($mensagem); ///gava logim usuariio leu 
      while($query_propostas = $query24->fetch_assoc()) { ////////////listar começo ?>
    
    <div id="caixa_redesocial8">
<p><?="&nbsp;  ";?></p>
<p><?="&nbsp;  ";?></p>
      
    <div class="col-md-3">
    <? if(empty($query_propostas['foto'] )){ ?>
      <img src="/galeriadefotos/peq/avatar.jpg" class="caixa_estoque80">
    <? }else { ?>
    <img src="/galeriadefotos/peq/<? echo $query_propostas['foto'] ?>"class="caixa_estoque80">
	<? } ?>
	</div>
    <div id="ver_descricao_foto2">
    <a href="#"><strong class="vermelho_11px_upper"><? echo  $query_propostas['remetene']; ?></strong></a> 
	<a href="#"><strong class="cinza_11px"><? echo utf8_encode( $query_propostas['mensagem']); ?></strong></a>
	
   &nbsp;<p><a href=""  >&nbsp;<? echo 	$query_propostas['data']; ?></a> 
	<a href="" > <? echo @$query_propostas['endereco'];; ?></a>
      <a href="acao.php?deletar=<?php echo alphaID($query_propostas['id'], true ); ?>"><strong class="vermelho_11px_upper">Deletar</strong></a> </p> 
	
  </div></div>
                                                  
    <? } ////listar fim  ?><?  
	
	?> 
 <?  } }?></div>  </div>
   <?   
	  
	 /////////////////////////// exibir mensagem fim////////////////////////////
	  /////////////////////////////////////////////////////////////////////////////
	  ////////////////////////////////////////////////////////////////////////////
	           
                        
   /////////////////////////////////exivir Visita////////////////////////////////////////////
	  ////////////////////////////////////////////////////////////////////////////
	 if( (Url::getURL(1)) && (Url::getURL(1)=="acessos") ){ 
 $sql2 =  "SELECT * FROM acessos WHERE   visitado = '" . $_SESSION['usuario']. "'";
      $query24 = $mysql->query($sql2);
      $query24->num_rows;
      if ($query24->num_rows != 0) {
   if ( $totalRows_acessos > 0) { ?>
  <div class="container">  <div class="col-md-12">
  <div class="navbar navbar-default ">
   
  
   
  
  
    <? while ($query_vicitas =$queryacessos->fetch_assoc()) { 
	   ?>
     <div id="caixa_estoque1"> 
    <div id="ver_descricao_foto22">
	 <? if (@$query_vicitas['foto_carro']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_vicitas['foto_carro'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <? } else{ ?>
                             <img src="/galeriadefotos/peq/avatar.png"  class="caixa_estoque80"  width="50" height="60"> 
                              <?   } ?> 
	</div>
    <div id="ver_descricao_foto2">
	<h1> <a href="#"><strong class="cinza_11px"><? echo  $query_vicitas['marca'].'&nbsp;'.$query_vicitas['modelo']; ?></strong></a></h1>
    <h2>  <a href="">&nbsp;<? echo "R$". '&nbsp;'. @number_format(trim($query_vicitas['preco']), 2, ',', '.'); ?></a>
     <a href="">&nbsp; <? echo $query_vicitas['endereco'];?></a>
   <a href="">&nbsp;&nbsp;<? echo calculardias($query_vicitas['data']); ?> </a> </h2> 
     
    
    </div></div>
    
    <?  }
	$mysql->query=( "UPDATE membros SET alvit=0  WHERE id = ". $_SESSION['id']."");
 
 $mensagem=$_SESSION['usuario']." Leu seus suas Visitas";
	@salvaLog($mensagem);
	   
	   
	    }}  }?>
  </div>
</div>
<? if ( $totalRows_propostas !="") { ?>
 <div id="caixa_estoque87">
 
   
 
	  
  <?  if (isset( $_GET['ver'])){ 
 
	$mysql->query=( "UPDATE membros SET alertamanesagem=0  WHERE id = '".$_SESSION['id']."'");
 
 $mensagem=$_SESSION['usuario']." Leu Suas Memsagems";
	salvaLog($mensagem);
				?><div id="ver_descricao_estoque">
  
   <? while ($query_propostas =$querypropostas->fetch_assoc()) {  ?>
  <div id="caixa_estoque1"> 
    <div id="ver_descricao_foto22"><?
                   			   if ($query_propostas ['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_propostas ['foto'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 
                              <? } else{ ?>
                             <img src="/galeriadefotos/peq/avatar.png"  class="caixa_estoque80"  width="50" height="60"> 
                              <?   } ?> 
      </div><div id="ver_descricao_foto2"> <h1> <a href="#"><strong class="vermelho_11px"><? echo  $query_cont['mensagem']; ?></strong></a></h1>
                        <h2><a href=""><? echo  $query_cont['remetene']; ?></a> &nbsp;&nbsp;<a href=""><? echo  @$query_cont['watapps']; ?></a>&nbsp;&nbsp;<a href=""><?php echo calculardias( $query_cont['data']); ?> </a>  </h2>
	                           <a href="acao.php?deletar=<?php echo alphaID($query_cont['id'], true ); ?>">Deletar</a>  </div><?
							  if (@$query_cont['respondido']=="1")  {  
						


$sql = "SELECT * FROM propostas WHERE resposta = '" . $query_cont['id']. "'	 AND remetene= '" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 
 $query2 = $mysql->query($sql);
 
 if ($query2->num_rows != 0) { ?>
  <div id="ver_descricao_estoque">
                 <? while ($query_cont33 = $query2->fetch_assoc()) {  ?>
                  <div id="caixa_estoque1">
                  <div id="ver_descricao_foto"><?
                   			   if (@$query_cont['foto']) { ?>
                          	  <img src="/galeriadefotos/peq/<?php echo $query_cont33['foto'] ;?>"   class="caixa_estoque80"width="50" height="60"> 
                              <? } else{ ?>
                              <img src="/galeriadefotos/peq/avatar.png"  class="caixa_estoque80"  width="50" height="60"> 
                              <?   } ?> </div>
                              <div id="caixa_estoque88"> <h1> <a href="#"><strong class="vermelho_11px"><? echo  $query_cont33['mensagem']; ?></strong></a></h1>
                                <h1><a href=""> <? echo  $query_cont33['remetene']; ?></a>&nbsp;&nbsp;<a href=""><? echo  @$query_cont33['email']; ?></a><a href="">&nbsp;&nbsp;<?php echo calculardias( $query_cont33['data']); ?> </a>  </h1>
	                          <a href="acao.php?deletar=<?php echo alphaID($query_cont33['id'], true ); ?>"><img src="/images/lixo.png" width="22" height="24" />Deletar</a>  </h1></div> <? } ?> </div><? }
							  	 } if (@$query_cont['foto']) {  ?> 
							      <div id="caixa_estoque1">
   <form action="acao.php?responder=<? echo  $query_cont['remetene']; ?>&&id_estoque=<?php echo  $query_cont['id_estoque']; ?>&&id_membro=<?php echo  $_SESSION['id']; ?>&&foto=<?php echo $_SESSION['foto']; ?>&&resposta=<?php echo  $query_cont['id']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">
     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">
  <input type="hidden"  name="email"value="<?php  echo @$row_estoque['telefone']; ?>">
      <textarea name="memsagem"placeholder="Mensagem" ></textarea>
      <input name="enviar" type="submit" class="botao2"value="enviar">      
                    </form> </div>
                      <?   } ?>                                 
    </div> <? }} } ?>
    </div></div> </div></div>
</div>
</div> <div id="caixa_estoque87">
 <?
   if (isset( $_GET['relatorio'])){ 
echo $sql = "SELECT * FROM  logs  ORDER BY id DESC  ";
 $query2 = $mysql->query($sql);
 echo  $query2->num_rows;
 if ($query2->num_rows != 0) { ?>
          <div id="caixa_estoque11"> 
	 <?   while ($row_estoque3 =$query2->fetch_assoc()) {   ?>
            
                 <p><a href="/<? echo $row_estoque3['hora']?>"><?  echo FormataData3($row_estoque3['hora']); ?></a>
                   <a href="/<? echo $row_estoque3['id']?>"> <?  echo $row_estoque3['mensagem']; ?> </a> </p>
                 
       <?   }  }  ?></div>
</div> 
    <?  } ?></div></div></section>

