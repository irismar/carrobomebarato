<?php require_once('Connections/repasses.php');

 


function calculardias($data) {
          $data_inicial =FormataData($data);
$data_final = date('d.m.Y');
// Cria uma fun��o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun��o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen�a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen�a de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
// Exibe uma mensagem de resultado:


if($dias == 0) {return "Hoje";}
	if($dias == 1) {return "Ontem";}
   


	if($dias < 7 ) {
		return $dias . " dias ";
	}
	else {
		if($dias < 30) {
			return round($dias / 7) . " semana(s) ";
		}
		else {
			if($dias < 365) {
				return round($dias / 30) . " mês(es) ";
			}
			else {
				return round($dias / 365) . " ano(s) ";
			}
		}
	}

}
function calculardiasvenda($data,$datavenda) {
          $data_inicial =FormataData($data);
$data_final =FormataData($datavenda);
// Cria uma fun��o que retorna o timestamp de uma data no formato DD/MM/AAAA
// Usa a fun��o criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
// Calcula a diferen�a de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos
// Calcula a diferen�a de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
// Exibe uma mensagem de resultado:

 return $dias ;
}
function deletarmensagem_eurementente($delet,$usuario,$id_usuario){

       $deletar = "DELETE FROM propostas WHERE id = ".$delet." AND remetene='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error());
       }
function deletarmensagem_eudestinatario($delet,$usuario,$id_usuario){

       $deletar = "DELETE FROM propostas WHERE id = ".$delet." AND Destinatario='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error());
       }	   
	   function deletartodasmensagem($delet,$usuario,$id_usuario){
       $deletar = "DELETE FROM propostas WHERE id_estoque = ".$delet." AND Destinatario='".$usuario."' OR   remetene='".$usuario."' ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());
	   $view = "UPDATE membros SET alertamanesagem=0  WHERE id = ".$id_usuario."";
        $executa = mysql_query($view) or die(mysql_error()); }	
	   function deletartodasvisitas($delet){
       $deletar = "DELETE FROM acessos WHERE id_estoque = ".$delet." ";
	   $Result1 = mysql_query($deletar) or die(mysql_error());}	
function maisdias($vendido){ 
 $data = date('Y-m-d');
 $view = "UPDATE estoque SET data_cadastro='".$data."'  WHERE Id_estoque = ".$vendido."";
 $executa = mysql_query($view) or die(mysql_error());
	
  } 
function gostei($busca){ 
$atualizar=$mysql->query("UPDATE estoque SET gostei= gostei+1 WHERE  Id_estoque=". $busca."");
	  } 
	  function naogostei($busca){ 
$mysql->query("UPDATE estoque SET naogostei = naogostei+1 WHERE  Id_estoque=". $busca."");
	  } //grama a função vendido//	      
function vendido($vendido,$quem){
$data = date('Y-m-d');
       $mysql->query=( "UPDATE estoque SET  vendido='SIM',datavenda='".$data."'  WHERE Id_estoque = ".$vendido." ");
       $mysql->query=( "UPDATE membros SET carros= -1 WHERE id = ".$quem."");
       
}
function faleconosco($nome,$email,$mensagem,$setor){
  $data=date('Y-m-d');
$updateSQL = "INSERT INTO faleconosco(nome,email,mensagem,setor,hora )
		VALUES ('".$nome."','".$email."','".$mensagem."','".$setor."','".$hora."')";
		 $Result2 = mysql_query($updateSQL) or die(mysql_error());
		
if($updateSQL) {
    echo "Mensagem enviada com sucesso ";
    $mensagem =$_POST['nome'] ."Enviou mensagem para administrador com sucesso" ;
	@salvaLog($mensagem);
    header("Location: enviar.php?prok");
	exit();				

	 }
}
function selecionar ($tabela,$ordem){
     $query_login =   "SELECT *  FROM  '".$tabela."'	 ORDER BY '".$ordem."' DESC";
	 $login = mysql_query($query_login) or die(mysql_error());
	 $row_selecionar = mysql_fetch_assoc($login);
	 $totalRows_login = mysql_num_rows($login);}
	 
	 
function verificar($tabele, $linha,$criterio1,$criterio2,$criterio3){
$sql = "SELECT ".$linha." FROM ".$tabele."	WHERE   modelotexto LIKE '%".$modulo."%'	AND estado= '".$_SESSION['estado']."' AND cidade='".$_SESSION['cidade']."' ORDER BY Id_estoque DESC LIMIT 999";
  $query = $mysql->query($sql);
  $query->num_rows;
	if ($query->num_rows  != '0') { 
	$_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". " AND estado="."'".$_SESSION['estado']."'". " AND cidade="."'".$_SESSION['cidade']."'"; 
	require_once"membro.php";	exit(); }
}	 
 
function segurancastring($s) {

$s = addslashes($s);

$s = htmlspecialchars($s);

$s = mysql_escape_string($s);

$s = str_ireplace("SELECT","",$s);



$s = str_ireplace("FROM","",$s);

$s = str_ireplace("WHERE","",$s);

$s = str_ireplace("INSERT","",$s);

$s = str_ireplace("UPDATE","",$s);

$s = str_ireplace("DELETE","",$s);

$s = str_ireplace("DROP","",$s);

$s = str_ireplace("*","",$s);

$s = str_ireplace("&","",$s);

$s = str_ireplace("=","",$s);

$s = str_ireplace("DATABASE","",$s);

$s = str_ireplace("USE","",$s);

return $s;}
function data22($data,$formato=12){
    $hora = $formato == 12 ? "h" : "H";
    $am_pm = (date("H",strtotime($data)) < 12) ? " AM" : " PM";
    $am_pm = $formato == 24 ? "" : $am_pm;
    if(date('d/m/Y', strtotime($data)) == date('d/m/Y')){
        return "Hoje às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else if(date('m/Y', strtotime($data)) == date('m/Y') && date("d", strtotime($data)) == date("d")-1){
        return "Ontem às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else if(date('m/Y', strtotime($data)) == date('m/Y') && date("d", strtotime($data)) == date("d")+1){
        return "Amanha às ".date("$hora:i",strtotime($data)).$am_pm;
    }
    else{ 
        return date("d/m/Y",strtotime($data))." "."  ás  ".date("$hora:i",strtotime($data)).$am_pm;
    }
}
function get_client_ip() {

     $ipaddress = '';

     if ($_SERVER['HTTP_CLIENT_IP'])

         $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

     else if(@$_SERVER['HTTP_X_FORWARDED_FOR'])

         $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

     else if(@$_SERVER['HTTP_X_FORWARDED'])

         $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

     else if(@$_SERVER['HTTP_FORWARDED_FOR'])

         $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

     else if(@$_SERVER['HTTP_FORWARDED'])

         $ipaddress = $_SERVER['HTTP_FORWARDED'];

     else if(@$_SERVER['REMOTE_ADDR'])

         $ipaddress = $_SERVER['REMOTE_ADDR'];

     else

         $ipaddress = 'UNKNOWN';



     return $ipaddress; 

}

     ?>