<?php
include('conect.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>An Alternative to pagination : Facebook Style</title>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(function() {



$('.load_more').live("click",function() {


var last_msg_id = $(this).attr("id");



if(last_msg_id!='end'){
    
  $.ajax({
type: "POST",
url: "facebook_style_ajax_more.php",
data: "lastmsg="+ last_msg_id, 
beforeSend:  function() {
$('a.load_more').append('<img src="facebook_style_loader.gif" />');
  
},
success: function(html){
    $(".facebook_style").remove();
$("ol#updates").append(html);


}
});
  
}


 
 
 



return false;


});
});

</script>
<style>
body {
	font-family:Arial, 'Helvetica', sans-serif;
	color:#000;
	font-size:15px;
}


a {
color:#2276BB;
text-decoration:none;
}

* {
	margin:0px;
	padding:0px
}
ol.row {
	list-style:none
}
ol.row li {
	position:relative;
	border-bottom:1px solid #EEEEEE;
	padding:8px;
}
ol.row li:hover {
	background-color:#F7F7F7;
}
ol.row li:first-child {
}
#container {
	margin-left:60px;
	width:580px
}

 img {
border : none ;
}





#facebook_style  {
border:1px solid #D8DFEA;
padding:10px 15px;
background-color:#EDEFF4;
}


#facebook_style a {
color:#3B5998;
cursor:pointer;
text-decoration:none;
font-family:"lucida grande",tahoma,verdana,arial,sans-serif;
font-size:11px;
text-align:left;
}




</style>
</head>
<body>
<div id='container'>
  <ol class="row" id="updates">
    <?php
$query ="select * from estoque ORDER BY Id_estoque ASC LIMIT 1";
$result = mysqli_query($dbc,$query);
while($row_estoque=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
$msg_id=$row_estoque['Id_estoque'];

?>
    <li> 
	 <img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>
		
    
    
     </li>
    <?php } ?>
  </ol>

  
  
  <div class="facebook_style" id="facebook_style">
  <a id="<?php echo $msg_id; ?>" href="#" class="load_more" >Show Older Posts <img src="arrow1.png" /> </a>
  </div>
</div>
</body>
</html>
