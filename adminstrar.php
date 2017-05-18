<?
 require_once('Connections/repasses.php');
require_once('log.php');  
require_once('admin/includes/tng/tNG.inc.php'); 

 if (IsLoggedIn()) {

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "add")) {
	 if(trim($_SESSION['segure'])==trim($_POST['segure'])){ 	
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
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 120, 90, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_120x90.jpg", $sTmpFolder . "mini/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_120x90.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		 $image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');
           // Redimensiona a imagem
           $image = $image->resize(569, 329,  'inside');
          // Salva a imagem em um arquivo (novo ou não)
           $image->saveToFile('galeriadefotos/grd/'.$numero.'.jpg');
		
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
		
	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
		
	}
       
    
	if ($_POST['email'] <> $email) {
		
		 $sql  = "SELECT email FROM membros WHERE email = '" . $_POST['email'] . "'";
		 $row_cliente = $mysql->query($sql);
         $totalRows_cliente =  $query->num_rows;
		
	} else {
		$totalRows_cliente = 0;
	}
	
	if (($totalRows_cliente == 0)) {
	
		if ($_POST['senha'] <> "") {
			$senha = $_POST['senha'];
		} else {
			$senha = $_SESSION['senha'];
		}
if($_FILES['imagem']['size'] > 0)
	{
	$mysql->query("UPDATE membros SET  endereco='".$_POST['endereco']."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."',watapps='".$_POST['watapps']."',oi='".$_POST['oi']."',vivo='".$_POST['vivo']."',tim='".$_POST['tim']."',claro='".$_POST['claro']."',fixo='".$_POST['fixo']."', email='".$_POST['email']."', senha='".$senha."' ,foto='".$imagem."' WHERE id='".$_SESSION["id"]."'");
      	   $mysql->query("UPDATE estoque SET  foto_membro='".$imagem."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."' WHERE id_membro='".$_SESSION["id"]."'");
          	   $mensagem =$_SESSION["usuario"]. "Atualizou eus dados com sucesso";
		       salvaLog($mensagem);
			   $direção='login.php?acao=login&&email='.$_POST['email'].'&&senha='.$_POST['senha'];
			   header("Location:$direção");
	exit();
 } else{
  $mysql->query("UPDATE membros SET  endereco='".$_POST['endereco']."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."',watapps='".$_POST['watapps']."',oi='".$_POST['oi']."',vivo='".$_POST['vivo']."',tim='".$_POST['tim']."',claro='".$_POST['claro']."',fixo='".$_POST['fixo']."', email='".$_POST['email']."', senha='".senha."'  WHERE id='".$_SESSION["id"]."'");
      	   $mysql->query("UPDATE estoque SET  cidade='".$_POST['cidade']."', estado='".$_POST['estado']."' WHERE id_membro='".$_SESSION["id"]."'");
          	   $mensagem =$_SESSION["usuario"]. "Atualizou eus dados com sucesso";
		       salvaLog($mensagem);
			    $direção='login.php?acao=login&&email='.$_POST['email'].'&&senha='.$_POST['senha'];
			   header("Location:$direção");
	exit();
	
}


  
  
  
  	


  
  } else {
   $mensagem =$nome_usuario. "Ocorreu um erro ao temtar atualizar dados ";
		
	
	$erro = 1;
	} } else {  "e nogento";}
} 
$sql = "SELECT * FROM  membros  WHERE  id= '". $_SESSION["id"]."' LIMIT 1 ";  
$query2 = $mysql->query($sql);
     while($row_membro= $query2->fetch_assoc()) { 
    $id= $row_membro['id'];
 $nome_usuario= $row_membro['nome'];
 $totalmemsagems= $row_membro['alertamanesagem'];
 $totalvisita= $row_membro['alvit'];
 $cidade= $row_membro['cidade'];
 $estado= $row_membro['estado'];
 $email= $row_membro['email'];
 $endereco= $row_membro['endereco'];
 $fotow= $row_membro['foto'];
 $foto= $row_membro['foto'];
 $senha= $row_membro['senha'];
 $carros= $row_membro['carros'];
 $watapps= $row_membro['watapps']; 
 $oi= $row_membro['oi']; 
 $vivo= $row_membro['vivo']; 
  $tim= $row_membro['tim']; 
 $claro= $row_membro['claro']; 
 $fixo= $row_membro['fixo']; 
  $url= $row_membro['url']; 
 
   
?>
<!DOCTYPE html>
<html>
<head>


<? include("meta.php"); ?>

<body></div>
</body>
 <div class="container">
 
<div id="texto"> </div><div id="texto2">
<form action="<? echo URL::getBase(); ?>acao?editar_user" name="add" id="add" enctype="multipart/form-data" method="POST" onsubmit="return ValidaCadastro();">
 <div id="caixa_cadastro">
      <ul class="nav nav-pills" role="tablist">
 
  
    <li role="presentation" class="active"><a href="">Para  Mudar o nome de usuario envie um email para  <span class="badge">mudanca@carrobomebarato.com</span></a></li>
	   
      </ul>
      
      
  </div>

  <div id="caixa_cadastro">
      <ul class="nav nav-pills" role="tablist">
 
  
    <li role="presentation" class="active"><a href="<?  echo URL::getBase(); ?>cadastro?card=<?=$endereco?>">Para  Mudança de Endereço  <span class="badge">Clik aqui na proxima pagina digite seu endereço</span></a></li>
	   
      </ul>
      
      
  </div>
  
   <div class="col-md-1">
  
   <p> <img src="img/icone-whatsapp.png"></p>
     </div>
      <div class="col-md-5"><span id="cb_telefone"> <input name="watapps" type="text"  class="input" id="telefone" value="<?php echo $watapps; ?>" size="10" maxlength="20" /> 
 </span>  </div>
 
 
   <div class="col-md-1">
  
   <p> <img src="img/icone_oi.png"></p>
     </div>
      <div class="col-md-5"><span id="cb_telefone"> <input name="oi" type="text"  class="input" id="telefone" value="<?php echo $oi; ?>" size="10" maxlength="20" /> 
 </span>  </div>
 
 
   <div class="col-md-1">
  
   <p>  <img src="img/icone_tim.png" ></p>
  </div> <div class="col-md-5">
   <input name="tim" type="text"  class="input" id="telefone" value="<?php echo $tim; ?>" size="10" maxlength="20" />
 </span>  </div>
 
 
   <div class="col-md-1">
  
   <p> <img src="img/claro-logo-5.png" ></p>
     </div>
      <div class="col-md-5"><span id="cb_telefone"><input name="claro" type="text"  class="input" id="telefone" value="<?php echo $claro; ?>" size="10" maxlength="20" /> 
 </span>  </div>
 
 <div class="col-md-1">
  
   <p> <img src="img/17-mascoteVIVO.png" ></p>
     </div>
      <div class="col-md-5"><span id="cb_telefone"><input name="vivo" type="text"  class="input" id="telefone" value="<?php echo $vivo; ?>" size="10" maxlength="20" /> 
 </span>  </div>
 
 <div class="col-md-1">
  
   <p> <img src="img/icon-tel10.png" ></p>
     </div>
      <div class="col-md-5"><span id="cb_telefone"><input name="fixo" type="text"  class="input" id="telefone" value="<?php echo $fixo; ?>" size="10" maxlength="20" /> 
 </span>  </div>
 
 
  <div class="col-md-5">
    <h1>email&nbsp;* </h1><input name="email" required name="email" type="text" class="input" id="email" value="<?php echo $email; ?>" size="40" maxlength="100" /> 
  </div>
  <div class="col-md-5"> 
    <h1>senha</h1>
    <input name="senha"   type="password" class="input" id="senha" value="<?php echo $senha; ?>" size="20" maxlength="200" />
    (S&oacute; preencha se desejar alterar) </div>
  <div class="col-md-12">
    <label> 
    <input name="imagem"   id="imagem" type="file" />
    <h1>FOTOS Sua ou Logotipo de Sua Empresa *</h1> </label>
    <input name="btnAction" type="submit" class="botao2" id="btnAction" onclick="EW_submitForm(this.form);" value="EDITAR" />
  </div>
  <input name="id" type="hidden" id="id" value="<? echo $_SESSION['id']; ?>" />
  <input name="url" type="hidden" id="id" value="<? echo  $url; ?>" />
   <input type="hidden" name="segure" value="<? echo  $_SESSION['segure']?>">
     <input type="hidden" name="nome" value="<? echo  $nome_usuario;?>">
      <input type="hidden" name="email" value="<? echo  $nome_usuario;?>">
  <strong><input name="id" type="hidden" id="id" value="<?php echo $senha; ?> " /></strong>
  <input type="hidden" name="MM_update" value="add" />
 
</form>

</div></div>
</div> 
<div id="rodape"> 
  <? }} include("rodape.php"); ?>
</div ></div>
</div> 
</body>
</html>




