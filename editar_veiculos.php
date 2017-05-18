  <link rel="stylesheet" href="css/estilo.css">
  <?php require_once('Connections/repasses.php');require_once('admin/includes/tng/tNG.inc.php'); 
  include "lib/WideImage.php"; 

  require_once('log.php');

$permitidos = array('editar_veiculos.php', 'estoque.php', 'ad.php', 'empresa.php');

	if (isset( $_SERVER['PHP_SELF']) AND (array_search( $_SERVER['PHP_SELF'], $permitidos) !== false)) {
		// Pega o valor da variï¿½vel $_GET['pagina']
		 $arquivo= alphaID($_GET['Id_estoque'],true);
		  $nomeurl= alphaID($_GET['membro'],true);
                $sql= "SELECT  Id_estoque,id_membro FROM estoque  	WHERE Id_estoque ='". $arquivo."'   LIMIT 1";
$dados = $mysql->query($sql);

// Executa a consulta
while($row_membro = $dados->fetch_assoc()) {
 $id_membro= $row_membro['id_membro'];
   $id_estoque= $row_membro['Id_estoque'];
$nome_estoque= $row_membro['nome_membro'];
if( $nome_estoque!= $nomeurl= alphaID($_GET['membro'],true)){ 
?><img src="images/segurança.png"><?
exit();
   }
 
   }

                
	} else {
		// Se nï¿½o existir variï¿½vel $_GET ou ela nï¿½o estiver na lista de permissï¿½es, define um valor padrï¿½o
	
	}
   $arquivo= alphaID($_GET['Id_estoque'],true);
		   $nomeurl= alphaID($_GET['membro'],true);
         $sql= "SELECT  * FROM estoque  	WHERE Id_estoque ='". $arquivo."'   LIMIT 1";
$dados = $mysql->query($sql);

// Executa a consulta
while($row_membro = $dados->fetch_assoc()) {
  $id_membro= $row_membro['id_membro'];
  $id_estoque= $row_membro['Id_estoque'];
$nome_estoque= $row_membro['nome_membro'];
$km= $row_membro['km'];

if( $id_membro!= $nomeurl= alphaID($_GET['membro'],true)){ 
?><img src="images/segurança.png"><?
exit();
   }
//if($_SESSION["id"]!=$id_membro){ 
   
  //  header("Location: /Impossivel_editar ");
//}
}
 

unset($_SESSION['ano']);
unset($_COOKIE['cidade']);
unset($_SESSION['modelo']);

