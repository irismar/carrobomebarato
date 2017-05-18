
<script>
function  mostrar(ID){
	document.getElementById(ID).style.display = "block";

}
function  ocultar(ID){
	document.getElementById(ID).style.display = "none";
	$("#dive").hide("slow");
}
function altera_display(id) {
	// Opções para o atributo display - block, inline e none
	if(document.getElementById(id).style.display=="none") {
		document.getElementById(id).style.display = "block";
	}
	else {
		document.getElementById(id).style.display = "none";
	}
}

function altera_100(id) {
	// Opções para o atributo display - block, width:80%} inline e none
	if(document.getElementById(id).style.width=="100px") {
		document.getElementById(id).style.width = "100px";
	}
	else {
		document.getElementById(id).style.width = "100px";
	}
}
</script>
    
 <?php @session_start();


 require'Connections/repasses.php';

 require "links.php";  
 $request = $_SERVER['REQUEST_URI'];

 require "log.php"; 
 require "meta.php";
   if($request=="/sair"){ include_once"sair.php"; exit(); }
   if($request=="/acao"){ include_once"acao.php"; exit(); }
   if($request=="/goo"){ include_once"login.php"; exit(); }
   ?>
   
</body>
</html>  
<?php
 
 $modulo=trim(Url::getURL( 0 ));
     $modulo = str_replace("%C3%A9", "?",   $modulo);
   $modulo = str_replace("%C3%A3", "?",   $modulo);
   $modulo = str_replace("%C3%AD", "?",   $modulo);
   $modulo = str_replace("%C3%A3o", "?o",   $modulo);
    $modulo = str_replace("%20", " ",   $modulo);
	$modulo = str_replace("?", "é",   $modulo);
	$modulo = str_replace("?o", "ão",   $modulo);
	$modulo = str_replace("%C3%A1", "á",   $modulo); 
	 $link =urldecode($_SERVER['REQUEST_URI']);
	 
    @$ex = explode('/', $link);
    $link1 = $ex[count($ex)-2];
    @$link2 = $ex[count($ex)-1];
    $link3 = $ex[count($ex)-1];
    @$ex2 = explode("?",$link);
    @$link11 = $ex2[count($ex2) -1];
    @$link12 = $ex2[count($ex2)-1];
    @$link13 = $ex2[count($ex2)-3];

/////para ajustar a paginação ///////
 $script =trim(  str_replace("/", "",   $_SERVER['REQUEST_URI']));
/////para ajustar a paginação ///////

if(isset($_GET['l']) || isset($_GET['e']) )
{
	
	 $_SESSION['km']=FALSE;
}else{
	
if(empty($_SESSION['km'])){
	
	 $_SESSION['km']='';}


}


if(isset($_GET['r']))
{
	
	 $_SESSION['km']=$_GET['r'];
}  
  if(@$_GET["ordem"]){
    if($_GET["ordem"]=="maiorpreco"){$ordem='preco DESC ';$ordem21="sim";$ordem2="Maisbarato";}
    if($_GET["ordem"]=="menorpreco"){$ordem='preco  ASC';$ordem22="sim";}
    if($_GET["ordem"]=="novo"){$ordem='ano2 DESC ';$ordem23="sim"; }
    if($_GET["ordem"]=="seminovo"){$ordem='ano2 ASC ';$ordem24="sim"; }
    }else{ $ordem='Id_estoque DESC';}
   		require "menu.php"; 
		
		
   		if( file_exists("$modulo.php")){
   		include_once("$modulo.php");exit();
  }if(@$_GET["mapa"]){
	 include_once("map.php");exit();}
	 
	 
	 
	 
	 $sql ="SELECT id FROM  membros 	WHERE  url='".$modulo."' LIMIT 1 ";
     $query = $mysql->query($sql);
     $query->num_rows;
	 if ($query->num_rows  == '1') { 
     unset($_SESSION['buscar']); 
	 $_SESSION['buscar']= "WHERE url="."'".$modulo."'"; 
	 require_once"membro.php";
	 exit();
	 
	 }else{
	 $sql ="SELECT  nome FROM  membros 	WHERE  nome='".$modulo."' LIMIT 1 ";
     $query = $mysql->query($sql);
     $query->num_rows;
	 if($query->num_rows  == '1') { 

	unset($_SESSION['buscar']); 
	 $_SESSION['buscar']= "WHERE nome_membro="."'".$modulo."'"; 
	require_once"membro.php";
	exit();	
		
		
	}
	 }
 	
	if(is_numeric	($modulo)){
 $sql="SELECT * FROM estoque WHERE Id_estoque='".$modulo."' ORDER BY Id_estoque ASC";
 $query = $mysql->query($sql);
  if($query->num_rows  == '1') { 

	unset($_SESSION['buscar']); 
	
	require_once"membro2.php";
	exit();	
		
		
	}}
	///////////////////////////////////busca organica marca ///////////////////////////////////////////////////
	
	
	////////////////////////////////////////bisca organica por marca ///////////////////////////////////////////////
	
	  if(isset($_GET['l'])){ 
	  $sql2 ="SELECT Id_estoque FROM estoque	WHERE    estado='".$_GET['e']."' AND cidade='".$_GET['l']."' AND exibir='1'";
    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
	 $_SESSION['buscar']= "WHERE  estado="."'".$_GET['e']."'". " AND cidade="."'".$_GET['l']."'"." AND exibir=" ."'1' "; 
	require_once"membro.php";	exit(); } else{
	///////////////////codigo//////////pesquisar marca modelo por raio ////////////////////////////////////
   $sql ="SELECT marcatexto FROM estoque	WHERE   marcatexto LIKE '%".$modulo."%'	AND estado='".$_GET['e']."'   AND exibir='1' ORDER BY Id_estoque DESC LIMIT 999";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
	$_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". " AND estado="."'".$get_estado."'"." AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); } }
	
	///////////////////fim////////////////////
	
	  }
	
	
	
	/////////////////////////////////////////////////////////////////////////////////
	if(isset($_GET['e'])){ 
	
    $sql ="SELECT Id_estoque FROM estoque	WHERE     estado='".$_GET['e']."' AND exibir='1'";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
    $_SESSION['buscar']= "WHERE  estado="."'".$_GET['e']."'  and exibir='1'"; 
	require_once"membro.php";	exit(); } else{ 
	////se naõ hover modelos vamos testar marcas //////////
	////////////////////começo //////////////////////////
	
	"Não encontramos resultados exibindo dados de todo o Brasil";
	 }	}
	
	//////////////////////fim///////////////// //////////
	///////se naõ hover modelos vamos testar marcas //////////
	
	if(isset($_GET['p'])){ 
	  $sql ="SELECT Id_estoque FROM estoque	WHERE   marcatexto LIKE '%".$modulo."%' or  modelotexto LIKE '%".$modulo."%' and exibir='1'	";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
		$_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'  and exibir='1'";  
	require_once"membro.php";	exit(); }
	else{ 
	 $sql ="SELECT modelotexto FROM estoque	WHERE   modelotexto LIKE '%".$modulo."%'and exibir='1'	 ORDER BY Id_estoque DESC LIMIT 999";
   $query = $mysql->query($sql);
    $query->num_rows;
	if ($query->num_rows  !='0') { 
	$_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%' and exibir='1'"; 
	require_once"membro.php";	exit(); }
	} }	// fim if(isset($_GET['p']))
	

	
	///////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////pesquisar marca modelo por raio///////////////////////
        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
         $_SESSION['km']="10";
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }
        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 50
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="50";
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }

        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 100
