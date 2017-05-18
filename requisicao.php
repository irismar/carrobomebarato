<?php

$acao = $_POST['acc'];

switch($acao){
	
	case 'Editar':
		echo 'A ação selecionada é editar';
	break;
	
	case 'Novo':
		echo 'A ação solicitada é criar';	
	break;
	
	case 'Exibir':
		echo 'A ação solicitada é exibir';	
	break;
	
	case 'Deletar':
		echo 'A ação solicitada é deletar';
	break;
	
}
?>
