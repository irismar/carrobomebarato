<?  require_once('file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/Connections/repasses.php'); 
  require "links.php"; 

  $modulo = Url::getURL( 0 );
  $sql = "SELECT nome_membro  FROM  estoque 	WHERE  nome_membro= '".$modulo."' ORDER BY id_estoque DESC";

 $query = mysql_query($sql);
  $totalRows_modelos = mysql_num_rows($query );
	if ($totalRows_modelos != 0) { 



header("Location: busca_carros.php?categoria=".$modulo."");
exit();
 }
 
	
 
?> <? 
   

	
	
	

getTime();	

ob_start();
   require_once('file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/admin/includes/tng/tNG.inc.php'); 
  if (IsLoggedIn()) {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add")) {
 if ($_SESSION["csrfToken "] == $_POST[' csrfToken ']) {
         echo "form do bem";
     }   else   {
         echo "Ops, solicitaï¿½ï¿½o NÃ£o permitida"; exit();
     }
   	$query_cliente = "SELECT email FROM membros WHERE email = '" . $_POST['email'] . "'";
	$cliente = mysql_query($query_cliente) or die(mysql_error());
	$row_cliente = mysql_fetch_assoc($cliente);
	$totalRows_cliente = mysql_num_rows($cliente);
	if (($totalRows_cliente == 0)) {
    
    
	$sTmpFolder = "galeriadefotos/";
	if($_FILES['imagem']['size'] > 0){
	$foto = $_FILES['imagem'];
	}else{
	$foto=NULL;
	}
	
	if($_FILES['imagem']['size'] > 0)
	{

		$numero =md5(microtime()); 
		$imagem =$numero. ".jpg";
		
		move_uploaded_file($foto["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 350, 263, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_350x263.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_350x263.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 120, 90, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_120x90.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_120x90.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
	}
	
	if (isset($_POST['premium'])) {
       echo    $datadevencimento= som_data(date('d.m.Y'), 31);
	$premium= $_POST['premium'];}else {$premium="NAU"; 
        $datadevencimento='NULL';}
	           
  $insertSQL= "INSERT INTO membros (lat,log,premium,data, nome, endereco,estado, cidade, telefone,telefone2,telefone3,telefone4, email, senha,foto,datapremium)
                                VALUES ('". $_SESSION['latsitante']."','".$_SESSION['longisitante']."','".$premium."','".$hora."','".$_POST['nome']."','".$_POST['endereco']."','".$_POST['regiao']."','".$_POST['city']."','".$_POST['telefone1']."','".$_POST['telefone2']."','".$_POST['telefone3']."','".$_POST['telefone4']."','".$_POST['email']."',' ".$_POST['senha']."','".$imagem."','".$datadevencimento."')";
        

  
  $Result1 = mysql_query($insertSQL) or die(mysql_error());

 
		
		
	
  $sql= "SELECT id,telefone,telefone2,telefone3,telefone4,premium, cidade,estado,foto,carros, endereco,nome,email,datapremium FROM membros";
$dados = $mysql->query($sql);
if($dados){
     unset($_SESSION["usuario"]);
	unset($_SESSION["Status"]);
	unset($_SESSION["nome"]);
	unset($_SESSION["id"]);
	unset($_SESSION["email"]);
	unset($_SESSION["senha"]);
	unset($_SESSION["telefone"]);
	unset($_SESSION["foto"]);
	unset($_SESSION["id_user"]);
	unset($_SESSION["telefone"]);
	unset($_SESSION['idparaeditar']);
	
	
	
	setcookie('usuario');
	setcookie('id');
	setcookie('alertamanesagem');
	setcookie('alertavisita');
	setcookie('cidade');
	setcookie('estado');
	setcookie('email');
	setcookie('foto');
	setcookie('carros');
	setcookie('premium');
        setcookie('datapremium');
	setcookie('telefone');
// Executa a consulta
 while($row_membro = $dados->fetch_assoc()) {
$id= $row_membro['nome']; 
$_SESSION["Status"] = "repasses";
	$_SESSION["usuario"] = $id;
	setcookie('usuario', $row_membro['nome']);
	setcookie('id', $row_membro['id']);
	setcookie('alertamanesagem', $row_membro['alertamanesagem']);
	setcookie('alertavisita', $row_membro['alvit']);
	setcookie('cidade', $row_membro['cidade']);
	setcookie('estado', $row_membro['estado']);
	setcookie('email', $row_membro['email']);
	setcookie('foto', $row_membro['foto']);
	setcookie('carros', $row_membro['carros']);
	setcookie('premium', $row_membro['premium']);
        setcookie('datapremium', $row_membro['datapremium']);
	setcookie('telefone', $row_membro['telefone']);
        setcookie('telefone2', $row_membro['telefone2']);
        setcookie('telefone3', $row_membro['telefone3']);
        setcookie('telefone4', $row_membro['telefone4']);
	$_SESSION["Status"] = "repasses";
	}}
						
	
	
  $insertGoTo = "/adicionar_veiculos.php?cad=ok";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  
   $mensagem =$_POST['nome'] ."Casdastrou-se  com sucesso" ;

	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "Nao foi possï¿½vel salvar o LOG!";

	}
    
  header(sprintf("Location: %s", $insertGoTo));
  } else {
  	$erro = 1;
  }
}else {  $Token = md5 (uniqid (rand (), true));

     // Definir o token como uma sessï¿½o
	 @session_start();
  $_SESSION['CsrfToken'] =$Token;} 




?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<? include("file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/inc_metatag.php"); ?>
 <link href="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/css/estilo.css" rel="stylesheet" type="text/css">
 <? include("file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/inc_data.php"); ?>
<style type="text/css">
@import url(file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/css/estilo.css);
</style>
<script type="text/javascript" src="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/js/jquery.js"></script>
<script type="text/javascript" src="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/js/simpleAutoComplete.js"></script>
<script src="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/Scripts/funcoes.js" type="text/javascript"></script>
<script src="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/Scripts/ajax.js" type="text/javascript"></script>
</head>
<? include("file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/inc_menu.php"); ?>
<div id="centro"> 
  <div id="texto2"> 
    <? if (@$_GET['plano'] <> '') { ?>
    <? } ?>
    <br></br>
    <form action="<?php echo $editFormAction; ?>" name="add" id="add" enctype="multipart/form-data" method="POST" onSubmit="return ValidaCadastro();">
      <div id="caixa_cadastro"> 
        <h1>nome&nbsp; da sua Empresa ou seu nome </h1><span id="cb_nome">
        <input name="nome" required  type="text" class="input" id="nome" value="<?php echo @$_POST['nome']; ?>" size="20" maxlength="100"onchange="javascript:Carreganome('ajax_cidades1.php',this.value);"/>
        <div id="caregarnome" > </div>
         <div id="caixa_cadastro"> 
      </div></div>
      <div id="caixa_cadastro"> 
        <h1>email&nbsp;*  * informe seu email *</h1>
        <span id="cb_email"> 
        <input name="email"   type="text" class="input"  required id="email" value="<?php echo  @utf8_decode(remover_caracter(mysql_escape_string($_POST['email'])));
 ; ?>" size="40" maxlength="100" onchange="javascript:Carregaemail('ajax_cidades_email.php',this.value);"/>
        <div id="caregaremail"></div>
        </span> </div>
      <div id="caixa_cadastro"> 
        <h1>Estado</h1>
        <span id="cb_endereco"> 
        <input type="text" value="<? echo @$_COOKIE['estado']; ?>" id="regiao" name="regiao"   />
        </span> </div>
      <div id="caixa_cadastro"> 
        <h1>Cidade</h1>
        <span id="cb_endereco"> 
        <input type="text"  value="<? echo @$_COOKIE['cidade']; ?>"id="city" name="city"  />
        </span> </div>
      <div id="caixa_cadastro"> 
        <h1>endereco</h1>
        <span id="cb_endereco"> <input name="endereco"  required name="endereco" type="text" class="input" id="endereco" value=" <?php echo @ $_SESSION['rua']; ?>" size="42" maxlength="100" /> 
        </span> </div>
      <div id="caixa_estoque1"> 
        <div id="caixa_cadastro"> 
          <h1>TEl Fixo</h1>
          <span id="cb_telefone"> 
          <input name="telefone1" required  type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['telefone']); ?>" size="10" maxlength="20" />
          </span> </div>
        <div id="caixa_cadastro"> 
          <h1>CELL</h1>
          <span id="cb_telefone"> <input name="telefone2" required name="telefone" type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['telefone']); ?>" size="10" maxlength="20" /> 
          </span> </div>
        <div id="caixa_cadastro"> 
          <h1>CELL</h1>
          <span id="cb_telefone"> <input name="telefone3" required name="telefone" type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['telefone']); ?>" size="10" maxlength="20" /> 
          </span> </div>
        <div id="caixa_cadastro"> 
          <h1>CELL</h1>
          <span id="cb_telefone"> <input name="telefone4" required name="telefone" type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['telefone']); ?>" size="10" maxlength="20" /> 
          </span> </div>
      </div>
      <div id="caixa_estoque1"> 
        <div id="caixa_cadastro"> 
          <h1>senha&nbsp;*</h1>
          <span id="cb_senha"> <input name="senha"  required name="senha" type="password" class="input" id="senha" size="20" maxlength="200" /> 
          </span> </div>
        <div id="caixa_cadastro"> 
          <h1>COMFIRMA&nbsp;*</h1>
          <span id="cb_senha2"> <input name="confirmar" required name="confirmar"  type="password" class="input" id="confirmar" size="20" maxlength="200" />(Digite 
          a senha novamente) </span> </div>
      </div>
      <div id="caixa_cadastro"> 
        <label> 
        <input name="imagem"  id="imagem" type="file" />
        Sua Foto ou Logotipo de Sua Empresa * </label>
      </div>
      <br>
      <div id="caixa_cadastro"> 
        <p>&nbsp; </p>
        <p> 
          <input name="btnAction" type="submit" class="botao2" id="btnAction" onClick="EW_submitForm(this.form);" value="CADASTRAR" />
        </p>
       <input type="hidden" name="MM_insert" value="add" />
      </div><div id="caixa_estoque1">
     <div id="caixa_cadastro_premium"> 
        <h1> assinar o plano de suporte e alerta via SMS anúncios ilimitados</h1> 
        <h1> 30 Reias por semana</h1> 
        <br><h1>para efetivar seu pagamento faça um deposito ou transferencia Bancaria BRADESCO AG 1751 CONTA 0506179-2 IRISMAR MENEZES SILVA após pagamento envia confirmação de pagamento para email<a href="#"> carrobomebarato@gmail.com</a> ou acesse <a href="file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/faleconosco.php">faleconosco
          </a>  e confirme seu pagamento
		</h1>
        <span id="premium"> 
        <h1> 
          <input name="premium" class="borda" type="checkbox" value="SIM" />
          sim</h1>
        </span>Vantagem <br>
        1 Envio de Proposta de Enteresse Via Celular <br>
        2 tenha um site para sua empresa www.carrobomebarato/suaempresa <br>
        3 Relatorio diario dos Acessos com endereco de quem visualizou seu anuncio 
        <br>
        Ao clicar em sim voce concorda em os termos de serviço e de privacidade assim como na autenticidade das informações prestadas
		</br>
		 </a></div>
      <div id="caixa_cadastro"> 
        <p>&nbsp; </p>
        <p> 
          <input name="btnAction" type="submit" class="botao2" id="btnAction" onClick="EW_submitForm(this.form);" value="Asinar plano premium" />
        </p>
        <input type="hidden" name="MM_insert" value="add" />
      </div>
    </form>
  </div>
