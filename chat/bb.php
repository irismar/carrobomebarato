<!DOCTYPE html>
 <html>
 <head>
    <title></title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     
        <script type="text/javascript">
        function atualizarTarefas() {
           // aqui voce passa o id do usuario
           var url="vermensagens.php?id=<?=trim($_GET['id_estoque'])?>";
		   
            jQuery("#tarefas").load(url);
        }
		 function enviarmensagens() {
           // aqui voce passa o id do usuario
           var url="enviarmenesagenes.php?id=<?=trim($_GET['id_estoque'])?>";
		   
            jQuery("#tarefas").load(url);
        }
        setInterval("atualizarTarefas()", 1000);
        </script>   
 </head>
 <body>
INFORMACAO EH EXIBIDA AQUI: <div id="tarefas"></div> 
 </body>
 </html><?php 
	require_once("inc/config.php"); // Retorna o arquivo de configurações do site.
	if (isset($_SESSION['nickname'])) {
		$nick = $_SESSION['nickname'];
		$_SESSION['session_id']=time();
		
		require_once("inc/chat.php"); // Retorna o arquivo do chat
	} else {
		require_once("inc/nick.php"); // Retorna o arquivo para definir um nick
	}
?>