	var xmlhttp = getXmlHttpRequest();
	
	function getXmlHttpRequest() {
		if (window.XMLHttpRequest) {
			return new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	
	
function Carrega(url,ID){
  document.getElementById("modelo").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?id_marca=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("modelo").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }
 
 function Carrega2(url,ID){
  document.getElementById("cidade_ajax").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?id_regiao=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("cidade_ajax").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }
 
 
 
 
 function Carreganome(url,ID){
  document.getElementById("caregarnome").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("POST", url + '?id_regiao=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("caregarnome").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }
 
 
 function Carreganome2(url,ID){
  document.getElementById("caregarnome").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("POST", url + '?id_regiao=' + ID , true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("caregarnome").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }
  function Carregaemail(url,ID){
  document.getElementById("caregaremail").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?id_regiao=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("caregaremail").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }



function Carrega4(url,ID){
  document.getElementById("cidade_ajax").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?regiao=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("cidade_ajax").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }

function Carrega5(url,ID){
  document.getElementById("marca").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?id_categoria=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   
	document.getElementById("marca").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }

function Carrega6(url,ID){
  document.getElementById("modelo").innerHTML = "<strong>Carregando...</strong>";
  xmlhttp.open("GET", url + '?id_marca=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("modelo").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
/**
  * Função para criar um objeto XMLHTTPRequest
  */
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
  * Função para criar um objeto XMLHTTPRequest
  */
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
  */
 function getDados() {
     
     // Declaração de Variáveis
     var nome   = document.getElementById("txtnome").value;
     var result = document.getElementById("Resultado");
     var xmlreq = CriaRequest();
     
     // Exibi a imagem de progresso
     result.innerHTML = '<img src="loader.gif"/>';
     
     // Iniciar uma requisição
     xmlreq.open("GET", "autocomplete.php?txtnome="+ nome, true);
     
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
         
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
             
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }
 
