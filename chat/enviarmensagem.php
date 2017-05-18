<?php 
	require_once("inc/config.php"); // Retorna o arquivo de configurações do site.
	if (isset($_SESSION['nickname'])) {
		$nick=strip_tags($_SESSION['nickname']);
		$mensagem=htmlspecialchars($_POST['mensagem']);
		$ip=$_SERVER['REMOTE_ADDR'];
        $DataHoje =  date("Y-m-d H:i:s");
		if ($mensagem == "/sair") {
			session_destroy();
			echo $nick." saiu.";
			header("Location: ./");
		} else {
		echo	$sql=mysql_query("INSERT INTO chat (nome,mensagem,ip,datahora,session_id,id_estoque) VALUES ('$nick','$mensagem','$ip', '$DataHoje','".$_SESSION['session_id']."','".$_GET['id']."') ")or die(mysql_error());
		}

	} else {
		require_once("inc/nick.php"); // Retorna o arquivo para definir um nick
	}
?>