function CriaRequest() {
try{request = new XMLHttpRequest();}catch (IEAtual){try{request = new ActiveXObject("Msxml2.XMLHTTP");}catch(IEAntigo){
try{request = new ActiveXObject("Microsoft.XMLHTTP");}catch(falha){request = false;}}}
if (!request)
   alert("Seu Navegador não suporta Ajax!");
else
   return request;
 }
function getDados() {
var fornecedor   = document.getElementById("fornecedor_local").value;
var produto = document.getElementById("produto_local");
var xmlreq = CriaRequest();
xmlreq.open("GET", "../pags/busca_produto.php?fornecedor=" + fornecedor, true);
xmlreq.onreadystatechange = function(){
if (xmlreq.readyState == 4) {
if (xmlreq.status == 200){produto.innerHTML = xmlreq.responseText;}
else{produto.innerHTML = "Erro: " + xmlreq.statusText;}}};
xmlreq.send(null);
}
function dados() {
var produto   = document.getElementById("produto_local").value;
var valor = document.getElementById("pergunta_combustivel");
var xmlreq = CriaRequest();
xmlreq.open("GET", "../pags/busca_combustivel.php?produto=" + produto, true);
xmlreq.onreadystatechange = function(){
if (xmlreq.readyState == 4) {
if (xmlreq.status == 200){valor.value = xmlreq.responseText;}
else{valor.value = "Erro: " + xmlreq.statusText;}}};
xmlreq.send(null);
}
function goFocus(elementID){
document.getElementById(elementID).focus();
}
function combustivel() {
	var combustivel = document.getElementById("combustivel_local").value;
	var outros = document.getElementById("outro_combustivel");
	if(combustivel == "Outros"){
		outros.style.display = 'block';
	}else{
		outros.style.display = 'none';
	}
}
function produto_combustivel() {
	var produto = document.getElementById("produto_local").value;
	var div = document.getElementById("combustivel");
	if(produto == "Gasolina" || produto == "Etanol" || produto == "Diesel S-500" || produto == "Diesel S-10"){
		outros.style.display = 'block';
	}else{
		outros.style.display = 'none';
	}
}
function km() {
var placa = document.getElementById("veiculo_combustivel").value;
var km = document.getElementById("km_antigo");
var xmlreq = CriaRequest();
xmlreq.open("GET", "../pags/busca_km.php?placa=" + placa, true);
xmlreq.onreadystatechange = function(){
if (xmlreq.readyState == 4) {
if (xmlreq.status == 200){km.value = xmlreq.responseText;}
else{km.value = "Erro: " + xmlreq.statusText;}}};
xmlreq.send(null);
}

