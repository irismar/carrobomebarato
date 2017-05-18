<div class=" blog-masthead">
 
<p>   
<a href="faleconosco.php"> Fale conosco </a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="faleconosco">Informar Erro</a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="faleconosco">Trabalhe com o Carrobomebarato</a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="faleconosco">Apoio ao Cliente</a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="faleconosco">Setor Finaceiro</a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="privacidade">Politica Privacidade</a>
&nbsp;&nbsp;&nbsp;&nbsp;<a href="faleconosco">Fazer um Denuncia</a>
</p><p>
Copyright @  <? echo  date('Y');?> - Carrobomebarato   - Todos os direitos reservados </p>
<p>Carrobomebarato apenas anúncia carros e motos a veracidade das informações cabe ao anunciante 

Carrobome Barato é  Gratis e sempre será mas se você quiser pode pagar 30 rais por mês e contar 
com suporte e relatórios <a href="/meta.php">saiba Mais </a><a href= "privacidade.php"> </p>
<?

if (isset($_GET['deletaranuncio']) ) {
		// Pega o valor da variável $_GET['pagina']
 $id_estoqueID= alphaID($_GET['deletaranuncio'],true);
$id_usuarioID= alphaID($_GET['id_usuario'],true);

$arquivo = mysql_real_escape_string($id_estoqueID);

 $query_estoque = "SELECT * FROM estoque WHERE Id_estoque = ".$id_estoqueID ." AND id_membro = ".$id_usuarioID."";
$estoque = mysql_query($query_estoque) or die(mysql_error());
$row_estoque = mysql_fetch_assoc($estoque);
$totalRows_estoque = mysql_num_rows($estoque);

if ($totalRows_estoque == 0) {
	
} else {

	
	$query_fotos = "SELECT * FROM fotos WHERE id_estoque = ".$id_estoqueID ."";
	$fotos = mysql_query($query_fotos) or die(mysql_error());
	$row_fotos = mysql_fetch_assoc($fotos);
	$totalRows_fotos = mysql_num_rows($fotos);

	@unlink($sTmpFolder . "mini/" . $row_fotos['imagem']);
	@unlink($sTmpFolder . "peq/" . $row_fotos['imagem']);
	@unlink($sTmpFolder . "grd/" . $row_fotos['imagem']);

	$deletar = "DELETE FROM fotos WHERE id_estoque = ".$id_estoqueID ."";
	$Result1 = mysql_query($deletar) or die(mysql_error());

	$deletar = "DELETE FROM estoque WHERE Id_estoque = ".$id_estoqueID." AND id_membro = ".$id_usuarioID."";
	
	$Result1 = mysql_query($deletar) or die(mysql_error());



}}else{

} //fim 
 
        if (isset(  $_GET['deletar'])){ 
 $delet= alphaID($_GET['deletar']);
 deletarmensagem($delet,$_SESSION['usuario'],$_SESSION['id']);
 $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou mensagem"."&nbsp;".  $delet;
 @salvaLog($mensagem);
        } 
		
     if (isset( $_GET['deletartudo'])){ 
//deletar todas as mensaguens enviadas para usuario
 $delet= alphaID($_GET['deletartudo']);
	  deletartodasmensagem($delet,$_SESSION['usuario'],$_SESSION['id']);
	   $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou todas as suas mensagem"."&nbsp;";
      @salvaLog($mensagem);
        }//fim	
	  if (isset( $_GET['deletartudo'])){ 
//deletar todas as mensaguens enviadas para usuario
 $delet= alphaID($_GET['deletartudo']);
	  deletartodasmensagem($delet,$_SESSION['usuario'],$_SESSION['id']);
	   $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou todas as suas mensagem"."&nbsp;";
      @salvaLog($mensagem);
        }//fim	
	//mais 90 dias de anuncio gratis	
   if (isset( $_GET['90dias'])){ 
 $vendido=  alphaID ($_GET['90dias'],true) ; 
  maisdias( $vendido);
   $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "renovou divulgação do carro"."&nbsp;". $vendido."&nbsp;"."por mais 90 dias " ;
      @salvaLog($mensagem);
	
	
  } //grama a função vendido//
  

	
	 
	@$temp= tempoExecucao();
    ///não renover por que causa erro    
 //codigo renmovido de maim por causar comflito de diversas inscriçoes de log
 //apagar mensagem//
  // deletar mensagem//
 //fim        
  	   ?>
       
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="Scripts/jquery-1.3.2.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript" src="Scripts/ajax.js"></script>
 <script>
function  mostrar(ID){
	document.getElementById(ID).style.display = "block";

}
function  ocultar(ID){
	document.getElementById(ID).style.display = "none";
	$("#dive").hide("slow");
}
function altera_display(id) {
	// Opções para o atributo display - block, inline e none
	if(document.getElementById(id).style.display=="none") {
		document.getElementById(id).style.display = "block";
	}
	else {
		document.getElementById(id).style.display = "none";
	}
}</script>
 
    
</div></div>
