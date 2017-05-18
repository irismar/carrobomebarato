
<?php require_once('Connections/repasses.php'); ?>
<?php
if(isset( $_GET['id_regiao'])){
$busca=trim($_GET['id_regiao']);
$buscae=$_GET['id_regiao'];
$busca= tirarAcentos1($_GET['id_regiao']);
$sql = "SELECT nome  FROM membros  	WHERE  nome = '".$buscae."' ORDER BY id DESC";
$query = $mysql->query($sql);
	if ($query->num_rows == 0) { ?>
	  <a href="#">
<?php echo "seu endereço na Internet"  ?><h1><? echo "www.carrobomebarato.com/".$busca;?></h1>
<h1>bem vindo ao seu site <? echo "www.carrobomebarato.com/".$busca;?></h1>
<?php 
 }else{ ?>
 
 	<?   while ($row_estoque = $query->fetch_assoc()) {  ?>  
       <a href="#"><h1><img src="/images/seta.gif"> <?php echo $row_estoque['nome'] ."&nbsp;&nbsp;"."já existe tente outro nome";?> </h1>

  <script type="text/javascript">
    alert("The email address <?php echo $_POST['email']; ?> is already registered.");
    history.back();
  </script>
<?php
$_SESSION['usuario_erro']="ok";
 exit(); }}} else{ ?> <a href="#"><p><img src="/images/seta.gif"><?php echo $busca."&nbsp;&nbsp;" ."Digite um nome"; ?></p> <?
}  ?>

