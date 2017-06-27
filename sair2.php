<?php



 $mensagem =@$_SESSION["usuario"].'&nbsp;' . "saiu com sucesso" ;
 	salvaLog($mensagem);
        
	ob_end_clean();
	session_destroy();
        unset($_COOKIE['endereco1']);
        unset($_COOKIE['rua']);
        unset($_COOKIE['cidade']);
        unset($_COOKIE['estado']);
        unset($_COOKIE['pais']);
        unset($_COOKIE['cep']);
        unset($_COOKIE['lat']);
        unset($_COOKIE['log']); 
	 ?>  <script language= "JavaScript">
location.href="/";

</script>