if (!IsLoggedIn()) {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
if (IsLoggedIn()) {
 
$sql2 = "SELECT  nome,carros ,alvit,alertamanesagem,foto,watapps,claro,oi,tim,vivo,fixo,email,cidade,estado,lat,log,endereco,data FROM  membros   WHERE  nome= '".$_SESSION["usuario"]."' LIMIT 1 ";
  $query2 = $mysql->query($sql2);
  if ($query2->num_rows != 0) { 
    while($row_membro = $query2->fetch_assoc()) {  
 $nome_usuario= $row_membro['nome'];
 $totalmemsagems= $row_membro['alertamanesagem'];
 $totalvisita= $row_membro['alvit'];
 $cidade= $row_membro['cidade'];
 $estado= $row_membro['estado'];
 $email= $row_membro['email'];
 $endereco= $row_membro['endereco'];
 $foto= $row_membro['foto'];
 $carros= $row_membro['carros'];
 $telefone= $row_membro['watapps'];
 
   }}}


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit")) {
    $val="13.999,00";
  $km = preg_replace("/[][><}{).(:;,!?*%~^`&#@]/", "", $_POST['km']);
  $preco = preg_replace("/[][><}{).(:;,!?*%~^`&#@]/", "", $_POST['preco']);
 
  
 $link = $_POST['id_modelo'];
          $ex = explode('/', $link);
         $id_modelo = $ex[count($ex)-2];
         $modelo = $ex[count($ex)-1]; 
  
        $link1 = $_POST['ID'];
        $ex1 = explode('/', $link1);
        $id_marca = $ex1[count($ex1)-2];
      $marca = $ex1[count($ex1)-1]; 
  

 $mysql->query ("UPDATE estoque SET ano='".$_POST['ano1']."', cor='".$_POST['cor']."', preco='".$preco."',
  condicoes='".$_POST['condicoes']."', km='".$km."', cidade='".$_POST['cidade']."', 
  portas='".$_POST['portas']."', combustivel='".$_POST['combustivel']."', transmissao='".$_POST['transmissao']."', descricao='".$_POST['descricao']."'
   WHERE Id_estoque='".$id_estoque."' AND id_membro='".$id_membro."'");
                       
					  
                     

  
    $mensagem= "Usuario" . $nome_usuario."atualizou dados carro".$id_estoque.$link ;
	                  salvaLog($mensagem);
	$_SESSION["msg"] = 3;
  $updateGoTo = "areadocliente.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  } header("Location: /". intval($id_estoque)."");
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_foto")) {
	
	$sTmpFolder = "galeriadefotos/";
	$foto = $_FILES['imagem'.$_POST['id']];

	if($_FILES['imagem'.$_POST['id']]['size'] > 0)
	{

		$numero =md5(microtime()); 
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto["tmp_name"], $sTmpFolder . $numero . ".jpg");
		

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 360, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x360.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x360.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");

    $image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');
         // Redimensiona a imagem
         $image = $image->resize(404, 304, 'fill','any');
         // Salva a imagem em um arquivo (novo ou não)
         $image->saveToFile('galeriadefotos/capa/'.$numero.'.jpg');
		 $image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');
           // Redimensiona a imagem
          $image = $image->resize(100, 100, 'fill','any');
          // Salva a imagem em um arquivo (novo ou não)
           $image->saveToFile('galeriadefotos/novo/'.$numero.'.jpg');

  $mysql->query ("UPDATE fotos SET imagem='".$imagem."' WHERE Id='".$_POST['id']."'");
  $mysql->query ("UPDATE estoque SET foto_carro='".$imagem."' WHERE Id_estoque='".$arquivo."'");
   $mysql->query ("UPDATE acessos SET foto_carro='".$imagem."' WHERE id_estoque='".$arquivo."'");
  $direção=URL::getBase();
			   ob_end_clean();
 ?>
 <script language= "JavaScript">
location.href="<?=$direção.trim($id_estoque)?>"
</script>

 <? exit();
  }
    $_SESSION["msg"] = 5;
	$updateGoTo = "areadocliente.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }  ?>
  
  <script language= "JavaScript">
location.href="<?=$direção.trim($id_estoque)?>"
</script>
<?  
exit();
}
?>
<?php

 $sql2 = "SELECT * FROM marca ORDER BY marca ASC";
 $query2 = $mysql->query($sql2);
 $totalRows_marcas=$query2->num_rows;

// Verifica se a variï¿½vel $_GET['pagina'] existe E se ela faz parte da lista de arquivos permitidos


 $sql2 = "SELECT * FROM fotos WHERE id_estoque = '".$arquivo."'";
 $query2 = $mysql->query($sql2);
 $totalRows_fotos=$query2->num_rows;


