function ValidaLoginMember(){

		d = document.log;
				
		if (d.email.value == ""){
			alert("O campo E-MAIL precisa ser preenchido!");
			d.email.focus();
			return false;
		}
		
		parte1 = d.email.value.indexOf("@");
		parte2 = d.email.value.indexOf(".");
		parte3 = d.email.value.length;
		
		if (!(parte1 >= 2 && parte2 >= 2 && parte3 >= 9)) {
			alert("O campo EMAIL deve conter um endereco eletronico!");
			d.email.focus();
			return false;
		}
		
		if (d.senha.value == ""){
			alert("O campo SENHA precisa ser preenchido!");
			d.senha.focus();
			return false;
		}

		return true;
}

function login_erro(id) {
	d = document.log;
	if (id == 1) {
		alert('Seu e-mail / senha está incorreto, tente novamente!');	
		d.email.focus();
	}
	if (id == 2) {
		alert('Seu login está bloqueado, entre em contato com o administrador do site.');	
		d.email.focus();
	}
}

function ValidaCadastro(){

			d = document.add;
		
			if (d.nome.value == ""){
				alert("O campo NOME precisa ser preenchido!");
				d.nome.focus();
				return false;
			}

			if (d.cidade.selectedIndex == 0){
				alert("Selecione a cidade!");
				d.cidade.focus();
				return false;
			}

			if (d.email.value == ""){
				alert("O campo E-MAIL precisa ser preenchido!");
				d.email.focus();
				return false;
			}
			
			parte1 = d.email.value.indexOf("@");
			parte2 = d.email.value.indexOf(".");
			parte3 = d.email.value.length;
			
			if (!(parte1 >= 2 && parte2 >= 2 && parte3 >= 9)) {
				alert("O campo EMAIL deve conter um endereco eletronico!");
				d.email.focus();
				return false;
			}
			
			if (d.senha.value == ""){
				alert("O campo SENHA precisa ser preenchido!");
				d.senha.focus();
				return false;
			}
			
			if (d.confirmar.value == ""){
				alert("O campo CONFIRMAR precisa ser preenchido!");
				d.confirmar.focus();
				return false;
			}

			if (d.confirmar.value != d.senha.value){
				alert("Digite a confirmação da senha novamente!");
				d.confirmar.value = "";
				d.confirmar.focus();
				return false;
			}
			
}

function EditarCadastro(){

			d = document.add;
		
			if (d.nome.value == ""){
				alert("O campo NOME precisa ser preenchido!");
				d.nome.focus();
				return false;
			}

			if (d.cidade.selectedIndex == 0){
				alert("Selecione a cidade!");
				d.cidade.focus();
				return false;
			}

			if (d.email.value == ""){
				alert("O campo E-MAIL precisa ser preenchido!");
				d.email.focus();
				return false;
			}
			
			parte1 = d.email.value.indexOf("@");
			parte2 = d.email.value.indexOf(".");
			parte3 = d.email.value.length;
			
			if (!(parte1 >= 2 && parte2 >= 2 && parte3 >= 9)) {
				alert("O campo EMAIL deve conter um endereco eletronico!");
				d.email.focus();
				return false;
			}
}


function ErroCodigo(){
	alert("Atenção\n O e-mail utilizado já está cadastrado!");
}

function ExcluirVeiculo(id){
if (confirm("Deseja realmente excluir o veículo?"))
	{ window.location='excluir_veiculos.php?Id_estoque='+id; }
}


function AdicionarCarros(){

			d = document.add;
			
			if (d.id_categoria.selectedIndex == 0){
				alert("Selecione a categoria!");
				d.id_categoria.focus();
				return false;
			}
			
			if (d.ano1.value == ""){
				alert("Selecione o Ano 1!");
				d.ano1.focus();
				return false;
			}
			if (d.ano2.value == ""){
				alert("Selecione o Ano 2!");
				d.ano2.focus();
				return false;
			}
			
			if (d.cor.value == ""){
				alert("O campo COR precisa ser preenchido!");
				d.cor.focus();
				return false;
			}
			if (d.preco.value == ""){
				alert("O campo PREÇO precisa ser preenchido!");
				d.preco.focus();
				return false;
			}
			if (d.condicoes.selectedIndex == 0){
				alert("Selecione as condições!");
				d.condicoes.focus();
				return false;
			}
			if (d.km.value == ""){
				alert("O campo KM precisa ser preenchido!");
				d.km.focus();
				return false;
			}
			if (d.combustivel.selectedIndex == 0){
				alert("Selecione o combustível!");
				d.combustivel.focus();
				return false;
			}

			if (d.regiao.selectedIndex == 0){
				alert("Selecione a região!");
				d.regiao.focus();
				return false;
			}

}

function EditarCarros(){

			d = document.edit;
			if (d.cor.value == ""){
				alert("O campo COR precisa ser preenchido!");
				d.cor.focus();
				return false;
			}
			if (d.preco.value == ""){
				alert("O campo PREÇO precisa ser preenchido!");
				d.preco.focus();
				return false;
			}
			if (d.km.value == ""){
				alert("O campo KM precisa ser preenchido!");
				d.km.focus();
				return false;
			}
}

function ValidaContato(){

		d = document.contato;
		texto = "Atenção!";
			
		if (d.nome.value == ""){
			alert(texto + "\nO campo NOME deve ser preenchido!");
			d.nome.focus();
			return false;
		}
		
		if (d.email.value == ""){
			alert(texto + "\nO campo E-MAIL deve ser preenchido!");
			d.email.focus();
			return false;
		}

		parte1 = d.email.value.indexOf("@");
		parte2 = d.email.value.indexOf(".");
		parte3 = d.email.value.length;
		
		if (!(parte1 >= 2 && parte2 >= 2 && parte3 >= 9)) {
			alert(texto + "\nO campo EMAIL deve conter um endereco eletronico!");
			d.email.focus();
			return false;
		}

		if (d.cidade.value == ""){
			alert(texto + "\nO campo CIDADE deve ser preenchido!");
			d.cidade.focus();
			return false;
		}

		if (d.uf.value == ""){
			alert(texto + "\nO campo ESTADO(UF) deve ser preenchido!");
			d.uf.focus();
			return false;
		}

		if (d.telefone.value == ""){
			alert(texto + "\nO campo TELEFONE deve ser preenchido!");
			d.telefone.focus();
			return false;
		}
		
		if (d.mensagem.value == ""){
			alert(texto + "\nO campo MENSAGEM deve ser preenchido!");
			d.mensagem.focus();
			return false;
		}
		return true;
}

	var xmlhttp = getXmlHttpRequest();
	
	function getXmlHttpRequest() {
		if (window.XMLHttpRequest) {
			return new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	
	
function Carrega(url,ID){
  xmlhttp.open("GET", url + '?id_cat=' + ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("class_sub").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
 }

function Carrega3(url,ID){

  document.getElementById("subcat2").innerHTML = '<select name="id_subcategoria" id="id_subcategoria"><option>Carregando...</option></select>';
  if (ID == '') {
	  document.getElementById("subcat2").innerHTML = '<select name="id_subcategoria" id="id_subcategoria"><option></option></select>';
  } else {
  xmlhttp.open("GET", url+'?id='+ID, true);
  xmlhttp.onreadystatechange = function(){
  
   if (xmlhttp.readyState == 4){
   var texto = xmlhttp.responseText;
   texto = texto.replace(/\+/g," ");
   texto = unescape(texto);
	document.getElementById("subcat2").innerHTML = xmlhttp.responseText;
   }
  } 
  xmlhttp.send(null);
  }
 }
