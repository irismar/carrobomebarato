<? $ip='179.181.117.26';
//$ip=get22_client_ip();   
  $sql="INSERT INTO acesso (session_id,ip,cidade,estado,pais,lat,log,cep,condicao) VALUES 
( '".session_id()."','".@$ip."','".@$cidade."','".@$estado."','".@$pais."','".@$_SESSION['lat']."','".@$_SESSION['log']."','".@$cep."','usuario usou php')"  ;
$sql=$mysql->query($sql);
?>
<div class="col-md-8">
    <div class="jumbotron"><p>Você violou uma regra de segurança  contate o suporte para maiores esclarecimentos </p>
<p></p></div></div>