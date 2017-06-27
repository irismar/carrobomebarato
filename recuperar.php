<? if(isset($_GET['sucesso'])){ ?> 
<div class="col-md-12">
        <div class="container">
            <div class="jumbotron">
                <h3>foi enviado um link para o email cadastrado</h3>
            </div>
</div></div><? include("rodape.php"); ?>
<? }else{ ?>
    <div class="col-md-12">
        <div class="container"><h3>Será enviado para seu email um link com a recuperação da senha</h3>
    <form action="acao.php?recuperar" method="post" enctype="multipart/form-data" name="carga" id="carga">
    <input type="text"placeholder="Seu Email cadastrado" name="email" required  id="nome" />
      <input name="enviar" type="submit" class="btn btn-default btn-success"value="Recuperar Senha">
      </form>
 
</div></div>
<div id="rodape"> 
  <? include("rodape.php"); ?>
</div></div>

</body>
</html>
<? 
}
?>





