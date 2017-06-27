
<? include "Connections/repasses.php";

?>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/>
<?   $sql2  = " SELECT id FROM propostas WHERE  id_membro='" .trim($_GET['id']). "' AND alerta='1' ORDER BY id  ASC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);

echo $totalRows_propostas = $query2->num_rows;

if ( $totalRows_propostas != 0) {  ?>

  
 <? }   ?>