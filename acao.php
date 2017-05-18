<? 
require_once'Connections/repasses.php'; 
 require_once('log.php');
  include "lib/WideImage.php";
/////////////////atualizar///usuario//////////////////inicio////


if ((isset($_GET["editar_user"])) ) { 
 if(trim($_SESSION['segure'])==trim($_POST['segure'])){ 	
require('admin/includes/tng/tNG.inc.php'); 

if (IsLoggedIn()) {
$sTmpFolder = "galeriadefotos/";
	$foto = $_FILES['imagem'];
	if($_FILES['imagem']['size'] > 0)	
	{
		
		
		$numero =md5(microtime()); 
		$imagem =$numero. ".jpg";
		move_uploaded_file($foto["tmp_name"], $sTmpFolder . $numero . ".jpg");
		//grd
		tNG_showDynamicThumbnail($sTmpFolder, $sTmpFolder, $numero . ".jpg", 600, 400, true);
		copy($sTmpFolder . "thumbnails/" . $numero . "_600x400.jpg", $sTmpFolder . "grd/" . $numero .".jpg");
		@unlink($sTmpFolder . "thumbnails/" . $numero . "_600x400.jpg");
				
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
		  }  if ($_POST['email'] <> $email) {
		
		 $sql  = "SELECT email FROM membros WHERE email = '" . $_POST['email'] . "'";
		 $row_cliente = $mysql->query($sql);
         $totalRows_cliente =  $query->num_rows;
		
	} else {
		$totalRows_cliente = 0;
	}
	
	if (($totalRows_cliente == 0)) {
	
		if ($_POST['senha'] <> "") {
			$senha = segurancastring($_POST['senha']);
		} else {
			$senha = $_SESSION['senha'];
		}
if($_FILES['imagem']['size'] > 0)
	{
		
	$mysql->query("UPDATE membros SET  endereco='".$_POST['endereco']."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."',watapps='".$_POST['watapps']."',oi='".$_POST['oi']."',vivo='".$_POST['vivo']."',tim='".$_POST['tim']."',claro='".$_POST['claro']."',fixo='".$_POST['fixo']."', email='".$_POST['email']."', senha='".$senha."' ,foto='".$imagem."' WHERE id='".$_SESSION["id"]."'");
      	   $mysql->query("UPDATE estoque SET  foto_membro='".$imagem."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."' WHERE id_membro='".$_SESSION["id"]."'");
		  
		   $_SESSION['foto']=trim($imagem);
            $mensagem =$_SESSION["usuario"]. "Atualizou eus dados com sucesso";
		       salvaLog($mensagem);
			  
			   $direção=URL::getBase();
			   ob_end_clean();
			  
			  ?>
  
  <script language= "JavaScript">
location.href="<?=$direção.trim($_POST['url'])?>"
</script>
<?  

 } else{
  $mysql->query("UPDATE membros SET  endereco='".$_POST['endereco']."', cidade='".$_POST['cidade']."', estado='".$_POST['estado']."',watapps='".$_POST['watapps']."',oi='".$_POST['oi']."',vivo='".$_POST['vivo']."',tim='".$_POST['tim']."',claro='".$_POST['claro']."',fixo='".$_POST['fixo']."', email='".$_POST['email']."', senha='".$senha."'  WHERE id='".$_SESSION["id"]."'");
      	 
		   $mysql->query("UPDATE estoque SET  cidade='".$_POST['cidade']."', estado='".$_POST['estado']."' WHERE id_membro='".$_SESSION["id"]."'");
		   
          	   $mensagem =$_SESSION["usuario"]. "Atualizou eus dados com sucesso";
		       salvaLog($mensagem);
			   $direção=URL::getBase();
			     ?>
  
  <script language= "JavaScript">
location.href="<?=$direção.trim($_POST['url'])?>"
</script>
<?  
	
	
}


  
  
  
  	


  
  } else {
 echo   $mensagem =$nome_usuario. "Ocorreu um erro ao temtar atualizar dados ";
		
	
	$erro = 1;
	}}}else{"Nogento";} }

/////////////////atualizar usuario fim //////////////////////

 if (isset( $_GET['vendido'])){
 $vendido= alphaID($_GET['vendido'],true);
echo $quem= alphaID($_GET['membro'],true);
$data = date('Y-m-d');
$sql2 = "SELECT  * FROM  estoque	WHERE  Id_estoque='".$vendido."' LIMIT 1 ";
  $query2 = $mysql->query($sql2);
  
    while($row_vendido= $query2->fetch_assoc()) { 
	 $dias=calculardiasvenda($row_vendido['data_cadastro'],$data);
	echo  $sql= "INSERT INTO vendido (nome_membro,id_membro,id_estoque,modelo,marca,data_anuncio,data_venda,dias,acessos,endereco,foto,preco)
	 VALUES ('".$row_vendido['nome_membro']."','".$row_vendido['id_membro']."','".$row_vendido['Id_estoque']."','".$row_vendido['modelotexto']."','".$row_vendido[     'marcatexto']."','".$row_vendido['data_cadastro']."','".$data."','".$dias."','".$row_vendido['acessos']."','".$row_vendido[     'endereco']."','".$row_vendido['foto_carro']."','".$row_vendido['preco']."')";
       $sql=$mysql->query($sql);
	   
	}
$mysql->query("DELETE FROM estoque WHERE  Id_estoque='".$vendido."' ");
$mysql->query("DELETE FROM propostas WHERE id = ".$vendido."' ");
$mysql->query("DELETE FROM poi_example WHERE id_estoque = ".$vendido."' ");

$sql2 = "SELECT  * FROM  fotos	WHERE  id_estoque = ".$vendido."";
  $query2 = $mysql->query($sql2);
  
    while($row_fotos= $query2->fetch_assoc()) { 
	
 $image = WideImage::load('galeriadefotos/grd/'.$row_fotos['imagem']);
// Redimensiona a imagem
$image = $image->resize(200, 100 );
// Salva a imagem em um arquivo (novo ou não)
$image->saveToFile('galeriadefotos/vendidos/'.$row_fotos['imagem']);
	
$sTmpFolder="galeriadefotos/";
	unlink("galeriadefotos/grd/".$row_fotos['imagem']);
	unlink("galeriadefotos/peq/".$row_fotos['imagem']);
	unlink("galeriadefotos/mini/".$row_fotos['imagem']);
	}
$mysql->query("DELETE FROM fotos WHERE  Id_estoque='".$vendido."' ");
    //echo$sql=   $mysql->query=( "UPDATE estoque SET  vendido=SIM  WHERE Id_estoque = ".$vendido." ");
	 //echo   $mysql->query=( "UPDATE estoque SET datavenda='".$data."'  WHERE Id_estoque ='".$vendido."' ");
	 //  echo $mysql->query=("UPDATE membros SET carros=carros-1, carros_vendido=carros_vendido +1 WHERE id = '".$quem."'");
$mysql->query("UPDATE membros SET carros_vendido=carros_vendido + 1,carros=carros - 1  WHERE id = ".$quem."");
$mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "Vendeu o carro "."&nbsp;". $vendido."&nbsp;" ;
     salvaLog($mensagem);
	
ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	exit();
	 } 
    if (isset(  $_GET['deletar_euremetente'])){ 
 		 $delet= alphaID($_GET['deletar_euremetente'],true);
		$mysql->query("DELETE FROM propostas WHERE id = ".$delet." AND remetene='".$_SESSION['usuario']."' ");
     
    $mysql->query( "UPDATE membros SET alertamanesagem=0  WHERE id = ".$_SESSION['id']."");
    $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou mensagem"."&nbsp;".  $delet;
    @salvaLog($mensagem);
    ob_end_clean();header("Location: ". $_SERVER['HTTP_REFERER']."");
		exit();}
		 
   if (isset(  $_GET['deletar_eudestinatario'])){ 
       $delet= alphaID($_GET['deletar_eudestinatario'],true);
       $mysql->query("DELETE FROM propostas WHERE id = ".$delet." AND Destinatario='".$_SESSION['usuario']."' ");
       $mysql->query("UPDATE membros SET alertamanesagem=0  WHERE id = ".$_SESSION['id']."");
       $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou mensagem"."&nbsp;".  $delet;
       @salvaLog($mensagem);
       ob_end_clean();header("Location: ". $_SERVER['HTTP_REFERER']."");
	   exit();} 
	   
	if (isset(  $_GET['DTM'])){ 
      $delet= alphaID($_GET['DTM'],true);
      $mysql->query("DELETE FROM propostas WHERE id_estoque = ".$delet." AND Destinatario='".$_SESSION['usuario']."' OR   remetene='".$_SESSION['usuario']."' ");
      $mysql->query( "UPDATE membros SET alertamanesagem=0  WHERE id = ".$_SESSION['id']."");
      $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou todas as suas mensagens"."&nbsp;".'<br>'. "se voc� apagou acidentalmente envie um e-mail para suporte@carrobomebarato.com com o codigo".  "&nbsp;". $delet;
      @salvaLog($mensagem);
      ob_end_clean();
	  header("Location: ". $_SERVER['HTTP_REFERER']."");
	    exit();}

  if (isset(  $_GET['deletartudo'])){ 
     $delet= alphaID($_GET['deletartudo'],true);
     $mysql->query("DELETE FROM acessos WHERE id_estoque = ".$delet." ");
     $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "deletou mensagem"."&nbsp;".  $delet;
     @salvaLog($mensagem);ob_end_clean();header("Location: ". $_SERVER['HTTP_REFERER']."");exit();
 } 
				
if (isset($_GET['memsagem'])) { 
  $sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,email,data,foto,endereco) VALUES ('".$_GET['memsagem']."', '".$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id']."','".$_POST['email']."','".$hora."','".@trim($_GET['foto'])."','".$_SESSION['endereco1']."')";
    $sql= $mysql->query($sql);  
	
  if($sql) {
    $_SESSION["mens_id_estoque"] =$_GET['id'];
    $_SESSION["msm"]="Memsagem Enviada Com Sucesso ";
    $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['memsagem'] ."&nbsp;"." com sucesso" ;
    $mysql->query("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
	  salvaLog($mensagem);
	 
	    ?>
  
  <script language= "JavaScript">
location.href="<?=$_SERVER['HTTP_REFERER']?>"
</script>
<?  
	exit();
	
 }else{
  $_SESSION["mens_id_estoque"] =$_GET['id'];
  $_SESSION["msm"]="Erro ao enviar mensagem  ";
  $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['memsagem'] ."&nbsp;"." com sucesso" ;
//salvaLog($mensagem);
 }}

if (isset($_GET['responder'])) { 
  if( @$_SESSION["mens_id_estoque"]==$_GET['resposta']){
  echo "você já Enviou mensagem";
 ?> <script language= "JavaScript">
location.href="<?=$_SERVER['HTTP_REFERER']?>"
</script><?
	exit();
	  }	
  
   $sql="INSERT INTO propostas ( 	

Destinatario,remetene,mensagem,id_estoque,email,data,foto,resposta) VALUES 
('".$_GET['responder']."', '".$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id_estoque']."','".$_POST['email']."','".$hora."','".$_GET['foto']."','".$_GET['resposta']."')";
  $sql= $mysql->query($sql); 
  
  
     if( $sql){
         $_SESSION["mens_id_estoque"] =  $_GET['resposta'];
          	
   $_SESSION["msm"]="Memsagem Enviada Com Sucesso ";
  $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['responder'] ."&nbsp;"." com sucesso" ;

    $mysql->query ("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
 
   $mysql->query("UPDATE propostas SET respondido= 1  WHERE id = ".$_GET['resposta']."");

	salvaLog($mensagem);
	

 ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	exit();

}//si n�o for logado atualiza aqui fim	
     ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	exit();
     
     }
///////////////////resposta fim //////////////	 
	 
	 if (isset( $_GET['gostei'])){
 $busca=trim($_GET['gostei']);
 $mysql->query("UPDATE estoque SET gostei= gostei+1 WHERE  Id_estoque=". $busca."");

 $mensagem=" visitante gostou do carro"."&nbsp;".  $busca."&nbsp;" ;
 @salvaLog($mensagem);
ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	exit();  } 
   if (isset( $_GET['naogostei'])){
	  $busca=trim($_GET['naogostei']);
$mysql->query("UPDATE estoque SET naogostei= naogostei+1 WHERE  Id_estoque=". $busca."");
$mensagem=" visitante n�o gostou do carro"."&nbsp;".  $busca."&nbsp;" ;
    @salvaLog($mensagem);
ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	exit();
  }  
if (isset( $_GET['90dias'])){ 
 $vendido=  alphaID ($_GET['90dias'],true) ; 
  $data = date('Y-m-d');
  

   $mysql->query  ("UPDATE estoque SET data_cadastro='".$data."',exibir='1'  WHERE Id_estoque= '".$vendido."'");
   $mensagem=" usuario"."&nbsp;". $_SESSION['usuario']."&nbsp;". "renovou divulgação do carro"."&nbsp;". $vendido."&nbsp;"."por mais 90 dias " ;
      @salvaLog($mensagem);
	
	ob_end_clean();
	header("Location: ". $_SERVER['HTTP_REFERER']."");
	
	  exit();
  }	 
  ?>