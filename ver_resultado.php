<div class="list-group"><?
    // Verifica se a consulta retornou linhas 

        // Atribui o c�digo HTML para montar uma tabela
     
     ?><?   // Captura os dados da consulta e inseri na tabela HTML
        
             while($linha = $query->fetch_assoc()) { 
                $exibir= $linha['exibir'];
		 if($exibir=='1') {	

             	 $modelo = explode(" ",$linha["marcatexto"]);
		     $co=explode("co",$modelo[0]); 
	 $co[0];
    $modelo[0]; 
     $linha["modelotexto"]; $modelo1 = explode(" ",$linha["modelotexto"]); 
     $estado=acento($linha["estado"]);
     $estado= trim(removeAcentos($estado));
     $cidade=acento($linha["cidade"]);
     $cidade= trim(removeAcentos($estado));
    
    

      ?>
     <div class="list-group-item"><ul>
  <p>  <a href="<?php  echo URL::getBase(); ?>" >
   

	
  <span><a href="<? echo  $linha["marcatexto"];?>" ><? echo utf8_encode( $linha["marcatexto"]);?></a>  <?  $linha["modelotexto"]; $modelo1 = explode(" ",$linha["modelotexto"]);    $modelo1[0]; ?>
 
      <a href="<? echo  $linha["modelotexto"];?>" ><?php echo utf8_encode( $modelo1[0]); ?></a></span>


  
    <br /> 
<span class=" glyphicon glyphicon-user" aria-hidden="true">	    
<a href="<? echo  $linha["url"];?>" ><? echo  $linha["nome_membro"];?></a></span>   
<? if ($linha['cidade']){ ?>
 
<span class=" glyphicon glyphicon-map-marker" aria-hidden="true"> 
<a href="/?l=<? echo trim( $linha["cidade"]);?>&&e=<? echo trim( $linha["estado"]);?>" ><? echo  $linha["cidade"];?></a></span> <? } ?>
 <span class="glyphicon glyphicon-map-marker" aria-hidden="true">  
 <a href="#" class="navbar-link">  <? echo $distancia= distancia( $linha['lat'], $linha['lon'],$_SESSION['lat'], $_SESSION['log']) ?> 
         
         Km de Distância 
       </span></a>
 </p>  			
		
 </ul>
</div>
     
 
		


            
                 <?   } }  ?>