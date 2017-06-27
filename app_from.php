 <?  session_start(); 
   require_once('Connections/repasses.php'); 
   require_once('log.php'); ?>
 
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/>
<div class="col-md-12">
  
    <a class="azul">Troque mensagem com o vendedor em  tempo real</a>
  

   
    <form action="acao.php?memsagem=<?php echo $_GET['app_memsagem'] ?>&&id=<?php echo $_GET['id']; ?>&&id_membro=<?php echo $_GET['id_membro']; ?>&&foto=<?php echo $_GET['foto']; ?>&&cod_seguranca=<?php echo $_GET['segure']; ?>&&marca=<?php echo $_GET['marca']; ?>&&modelo=<?php echo $_GET['modelo']; ?>&&preco=<?php echo $_GET['preco']; ?>&&endereco1=<?=$_GET['endereco1']?>" method="post" >
    <? if(isset($_SESSION['nome_visita'])&& ($_SESSION['nome_visita']!='')){?>
        <input type="hidden"   name="nome" value="<?=$_SESSION['nome_visita'];?>" required  id="nome" />

     <input type="hidden"  name="email"  value="<?=$_SESSION['telefone_visita'];?>" id="email" />
    <? }else{ ?>
    
         <input type="text"  placeholder="Seu nome"  name="nome" required  id="nome" />

        <input type="text"  name="email"placeholder="Telefone não ligamos sem sua autorização" required   name="email" id="email" />
 
    <?  } ?>
   
     <input type="text" name="memsagem"placeholder="Escreva uma mensagem ao vendedor aguarde alguns segundos pela resposta" >

    
     
     <input name="enviar" type="submit" class="botao"value="enviar">
    
     </form>
    
        

 </div>
<? if(isset($_GET['app_memsagem']) && ( isset($_POST['memsagem'])&& ($_POST['memsagem']!='')) ) { 
 require_once'Connections/repasses.php'; 
 require_once('log.php');

     $sql2  = " SELECT id FROM propostas WHERE  cod_seguranca='" .trim($_SESSION['segure']). "'  ORDER BY id  ASC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);

$totalRows_propostas = $query2->num_rows;

  if ( $totalRows_propostas != 0) { 
    
 //echo $sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,email,data,foto,endereco,cod_seguranca,respondido,alerta,id_membro,marca,modelo,preco) VALUES"
         //. " ('".$_GET['app_memsagem']."', '".@$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id']."','".$_POST['email']."','".$hora."','".@trim($_GET['foto'])."','".$_COOKIE['endereco1']."','".$_SESSION['segure']."','1',+1,'".@trim($_GET['id_membro'])."','".@trim($_GET['id_membro'])."','".@trim($_GET['marca'])."','".@trim($_GET['modelo'])."','".@trim($_GET['preco'])."')";
 $sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,email,data,foto,endereco,cod_seguranca,alerta,id_membro,marca,modelo,preco,respondido) VALUES ('".$_GET['app_memsagem']."', '".@$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id']."','".$_POST['email']."','".$hora."','".@trim($_GET['foto'])."','".$_COOKIE['endereco1']."','".$_SESSION['segure']."',+1,'".@trim($_GET['id_membro'])."','".@trim($_GET['marca'])."','".@trim($_GET['modelo'])."','".@trim($_GET['preco'])."','1')";
$sql= $mysql->query($sql); 
    
  }else{
   $sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,email,data,foto,endereco,cod_seguranca,alerta,id_membro,marca,modelo,preco) VALUES ('".$_GET['app_memsagem']."', '".@$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id']."','".$_POST['email']."','".$hora."','".@trim($_GET['foto'])."','".$_COOKIE['endereco1']."','".$_SESSION['segure']."',+1,'".@trim($_GET['id_membro'])."','".@trim($_GET['marca'])."','".@trim($_GET['modelo'])."','".@trim($_GET['preco'])."')";
$sql= $mysql->query($sql);     

  }
if($sql) {
    
    $mensagem ="Usuario "."&nbsp;".@$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['app_memsagem'] ."&nbsp;"." com sucesso" ;
    $mysql->query("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
    salvaLog($mensagem);
    if(!isset($_SESSION['nome_visita'])){
    $_SESSION['nome_visita']=$_POST['nome'];
    $_SESSION['telefone_visita']=$_POST['email'];
      header("Location: app_from.php");
	  
    }
    setcookie('nome', $_SESSION['segure'], (time() + (5 * 60)));

}else{
  $_SESSION["mens_id_estoque"] =$_GET['id'];
  $_SESSION["msm"]="Erro ao enviar mensagem  ";
  $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['app_memsagem'] ."&nbsp;"." com sucesso" ;
//salvaLog($mensagem);
 }
if (isset($_GET['responder'])) { 
  if( @$_SESSION["mens_id_estoque"]==$_GET['resposta']){
   "você já Enviou mensagem";
 
	  }
}} ?>
