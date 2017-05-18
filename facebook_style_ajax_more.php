<?php

include('Connections/repasses.php');

 require "links.php";  
  $request = $_SERVER['REQUEST_URI'];

 require "log.php"; 
 require "meta.php";


if(isset($_POST['lastmsg']) &&is_numeric($_POST['lastmsg']))
{
$lastmsg=$_POST['lastmsg'];
$query="select * from estoque where Id_estoque >'$lastmsg' order by Id_estoque asc limit 1";
$result = mysqli_query($dbc,$query);

?><?
while($row_estoque=mysqli_fetch_array($result,MYSQLI_ASSOC))
{ 
$msg_id=$row_estoque['Id_estoque'];
?>

  <li> <?= $msg_id;?>  </li>
<?
	



 
  ?>



      <? } ?>
 


    
    
   	

<?
	
if( mysqli_num_rows($result)==1){
   ?>
<div class="facebook_style" id="facebook_style"> <a id="<?php echo $message; ?>" href="#" class="load_more" >Show Older Posts <img src="arrow1.png" /></a> </div>
<?php
 }else {
    
    echo '  <div  id="facebook_style">
  <a  id="end" href="#" class="load_more" >No More Posts</a>
  </div>';
    
 }
}
?>
