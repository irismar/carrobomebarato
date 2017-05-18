function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
         
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
         
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
     
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
 
 /**
  * Função para enviar os dados
  */$(document).ready(function() {
	$("#enviar").click(function() {
		var nome = $("#nome");
		var nomePost = nome.val(); 
		var email = $("#email");
		var emailPost = email.val(); 
		var telefone = $("#telefone");
		var telefonePost = telefone.val(); 
		var id_estoque = $("#id_estoque");
		var id_estoquePost = id_estoque.val(); 	
		$.post("enviar.php", {nome: nomePost, email: emailPost, telefone: telefonePost,id_estoque: id_estoquePost},
		function(data){
		 $("#resposta").html(data);
		 }
		 , "html");
	});
});
