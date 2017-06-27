

        	<?  require_once('Connections/repasses.php'); 

		require_once('meta.php'); 

		 require_once('log.php'); 

		  require_once('links.php'); 

 @session_start(); 



if(isset($_GET["seja_bem_vindo"])){ 

 include("map/index.php");

  include("rodape.php"); 

  exit(); }

  

  if(isset($_GET["card"])){ 

 include("map/index.php");

  include("rodape.php"); 

  exit(); }

 if(isset($_GET["facebook"])){

 include("mapa_cadastro.html");

  include("rodape.php"); exit();

   }

 

 

 if(isset($_GET["cad"])) {

 $_SESSION['endereco']=$_GET["cad"];

 include("lx.php");  }

 

 if(isset($_GET["novo_endereco"])) {

 $_SESSION['endereco']=$_GET["novo_endereco"];

 include("lx.php");  }

getTime();		

ob_start();

    



if(isset($_GET["novo"]) ) {

 require_once('admin/includes/tng/tNG.inc.php'); 

include "lib/WideImage.php";

 

	if( !isset($_SESSION['id_facebook'])){ 	 



$sTmpFolder = "galeriadefotos/";

	$foto = $_FILES['imagem'];

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

		 $mensagem =$_POST['nome']. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para seu perfil com sucesso" ;

		 salvaLog($mensagem);

		 

		 $image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');

           // Redimensiona a imagem

           $image = $image->resize(100, 100, 'fill','any');

          // Salva a imagem em um arquivo (novo ou não)

           $image->saveToFile('galeriadefotos/novo/'.$numero.'.jpg'); 

		   $image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');

           // Redimensiona a imagem

           $image = $image->resize(569, 329,  'inside');

          // Salva a imagem em um arquivo (novo ou não)

           $image->saveToFile('galeriadefotos/grd/'.$numero.'.jpg');

		 

		 }

		}

         

		if( isset($_SESSION['id_facebook'])){ 	

		$imagem="facebook"; $id_facebook=$_SESSION['id_facebook']; $namefacebook=$_SESSION['name_facebook']; }else{  $id_facebook=NULL;$namefacebook=NULL; }

		

 $url_user=tirarAcentos1($_POST['nome']);		

  $sql= "INSERT INTO membros (premium,data, nome, endereco,log, lat,cidade,estado,watapps,claro,oi,tim,vivo,fixo, email, senha,foto,datapremium,idfacebook,namefacebok,url)

 VALUES ('".$premium."','".$hora."','".trim($_POST['nome'])."','".trim($_POST['endereco'])."','".trim($_POST['log'])."','".trim($_POST['lat'])."','".trim($_POST['cidade'])."','".trim($_POST['estado'])."','".$_POST['watapps']."','".$_POST['claro']."','".$_POST['oi']."','".$_POST['tim']."','".$_POST['vivo']."','".$_POST['fixo']."','".$_POST['email']."',' ".$_POST['senha']."','".$imagem."','".$datadevencimento."','".$_SESSION['id_facebook']."','".$_SESSION['name_facebook']."','".trim($url_user)."')";

$sql56=$mysql->query($sql);

 

	 echo $sql2 = "SELECT  * FROM  membros 	WHERE  nome='".trim($_POST['nome'])."' LIMIT 1 ";

  $query2 = $mysql->query($sql2);

   $query2->num_rows;

  if ($query2->num_rows == '1') { 

    while($row_estoque1 = $query2->fetch_assoc()) { 

	 $_SESSION['goo']=$row_estoque1['id'];

	

			  ?>

  

  <script language= "JavaScript">

location.href="/goo" 

</script> 

<?  

	 exit(); 

 

}}}

  ?>

<!DOCTYPE html>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<? include("meta.php"); ?>

<script type="text/javascript" src="js/jquery.js" async></script>

<script type="text/javascript" src="js/simpleAutoComplete.js" async></script>



<script src="Scripts/funcoes.js" type="text/javascript" async></script>

<script src="Scripts/ajax.js" type="text/javascript" async></script>