$(document).ready(function(){

	$("#produto_local").blur(function(){
		$.ajax({
			url: "../pags/busca_valor.php",
			dataType: "json",	
			data: {
			    produto: $('#produto_local').val(),
			    fornecedor: $('#fornecedor_local').val()
			},
			success: function( data ) {
			   $('#valor_produto').val(data);
			}
		});
	});

	//Formas de Pagamento
	$("#antecipado").click(function(){
		$(".aprazo").hide();
		$(".avista").hide();
		$(".antecipado").show();
		$("#opcoes_none").hide();
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").hide();
		$("#terceira_parcela").hide();
		$("#segunda_parcela").hide();
		$("#primeira_parcela").hide();
		$("#parcela_unica").hide();
	});
	$("#avista").click(function(){
		$(".aprazo").hide();
		$(".avista").show();
		$(".antecipado").hide();
		$("#opcoes_none").hide();
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").hide();
		$("#terceira_parcela").hide();
		$("#segunda_parcela").hide();
		$("#primeira_parcela").hide();
		$("#parcela_unica").hide();
	});
	$("#aprazo").click(function(){
		$(".aprazo").show();
		$(".avista").hide();
		$(".antecipado").hide();
	});
	//Opções da forma Antecipada
	$("input[name='forma_antecipado']").click(function(){
		$("#data_pagamento_antecipado").show();
	});
	//Opções da forma à vista
	$("input[name='forma_avista']").click(function(){
		$("#data_pagamento_avista").show();
	});
	//Fazendo aparecer as opções de parcela
	$("#aprazo").click(function(){
		$("#opcoes_none").show();
	});
	$("#um").click(function(){
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").hide();
		$("#terceira_parcela").hide();
		$("#segunda_parcela").hide();
		$("#primeira_parcela").hide();
		$("#parcela_unica").show();
	});
	$("#dois").click(function(){
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").hide();
		$("#terceira_parcela").hide();
		$("#segunda_parcela").show();
		$("#primeira_parcela").show();
		$("#parcela_unica").hide();
	});
	$("#tres").click(function(){
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").hide();
		$("#terceira_parcela").show();
		$("#segunda_parcela").show();
		$("#primeira_parcela").show();
		$("#parcela_unica").hide();
	});
	$("#quatro").click(function(){
		$("#sexta_parcela").hide();
		$("#quinta_parcela").hide();
		$("#quarta_parcela").show();
		$("#terceira_parcela").show();
		$("#segunda_parcela").show();
		$("#primeira_parcela").show();
		$("#parcela_unica").hide();
	});
	$("#cinco").click(function(){
		$("#sexta_parcela").hide();
		$("#quinta_parcela").show();
		$("#quarta_parcela").show();
		$("#terceira_parcela").show();
		$("#segunda_parcela").show();
		$("#primeira_parcela").show();
		$("#parcela_unica").hide();
	});
	$("#seis").click(function(){
		$("#sexta_parcela").show();
		$("#quinta_parcela").show();
		$("#quarta_parcela").show();
		$("#terceira_parcela").show();
		$("#segunda_parcela").show();
		$("#primeira_parcela").show();
		$("#parcela_unica").hide();
	});

	//Validando inputs de valores e datas da 1ª parcela
	$("input[name='primeiro_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_primeira_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	//Validando inputs de valores e datas da 2ª parcela
	$("input[name='segundo_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_segundo_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	//Validando inputs de valores e datas da 3ª parcela
	$("input[name='terceiro_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_terceiro_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	//Validando inputs de valores e datas da 4ª parcela
	$("input[name='quarto_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_quarto_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	//Validando inputs de valores e datas da 5ª parcela
	$("input[name='quinto_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_quinto_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	//Validando inputs de valores e datas da 6ª parcela
	$("input[name='sexto_vencimento_externo']").blur(function(){
		if (!$(this).val()) {
			alert("Campo Data da 1ª Parcela em branco!");
		}
	});
	$("input[name='valor_sexto_externo']").blur(function(){
		if ($(this).val() == "R$0,00") {
			alert("Campo Valor da 1ª Parcela em branco!");
		}
	});
	$("#quantidade_local").blur(function(){
		if ($("#pergunta_combustivel").val() == "sim") {
			$("#combustivel").show();
			$("#focusaki").focus();
		}else{
			$("#combustivel").hide();
		}
	});

	$("#km_combustivel").blur(function(){
		var $subtracao = $(this).val() - $("#km_antigo").val();
		var $divisao = $subtracao / $("#quantidade_local").val();
		$("#consumo_combustivel").val($divisao);
	});

	//Modal para cadastro e mudança de senha.
	$("#cadastro_usuario").click(function(){
		$("#fundo_modal").show(200);
		$("#new_user").show(200);
	});
	$("#trocar_senha").click(function(){
		$("#fundo_modal").show(200);
		$("#change_pass").show(200);
	});
	$("#usuarios_cadastrados").click(function(){
		$("#fundo_modal").show(200);
		$("#users").show(200);
	});
	$("#unidades_cadastradas").click(function(){
		$("#fundo_modal").show(200);
		$("#conteudo_modal").show(200);
	});
	$("#fornecedores_cadastrados").click(function(){
		$("#fundo_modal").show(200);
		$("#conteudo_modal").show(200);
	});
	$(".close").click(function(){
		$("#fundo_modal").hide(200);
		$("#new_user").hide(200);
		$("#change_pass").hide(200);
		$("#users").hide(200);
		$("#conteudo_modal").hide(200);
		$("#lancamentos").hide(200);
	});

	//MASKMONEY
	$("#money").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	//Criando as mascaras de valor monetario para as parcelas
	$("#money1").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	$("#money2").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	$("#money3").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	$("#money4").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	$("#money5").maskMoney({prefix:'R$', decimal:",", thousands:"."});
	$("#money6").maskMoney({prefix:'R$', decimal:",", thousands:"."});
});