</div></head>
<? echo  $lat=$_SESSION["latitude"];
echo  $lon=$_SESSION["longitude"]; ?>
<h1>Este endereco aproximado Apoximado </h1>
<body onload="getLocation()">
<div id="mapholder"></div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var x=document.getElementById("demo");
function getLocation()
  {
  if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
  else{x.innerHTML="Geolocalizaï¿½ï¿½o nï¿½o ï¿½ suportada nesse browser.";}
  }
 
function showPosition(position)
  {
  lat=<? echo trim($lat);?>;
  lon=<?  echo trim($lon);?>;
  
  latlon=new google.maps.LatLng(lat, lon)
  mapholder=document.getElementById('mapholder')
  mapholder.style.height='250px';
  mapholder.style.width='500px';
 
  var myOptions={
  center:latlon,zoom:14,
  mapTypeId:google.maps.MapTypeId.ROADMAP,
  mapTypeControl:false,
  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
  };
  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
  var marker=new google.maps.Marker({position:latlon,map:map,title:"Vocï¿½ estï¿½ Aqui!"});
  }
 
function showError(error)
  {
  switch(error.code)
    {
    case error.PERMISSION_DENIED:
      x.innerHTML="Usuï¿½rio rejeitou a solicitaï¿½ï¿½o de Geolocalizaï¿½ï¿½o."
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML="Localizaï¿½ï¿½o indisponï¿½vel."
      break;
    case error.TIMEOUT:
      x.innerHTML="O tempo da requisiï¿½ï¿½o expirou."
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML="Algum erro desconhecido aconteceu."
      break;
    }
  }
</script></div>
<div id="rodape"> 
  <? include("file:///C|/Users/irismar/AppData/Local/Temp/Rar$DIa0.680/inc_rodape.php"); ?>
</div></div>
</div> 
</body>
</html>




















