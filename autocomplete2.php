 <?
include "links.php";
include "log.php";

if (isset($_GET["txtnome"])) {
    $busca = ucfirst(trim(removeAcentos($_GET["txtnome"])));
	
	echo $sql = "SELECT  * FROM  veiculos 	WHERE modelo  LIKE '%".trim( $busca)."%'  order by id DESC LIMIT 125 ";
  $query = $mysql->query($sql);
    
    
	
		include'ver_resultado2.php';
       
			 } else {
				 
	 
        // Se a consulta n�o retornar nenhum valor, exibi mensagem para o usu�rio
     ?> 
    </div><? 
}
?>