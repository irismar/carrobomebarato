<? 
 require_once'Connections/repasses.php';
  require_once'links.php';
 $modulo =trim(Url::getURL( 0 ));
echo 
 '<br>'.'<br>'
.$sql2 = "SELECT  * FROM  membros 	WHERE  url='".trim($modulo)."' LIMIT 1 ";
  $query_cont_menu = $mysql->query($sql2);
  if ($query_cont_menu->num_rows =='1') { 
      while($row_estoque1 =  $query_cont_menu->fetch_assoc()) {
		  
		  
		  
	   $_SESSION['query_cont_menu']=$row_estoque1['url'];
	 } ?>
	
<?	} else {  }
 
 ?>
 