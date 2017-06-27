<?php
	mysql_connect('localhost', 'root', '') or die('Erro ao conectar com o servidor');
	mysql_select_db('paginador') or die ('Erro ao selecionar o banco de dados');
   	$tipo=$_GET['tipo'];
   	if($tipo=='listagem'){
   		$pag=$_GET['pag'];
   		$maximo=$_GET['maximo'];
		$inicio = ($pag * $maximo) - $maximo; //Variável para LIMIT da sql
		?>
		<tr>
			<td>ID</td>
			<td>Nome</td>
			<td>E-mail</td>
		</tr>
		<?php
   		$sql="SELECT * FROM itens ORDER BY id LIMIT $inicio, $maximo"; //consulta no BD
				$resultados = mysql_query($sql) //Executando consulta
				or die (mysql_error()); //Se ocorrer erro mostre-o
				if (@mysql_num_rows($resultados) == 0) //Se não retornar nada
				echo("Nenhum cadastro encontrado");
				while ($res=mysql_fetch_array($resultados)) { //laço para listagem de itens
				$id = $res[0];
				$nome = $res[1];
				$email = $res[2];	
			?>
			<tr>
				<td><?php echo $id ?></td>
				<td><?php echo $nome ?></td>
				<td><?php echo $email?></td>
			</tr>
			<?php } 
   	}else if($tipo=='contador'){
   		$sql_res=mysql_query("SELECT * FROM itens"); //consulta no banco
		$contador=mysql_num_rows($sql_res); //Pegando Quantidade de itens
		echo $contador;
   	}else{
   		echo "Solicitação inválida";
   	}
?>