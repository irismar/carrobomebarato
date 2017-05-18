<? 
require_once('Connections/repasses.php'); 
require_once('log.php');
include "lib/WideImage.php"; 
?>
<?php require_once('admin/includes/tng/tNG.inc.php'); 
?>

<?php
$_SESSION['plano'] ='1';
	$data = date('Y-m-d');
if (!IsLoggedIn()) {
	ob_end_clean();
	header("Location: index.php");
	exit();
}
 if (IsLoggedIn()) {

 $sql= "SELECT * FROM membros  	WHERE nome ='". $_SESSION["usuario"]."'   LIMIT 1";
 $dados = $mysql->query($sql);

// Executa a consulta
 while($row_membro = $dados->fetch_assoc()) {
  $id= $row_membro['id'];
 $nome_usuario= $row_membro['nome'];
 $totalmemsagems= $row_membro['alertamanesagem'];
 $totalvisita= $row_membro['alvit'];
 $cidade= trim($row_membro['cidade']);
 $estado= trim($row_membro['estado']);
 $email= $row_membro['email'];
 $endereco= $row_membro['endereco'];
 $fotow= $row_membro['foto'];
 $carros= $row_membro['carros'];
 $data_cadastro= $row_membro['data'];
 $telefone= $row_membro['watapps'];
$telefone= $row_membro['watapps']; 
 $lat=$row_membro['lat']; 
    $lon=$row_membro['log'];
	  $url=$row_membro['url']; 
 
   }}

