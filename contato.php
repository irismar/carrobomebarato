<style>
@media (min-width: 960px){
#blog-landing {
  margin-top: 430px !important;}}
@media screen and (min-width:50px) and (max-width: 589px) {
#blog-landing {  margin-top: 0%!important;}
@media screen and (min-width:590px) and (max-width:959px) {
#blog-landing {  margin-top: 500px!important;}
</style> <?
include "links.php";
include "log.php";
@$sessin_estado= trim(removeAcentos($_SESSION['estado']));
@$sessin_cidade=trim( removeAcentos($_SESSION['cidade']));
if (isset($_GET["txtnome"])) {
    $busca = trim(removeAcentos($_GET["txtnome"]));
   
    if (empty($busca)) {
        $sql = "SELECT estado,modelotexto,preco,cidade,ano,marcatexto,foto_carro,nome_membro FROM estoque";
    } else {
        $busca .= "%";
		
		
       
$sql = "SELECT
 * FROM estoque
				
			WHERE estado  LIKE '%".$sessin_estado."%' 
			  or modelotexto LIKE '%".$busca."%'
			  or  marcatexto LIKE '%".$busca."%'
			  or nome_membro LIKE '%".$busca."%'
			   or ano LIKE '%".$busca."%'
			     or cidade LIKE '%".$busca."%'
				 or estado LIKE '%".$busca."%'
				  
				  or preco  LIKE '%".$busca."%'
			
			
			 ORDER BY preco  ASC LIMIT 12";
    }
     $query = $mysql->query($sql);
    
	if ($query->num_rows   > 0) { 
    // Verifica se a consulta retornou linhas 

        // Atribui o c�digo HTML para montar uma tabela
     
     ?><?   // Captura os dados da consulta e inseri na tabela HTML
        
             while($linha = $query->fetch_assoc()) {  
             	 $modelo = explode(" ",$linha["marcatexto"]);
		     $co=explode("co",$modelo[0]); 
	 $co[0];
    $modelo[0]; 
     $linha["modelotexto"]; $modelo1 = explode(" ",$linha["modelotexto"]); 
     $estado=acento($linha["estado"]);
     $estado= trim(removeAcentos($estado));
     $cidade=acento($linha["cidade"]);
     $cidade= trim(removeAcentos($estado));
    
    

      ?>
<a href="#"> <ul> 
<? if(isset ($linha["foto_carro"])){  ?>

<a href="<? echo  $modelo1[0] ."?e=".$estado; ?>"><img src="/galeriadefotos/peq/<? echo  $linha["foto_carro"] ?>"   /></a>
<? } else{ ?>

<a href="<? echo  $modelo1[0] ."?e=".$estado; ?>"><img src="/galeriadefotos/peq/semfoto.jpg"   /></a>
 <? } ?>
<div id="caixa_estoque6">
  

 <p><a href="/<? echo  $linha["Id_estoque"];?>">  <? echo  $linha["marcatexto"];?>  <?  $linha["modelotexto"]; $modelo1 = explode(" ",$linha["modelotexto"]); echo  $modelo1[0]; ?></p></a>
  
			 <p><a href="/<? echo  $linha["Id_estoque"];?>"> R$<? echo  @number_format(trim($linha["preco"]), 2, ',', '.'); ?></a></p>
			
			 <p><a href="/<? echo  $linha["nome_membro"];?>">  <? echo  $linha["nome_membro"];?></a> </p>
			  <p><a href="?e=<? echo  $linha["estado"];?>">  <? echo  $linha["nome_membro"];?></a> </p>			
		      <p><a href="?e=<? echo  $linha["estado"];?>">  <? echo  $linha["cidade"];?></a> </p>   
           </div> </ul> </a>
            
     <?    }  
       
    } else {
        // Se a consulta n�o retornar nenhum valor, exibi mensagem para o usu�rio
     ?> <ul><?   echo "Não foram encontrados registros!"; ?> </ul><?
    }
}
?>