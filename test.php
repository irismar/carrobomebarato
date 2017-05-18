
<?php require_once('Connections/repasses.php'); 

$i = 1;
while( $i <= 10 ){
 


 $sql2 = "SELECT  * FROM  estoque	WHERE  Id_estoque='1'	 ";
  $query2 = $mysql->query($sql2);
   $query2->num_rows;
  while($row_estoque1 = $query2->fetch_assoc()) { 
  $sql= "INSERT INTO estoque (foto_carro,contato,taxa,entrada,endereco,id_membro,foto_membro,nome_membro, data, data_cadastro, categoria,marcatexto,modelotexto,  ano, ano2, cor, preco, condicoes, km, cidade,estado, portas, combustivel, transmissao, descricao, id_plano,lat,lon ,watapps,oi,vivo,claro,tim,fixo,email,video,idfacebook,url)
  VALUES ( '".$row_estoque1['foto_carro']."','". $row_estoque1['contato']."', '".$row_estoque1['taxa']."','".$row_estoque1['entrada']."','".$row_estoque1['endereco']."',                     
					   '".$row_estoque1['id_membro']."',
					   '".$row_estoque1['foto_membro']."',
					   '". $row_estoque1['nome_membro']."',
					   '".$hora."',
					   '".$hora."',				   
                               '3',
					   '".$row_estoque1['marcatexto']."',
					   '".$row_estoque1['modelotexto']."',
					  
                        '".$row_estoque1['ano1']."',
					   '".$row_estoque1['ano2']."',
                                           '".$row_estoque1['cor']."',
                                           '".$row_estoque1['preco'] ."',
					   '".$row_estoque1['condicoes']."',
					   '".$row_estoque1['km']."',
					   '".$row_estoque1['cidade']."',
					   '".$row_estoque1['estado']."',
					   '".$row_estoque1['portas']."',
					   '".$row_estoque1['combustivel']."',
					   '".$row_estoque1['transmissao']."',
                                           '".$row_estoque1['descricao']."',
					   '".$row_estoque1['plano']."',
					   '".$row_estoque1['watapps']."',
					   '".$row_estoque1['lat']."',
					   '".$row_estoque1['lon']."',
					   '".$row_estoque1['oi']."',
					   '".$row_estoque1['vivo']."',
					   '".$row_estoque1['claro']."',
					   '".$row_estoque1['tim']."',
					    '".$row_estoque1['fixo']."',
					   '".$row_estoque1['email']."',
					     '".trim($row_estoque1['video'])."',
						 '".trim($row_estoque1['id_facebook'])."',
						   '".$row_estoque1['url']."')"; 
   $sql= $mysql->query($sql); 		
	
  }
  echo $i.'<br>';
   }

 ?>


  
  