unset($_SESSION['cadastro']);
$_SESSION["msg"] = "";

  unset($_SESSION['id_fipe']);


 $editFormAction = $_SERVER['PHP_SELF'];



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "add")) {
  
	$sTmpFolder = "galeriadefotos/";
	$foto = $_FILES['imagem'];
	$foto2 = $_FILES['imagem2'];
	$foto3 = $_FILES['imagem3'];
	$foto4 = $_FILES['imagem4'];
	$foto5 = $_FILES['imagem5'];
	$foto6 = $_FILES['imagem6'];
	$foto7 = $_FILES['imagem7'];



      
	@$link = $_POST['modelo'];
    $ex = explode('/', $link);
    $id_modelo = $ex[count($ex)-2];
    $modelo = $ex[count($ex)-1]; 
    $link1 =trim( $_POST['marca']);
    $ex1 = explode('/', $link1);
    $id_marca = $ex1[count($ex1)-2];
    $marca = $ex1[count($ex1)-1]; 
	 $km=$_POST['km']; 
    $preco= $_POST['preco'];
    $fipe= $_POST['fipe'];	 


 $url_user=tirarAcentos1($_POST['url']);	

  $sql= "INSERT INTO estoque (contato,taxa,entrada,premium,endereco,id_membro,foto_membro,nome_membro, data, data_cadastro, categoria,marcatexto,modelotexto,  ano, ano2, cor, preco, condicoes, km, cidade,estado, portas, combustivel, transmissao, descricao, id_plano,lat,lon ,watapps,oi,vivo,claro,tim,fixo,email,video,idfacebook,url,fipe)
  VALUES ('". $telefone."', '".$_POST['taxa']."','".$_POST['entrada']."','".$_SESSION['premium']."','".$endereco."',
					   '".$id."',
					   '".$fotow."',
					   '". $nome_usuario."',
					   '".$hora."',
					   '".$data_cadastro."',				   
                               '3',
					   '".$_POST['marca']."',
					   '".$_POST['modelo']."',
					  
                        '".$_POST['ano']."',
					   '".$_POST['ano']."',
                                           '".$_POST['cor']."',
                                           '".$_POST['preco'] ."',
					   '".$_POST['condicoes']."',
					   '".$_POST['km']."',
					   '".trim($cidade)."',
					   '".trim($estado)."',
					   '".$_POST['portas']."',
					   '".$_POST['combustivel']."',
					   '".$_POST['transmissao']."',
                                           '".$_POST['descricao']."',
					   '".$_SESSION['plano']."',
					   '".trim($lat)."',
					   '".trim($lon)."',
					   '".$_SESSION['watapps']."',
					   '".$_SESSION['oi']."',
					   '".$_SESSION['vivo']."',
					   '".$_SESSION['claro']."',
					   '".$_SESSION['tim']."',
					    '".$_SESSION['fixo']."',
					   '".$email."',
					     '".trim($_POST['video'])."',
						 '".trim($_SESSION['id_facebook'])."',
						   '".$url_user."', '".$fipe."')"; 
   $sql= $mysql->query($sql); 		
	
  $sql2 = "SELECT nome_membro,Id_estoque,url,carros  FROM estoque WHERE  nome_membro ='". $_SESSION["usuario"]."' ORDER BY Id_estoque DESC";
	$estoque = $mysql->query($sql2);
	$row_estoque= $estoque ->fetch_assoc();
	$id_estoque=$row_estoque['Id_estoque'];
	$url= $row_estoque['url'];
	 $carr= $row_estoque['carros'];
	   $carro_atual= $carros_total +1 ;
	
  $km=$_POST['km']; 
  $preco= $_POST['preco'];
  	 
  
	
                
	
	$up=$mysql->query ( "UPDATE membros SET carros = carros + 1 WHERE  url='".$url."'");
	$up=$mysql->query ( "UPDATE estoque SET carros ='".$carro_atual."' WHERE  url='".$url."'");
	$up=$mysql->query ( "UPDATE membros SET carros_total = carros_total + 1 WHERE  url='".$url."'");


	
	foreach ($_POST as $campo => $valor) {
		if ($valor == 'Sim') {
			$check = explode("acessorios_",$campo);
			
			$sql= "INSERT INTO acessorios_carros (id_acessorios, id_estoque) VALUES (".$check[1].",".$id_estoque.")";
			
			 $sql= $mysql->query($sql); 
			
			
			
		}
	}

	
	if($_FILES['imagem']['size'] > 0)
	{

		$numero =md5(microtime()); 
		$imagem =$numero. ".jpg";
		
		move_uploaded_file($foto["tmp_name"], $sTmpFolder . $numero . ".jpg");
        //grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		@unlink($sTmpFolder . $numero . ".jpg");
		$image = WideImage::load('galeriadefotos/grd/'.$numero.'.jpg');
         // Redimensiona a imagem
         $image = $image->resize(404, 304, 'inside');
         // Salva a imagem em um arquivo (novo ou não)
         $image->saveToFile('galeriadefotos/capa/'.$numero.'.jpg');
		 
		   $image = $image->resize(100, 100, 'inside');
         // Salva a imagem em um arquivo (novo ou não)
         $image->saveToFile('galeriadefotos/novo/'.$numero.'.jpg');
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql); 
		
		 $sql = "INSERT INTO poi_example (id_estoque,name,endereco,lat,lon,carromodelo,preco,foto)
		VALUES ('".$id_estoque."','".$nome_usuario."','".$endereco."','".$lat."','".$lon."','".$_POST['modelo']."','".$preco."','".$imagem."')";
		$sql= $mysql->query($sql); 
	
		$adimagem=$mysql->query ("UPDATE estoque SET foto_carro='".$imagem."' WHERE Id_estoque='".$id_estoque."'");
        
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$id_estoque.'&nbsp;'. "com sucesso" ;
		if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	
		
		
		}   
	if($_FILES['imagem2']['size'] > 0)
	{

		$numero =md5(microtime()); 
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto2["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
         $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
	
        
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$id_estoque.'&nbsp;'. "com sucesso" ;
		if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	
	}   

	if($_FILES['imagem3']['size'] > 0)
	{

		$numero =md5(microtime()); 
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto3["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
          $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
		  
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$id_estoque.'&nbsp;'. "com sucesso" ;
		if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	
	}   


	if($_FILES['imagem4']['size'] > 0)
	{

		$numero =md5(microtime());  
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto4["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
         $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
		$adimagem=$mysql->query ("UPDATE estoque SET foto_carro='".$imagem."' WHERE Id_estoque='".$id_estoque."'");
        
		
	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	}   
	

	if($_FILES['imagem5']['size'] > 0)
	{

		$numero =md5(microtime());  
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto5["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
         $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
		  
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$id_estoque.'&nbsp;'. "com sucesso" ;
		
	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	}   
	

	if($_FILES['imagem6']['size'] > 0)
	{

		$numero =trim($foto6. $marca.  $modelo);
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto6["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		@unlink($sTmpFolder . $numero . ".jpg");
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
          $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
	  
		 $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$id_estoque.'&nbsp;'. "com sucesso" ;
		
	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	}   


	if($_FILES['imagem7']['size'] > 0)
	{

		$numero =md5(microtime());  
		$imagem = $numero . ".jpg";
		
		move_uploaded_file($foto7["tmp_name"], $sTmpFolder . $numero . ".jpg");

		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 640, 480, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_640x480.jpg");
				
		//peq
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 220, 190, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg", $sTmpFolder . "peq/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_220x190.jpg");
		
		@unlink($sTmpFolder . $numero . ".jpg");
		
		
		$sql = "INSERT INTO fotos (id_estoque,imagem) VALUES ('".$id_estoque."','".$imagem."')";
		 $sql= $mysql->query($sql);
          $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' .$imagem.'&nbsp;'."para carro" .$row_estoque['Id_estoque'].'&nbsp;'. "com sucesso" ;
		$adimagem=$mysql->query ("UPDATE estoque SET foto_carro='".$imagem."' WHERE Id_estoque='".$id_estoque."'");
        
		
	if (salvaLog($mensagem)) {

	echo "O LOG foi salvo com sucesso!";

	} else {

	echo "NAo foi possivel salvar o LOG!";

	}
	}   

  $_SESSION["msg"] = 2;
  $insertGoTo = "/".$row_estoque['Id_estoque'];
  $mensagem =$nome_usuario. "Adicionou " .'&nbsp;' ." carro" .$row_estoque['Id_estoque'].'&nbsp;'. " fotos com sucesso " ;
 salvaLog($mensagem);
	   unset($_SESSION['id_fipe']);
			   ob_end_clean();
			  
			  ?>
  
  <script language= "JavaScript">
location.href="<?="/".trim($row_estoque['Id_estoque'])?>"
</script>
<?  
	exit();
 
	

}







?>
<!DOCTYPE html>
<html>
<head>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
 
 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/estilo.css" rel="stylesheet" type="text/css">
<? include("meta.php"); ?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/simpleAutoComplete.js"></script>

<script src="Scripts/funcoes.js" type="text/javascript"></script>
<script src="Scripts/ajax.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
	    $('#estado_autocomplete').simpleAutoComplete('ajax_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		attrCallBack: 'rel',
		identifier: 'estado'
	    },estadoCallback);

	    $('#cidade_autocomplete').simpleAutoComplete('ajax_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		identifier: 'cidade',
		extraParamFromInput: '#id_estado'
	    },cidadeCallback);
		
		  $('#ano_autocomplete').simpleAutoComplete('ajax_query.php',{
		autoCompleteClassName: 'autocomplete',
		selectedClassName: 'sel',
		identifier: 'cidade',
		extraParamFromInput: '#id_ano'
	    },anoCallback);
        });
		
	
	
	function estadoCallback( par )
	{
	    $("#id_estado").val( par[0] );
	    $("#uf1").val( par[1] );
	    $("#cidade_autocomplete").removeAttr("disabled");
		$("#cidade_autocomplete, #uf2, #id_cidade").val("");
	}
	function anoCallback( par )
	{
	    $("#id_ano").val( par[0] );
	    $("#uf1").val( par[1] );
	    $("#ano_autocomplete").removeAttr("disabled");
		$("#cidade_autocomplete, #uf2, #id_cidade").val("");
	}

	function cidadeCallback( par )
	{
	    $("#id_cidade").val( par[0] );
	    $("#uf2").val( par[1] );
	}
	
    </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<div class="container">
