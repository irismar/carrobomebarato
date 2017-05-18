
<?php 
	require_once("../Connections/repasses.php"); // Retorna o arquivo de configurações do site.
	if (isset($_SESSION['nickname'])) {
		
		echo $sql ="SELECT * FROM chat  WHERE  session_id= '" . $_SESSION['session_id']. "' AND id_estoque= '".$_GET['id']."'";
		 
		
  $query = $mysql->query($sql);
  
		 
		 
		 
		if ($query->num_rows > 0) {
			
			 while($ln = $query->fetch_assoc()) { 
				$nick=strip_tags($ln['nome']);
				$mensagem=htmlspecialchars($ln['mensagem']);
				echo "<p>".$nick.": ".$mensagem."</p>";
			}
		} else {
		
			
		}
	} else {
		require_once("inc/nick.php"); // Retorna o arquivo para definir um nick
	}
?>