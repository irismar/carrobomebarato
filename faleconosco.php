
<? if(isset($_GET['proposta'])){
    
$nome = mysql_real_escape_string($_POST['nome']);
$email =mysql_real_escape_string( $_POST['email']);
$mensagem = mysql_real_escape_string($_POST['mensaguem']);
$setor =mysql_real_escape_string( $_POST['setor']);

if (!($nome) || !($email) || !($mensagem )){ ?> 

   <div id="caixa_redesocial3"><h1> <?
	echo "coloque seu nome mensagem e email  por favor.";
       ?> </h1> </div></div><?
} else {
//Abrindo Conexao com o banco de dados
$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
$data=date('Y-m-d');
$sql="INSERT INTO faleconosco(nome,email,mensagem,setor,hora,ip )
		VALUES ('".$nome."','".$email."','".$mensagem."','".$setor."','".$hora."','".$ip."')";
$sql= $mysql->query($sql);
		
if($sql) {
   
 $mensagem =$_POST['nome'] ."Enviou mensagem para administrador com sucesso" ;

	@salvaLog($mensagem);
   
		

	 }
$mensagem =$_POST['nome'] ."ERRO mensagem para administrador com sucesso" ;

  @salvaLog($mensagem);


  }
}
?>
  






 
    <div id="caixa_redesocial3"> 
       
    <form action="?proposta" method="post" enctype="multipart/form-data" name="carga" id="carga">
      <select name="setor" id="setor">
           <option value="setor financeiro" selected="selected">Setor Financeiro</option>
        <option value="informar Erro" selected="selected">informar erro</option>
         <option value="Ajuda ao Asinante" selected="selected">ajuda ao asinante</option>
          <option value="Ajuda ao Programado" selected="selected">ajuda ao programador</option>
           <option value="confirmar pagamento" selected="selected">confirmar Pagamento</option>
          
            <option value="confirmar pagamento" selected="selected">informar fraude</option>
           
      
      </select>
        <input type="text"placeholder="Seu nome" name="nome" required  id="nome"  value="<?php echo @$_SESSION['usuario']; ?>"/>
     <input type="text" name="email"placeholder="Número do telefone ou Email" required   name="email" id="email" value="<?php echo @$_SESSION['email']; ?>" />
      <textarea name="mensaguem"placeholder="Mensagem" cols="42" rows="10"></textarea>
      <input name="enviar" type="submit" class="btn btn-default btn-success"value="enviar">
      </form>
 
</div>
<div id="rodape"> 
  <? include("rodape.php"); ?>
</div></div>
</div></div> 
</body>
</html>
<? 

?>





