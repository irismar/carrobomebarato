   <?
   require_once('Connections/repasses.php'); 
   require_once('log.php'); 
       $sql2  = "SELECT * FROM propostas WHERE id_estoque ='" .trim($_GET['id']). "' AND destinatario='" .trim($_GET['nome_membro']). "'   AND id_estoque='" .trim($_GET['id_estoque']). "'	 AND cod_seguranca='" .trim($_GET['segure']). "' ORDER BY remetene  ASC  LIMIT 999"; 
 $query2 = $mysql->query($sql2);

@$totalRows_propostas = $query2->num_rows;

  if ( $totalRows_propostas != 0) { ?>
 <?php while ($query_cont= $query2->fetch_assoc()) { if($query_cont['resposta']='1'){ 
                             ////esse codigo serve para remover alerta apos ler a mensagem ///
                            //$mysql->query( "UPDATE propostas SET alerta=0  WHERE   resposta='1' AND id =".$query_cont['id']." ");
                            $mysql->query( "UPDATE propostas SET acesso='$hora'  WHERE   id =".$query_cont['id']." AND  resposta='0' ");
                             
                             ?>
                         
<div class="col-md-12 ">
    <div class="col-md-1">
    <img src="/galeriadefotos/peq/avatar.jpg" class="img-circle"   width="50" height="60"> 
    </div><div class="col-md-11">
                       
                          <ol class="breadcrumb"><div class="text-left">
  <li ><i class="fa fa-user fa-1x" aria-hidden="true"><?php echo  @$query_cont['remetene']; ?></i><i class="fa fa-phone fa-1x" aria-hidden="true"><?php echo  @$query_cont['email']; ?></i><i class="fa fa-calendar-plus-o fa-1x" aria-hidden="true"><?php echo data22( $query_cont['data']); ?></i></li>                                   
  <li><a href="#" style="color:#387DC2; font-size:14px"><?php echo  $query_cont['mensagem']; ?></a>
  
 
  
  <? if($query_cont['lido']=='0'){ ?>
      <i class="fa fa-check" aria-hidden="true" style="color:#555;"></i><i class="fa fa-check" aria-hidden="true" style="color:#555;"></i>

  
  <? }else{?> 
  <i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i><i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i><i class="fa fa-check" aria-hidden="true" style="color:#5cb85c;"></i>

      <? } ?><p>
          
      
      
      
    <?   $sql2  = "SELECT * FROM propostas WHERE respondido='" .trim($query_cont['id'])."' 	 ORDER BY id  ASC  LIMIT 999"; 
 $query3 = $mysql->query($sql2);

$query3->num_rows;

  if ( $query3->num_rows != 0) { ?>
  <?php while ($query_resposta= $query3->fetch_assoc()) {  ?> 
      
   <div class="caption"> <div class="col-md-11 text-right"> <a href="#" style="color:#387DC2; font-size:14px">  <?=$query_resposta['mensagem'];?></a></i>
  </div> <div class="col-md-1" >
    <img src="/galeriadefotos/peq/<?=$query_resposta['foto'];?>" class="img-circle"   > 
   </div></div><? } 
  
  } else{ ?>
      
    <i class="fa fa-comment fa-2x azul" >
       <a href="modalresponder.php?id=<?php echo  $query_cont['id']; ?>&&id_membro=<?php echo  $query_cont['id_membro']; ?>&&remetene=<?php echo  $query_cont['remetene']; ?>&&destinatario=<?php echo  $query_cont['Destinatario']; ?>&&foto=<?php echo  $_SESSION['foto']; ?>&&id_estoque=<?php echo  $query_cont['id_estoque']; ?>&&cod_seguranca=<?php echo  $query_cont['cod_seguranca']; ?>&&endereco=<?php echo  @$_SESSION['endereco1']; ?>&&url=<?=$_GET['url']?>">Responder</a></i>   </p>             
  
    
      <?} ?>
      
     </li>              </div> 
                             
 <li ><i class="fa fa-car fa-1x" aria-hidden="true"><?php echo  $query_cont['modelo']; ?>&nbsp;&nbsp;&nbsp;<?php echo  $query_cont['marca']; ?>&nbsp;&nbsp;&nbsp;<? if ($query_cont['preco']!=''){ ?>
    <? echo "R$". '&nbsp;'.  @number_format(trim($query_cont['preco']), 2, ',', '.');
    ?></a>  <? } else { echo " R$ A  combinar" ; } ?></i></li></i></li>
                          </ol><hr></div></div>
                              <?php }  				

							 
	                           

                } 

   }   ?>

		 