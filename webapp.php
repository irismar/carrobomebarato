<div class="container">
    <div id="contato"></div>
   <?
  
  if(isset($_GET['segure'])){ 
    
  ?>

		 
<div class="col-md-9">
 
     
     <div id="lista"></div>
    <div class="col-md-9">   
     <iframe src="app_resposta.php?app_memsagem=<?php echo $_SESSION["usuario"]?>&&id=<?php echo $_GET['id']; ?>&&id_membro=<?php echo $_SESSION["id"]; ?>&&foto=<?php echo $_SESSION["foto"]; ?>&&cod_seguranca=<?php echo $_GET['segure']; ?>" class="col-md-12" ></iframe>
     

 </div>
    



    
</div>
     
     
     
   

                                 
  </div> <? }?>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
     $("#resposta").click(function() {
         var nome = $("#nome");
         var nomePost = nome.val(); 
         var email = $("#email");
         var emailPost = email.val(); 
         var telefone = $("#telefone");
         var telefonePost = telefone.val();     
         $.post("app_pergunta.php", {nome: nomePost, email: emailPost, telefone: telefonePost},
         function(data){
         $("#resposta").html(data);
          }
          , "html");
     });
 });
</script>    <script type="text/javascript">        
			$(document).ready(function(){
				comeca();
			})
			var timerI = null;
			var timerR = false;

			function para(){
    			if(timerR)
        			clearTimeout(timerI)
    			timerR = false;
			}
			function comeca(){
    			para();
    			lista();
			}
			function lista(){
				$.ajax({
					url:"<?  echo URL::getBase(); ?>appmensagem_vendedor.php?id=<?=$_GET['id'];?>&&segure=<? echo trim($_GET['segure']);?>",
   					success: function (textStatus){
 						$('#lista').html(textStatus); //mostrando resul tado
 					}
 				})
 				timerI = setTimeout("lista()", 1000);//tempo de espera
    			        timerR = true;

			}
                     </script>	
   <script type="text/javascript">        
			$(document).ready(function(){
				comecar_contato();
			})
			var timerI = null;
			var timerR = false;

			function para(){
    			if(timerR)
        			clearTimeout(timerI)
    			timerR = false;
			}
			function comecar_contato(){
    			para();
    			contato();
			}
			function contato(){
				$.ajax({
					url:"<?  echo URL::getBase(); ?>appmensagem_contato.php",
   					success: function (textStatus){
 						$('#contato').html(textStatus); //mostrando resul tado
 					}
 				})
 				timerI = setTimeout("contato()", 1000);//tempo de espera
    			        timerR = true;

			}
                     </script>	                     
       