<?php require_once('log.php');
  $registros =60;
if (isset($_GET['pagina'])) {
	
 $pagina_atual =$_GET['pagina'];
}else { $pagina_atual=1;}

// encontra a quantidade total de
// registros no banco de dados
// agora ordenados por nome do pa?s
$data = date('Y-m-d');


	  $sql2 = "SELECT * FROM estoque where url='".$modulo."'

ORDER BY Id_estoque DESC
";
   	 

 
  $query2 = $mysql->query($sql2);
 $registros_total=$query2->num_rows;

 

 //$resultado = $mysql->query("select count(*) as total  FROM estoque	$busca  ")->fetch_assoc();
// calculo para encontrar o total
// de p?ginas necess?rias para a pagina??o
// calculo para encontrar o total
// de p?ginas necess?rias para a pagina??o
$paginas = ceil($registros_total / $registros);
// Calcula os intervalos iniciais e finais
// para saber quais registros vamos mostrar
$fim = $registros * $pagina_atual;
$inicio = ($fim - $registros);
// Note que no caso do MySQL, n?o precisamos
// saber o limite final, basta utilizar
// o limite inicial com a quantidade m?xima
// de registros retornados por consulta.
// a consulta agora est? ordenada por nome do pa?s


$sql3 = "SELECT * FROM estoque where url='".$modulo."'

ORDER BY Id_estoque DESC
";


 $query3 = $mysql->query($sql3);
 $query3->num_rows;
?>


<div id="wrapper"><div id="columns">

<?php

while($row_estoque = $query3->fetch_assoc()) { 

	?>
	
		<div class="pin">
		  
			
			
	
<?php
$data_inicial =FormataData($row_estoque['data']);
$data_final = date('d.m.Y');
// Cria uma fun??o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun??o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen?a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen?a de dias
@$dias=(int)floor( $diferenca/(60 * 60 * 24)); // 225 dias
 @$dia=trim($dias);
      
if(isset($_SESSION['horizontal'])&&($_SESSION['horizontal']="ok")){
 include'main2.php';
}else{
    include'main.php';
}
   ?>  </div>



      <? } ?>
 </div></div>



<? if (@$registros_total >=$registros){?>
 <div id="caixa_estoque88"> <ul class="navegacao">
    <!-- Coloca os links para a primeira p?gina
e p?gina anterior -->
<?php
     if ($pagina_atual == 1): ?>
    <li class="active">Primeira</li>
    <li class="active">Anterior</li>
    <? else: 
  if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {
?>
 <li> <a href="<?php echo $link;  ?>?pagina=1<?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Primeira</a> 
 <? } else { ?>
 <li> <a href="<?php echo $link;  ?>&&pagina=1<?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Primeira </a> </li>
 <? } 
 if(( $script== "?pagina=".$pagina_atual) or ($script!='') or  empty(Url::getURL(1)) or (isset($_GET['lat'])or ($pag_user=TRUE))){ ?>
 <li> <a href="<?php echo $link; ?>?pagina=<?php print $pagina_atual-1;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> Anterior </a> </li>
 <? } else { ?>
 <li> <a href="<?php echo $link; ?>&&pagina=<?php print $pagina_atual-1;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> Anterior </a> </li>
 <? } ?>
<?php endif; ?>
<!-- mostra at? cinco p?ginas antes da p?gina atual -->
<?php foreach(array_reverse(range($pagina_atual-1, $pagina_atual-10)) as $pagina): ?>
<?php if ($pagina > 0): 
if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {
?>
<li> <a href="<?php echo $link; ?>?pagina=<?php echo  $pagina; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"><?php echo $pagina; ?></a></li>
<? } else { ?>
<li> <a href="<?php echo $link; ?>&&pagina=<?php echo  $pagina; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"><?php echo $pagina; ?></a></li>
<? } ?>
<?php endif; ?>
<?php endforeach; ?>
    <!-- mostra a p?gina atual para o usu?rio -->
    <li class="active"><?php echo  $pagina+1; ?></li><li> 
    <!-- mostra at? cinco p?gina ap?s a p?gina atual -->
    <?php foreach( range($pagina_atual+1, $pagina_atual+4) as $pagina): ?>
    <?php if ($pagina < $paginas): ?>
    <?
    //se $modulo="" 
   
  if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {
 

 ?>


    <a href=" <?php echo $link; ?>?pagina=<?php echo  $pagina; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 
      <?php  echo  $pagina; ?></a> 
  <? } else {  ?>

    <a href=" <?php echo $link; ?>&&pagina=<?php echo  $pagina; ?>"> 
     <?php  echo  $pagina; ?> </a> <? } ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <!-- mostra os links para a pr?xima p?gina
e para a ?ltima p?gina da lista -->
    <?php if ($pagina_atual == $paginas): ?>
    </li><li class="active">Proxima</li>
    <li class="active">Última</li>
    <?php else: 

  if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual) or ($pag_user=TRUE)) {
 ?>

 
  
                 <li><a href=" <?php echo $link; ?>?pagina=<?php print $pagina_atual+1; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Proxima</a> </li>
<? } else { ?>




<li><a href=" <?php echo  $link; ?>&&pagina=<?php echo  $pagina_atual+1; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Proxima</a> </li>
 <? } 



  if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {
?>





    <li> <a href="<?php echo $link; ?>?pagina=<?php print $paginas;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 
      &Uacute;ltima</a> </li>
      
      <? }else{ ?>
      <li> <a href="<?php echo $link; ?>&&pagina=<?php print $paginas;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 
      &Uacute;ltima</a> </li>
      <? } ?>
   
    <?php endif; ?>
  </ul></div>

<?php } ?></div>
</div>
</body>

<script src="Scripts/jquery-1.3.2.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript" src="/Scripts/ajaxpost.js"></script>
<script src="/Scripts/ajax.js" type="text/javascript"></script>

  <div id="rodape"> 
  <?php include("rodape.php");  ?>
</div>