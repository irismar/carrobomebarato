<?php require_once('Connections/repasses.php'); 

 require_once('log.php'); 
 

if (isset($_GET['facebook'])){
$sql = "select *   FROM membros WHERE   idfacebook='".$_SESSION['id_facebook']."' LIMIT 1";
		
        $dados = $mysql->query($sql);
       if( $dados->num_rows=="1"){
       $row_membro = $dados->fetch_assoc();
    
    $_SESSION["Status"] = "repasses";
	$_SESSION["usuario"]= $row_membro['nome'];
        $_SESSION["url"]= $row_membro['url'];
	$_SESSION["id"]= $row_membro['id'];
	$_SESSION["alertamanesagem"]= $row_membro['alertamanesagem'];
	$_SESSION["alertavisita"]= $row_membro['alvit'];
	$_SESSION["cidade"]= $row_membro['cidade'];
	$_SESSION["estado"]= $row_membro['estado'];
	$_SESSION["endereco"]= $row_membro['endereco'];
	$_SESSION["email"]= $row_membro['email'];
	$_SESSION["foto"]= $row_membro['foto'];
	$_SESSION["carros"]= $row_membro['carros'];
	$_SESSION["premium"]= $row_membro['premium'];
    $_SESSION["datapremium"]= $row_membro['datapremium'];
	$_SESSION["watapps"]= $row_membro['watapps'];
    $_SESSION["oi"]= $row_membro['oi'];
    $_SESSION["vivo"]= $row_membro['vivo'];
    $_SESSION["tim"]= $row_membro['tim'];
	$_SESSION["fixo"]= $row_membro['fixo'];
	$_SESSION["Status"] = "repasses";
	$mensagem =$row_membro['nome'] ." &nbsp;"."logou Usando comta facebook com sucesso" ;
	 $mysql->query( "UPDATE estoque SET estatus='on-line'  WHERE id_membro = ".$_SESSION['id']."");
	$_SESSION["on_line"]=true;
	salvaLog($mensagem);
	header("Location: ".$row_membro['url']."");
						exit();
	} else{ $mensagem =$row_membro['nome'] ." &nbsp;"."errou a senha" ;
	salvaLog($mensagem);
	
	header("Location: /?erroEmaileousenha");
						exit();
						}////login senha errada
	
	

}


if(@$request=="/goo"){ 
$sql = "select *   FROM membros WHERE   id='".$_SESSION['goo']."' LIMIT 1";
		
    $dados = $mysql->query($sql);
    if( $dados->num_rows=="1"){
    $row_membro = $dados->fetch_assoc();
    $_SESSION["Status"] = "repasses";
    $_SESSION["url"]= $row_membro['url'];
	$_SESSION["usuario"]= $row_membro['nome'];
	$_SESSION["id"]= $row_membro['id'];
	$_SESSION["alertamanesagem"]= $row_membro['alertamanesagem'];
	$_SESSION["alertavisita"]= $row_membro['alvit'];
	$_SESSION["cidade"]= $row_membro['cidade'];
	$_SESSION["estado"]= $row_membro['estado'];
	$_SESSION["endereco"]= $row_membro['endereco'];
	$_SESSION["email"]= $row_membro['email'];
	$_SESSION["foto"]= $row_membro['foto'];
	$_SESSION["carros"]= $row_membro['carros'];
	$_SESSION["premium"]= $row_membro['premium'];
    $_SESSION["datapremium"]= $row_membro['datapremium'];
	$_SESSION["watapps"]= $row_membro['watapps'];
    $_SESSION["oi"]= $row_membro['oi'];
    $_SESSION["vivo"]= $row_membro['vivo'];
    $_SESSION["tim"]= $row_membro['tim'];
	$_SESSION["fixo"]= $row_membro['fixo'];
	$_SESSION["Status"] = "repasses";
	$mensagem =$row_membro['nome'] ." &nbsp;"."logou após atualizações  sucesso" ;
	 $mysql->query( "UPDATE estoque SET estatus='on-line'  WHERE id_membro = ".$_SESSION['id']."");
	 $_SESSION["on_line"]=true;
	salvaLog($mensagem);
	header("Location: ".$row_membro['url']."");
						exit();
	} else{ $mensagem =$row_membro['url'] ." &nbsp;"."errou a senha" ;
	salvaLog($mensagem);
	
	header("Location: /?erroEmaileousenha");
						exit();
						}////login senha errada
	
	

}

