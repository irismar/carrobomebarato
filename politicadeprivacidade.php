<?    require_once('log.php'); 


<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>
<? include("meta.php"); 
   ?>
<link rel="stylesheet" type="text/css" href="css/ie.css" /></style>

<? include("menu.php"); ?>
<div id="centro"> 
    <div id="caixa_redesocial3"><h1> Politica de Privacidade Carrocomebarato.com</h1>
	<p>O Site Carrobome barato tem seus servidores instalados no Brasil.obecendo  a legisla�ao Brasileira de prote��o ao direito civil.
   Nos Resgardamos ao direito de gravar registro de toda a atividade feita por usuario para fins de revis�o de conteudo, aperfei�oamento do sistema e  para fins legais.
    � Vedado sob pena de Denuncia as autoridades toda e qualquer manifesta�ao de intoler�ncia religiosa racial de genero  <br>
	  </p>
	<h1>Carro Bom e Barato � uma Empresa do tipo Startups  tecnologica.</h1>
	<p>Das Garantias do anunciante </p>
	<p></p>
	<p></p>
	<p></p>
 <div id="rodape"> 
  <? include("rodape.php"); ?>
</div></div>
</div></div> 
</body>
</html>
<? 

$html = ob_get_clean ();
echo preg_replace('/\s+/', ' ', $html);

?>





