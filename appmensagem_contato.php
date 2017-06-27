 <? session_start(); ?>
<link href="/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="/css/ie.css" rel="stylesheet" type="text/css"/><?
   require_once('Connections/repasses.php'); 
   require_once('log.php'); 
 $sql2  = " SELECT * FROM propostas WHERE  Destinatario='" .trim($_SESSION["usuario"]). "' and  respondido ='0'  ORDER BY id  DESC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);

 $totalRows_propostas = $query2->num_rows;

  if ( $totalRows_propostas != 0) { ?>

<div class="col-md-3">
  
                 <?php while ($query_cont= $query2->fetch_assoc()) {  

              
  


                      
                          ?>
                         

                              
                   			   
    <div class="col-md-1">
                              <img src="/galeriadefotos/peq/avatar.jpg" class="img-circle"   width="50" height="60"> 

    </div><div class="col-md-11">
                          
   <ol class="breadcrumb"><div class="text-left">
    <li ><i class="fa fa-user fa-1x" aria-hidden="true"><?php echo  $query_cont['remetene']; ?></i></li>
    <li ><i class="fa fa-phone fa-1x" aria-hidden="true"><?php echo  $query_cont['email']; ?></i></li>
    <li ><i class="fa fa-map-marker fa-1x" aria-hidden="true"><?php echo  $query_cont['endereco']; ?></i></li>
    <li ><i class="fa fa-car fa-1x" aria-hidden="true"><?php echo  $query_cont['modelo']; ?></i></li>
    <li ><i class="fa fa-money fa-1x" aria-hidden="true"><?php echo  $query_cont['preco']; ?></i></li>
    
  <li><a href="<?  echo URL::getBase(); ?>webapp?segure=<?php echo  $query_cont['cod_seguranca']; ?>&&id=<?php echo  $query_cont['id_estoque']; ?>"><?php echo  $query_cont['mensagem']; ?></a></li>
  
  <li ><h4><a href="<?  echo URL::getBase(); ?>webapp?segure=<?php echo  $query_cont['cod_seguranca']; ?>&&id=<?php echo  $query_cont['id_estoque']; ?>"> <span class="label label-default"><?php echo data22( $query_cont['data']); ?></span> 
           <? if($query_cont['alerta']!='0'){ ?>
          
          
              <span class="label label-success">Nova Mensagem</span> <? } ?></h4></a></li>
              <li ><i class="fa fa-trash fa-1x" aria-hidden="true"><a href="acao.php?deletar_eudestinatario=<?php echo  $query_cont['cod_seguranca']; ?>&&id_estoque=<?php echo  $query_cont['id_estoque']; ?>">Excluir converça</a>
                  </i></li>
                           </div> 
                          </ol></div>
       
                         
                         
                              
                              <?php }  ?>				


    


  <?  ?> </div> <?} 