/**
 * @author Clube dos Geeks
 */
var numitens=3; //quantidade de itens a ser mostrado por página
var pagina=1;	//página inicial - DEIXE SEMPRE 1
$(document).ready(function(){
	getitens(pagina,numitens); //Chamando função que lista os itens
})
function getitens(pag, maximo){
	pagina=pag; 
	$.ajax({
	type: 'GET',
	data: 'tipo=listagem&pag='+pag +'&maximo='+maximo,
	url:'getitens.php',
   	success: function(retorno){
    	$('#conteudo').html(retorno); 
        	contador() //Chamando função que conta os itens e chama o paginador
     	}
    })
}
function contador(){
	$.ajax({
      	type: 'GET',
      	data: 'tipo=contador',
      	url:'getitens.php',
   		success: function(retorno_pg){
        	paginador(retorno_pg)
      	}
    })
}
function paginador(cont){
	if(cont<=numitens){
		$('#paginador').html('<tr><td>Apenas uma Página<td><tr>')
	}else{
		$('#paginador').html('<tr></tr>');
		if(pagina!=1){
			$('#paginador tr').append('<td><a href="#" onclick="getitens('+(pagina-1)+', '+numitens+')">Página Anterior</a></td>')
		}
		var qtdpaginas=Math.ceil(cont/numitens)
		for(var i=1;i<=qtdpaginas;i++){
			if(pagina==i){
				$('#paginador tr').append('<td  style="background: red"><a href="#" onclick="getitens('+i+', '+numitens+')">'+i+'</a></td>')
			}else{
				$('#paginador tr').append('<td><a href="#" onclick="getitens('+i+', '+numitens+')">'+i+'</a></td>')
				}
		}
		if(pagina!=qtdpaginas){
			$('#paginador tr').append('<td><a href="#" onclick="getitens('+(pagina+1)+', '+numitens+')">Próxima Página</a></td>')
		}
	}
}
			