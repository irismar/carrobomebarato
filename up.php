<? require_once('Connections/repasses.php');

$timestamp = strtotime("-90 days");
// Exibe o resultado
 date('Y-m-d', $timestamp); // 27/03/2009 05:02
echo $post_niver1=date('Y-m-d', $timestamp); 
 echo "</br>";
echo $post_niver2=date('Y-m-d');
echo "</br>";
$sql2 = "SELECT Id_estoque FROM estoque WHERE data < '$post_niver1' ";
$query2=$mysql->query($sql2);
   while($s= $query2->fetch_assoc()) { 
   
    echo 'id'. $id= $s['Id_estoque'];
    echo "</br>";
    //$crud = new crud('estoque'); // instancia classe com as operaçoes crud, passando o nome da tabela como parametro
    //$crud->atualizar("exibir='0'", "Id_estoque='$id'"); // utiliza a funçao ATUALIZAR da classe crud 
   $mysql->query  ("UPDATE estoque SET exibir='0'  WHERE Id_estoque='".$id."'");    
    //$mysql->query  ("UPDATE estoque SET exibir='1'  WHERE Id_estoque='".$id."'");    
    }
?>