$sql2 == "SELECT * FROM fotos WHERE id_estoque = '".$arquivo."'";
 $query_fotos = $mysql->query($sql2);
 $totalRows_anolista=$query2->num_rows;
 $sql2= "SELECT * FROM estoque WHERE Id_estoque = '".$arquivo."' ";
 $query2 = $mysql->query($sql2);
 $totalRows_estoque=$query2->num_rows;
 if ($totalRows_estoque == 0) { 
 $mensagem= "ERRO GRAVE AO ATUALIZAR O CARRO  '".$arquivo."' ";
                    salvaLog($mensagem);
            header("Location: index.php");
            exit();
  
 }else{
   while($row_estoque = $query2->fetch_assoc()) { 
 
?>
<!DOCTYPE html><html>
<head>

<? include("meta.php"); ?>


<script src="Scripts/funcoes.js" type="text/javascript"></script>
<script src="Scripts/ajax.js" type="text/javascript"></script>
</head>
<body <? if (@$erro == 1) { echo 'onload="ErroCodigo();"';} ?>>
<div id="layout"> 
  <div id="layout_principal"> 
    <div id="topo"> 
    
<div class="container">

 <div class="navbar navbar-default ">
     <div class="col-md-3">
<? if( @$row_estoque1['idfacebook'] <>''){ ?> 
   <a href=" /<?= $_SESSION['usuario']?>" > <img src="https://graph.facebook.com/<?php echo $_SESSION['id_facebook']; ?>/picture"></a> 
   <? }else{ ?> 
   <img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "avatar.jpeg"; } ?>" ></a> 

   <? } ?>

</div> 
   <div class="col-md-8"> 
      <p class="navbar-text-left">
        <a href="#" class="navbar-link"><?php echo $row_estoque['marcatexto']."". $row_estoque['modelotexto']; ?> </a> </p>
        
        <p class="navbar-text-left">
        <a href="#" class="navbar-link"> Ano <? echo $row_estoque['ano'] ;?></a> </p>
	 
         <p class="navbar-text-left">
        <a href="#" class="navbar-link">Portas <?php echo $row_estoque['km']; ?>  Preço  <?php echo $row_estoque['preco']; ?>  Km <?php echo $row_estoque['km']; ?>  </a> </p>
       </div>
  </div>      
 <div class="container">
  <form action="" method="POST" enctype="multipart/form-data" name="edit" id="edit" onSubmit="return EditarCarros();"></div> 
  <div id="caixa_cadastro"> 
  <h1>ANO &nbsp;*</h1>
  <input name="ano1" type="text" class="input" id="ano1" value="<?php echo $row_estoque['ano']; ?>" size="5" maxlength="5" />
  </div>
  <div id="caixa_cadastro"> 
  <h1>COR&nbsp;*</h1>
  <span id="cb_telefone"> 
  <input name="cor" type="text" class="input" id="cor" value="<?php echo $row_estoque['cor']; ?>" size="15" maxlength="20" />
  </span> </div>
  <div id="caixa_cadastro"> 
      <h1>PRE&Ccedil;O&nbsp;*</h1>
      <span id="cb_email"> 
      <input name="preco" type="text" class="input" id="preco" value="<?php echo $row_estoque['preco']; ?>" size="10" maxlength="10" />
      Ex. 19.000,00</span> </div>
    <div id="caixa_cadastro"> 
      <h1>PORTAS</h1>
      <td height="20"><span id="cb_telefone2"> 
        <input name="portas" type="text" class="input" id="portas" value="<?php echo $row_estoque['portas']; ?>" size="5" maxlength="1" />
        </span> </div>
    <div id="caixa_cadastro"> 
      <h1>CONDI&Ccedil;&Otilde;ES&nbsp;*</h1>
      <td height="20"><label> 
        <select name="condicoes" id="condicoes" style="margin-right:10px; width:130px;">
          <option value="Novo" <? if ('Novo' == $row_estoque['condicoes']) { echo "selected"; }; ?>>Novo</option>
          <option value="Usado" <? if ('Usado' == $row_estoque['condicoes']) { echo "selected"; }; ?>>Usado</option>
          <option value="Usado" <? if ('Financiado' == $row_estoque['condicoes']) { echo "selected"; }; ?>>Financiado</option>
        </select>
        </label> </div>
    <div id="caixa_cadastro"> 
      <h1>KM&nbsp;*</h1>
      <td height="20"><span id="cb_email4"> 
        <input name="km" type="text" class="input" id="km" value="<?php echo @$km; ?>" size="10" maxlength="10"/>
        </span> </div>
    <div id="caixa_cadastro"> 
      <h1>COMBUST&Iacute;VEL&nbsp;*</h1>
      <td height="20"><label> 
        <select name="combustivel" id="combustivel" style="margin-right:10px; width:130px;">
          <option value="Flex" <? if ('flex' == $row_estoque['combustivel']) { echo "selected"; }; ?>>Flex</option>
         <option value="Gasolina" <? if ('Gasolina' == $row_estoque['combustivel']) { echo "selected"; }; ?>>Gasolina</option>
          <option value="Diesel" <? if ('Diesel' == $row_estoque['combustivel']) { echo "selected"; }; ?>>Diesel</option>
           </select>
        </label> </div><div id="caixa_cadastro">
    <h1>TRANSMISS&Atilde;O</h1><label>
    <select name="transmissao" id="transmissao">
      <option value="Manual" <?php if (!(strcmp("Manual", $row_estoque['transmissao']))) {echo "selected=\"selected\"";} ?>>Manual</option>
      <option value="Semi-Automatica" <?php if (!(strcmp("Semi-Automatica", $row_estoque['transmissao']))) {echo "selected=\"selected\"";} ?>>Semi-Automatica</option>
      <option value="Automatica" <?php if (!(strcmp("Automatica", $row_estoque['transmissao']))) {echo "selected=\"selected\"";} ?>>Automatica</option>
    </select></div>
    <div id="caixa_cadastro"> 
      <h1>CIDADE&nbsp;*</h1>
      <input name="cidade" type="text" class="input" id="cidade" value="<?php echo $row_estoque['cidade']; ?>" size="22" maxlength="220"/></select> </label> 
    </div>
    <div id="caixa_cadastro"> 
      <h1>DESCRICÃO</h1>
      <textarea name="descricao" cols="50" rows="6" wrap="physical" class="input" id="descricao" value="<?php echo $row_estoque['descricao']; ?>"><?php echo $row_estoque['descricao']; ?></textarea>
    </div>   <div id="caixa_cadastro">   <div id="caixa_cadastro"> </div> 
  <h1>  <input name="btnAction" type="submit" class="botao2" id="btnAction" onClick="EW_submitForm(this.form);" value="EDITAR" />
   </h1></div>
    <div id="caixa_cadastro"> 
      <input name="id" type="hidden" id="id" value="<?php echo $row_estoque['Id_estoque']; ?>" />
    </div>
    <br>
    <br>
    <br>
    <br>
    <input type="hidden" name="MM_update" value="edit" />
  </form>
</div>
<? do { ?>
<div id="caixa_cadastro"> 
<?php if(isset($row_fotos['imagem'])){ ?>
  <form action="" method="POST" enctype="multipart/form-data" name="edit_foto" id="edit_foto" onSubmit="return AdicionarCarros();">
    <div id="caixa_foto3"> <img src="galeriadefotos/peq/<?php echo $row_fotos['imagem']; ?>" " /> 
    </div>
    <label> 
    <input name="imagem<?php echo $row_fotos['Id']; ?>" type="file" id="imagem<?php echo $row_fotos['Id']; ?>" size="25" />
    <input name="id" type="hidden" id="id" value="<?php echo $row_fotos['Id']; ?>" />
    </label>
    <h1> 
      <input name="btnAction" type="submit" class="botao2" id="btnAction" onClick="EW_submitForm(this.form);" value="trocar a imagem antiga " />
    </h1>
    <input type="hidden" name="MM_update" value="edit_foto" />
  </form>
</div>
<? }} while($row_fotos = $query_fotos->fetch_assoc()); ?>
   </div> 
  <div id="rodape"> 
    <? include("rodape.php"); ?>
  </div></div>
  </div> 
</body>
</html>




<?php
}}
?>