<?php

include_once"log.php";

 $mensagem =$_SESSION["usuario"].'&nbsp;' . "saiu com sucesso" ;
 	salvaLog($mensagem);
        
	 $mysql->query( "UPDATE estoque SET estatus='of-line'  WHERE id_membro = ".$_SESSION['id']."");
	
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
	unset($_SESSION['segure']);
	session_destroy();
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
	setcookie("latitude");
	
	ob_end_clean();
	@session_destroy();
	 ?>

  
  <script language= "JavaScript">
location.href="/"
</script>
<?  
	
exit(); 
?>