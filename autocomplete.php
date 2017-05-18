<?
include "links.php";
include "log.php";
	
 $_SERVER['HTTP_REFERER'];

 @$ex = explode('/', $_SERVER['HTTP_REFERER']);
     @$link1 = $ex[count($ex)-1];
    @$link2 = $ex[count($ex)-2];
     @$link3 = $ex[count($ex)-1];

  $modulo =trim(Url::getURL( 0 ));
@$sessin_estado= trim(removeAcentos($_SESSION['estado']));
@$sessin_cidade=trim( removeAcentos($_SESSION['cidade']));
  @$lat= number_format($_SESSION['lat'], 6, '.', ' ').'<br>';
 @$log=number_format($_SESSION['log'], 6, '.', ' ').'<br>';
if (isset($_GET["txtnome"])) {
    $busca = trim(removeAcentos($_GET["txtnome"]));
	
	$sql2 = "SELECT  id FROM  membros 	WHERE  url='".trim($link1)."' LIMIT 1 ";
  $query2 = $mysql->query($sql2);
   $query2->num_rows;
  if ($query2->num_rows =='1') { 
  
   $userbusca="WHERE url='".$link1."' " ;
   
   
  $sql = "SELECT * FROM estoque $userbusca 
ORDER BY Id_estoque ASC
LIMIT 40";
	
	
	}else{ 
	
	
	
	$userbusca="WHERE modelotexto LIKE" ."'%".$busca."%'"." or marcatexto LIKE" ."'%".$busca."%'"." or url LIKE" ."'%".$busca."%' AND exibir='1'";
	
	  $sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque $userbusca  
HAVING distancia < ".$_SESSION['km']."
ORDER BY distancia ASC
LIMIT 40";
	
	}
	
   
    if (empty($busca)) {
        
    } else {
        $busca = "AND exibir='1'";
	
	

    }
     $query = $mysql->query($sql);
    
	if ($query->num_rows   > 0) {
		include'ver_resultado.php';
       
			 } else {
				 
	////////////////////////////////////////buscar mais longe////se não encontrar no raio////////////////////////////			 
	$userbusca="WHERE modelotexto LIKE" ."'%".$busca."%'"." or marcatexto LIKE" ."'%".$busca."%'"." or url LIKE" ."'%".$busca."%' and exibir='1'";
	
	
//////////////////
 $sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < ".$_SESSION['km']."
";

	  $query = $mysql->query($sql);
    
	if ($query->num_rows   > 0) {
		include'ver_resultado.php';
       
			 }
	
	//////////////////////////

	//////////////////
 $sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 50
";
$query = $mysql->query($sql);

	if ($query->num_rows   > 0) {
		 $_SESSION['km']="50";
		include'ver_resultado.php';
       
			 }
	//////////////////////////
	
	//////////////////
$sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque Where exibir='1'
HAVING distancia < 100
";
$query = $mysql->query($sql);

	if ($query->num_rows   > 0) {
		 $_SESSION['km']="100";
		include'ver_resultado.php';
       
			 }
	//////////////////////////
	//////////////////
$sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque Where exibir='1'
HAVING distancia < 500
";
$query = $mysql->query($sql);

	if ($query->num_rows   > 0) {
		 $_SESSION['km']="500";
		include'ver_resultado.php';
       
			 }
	////////////////////////////////////////////
$sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque Where exibir='1'
HAVING distancia < 1000
";
$query = $mysql->query($sql);

	if ($query->num_rows   > 0) {
		 $_SESSION['km']="100";
		include'ver_resultado.php';
       
			 }	//////////////////////////	
		 
$sql = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque Where exibir='1'
HAVING distancia < 10000
";
$query = $mysql->query($sql);

	if ($query->num_rows   > 0) {
		 $_SESSION['km']="1000";
		include'ver_resultado.php';
       
			 }					 
				 
        // Se a consulta n�o retornar nenhum valor, exibi mensagem para o usu�rio
     ?> <?   echo "Não foram encontrados registros!";  
    }?></div><? 
}
?>