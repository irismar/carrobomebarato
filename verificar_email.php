<?php require_once('Connections/repasses.php'); ?>
<?php
if(isset( $_GET['id_regiao'])){
 $busca= $_GET['id_regiao'];
 
 
// usamos a função isMail passando a variável $email
if (validaEmail($busca)){
 
} else {
    echo "E-mail inválido. Digite E-mail valido nomeusuario@dominio.com";
	exit();
}
 
$sql = "SELECT * FROM membros WHERE email = '{$busca}'"; //monto a query


  $query = $mysql->query( $sql ); //executo a query

  if( $query->num_rows > 0 ) {//se retornar algum resultado
    echo 'Já existe um usuario cadastrado com esse email !';
  } 
}  ?>

