
 <?php
require_once"Connections/repasses.php";

if(isset($_POST['lastmsg']) &&is_numeric($_POST['lastmsg']))
{
echo $lastmsg=$_POST['lastmsg'];
$query="select * from estoque where Id_estoque >'$lastmsg' order by Id_estoque asc limit 1";
$result = mysqli_query($dbc,$query);


while($row_estoque=mysqli_fetch_array($result,MYSQLI_ASSOC))
{ 
@$dist =  distancia($_SESSION['lat'],$_SESSION['log'],$row_estoque['lat'],$row_estoque['lon']);

$id=trim($row_estoque['Id_estoque']);
?>
    <li>
	
	<? $content = file_get_contents('main.php');
$execute = '?>' . $content.'<?';



print($execute);
	?>
    </li>
    


<?php
}


	
if( mysqli_num_rows($result)==1){
   ?> 
    
   

 	   <div id="more">
    <a  id="<?php echo $id; ?>" class="load_more" href="#"><?php
	
?>more</a>  </div>
 




<?php
 }else {
    
    echo '   <div id="more">
    <a  id="end" class="load_more" href="#">No More Posts </a>  </div>';
    
 }
}
?>