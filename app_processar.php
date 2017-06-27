<? 
 require_once'Connections/repasses.php'; 
 require_once('log.php');
if(isset($_GET['app_memsagem'])&& (empty($_POST['submit'])) ) { 
 @$sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,email,data,foto,endereco,cod_seguranca) VALUES ('".$_GET['app_memsagem']."', '".@$_POST['nome']."','".$_POST['memsagem']."','".$_GET['id']."','".$_POST['email']."','".$hora."','".@trim($_GET['foto'])."','".$_SESSION['endereco1']."','".$_SESSION['segure']."')";
    $sql= $mysql->query($sql);  
	
  if($sql) {
  	
    $mensagem ="Usuario "."&nbsp;".@$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['memsagem'] ."&nbsp;"." com sucesso" ;
    $mysql->query("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
	  salvaLog($mensagem); 
           ?>
         <script language= "JavaScript">
location.href="<?=$_SERVER['HTTP_REFERER']?>"
</script><?
	exit();
	   
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
}} ?>
