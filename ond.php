

<body>
<div id="container">
<div id="form">
 
<?php
$conect= new mysqli('localhost','root','', 'u386698969_carro');

 
//Transferir o arquivo
if (isset($_POST['submit'])) {
 
    if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
         "<h1>" . "File ". $_FILES['filename']['name'] ." transferido com sucesso ." . "</h1>";
        "<h2>Exibindo o conteúdo:</h2>";
        //readfile($_FILES['filename']['tmp_name']);
    }
 
    //Importar o arquivo transferido para o banco de dados
    $handle = fopen($_FILES['filename']['tmp_name'], "r");
 $i = 1;
while( $i <= 10 ){

    while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
     
        $sql= "INSERT geolitecity-blocks (startIpNum,endIpNum,locId)values('".$data[0]."','".$data[1]."','".$data[2]."')";
       $sql=$conect->query($sql);
     
    }
 
    fclose($handle);
 
    print "Importação feita.";
 
//Visualizar formulário de transferência
}} else {
 
    print "Transferir novos arquivos CSV selecionando o arquivo e clicando no botão Upload<br />\n";
 
    print "<form enctype='multipart/form-data' action='#' method='post'>";
 
    print "Nome do arquivo para importar:<br />\n";
 
    print "<input size='50' type='file' name='filename'><br />\n";
 
    print "<input type='submit' name='submit' value='Upload'></form>";
 
}
 
?>
 
</div>
</div>
</body><?
if (IsLoggedIn())

  {
?><div class="container">
              
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="panel panel-success">
                        <div class="panel-heading">
                          Relação De Usuarios                         </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>   
                                            <th>Nome da Loja</th>
                                            
                                            <th>Endereco</th>
                                            <th>Cidade</th>
                                            <th>Estado</th>
                                             <th>Carros Anunciados</th>
                                            <th>Carros Vendidos</th>
                                            <th>Carros Anunciados</th>
                                             <th>Editar Dados Clik sobre o iten que deseja editar </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                   <?
                $sql2 = "SELECT  * FROM  membros 	 ";
  $query2 = $mysql->query($sql2);

 
  
  while($campo= $query2->fetch_assoc()) {  ?>   <tr>
                    <? 
                                             ?>
                                                                               
                                           
                                            <td><?php echo $campo['nome']; // mostrando o campo NOME da tabela ?></td>
                                            
                                            <td><?php echo $campo['endereco']; // mostrando o campo NOME da tabela ?></td>
                                            <td><?php echo $campo['cidade']; // mostrando o campo NOME da tabela ?></td>
                                             <td><?php echo $campo['estado']; // mostrando o campo NOME da tabela ?></td>
                                            <td><?php echo $campo['carros']; // mostrando o campo NOME da tabela ?></td>
                                            <td><?php  echo $campo['carros_total']; // mostrando o campo NOME da tabela ?></td>
                                            <td><?php echo $campo['carros_vendido']; // mostrando o campo NOME da tabela ?></td>
                                            <td><button class="btn btn-primary  btn-xs"><i class="fa fa-edit "></i> <a href="editar_livro.php?id=<?=$campo['id'];?>">Confirma Pagamento</a></button>
                                            <button class="btn btn-danger  btn-xs"><i class="fa fa-pencil "></i><a href="excluir_livro.php?excluir_livro=<?=$campo['id'];?>&&titulo=<?=$campo['titulo'];?>"> Excluir</a></button>
                                            </td>
                                           
                                            
                                               
                                              
                    <? 
                      }?>                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
             </div>
              
             </div><?
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  }
