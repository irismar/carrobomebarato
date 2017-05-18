<?php
$txt = $_POST['txt'];
if(!empty($txt)){
	echo "Você digitou: " . $txt;
}
else{
	echo "Campo está vazio.";
}
?>