<? if(!isset($_GET['marca'])){ ?>
  <form action="?" method="GET" enctype="multipart/form-data" name="add" id="add" onSubmit="return AdicionarCarros();">
    <div id="caixa_cadastro"> 
      <h2>Digite aqui o nome do seu carro</h2>
      <input type="text" id="estado_autocomplete" name="marca" autocomplete="off"  />
    </div>
    <input type="hidden" name="id_estado" id="id_estado" />
    <div id="caixa_cadastro"> 
      <h2>Escolha o Modelo:</h2>
      <input type="text" id="cidade_autocomplete" name="modelo" autocomplete="off" disabled />
       <input type="hidden" name="id_ano" id="id_ano" />
    
    </div>
    
   
     <input name="btnAction" type="submit" class="botao2" id="btnAction"  value="Analizar" />
    
      <input type="hidden" name="url" value="<? echo $url;?>" />
    <input name="id_membro" type="hidden" id="id_membro" value="<? echo $_SESSION['id']; ?>" />
  </form>
   <? } else{ 
       
      $str=trim( $_GET['modelo']);
      $arry=explode("Fipe",$str);
     
       ?><div class="container">
      <form action="adicionar.php" method="POST" enctype="multipart/form-data" name="add" id="add" onSubmit="return AdicionarCarros();">
<? $sql = "SELECT * FROM veiculos  where id='".trim($arry['1'])."'  limit 1";
	$r = $mysql->query($sql);
	if ( $r )
	{ ?>
	   
<ul >
           <?  while( $l =$r->fetch_assoc())
	    { ?>
      <div class="jumbotron">
   <li>   <a href="/adicionar">
   <?
  $marca = $l['marca'];$modelo=$l['modelo'];
    echo  $p = $l['marca']." ".$l['modelo']."  ";?></a></li> 
   <li>   <a href="#"><? echo 'ano fabricação:'." ".$l['ano'] ."  "?></a></li>
    <li>   <a href="#"><? echo 'Combustivel:'." ".$l['combustivel'] ."  "?></a></li>
    <? 
	


if(strpos($l['modelo'],"4p") !== false)
     {
     $portas='4';
     }
  
if(strpos($l['modelo'],"2p") !== false)
     {
     $portas='2';
     }
if(strpos($l['modelo'],"5p") !== false)
     {
     $portas='5';
     }
if(strpos($l['modelo'],"3p") !== false)
     {
     $portas='3';
     }
if(	@$portas == false) {
 $portas='';	
}

	 if(	@$portas == false) {
 $portas='';	
}  else{  ?> 
    <li>   <a href="#"><? echo 'Número de Portas:'." ".$portas ."  "?></a></li>
<? } if(strpos($l['modelo'],"Aut") !== false)
     { ?>
    <li>   <a href="#"><? echo 'Transmissão:'." " .'Automatica' ?></a></li>
    <?  } ?>
    
    
    <li><img src="img/fipe.png" >   <a href="#"><? echo "  ". 'Valor de Referência Fipe:'." ".$l['valor'];?></a></li>
   o preço de referência é obitido via API no site da fipe última atualização   <? echo  date('d/m/Y');?>
   
 
       
                 
          
       </div>
	
	   </ul>  
	 </div>
    <div id="caixa_cadastro"> 
      <h1>COR&nbsp;*</h1>
      <span id="cb_telefone"> 
      <input name="cor" type="text" class="input" id="cor" value="<?php echo @$_POST['cor']; ?>" size="15" maxlength="30"/>
      </span> </div>
    <div id="caixa_cadastro"> 
      <h1>PRE&Ccedil;O&nbsp;*</h1>
      <span id="preco"> 
      <input name="preco"type="text" class="input"  value="<?
echo @ $_POST['preco'];
?>" size="10" maxlength="10"/>
      Ex. 19.000,00</span></div>
     <div id="caixa_cadastro"> 
      <h1>Valor Entrada</h1> Se não sabe sem problemas pode deixar em  Branco 
      <select name="entrada" id="transmissao" placeholder=" Se não sabe sem problemas pode deixar em  Branco" >
           <option value="0.0" selected="selected">0%</option>
        <option value="0.1">10%</option>
         <option value="0.2">20%</option>
          <option value="0.3">30%</option>
           <option value="0.4">40%</option>
            <option value="0.5">50%</option>
           
           </select>
    </div><div id="caixa_cadastro"> 
      <h1>taxa de juro</h1>
      <span id="preco"> 
      <input name="taxa"  type="text"  class="input" placeholder=" Se não sabe sem problemas pode deixar em  Branco"  value="<?php echo @$_GET['taxa']; ?>" size="10" maxlength="10"/>
      Ex. 1,75 ao mes </span></div>
    <div id="caixa_cadastro"> 
      <h1>PORTAS</h1>
      <? if(!empty($portas)){ ?>
      <input name="porta"  type="text"  class="input" placeholder=" Se não sabe sem problemas pode deixar em  Branco"  value="<?php echo @$portas; ?>" size="10" maxlength="10"/>
      <?} else{ ?>
      <span id="cb_telefone2"> 
       <select name="porta" id="ate" >
        
        <option value="2">2</option>
        <option value="3">2</option>
        <option value="4">4</option>
       
       
      </select>
      <? }?>
    </div>
    <div id="caixa_cadastro"> 
      <h1>CONDIÇÃO</h1>
      <label> 
      <select name="condicoes" id="condicoes" >
        <option value="0">escolha uma Opção</option>
        <option value="Novo">Novo</option>
        <option value="Usado" selected="selected">Usado</option>
        <option value="Financiado">Financiado</option>
      </select>
      </label>
    </div>
    <div id="caixa_cadastro"> 
      <h1>KM</h1>
      <span id="cb_email4"> 
      <input name="km" type="text" class="input" id="km" value="<?php echo @$_POST['km']; ?>" size="10" maxlength="10"/>
      Ex. 80.000</span></div>
    <div id="caixa_cadastro"> 
      <h1>COMBUSTVEL*</h1>
      <? if(strpos($l['modelo'],"Flex") !== false)
     { ?>
         <input name="combustivel" type="text" class="input" id="km" value="FLEX" size="10" maxlength="10"/>
     <? }else{ ?>
      <label> 
      <select name="combustivel" id="combustivel" >
        <option>escolha uma opção</option>
        <option value="Gasolina">Gasolina</option>
        <option value="Alcool">Alcool</option>
        <option value="Diesel">Diesel</option>
        <option value="Flex" selected="selected">Flex</option>
        <option value="GNV">GNV</option>
      </select>
      </label>
           <? } ?>
    </div>
    <div id="caixa_cadastro"> 
         <h1>TRANSMISSÃO</h1>
       <? if(strpos($l['modelo'],"Aut") !== false)
     { ?>
      <input name="transmissao" type="text" class="input" id="km" value="<?php echo 'Automatico'?>" size="10" maxlength="10"/>
    <?  } else{ ?>
     
      <select name="transmissao" id="transmissao">
        <option value="Manual" selected="selected">Manual</option>
        <option value="Semi-Automatica">Semi-Automatico</option>
        <option value="Automatico">Automatico</option>
    </select> <? } ?>
    </div>
	 <div id="caixa_cadastro"> 
      <h1><img src="img/yutube.png" width="30">Poste um video no yutube e cole o endereço o video fará parte do seu anuncio  
      <span id="cb_telefone2"> 
      <input name="video" type="text"  class="input" id="video" placeholder=" algo como https://www.youtube.com/watch?v=YHRhpSD1UpI" value="<?php echo @$_POST['video']; ?>" size="99" maxlength="900" />
      </span></div>
    <div class="container">


    <div class="col-md-12">
      <div class="col-md-8"><img src="img/sites-responsivos-dispositivos.png" > 
      <h1>Foto Capa do anúncio </h1>
      <label> insira uma foto de boa qualidade e com imagem bem clara do carro
      <input name="imagem" type="file" id="imagem" size="25" />
      </label>
    </div> </div> </div> 
    <div id="caixa_cadastro"> 
      <h1>FOTOS LATERAL *</h1>
      <label> 
      <input name="imagem2" type="file" id="imagem2" size="25" />
      </label>
    </div>
    <div id="caixa_cadastro"> 
      <h1>FOTOS TRASEIRA *</h1>
      <label> 
      <input name="imagem3" type="file" id="imagem3" size="25" />
      </label>
    </div>
    <div id="caixa_cadastro"> 
      <h1>FOTOS INTERIOR *</h1>
      <label> 
      <input name="imagem4" type="file" id="imagem4" size="25" />
      </label>
    </div>
    <div id="caixa_cadastro"> 
      <h1>FOTOS PAINEL *</h1>
      <input name="imagem5" type="file" id="imagem5" size="25" /></label>
      </div>
    <div id="caixa_cadastro"> 
      <h1><strong>OUTRAS FOTOS</h1>
      <input name="imagem6" type="file" id="imagem6" size="25" /></label>
      </div>
    <div id="caixa_cadastro"> 
      <h1>OUTRAS FOTOS</h1>
      <input name="imagem7" type="file" id="imagem7" size="25" /></label>
      </div>
    <div id="caixa_cadastro"> 
      <h1>OUTRAS FOTOS</h1>
      <input name="imagem8" type="file" id="imagem8" size="25" /></label>
      </div> <div class="col-md-12">
    <h1> DESCRIÇÃO</h1>
    <span> 
    <textarea name="descricao" cols="50" rows="4" wrap="physical" class="input" id="descricao" value="<?php echo $_POST['descricao']; ?>"></textarea>
    <?
    $sql2 = "SELECT * FROM acessorios ORDER BY acessorios ASC";
 $query2 = $mysql->query($sql2);

    while($row_acessorios= $query2->fetch_assoc()){ ?>
    
      <div class="col-md-12">

    
    <input name="acessorios_<?php echo $row_acessorios['id']; ?>" style="border:3px;" type="checkbox" id="acessorios_<?php echo $row_acessorios['id']; ?>" value="Sim" />
    <?php echo  utf8_encode($row_acessorios['acessorios']); ?>
    	 </div><? } ?>
    

    <input name="btnAction" type="submit" class="botao2" id="btnAction" onClick="EW_submitForm(this.form);" value="CADASTRAR" />
    <input type="hidden" name="MM_insert" value="add" />
    <input type="hidden" name="url" value="<? echo $url;?>" />
    <input type="hidden" name="modelo" value="<? echo $modelo;?>" /> </li> 
    <input type="hidden" name="marca" value="<? echo $marca;?>" />
    <input type="hidden" name="ano" value="<? echo $ano;?>" />
    <input type="hidden" name="fipe" value="<? echo $l['valor'];?>" />
    <input name="id_membro" type="hidden" id="id_membro" value="<? echo $_SESSION['id']; ?>" />
  </form><? }  } } ?>
</div></div></div>
</body>
</html>




















<?php

?>