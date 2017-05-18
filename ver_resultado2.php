<div class="list-group"><?
    // Verifica se a consulta retornou linhas 

        // Atribui o c�digo HTML para montar uma tabela
     
     ?><?   // Captura os dados da consulta e inseri na tabela HTML
        
             while($linha = $query->fetch_assoc()) { 
		 	

             	
    

      ?>
     <div class="list-group-item"><ul>
  <p>  <a href="<?php  echo URL::getBase(); ?>" >
   

	
  <span><a href="#" ><? echo  $linha["marca"];?></a> 
 
 <a href="#" ><?php echo  $linha["modelo"]; ?></a></span>


  
  
 </p>  			
		
 </ul>
</div>
     
 
		


            
     <?    }  ?>