$sAcao = @$_GET["acao"];
 if(trim($_SESSION['segure'])==trim($_POST['segure']) ){ 	

if ($sAcao == "login") {
     unset($_SESSION["usuario"]);
	unset($_SESSION["Status"]);
	unset($_SESSION["nome"]);
	unset($_SESSION["id"]);
	unset($_SESSION["email"]);
	unset($_SESSION["senha"]);
	unset($_SESSION["telefone"]);
	unset($_SESSION["foto"]);
	unset($_SESSION["id_user"]);
	unset($_SESSION["telefone"]);
	unset($_SESSION['idparaeditar']);
	setcookie('usuario');
	setcookie('id');
	setcookie('alertamanesagem');
	setcookie('alertavisita');
	setcookie('cidade');
	setcookie('estado');
	setcookie('email');
	setcookie('foto');
	setcookie('carros');
	setcookie('premium');
    setcookie('datapremium');
	setcookie('telefone');
	if(isset($_GET['senha']) AND (isset($_GET['email']) )){
		$nome =segurancastring($_GET['email']);
		$senha =segurancastring($_GET['senha']);
		} else {
		$nome =segurancastring($_POST['email']);
		$senha =segurancastring($_POST['senha']);
		}
		
		echo $sql = "select *   FROM membros WHERE   email='".$nome."' LIMIT 1";
		
        $dados = $mysql->query($sql);
       if( $dados->num_rows=="1"){
       $row_membro = $dados->fetch_assoc();
      if($row_membro['senha']==$senha){

    $_SESSION["Status"] = "repasses";
	$_SESSION["usuario"]= $row_membro['nome'];
        $_SESSION["url"]= $row_membro['url'];
	$_SESSION["id"]= $row_membro['id'];
	$_SESSION["alertamanesagem"]= $row_membro['alertamanesagem'];
	$_SESSION["alertavisita"]= $row_membro['alvit'];
	$_SESSION["cidade"]= $row_membro['cidade'];
	$_SESSION["estado"]= $row_membro['estado'];
	$_SESSION["endereco"]= $row_membro['endereco'];
	$_SESSION["email"]= $row_membro['email'];
	$_SESSION["foto"]= $row_membro['foto'];
	$_SESSION["carros"]= $row_membro['carros'];
	$_SESSION["premium"]= $row_membro['premium'];
    $_SESSION["datapremium"]= $row_membro['datapremium'];
	$_SESSION["watapps"]= $row_membro['watapps'];
    $_SESSION["oi"]= $row_membro['oi'];
    $_SESSION["vivo"]= $row_membro['vivo'];
    $_SESSION["tim"]= $row_membro['tim'];
	$_SESSION["fixo"]= $row_membro['fixo'];
	$_SESSION["Status"] = "repasses";
	$mensagem =$row_membro['nome'] ." &nbsp;"."logou com sucesso" ;
	 $mysql->query( "UPDATE estoque SET estatus='on-line'  WHERE id_membro = ".$_SESSION['id']."");
	 $_SESSION["on_line"]=true;
	
	salvaLog($mensagem);
	header("Location: ".$row_membro['url']."");
						exit();
	} else{ $mensagem =$row_membro['url'] ." &nbsp;"."errou a senha" ;
	salvaLog($mensagem);
	
	header("Location: /?erroEmaileousenha");
						exit();
						}////login senha errada
	
	} else{  $mensagem =$row_membro['nome'] ." &nbsp;"."errou a usuario" ;
	salvaLog($mensagem);
	
	header("Location: /?erroEmaileousenha");
						exit();}////login senha errada
	}else {"E Nojeto"; }
	}


?>