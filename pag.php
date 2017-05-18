<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>An Alternative to pagination : Twitter Style</title>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">
$(function() {//When the Dom is ready

$('.load_more').live("click",function() {//If user clicks on hyperlink with class name = load_more
var last_msg_id = $(this).attr("id");
//Get the id of this hyperlink 
//this id indicate the row id in the database 
if(last_msg_id!='end'){
    //if  the hyperlink id is not equal to "end"
$.ajax({//Make the Ajax Request
type: "POST",
url: "twitter_style_pagination_ajax_more.php",
data: "lastmsg="+ last_msg_id, 
beforeSend:  function() {
$('a.load_more').html('<img src="loading.gif" />');//Loading image during the Ajax Request
  
},
success: function(html){//html = the server response html code
    $("#more").remove();//Remove the div with id=more 
$("ol#updates").append(html);//Append the html returned by the server .

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
.load_more {
	background-color:#FFFFFF;
	background-image:url("more.gif");
	background-position:left top;
	background-repeat:repeat-x;
	border-color:#DDDDDD #AAAAAA #AAAAAA #DDDDDD;
	border-style:solid;
	border-width:1px;
	display:block;
	font-size:14px;
	font-weight:bold;
	height:22px;
	line-height:1.5em;
	margin-bottom:6px;
	outline:medium none;
	padding:6px 0;
	text-align:center;
	text-shadow:1px 1px 1px #FFFFFF;
	width:100%;
}
.load_more {
	-moz-border-radius:5px 5px 5px 5px;
}
.load_more:hover {
	background-position:left -78px;
	border:1px solid #BBBBBB;
	text-decoration:none;
}
.load_more:active {
	background-position:left -38px;
	color:#666666;
}
img {
	border : none;
}
</style>
</head>
<body>
<div id='container'>
  <ol class="row" id="updates">
  <div class="container marketing">
<section id="blog-landing">





    <?php
$query ="select * from estoque ORDER BY Id_estoque ASC LIMIT 1";
$result = mysqli_query($dbc,$query);
while($row_estoque=mysqli_fetch_array($result,MYSQLI_ASSOC))
{
@$dist =  distancia($_SESSION['lat'],$_SESSION['log'],$row_estoque['lat'],$row_estoque['lon']);
	
$id=trim($row_estoque['Id_estoque']);
?>
    <li>  <img src="/galeriadefotos/grd/<? if (($row_estoque['foto_carro'] <> '') and ((file_exists("galeriadefotos/grd/".$row_estoque['foto_carro'])))) { echo $row_estoque['foto_carro']; } else { echo "semimagem.png"; } ?>"></a>
		</li>
    <?php } ?>
  </ol>
  <div id="more" style="margin-top: 20px;"> <a  id="<?php echo $id; ?>" class="load_more" href="#">more</a> </div>
</div>
 </section> </div> 
</body>
</html>
