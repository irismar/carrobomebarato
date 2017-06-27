<? include "Connections/repasses.php";

?></a>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/>
<div class="col-md-12">

    <form action="?app_memsagem=<?php echo $_GET['app_memsagem'] ?>&&id=<?php echo $_GET['id']; ?>&&id_membro=<?php echo $_GET['id_membro']; ?>&&foto=<?php echo $_GET['foto']; ?>&&cod_seguranca=<?php echo $_GET['cod_seguranca']; ?>&&endereco1=<?php echo $_GET['endereco1']; ?>" method="post" >
  
    
     <input type="hidden" name="id_estoque"  value="<?php echo $_GET['id']; ?>">
     <input type="hidden" name="segure"  value="<?php echo $_GET['cod_seguranca']; ?>">
     
     <input type="text" name="memsagem"placeholder="Mensagem" >

 
     <input name="enviar" type="submit" class="botao"value="enviar">

     </form>

 </div>
<? if(isset($_GET['app_memsagem']) && ( isset($_POST['memsagem'])&& ($_POST['memsagem']!='')) ) { 
 require_once'Connections/repasses.php'; 
 require_once('log.php');

    
$sql="INSERT INTO propostas (remetene,mensagem,id_estoque,data,foto,endereco,cod_seguranca,respondido,resposta,alerta,id_membro) VALUES ('".$_GET['app_memsagem']."','".$_POST['memsagem']."','".$_GET['id']."','".$hora."','".@trim($_GET['foto'])."','".$_GET['endereco1']."','".$_GET['cod_seguranca']."','1','1',+1,'".$_GET['id_membro']."')";
$sql= $mysql->query($sql); 
  
if($sql) {
    $mensagem ="Usuario "."&nbsp;".@$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['app_memsagem'] ."&nbsp;"." com sucesso" ;
    $mysql->query("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
    salvaLog($mensagem); 
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $_SESSION['form_token'] = $token;

}else{
  $_SESSION["mens_id_estoque"] =$_GET['id'];
  $_SESSION["msm"]="Erro ao enviar mensagem  ";
  $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['memsagem'] ."&nbsp;"." com sucesso" ;
//salvaLog($mensagem);
 }
if (isset($_GET['responder'])) { 
  if( @$_SESSION["mens_id_estoque"]==$_GET['resposta']){
   "você já Enviou mensagem";
 
	  }
} }?>
