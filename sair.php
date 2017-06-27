<?php

session_start();
include_once'Connections/repasses.php';
 $mensagem =@$_SESSION["usuario"].'&nbsp;' . "saiu com sucesso" ;
 	salvaLog($mensagem);
        session_destroy();
	 ?>  <script language= "JavaScript">
location.href="/";

</script>
