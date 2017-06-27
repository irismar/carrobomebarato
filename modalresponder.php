<? include "Connections/repasses.php";
if(IsLoggedIn()){
?></a>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    

    <!-- Bootstrap -->
    

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <?
   require_once('Connections/repasses.php'); 
   require_once('log.php'); 
   if(isset($_GET['app_memsagem']) && ( isset($_POST['memsagem'])&& ($_POST['memsagem']!='')) ) { 
 require_once'Connections/repasses.php'; 
 require_once('log.php');

    
echo $sql="INSERT INTO propostas (Destinatario,remetene,mensagem,id_estoque,data,foto,cod_seguranca,respondido,resposta,alerta,id_membro) VALUES "
        . "('".$_GET['app_memsagem']."','".$_GET['destinatario']."','".$_POST['memsagem']."','".$_GET['id_estoque']."','".$hora."','".@trim($_GET['foto'])."','".$_GET['cod_seguranca']."','".$_GET['id']."','1',+1,'".$_GET['id_membro']."')";
$sql= $mysql->query($sql); 
  
if($sql) {
    $mensagem ="Usuario "."&nbsp;".@$_GET['destinatario']." mandou uma memsagem para usuario"."&nbsp;".$_GET['app_memsagem'] ."&nbsp;"." com sucesso" ;
    $mysql->query("UPDATE membros SET alertamanesagem=alertamanesagem + 1  WHERE id = ".$_GET['id_membro']."");
    salvaLog($mensagem); 
    $token = bin2hex(openssl_random_pseudo_bytes(32));
    $_SESSION['form_token'] = $token; ?>
<script language= "JavaScript">
location.href="<?=$_GET['url'].'#'.trim($_GET['id_estoque'])?>"
</script><?
}else{
  $_SESSION["mens_id_estoque"] =$_GET['id'];
  $_SESSION["msm"]="Erro ao enviar mensagem  ";
  $mensagem ="Usuario "."&nbsp;".$_POST['nome']." mandou uma memsagem para usuario"."&nbsp;".$_GET['memsagem'] ."&nbsp;"." com sucesso" ;
//salvaLog($mensagem);
 }
if (isset($_GET['responder'])) { 
  if( @$_SESSION["mens_id_estoque"]==$_GET['resposta']){
   "você já Enviou mensagem";
 
	  }
} }else{
    $sql2  = "SELECT * FROM propostas WHERE id ='" .trim($_GET['id']). "' 	 ORDER BY id  ASC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);

 @$totalRows_propostas = $query2->num_rows;

  if ( $totalRows_propostas != 0) { ?>
  <?php while ($query_cont= $query2->fetch_assoc()) {  
      

$datatime1 = new DateTime($query_cont['acesso']);
$datatime2 = new DateTime($hora);
$data1  = $datatime1->format('Y-m-d H:i:s');
$data2  = $datatime2->format('Y-m-d H:i:s');
$diff = $datatime1->diff($datatime2);
$horas = $diff->i + ($diff->days * 24*60*60);
$mysql->query( "UPDATE propostas SET lido=1  WHERE   id=".$query_cont['id']." ");
                        $mysql->query( "UPDATE propostas SET alerta=0  WHERE   resposta='0' AND id =".$query_cont['id']." ");
                               
                       if(  @$query_cont['resposta']=='0') { 
                           ////codigo para exibir a pergunta///
                        ?>  
                         
<div class="container modalresponde">
    <div class="center-block">
    <div class="col-md-1 col-xs-2">
    <img src="/galeriadefotos/peq/avatar.jpg" class="img-circle"   width="50" height="60"> 
    </div><div class="col-md-11 col-xs-10">
                       
                          <ol class="breadcrumb"><div class="text-left">
  <li ><i class="fa fa-user fa-1x" aria-hidden="true"><?php echo  @$query_cont['remetene']; ?></i><i class="fa fa-phone fa-1x" aria-hidden="true"><?php echo  @$query_cont['email']; ?></i><i class="fa fa-calendar-plus-o fa-1x" aria-hidden="true"><?php echo data22( $query_cont['data']); ?></i></li>                                   
  <li><a href="#"><?php echo  $query_cont['mensagem']; ?></a>
  
 
  
  <? if($query_cont['lido']=='0'){ ?>
      <i class="fa fa-check" aria-hidden="true" style="color:#555;"></i><i class="fa fa-check" aria-hidden="true" style="color:#555;"></i>

  
  <? }else{?> 
  <i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i><i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i><i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i>

      <? } 
      
      //////////////////from resposta da pergunta/////
      ?><p>
          <form action="?app_memsagem=<?php echo $query_cont['remetene'] ?>&&destinatario=<?php echo $query_cont['Destinatario'] ?>&&id=<?php echo $query_cont['id']; ?>&&id_membro=<?php echo $query_cont['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>&&cod_seguranca=<?php echo $query_cont['cod_seguranca']; ?>&&endereco=<?php echo @$_GET['endereco']; ?>&&id_estoque=<?php echo @$_GET['id_estoque']; ?>&&url=<?= $_GET['url']?>" method="post" >
    
     
     <input type="text" name="memsagem"placeholder="Mensagem" >

 
     <input name="enviar" type="submit" class="botao"value="responder">

     </form>
        </p>             
   </li>              </div> 
    


                              
    <li ><i class="fa fa-car fa-1x" aria-hidden="true"><?php echo  $query_cont['modelo']; ?><?php echo  $query_cont['preco']; ?></i></li>
                          </ol><hr></div></div></div>
       
                      
<?php }} } } } ?> 

              

    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

