<? include "Connections/repasses.php";

?>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/>
<?    $sql2  = " SELECT id, alvit FROM membros WHERE  id='" .trim($_GET['id']). "' ORDER BY id  ASC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);



if (  $query2->num_rows != 0) {

  while ($query_cont= $query2->fetch_assoc()){
      
      echo $query_cont['alvit'];
      
  }
  }   ?>