</div> 

      <form action="<? URL::getBase();?>cadastro?novo" name="add" id="add" enctype="multipart/form-data" method="POST" onsubmit="return ValidaCadastro();">

      <div id="caixa_cadastro"> 

      <h1>nome&nbsp; da sua Empresa ou seu nome </h1><span id="cb_nome">

      <input name="nome" required  type="text" class="input" id="nome" value="<?php echo @$_POST['nome']; ?>" size="20" maxlength="100"onchange="javascript:Carreganome('verificar_user.php',this.value);"placeholder="Digite seu nome ou de sua empresa"/>

      <div id="caregarnome" > </div>

      </div>

      <div id="caixa_cadastro"> 

      <h1>email&nbsp;*  * informe seu email *</h1>

      <span id="cb_email"> 

		<? if (isset($_SESSION['email_facebook'])){ ?>

	 <input name="email"   type="text" class="input"  required id="email" value="<? echo  @$_SESSION['email_facebook']; ?>" size="40" maxlength="100" onchange="javascript:Carregaemail('verificar_email.php',this.value);" placeholder="Digite seu email"/>

  <? 	}else{  ?>  <input name="email"   type="text" class="input"  required id="email" value="<? echo  @utf8_decode(retira_acentos(mysql_escape_string($_POST['email']))); ?>" size="40" maxlength="100" onchange="javascript:Carregaemail('verificar_email.php',this.value);" placeholder="Digite seu email"/>

     <?  }	?>

          <div id="caregaremail"></div>

        </span> </div>

         <div id="caixa_cadastro"> 

        <h1>Cidade</h1>

        <span id="cb_endereco"> <input name="cidade" id="cidade"   type="text" class="input" id="endereco" value=" <?php echo @$cidade; ?>" size="42" maxlength="100" /> 

        </span> </div>

		 <div id="caixa_cadastro"> 

        <h1>Estado</h1>

        <span id="cb_endereco"> <input name="estado" id="estado"   type="text" class="input" id="estado" value=" <?php echo @$estado; ?>" size="42" maxlength="100" /> 

        </span> </div>

        <input type="hidden" value="<?php echo @trim($_GET['lat']); ?>" id="lat" name="lat"   />

       

        <input type="hidden"  value="<?php echo @trim($_GET['long']); ?>"id="log" name="log"  />

       

      <div id="caixa_cadastro"> 

        <h1>endereco</h1>

        <span id="cb_endereco"> <input name="endereco" id="endereco"  required name="endereco" type="text" class="input" id="endereco" value=" <?php echo @$rua."&nbsp;&nbsp;".@$cidade."&nbsp;&nbsp;".@$estado."&nbsp;&nbsp;". @$pais."&nbsp;&nbsp;".  @$cep; ?>" size="82" maxlength="100" /> 

        </span> </div>

      <div id="caixa_estoque1"> 

        <div id="caixa_cadastro"> 

         

          <span id="cb_telefone"> 

           <h1></h1><img src="/img/icone-whatsapp10.png" >

           <input name="watapps" required  type="number"  class="input" id="watapps" value="<? echo @utf8_encode($_POST['watapps']); ?>" size="10" maxlength="20" placeholder="DD-número"/>

          </span> </div>

        <div id="caixa_cadastro"> 

          <h1></h1>

          <span id="cb_telefone"> <img src="/img/claro-logo-510.png"><input name="claro" type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['claro']); ?>" size="10" maxlength="20" placeholder="DD-número"/> 

          </span> </div>

        <div id="caixa_cadastro"> 

          <h1></h1>

          <span id="cb_telefone"><img src="/img/icone_oi10.png" > <input name="oi"  type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['oi']); ?>" size="10" maxlength="20" placeholder="DD-número"/>

          </span> </div>

		        <div id="caixa_cadastro"> 

          <h1></h1>

          <span id="cb_telefone"><img src="/img/icone_tim10.png" > <input name="tim"  type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['tim']); ?>" size="10" maxlength="20" placeholder="DD-número"/>

          </span> </div>

        <div id="caixa_cadastro"> 

          <h1></h1>

          <span id="cb_telefone"><img src="/img/17-mascoteVIVO10.png" > <input name="vivo" type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['vivo']); ?>" size="10" maxlength="20" placeholder="DD-número"/>

          </span> </div>

		   <div id="caixa_cadastro"> 

          <h1></h1>

          <span id="cb_telefone"><img src="/img/icon-tel10.png"> <input name="fixo"  type="number"  class="input" id="telefone" value="<? echo @utf8_encode($_POST['fixo']); ?>" size="10" maxlength="20" placeholder="DD-número"/>

          </span> </div>

      </div>

      <div id="caixa_estoque1"> 

        <div id="caixa_cadastro"> 

          <h1>senha&nbsp;*</h1>

          <span id="cb_senha"> <input name="senha" valuer "" required name="senha" type="password" class="input" id="senha" size="20" maxlength="200" /> 

          </span> </div>

        <div id="caixa_cadastro"> 

          <h1>COMFIRMA&nbsp;*</h1>

          <span id="cb_senha2"> <input name="confirmar" valuer "" required name="confirmar"  type="password" class="input" id="confirmar" size="20" maxlength="200" />(Digite 

          a senha novamente) </span> </div>

      </div>

      <div id="caixa_cadastro"> 

	  <? if (isset($_SESSION['id_facebook'])){ ?>

	  <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture" > <? }else{ ?>

                   <label>  Sua Foto ou Logotipo de Sua Empresa * </label>

				    <input name="imagem" type="file" id="imagem" size="55" />

					<? } ?>

      </div>

      <br>

      <div id="caixa_cadastro"> 

        <p>&nbsp; </p>  <input type="hidden" name="MM_insert" value="add" />

        <p> 

          <input name="btnAction" type="submit" class="botao2" id="btnAction" onclick="EW_submitForm(this.form);" value="CADASTRAR" />

        </p>

     

     

    </form>

  </div>

</div></head> 



<div id="rodape"> 

  <? include("rodape.php"); ?>

</div></div>

</div> 

</body>

</html>









































