<? require_once('Connections/repasses.php');

$timestamp = strtotime("-90 days");
// Exibe o resultado
 date('Y-m-d', $timestamp); // 27/03/2009 05:02
echo $post_niver1=date('Y-m-d', $timestamp); 
 
echo $sql2 = "SELECT Id_estoque,data_cadastro FROM estoque WHERE data_cadastro > '$post_niver1' ";
$query2=$mysql->query($sql2);

    echo $contar= $query2->num_rows;
   while($s= $query2->fetch_assoc()) { 
   
    echo 'id'. $id= $s['Id_estoque'];
    echo "</br>";
     echo 'id'. $s['data_cadastro'];
    //$crud = new crud('estoque'); // instancia classe com as operaçoes crud, passando o nome da tabela como parametro
    //$crud->atualizar("exibir='0'", "Id_estoque='$id'"); // utiliza a funçao ATUALIZAR da classe crud 
   //$mysql->query  ("UPDATE estoque SET exibir='0'  WHERE Id_estoque='".$id."'");    
    $mysql->query  ("UPDATE estoque SET exibir='1'  WHERE Id_estoque='".$id."'");    
    }
?>