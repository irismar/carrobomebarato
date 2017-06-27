<? if(IsLoggedIn()){
    
    $sql2  = "SELECT * FROM propostas WHERE id_estoque ='" .  $row_estoque['Id_estoque']. "'	 AND Destinatario='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 


  $query2 = $mysql->query($sql2);

@$totalRows_propostas = $query2->num_rows;

  if ( $totalRows_propostas != 0) { ?>

        <div id="ver_descricao_estoque">  <a href="acao.php?deletartudo=<?php echo alphaID($row_estoque['Id_estoque'] ); ?>"><i class="fa fa-trash fa-1x"></i>Deletar todas estas Mensagem</a>
  <div id="caixa_estoque1">
                 <?php while ($query_cont= $query2->fetch_assoc()) {  ?>

                

                  <div class="col-md-1"><?php

                   			   if (@$query_cont['foto']) { ?>

                          	  <img src="/galeriadefotos/novo/<?php echo $query_cont['foto'] ;?>"  class="caixa_estoque80"  width="50" height="60"> 

                              <?php } else{ ?>

                              <img src="/galeriadefotos/peq/avatar.jpg"  class="caixa_estoque80"  width="50" height="60"> 

                              <?php   } ?> </div>
                      <div class="col-md-11"><p>
                              <p><samp class="fa glyphicon glyphicon-user fa-1x"></samp><a><?php echo  @$query_cont['remetene']; ?></a> </p>
                              <p><samp class="fa fa-calendar-o fa-1x"></samp><a><?php echo data22( @$query_cont['data']); ?></a> </p>
                             <p>  <samp class="fa fa-whatsapp fa-1x"></samp><a><?php echo  @$query_cont['email']; ?></a> </p>
        <h1><samp class="glyphicon glyphicon-map-marker"></samp><?php echo  @$query_cont['endereco']; ?></a> </h1>

            </
                             <p><a href="#"><strong class="vermelho_11px"><?php echo  $query_cont['mensagem']; ?></strong></a></p>

                          

						

							

                             <p>  <a href="acao.php?deletar_eudestinatario=<?php echo alphaID($query_cont['id'] ); ?>">Deletar</a></p><hr class="col-md-12">  <?php

							 if (@$query_cont['respondido']=="1")  {  

							

 $sql= "SELECT * FROM propostas WHERE resposta ='" . $query_cont['id']. "'	 AND remetene='" . $_SESSION["usuario"]. "' ORDER BY id DESC LIMIT 99"; 

  $query2 = $mysql->query($sql);

 @$totalRows_propostas33 =$query2->num_rows;

 if ( $totalRows_propostas33 != 0) { ?> </div>

  <div id="ver_descricao_estoque">

                 <?php while ($query_cont33 =  $query2->fetch_assoc()) {  ?>

                  <div id="caixa_estoque_resposta">

                 

                               
               

                               <div id="ver_descricao_foto2">

                              </br> <a href="#"><strong class="azul_resposta"><?php echo  $query_cont33['mensagem']; ?></strong></a>

                               </div> <div id="ver_descricao_foto"><?php

                   			   if (@$query_cont['foto']) { ?>

                          	  <img src="/galeriadefotos/novo/<?php echo $query_cont33['foto'] ;?>"   width="50" height="60"> 

                              <?php } else{ ?>

                              <img src="/galeriadefotos/peq/avatar.jpg"   width="50" height="60"> 

                              <?php   } ?> </div><div id="caixa_respostas">

                           <p> <a href="">&nbsp;<?php echo data22( $query_cont33['data']); ?> </a>  

                               <a href="acao.php?deletar=<?php echo alphaID($query_cont33['id'] ); ?>"><i class="fa fa-trash fa-1x"></i>Deletar</a></p>

                           </div></div> <?php } ?>  <?php } } else {?><?php 	}					

							   if (@$query_cont['foto']) {  ?> 

							     <div id="caixa_redesocial">

   <form action="acao.php?responder=<?php echo  $query_cont['remetene']; ?>&&id_estoque=<?php echo $row_estoque['Id_estoque']; ?>&&id_membro=<?php echo $row_estoque['id_membro']; ?>&&foto=<?php echo $_SESSION['foto']; ?>&&resposta=<?php echo  $query_cont['id']; ?>" method="post" enctype="multipart/form-data" name="carga" id="carga">

     <input type="hidden"  name="nome"value="<?php  echo @$_SESSION['usuario']; ?>">

  <input type="hidden"  name="email" value="<?php  echo @$row_estoque['email']; ?>">
   <input type="hidden"  name="id_estoque" value="<?php  echo @$row_estoque['Id_estoque']; ?>">
   <div class="col-md-9">
      <textarea name="memsagem"placeholder="Mensagem" ></textarea></div>
   <div class="col-md-2">
      <input name="enviar" type="submit" value="enviar"></div>

      

                    </form> </div>

                      <?php   } ?>

	                                  

    </div>  <?php }?>

</div></div>  <?php } } ?>

		 