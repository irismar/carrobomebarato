   <?php 
if (strcmp(basename($_SERVER['SCRIPT_NAME']), basename(__FILE__)) === 0){

header("location:/erro.php");

}
   $link = $_SERVER['REQUEST_URI'];
    $ex = explode('/', $link);
$link1 = $ex[count($ex)-2];
$sql2  = "SELECT * FROM fotos WHERE id_estoque = '".$modulo."' ORDER BY Id ASC";
$query_fotos = $mysql->query($sql2);
$totalRows_foto_unica =$query_fotos->num_rows;

$sql2= "SELECT A.acessorios FROM acessorios_carros AS AC 
INNER JOIN acessorios AS A ON (A.id = AC.id_acessorios)
WHERE id_estoque = '".$modulo."'";
$query_acessorios = $mysql->query($sql2);
$totalRows_opcionais =$query_acessorios->num_rows; 
   require_once('log.php');
  

$sql = "select *   FROM estoque 
				
			WHERE  Id_estoque ='".$modulo."' ";
$dados = $mysql->query($sql);

// Imprime o cabeï¿½alho da lista de dados
 
// Imprime uma linha para cada
// registro encontrado no banco de dados


?>


<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">

<head>
<? include("meta.php"); 
   ?>
<script src="Scripts/jquery-1.3.2.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript" src="Scripts/ajaxpost.js"></script>

<script src="Scripts/funcoes.js" type="text/javascript"></script>
<script src="Scripts/ajax.js" type="text/javascript"></script>



 <?
 while($row_estoque = $dados->fetch_assoc()) {
 $dono=$row_estoque['nome_membro'];
  $donourl=$row_estoque['url'];
  $modulo = Url::getURL( 0 );
   $link = $_SERVER['REQUEST_URI'];
    $ex = explode('/', $link);
  $link1 = $ex[count($ex)-2];
 $sql = "SELECT  * FROM  membros 	WHERE  nome= '".$row_estoque['nome_membro']."' LIMIT 1 ";
 $membros = $mysql->query($sql);
 $totalRows_modelos = $membros->num_rows;
	if ($totalRows_modelos != 0) { 
	while ($row_estoque1 = $membros->fetch_assoc()) {  ?><?
    	include'menu_baixo.php';
 } 
  	 } 
  


		 include("maim_ver.php");    ?> </div>
	 
	 
	         <?    $sql = "SELECT Id_estoque ,ano,ano2,foto_carro,marcatexto,modelotexto,preco,km,nome_membro,url vendido FROM  estoque 	WHERE url='".$donourl."' AND  Id_estoque!= '".$modulo."' order by Id_estoque DESC LIMIT 12";
 $estoque = $mysql->query($sql);
$totalRows_modelos = $estoque->num_rows;
	if ($totalRows_modelos > 0) { ?>
           <div class="container">
	 <?  while ($row_estoque3 = $estoque->fetch_assoc()) {   ?>

  <div class="col-sm-5 col-md-5">
    <ol class="breadcrumb"> <div class="thumbnail">
        <a href="/<? echo $row_estoque3['Id_estoque']?>"> <img src="/galeriadefotos/peq/<? if (($row_estoque3['foto_carro'] <> '') and ((file_exists("galeriadefotos/peq/".$row_estoque3['foto_carro'])))) { echo $row_estoque3['foto_carro']; } else { echo "avatar.png"; } ?>" class="img2"   ></a> 
               
      <div class="caption">
     <div class="text-left">
    <li ><i class="fa fa-user fa-1x" aria-hidden="true"><?php echo @$row_estoque3['modelotexto']; ?></i></li>
     <li ><i class="fa fa-money fa-1x" aria-hidden="true"> <? if ($row_estoque3['preco']!=''){ ?>
    <? echo "R$". '&nbsp;'.  @number_format(trim($row_estoque3['preco']), 2, ',', '.');
    ?></a>  <? } else { echo " R$ A  combinar" ; } ?></i></li>
          </div>
        
      
      </div></div></ol>
    
  </div>
          
                   
	   


                
       <?   } ?> </div><?}} ?>  
                
           

</div> </div>
<div id="rodape"> 
  <? include("rodape.php"); ?>
</div></div>
</div></div> 
</body>
</html>







