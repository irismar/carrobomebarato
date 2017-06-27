
<? 


if(Url::getURL( 1 )=="sucesso"){ ?>
<div class="col-md-12">
       <div class="container">
            
           <div class="jumbotron">
           <h2>Mensagem enviada com sucesso</h2>     
           </div>
       </div>
 </div>    
<? }else{ ?> <div class="col-md-12"><div class="container">
    <form action="acao.php?proposta" method="post" enctype="multipart/form-data" name="carga" id="carga">
      <select name="setor" id="setor">
           <option value="setor financeiro" selected="selected">Setor Financeiro</option>
        <option value="informar Erro" selected="selected">informar erro</option>
         <option value="Ajuda ao Asinante" selected="selected">ajuda ao asinante</option>
          <option value="Ajuda ao Programado" selected="selected">ajuda ao programador</option>
           <option value="confirmar pagamento" selected="selected">confirmar Pagamento</option>
          
            <option value="confirmar pagamento" selected="selected">informar fraude</option>
           
      
      </select>
 <? if (IsLoggedIn()) {   ?>     
        <input type="hidden"placeholder="Seu nome" name="nome" required  id="nome"  value="<?php echo @$_SESSION['usuario']; ?>"/>
     <input type="hidden" name="email"placeholder="Número do telefone ou Email" required   name="email" id="email" value="<?php echo @$_SESSION['email']; ?>" />
     
 <? }else{ ?> 
     <input type="text"placeholder="Seu nome" name="nome" required  id="nome"  value="<?php echo @$_SESSION['usuario']; ?>"/>
      <input type="text" name="email"placeholder="Número do telefone ou Email" required   name="email" id="email" value="<?php echo @$_SESSION['email']; ?>" />
     
     <? } ?>
      <textarea name="mensaguem"placeholder="Mensagem" cols="42" rows="10"></textarea>
      <input name="enviar" type="submit" class="btn btn-default btn-success"value="enviar">
      </form>
 
</div></div><? } ?>
<div id="rodape"> 
  <?  include("rodape.php"); ?>
</div></div>
</div></div> 
</body>
</html>
<? 

?>





