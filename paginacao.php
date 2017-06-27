 <div id="caixa_estoque88"> <ul class="navegacao">

    <!-- Coloca os links para a primeira p?gina

e p?gina anterior -->

<?php

     if ($pagina_atual == 1): ?>

    <li class="active">Primeira</li>

    <li class="active">Anterior</li>

    <? else: 

  if(($script ==NULL) or(isset($_GET['ip'])) or (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {

?>

 <li> <a href="<?php echo $link;  ?>&&pagina=1<?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Primeira</a> 

 <? } else { ?>

 <li> <a href="<?php echo $link;  ?>&&pagina=1<?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Primeira </a> </li>

 <? } 

 if(( $script== "?pagina=".$pagina_atual) or ($script!='') or  empty(Url::getURL(1)) or (isset($_GET['lat'])or ($pag_user=TRUE))){ ?>

 <li> <a href="<?php echo $link; ?>&&pagina=<?php print $pagina_atual-1;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> Anterior1 </a> </li>

 <? } else { ?>

 <li> <a href="<?php echo $link; ?>&&pagina=<?php print $pagina_atual-1;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> Anterior 2</a> </li>

 <? } ?>

<?php endif; ?>

<!-- mostra at? cinco p?ginas antes da p?gina atual -->

<?php foreach(array_reverse(range($pagina_atual-1, $pagina_atual-10)) as $pagina): ?>

<?php if ($pagina > 0): 
 
if(($script ==NULL) or  (isset($_GET['lat']))or  (isset($_GET['ip']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {

?>

<li> <a href="<?php echo $link; ?>&&pagina=<?php echo  $pagina; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"><?php echo $pagina; ?></a></li>

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

   
echo $link;
  if(($script ==NULL) or  (isset($_GET['lat']))or(isset($_GET['ip']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {
?>
    <a href=" <?php echo $link; ?>&&pagina=<?php echo  $pagina; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 

      <?php  echo  $pagina; ?><?=$link?></a> 

  <? } else {  ?>
    <a href=" <?php echo $link; ?>&&pagina=<?php echo  $pagina; ?>"> 
     <?php  echo  $pagina; ?> ww</a> <? } ?>
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
  <li><a href=" <?php echo  $link; ?>&&pagina=<?php print $pagina_atual+1; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Proxima</a> </li>

<? } else { ?>
<li><a href=" <?php echo  $link; ?>&&pagina=<?php echo  $pagina_atual+1; ?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>">Proxima</a> </li>

 <? } 
  if(($script ==NULL) or  (isset($_GET['lat']))or ( $script== "?pagina=".$pagina_atual)or ($pag_user=TRUE)) {

?>
 <li> <a href="<?php echo $link; ?>&&pagina=<?php print $paginas;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 

      &Uacute;ltima</a> </li>
  <? }else{ ?>

      <li> <a href="<?php echo $link; ?>&&pagina=<?php print $paginas;?><?php if(isset($ordem1)&&$ordem1="sim"){echo "?".$ordem3;}?>"> 

      &Uacute;ltima</a> </li>

      <? } ?>
 <?php endif; ?>

  </ul></div>



<?php } ?></div>