";    $query = $mysql->query($sql2);

     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="100";
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }


        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 1000
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="1000";
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }

        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   marcatexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10000
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="10000";
	 $_SESSION['buscar']= "WHERE marcatexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }        
	
	
	 
	
	  
	 // $contador = mysql_query("SELECT count(modelotexto) as total FROM estoque WHERE   estado='".acento($_GET['estado'])."'") or die(mysql_error());

//$comentario = mysql_fetch_assoc($contador);
//echo $comentario['total'];
	
	
	//$selecionado ="SELECT count(modelotexto) as total FROM estoque 
                        //WHERE   estado='".acento($_GET['estado'])."'";
//$sql30 = mysql_query($selecionado);
//$resultado = mysql_fetch_array($sql30);
 
    //echo "total".$resultado['total']."</td>";
 
////////////////////////pesquisa modelo//////////////////////////////////////////////////////
//
// 
//
///////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////pesquisar marca modelo por raio///////////////////////
        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
         $_SESSION['km']="10";
	 $_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }
        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 50
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="50";
	 $_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }

        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 100
";    $query = $mysql->query($sql2);

      $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="100";
	 $_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }


        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 1000
";    $query = $mysql->query($sql2);
      $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="1000";
	 $_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }

        $sql2 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque WHERE   modelotexto LIKE '%".$modulo."%' AND exibir='1'
HAVING distancia < 10000
";    $query = $mysql->query($sql2);
     $query->num_rows;
	if ($query->num_rows >'0') { 
            $_SESSION['km']="10000";
	 $_SESSION['buscar']= "WHERE modelotexto LIKE"."'%".$modulo."%'". "  AND exibir=" ."'1' ";  
	require_once"membro.php";	exit(); }        
	
	
	 
	
//
//
//
//
///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////fim pesquisa modelo/////////////////////////////////////////////////
        
        
        
        
	


if(isset($_GET['brasil'])){ 
$_SESSION['buscar']= ""; 

require_once"membro.php";	exit();
} 

	///consulta limpra sem criterio index



	
//////////////////
if(!empty($_SESSION['km'])){
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque 
HAVING distancia < ".$_SESSION['km']."
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	
	
        require_once"membro.php";	exit(); } }
	//////////////////////////
	//////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 10
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	$_SESSION['km']="10";
	
	require_once"membro.php";	exit(); }
	//////////////////////////
	//////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 50
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	 $_SESSION['km']="50";
	
	require_once"membro.php";	exit(); }
	//////////////////////////
	
	//////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 100
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	 $_SESSION['km']="100";
	
	require_once"membro.php";	exit(); }
	//////////////////////////
	//////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque  where exibir='1'
HAVING distancia < 500
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	echo $_SESSION['km']="500";
	
	require_once"membro.php";	exit(); }
	////////////////////////////////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 1000
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	 $_SESSION['km']="1000";
	
	require_once"membro.php";	exit(); }
	//////////////////////////	
////////////////////////////////////////////
$sql3 = "SELECT *,
(6371 * acos(
cos( radians('$lat') )
* cos( radians( lat ) )
* cos( radians( lon ) - radians( '$log') )
+ sin( radians('$lat') )
* sin( radians( lat ) ) 
)
) AS distancia FROM estoque where exibir='1'
HAVING distancia < 10000
";
$query = $mysql->query($sql3);

	if ($query->num_rows  !='0') { 
	 $_SESSION['km']="10000";
	
	require_once"membro.php";	exit(); }	
	
///////////////////////////////////////////	
    
	
	if( file_exists("$link1.php")){
  include_once("$link1.php");exit();
  }
	?> 