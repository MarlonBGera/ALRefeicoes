<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Lançamento Fornecedor Externo</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">
</head>
<?php
	//Conectando ao banco de dados e as funções do sistema!!
	include('../pags/connect.php');
	include('../pags/funcoes.php');

	//Verificando se há algum usuario logado.
	//Caso não haja redireciona para a pagina de error!!!
	if((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)):
	unset($_SESSION['login']);
	unset($_SESSION['senha']);
	header('Location: ../pags/404.php');
	endif;
?>
<body style="text-align: center;">
<div class="topo_relatorio">
	<div class="logo_marca"></div>
	<div class="informacoes_sistema">
		<h3>A.L. Refeições Coletivas</h3>
		<h5 style="margin: 5px 0px 0px 0px;font-size: 15px;">Relatório de Fornecedores</h5>
	</div>	
</div>
<table class="tabela_relatorio">
	<tr style="font-weight: bold;">
		<td>Razão Social</td>
		<td>Nome Fantasia</td>
		<td>Tipo de Fornecedor</td>
		<td>CNPJ</td>
		<td>Inscrição Estadual</td>
		<td>Endereço</td>
		<td>E-mail</td>
		<td>Contato</td>
		<td>Telefone</td>
		<td>Contato</td>
		<td>Telefone</td>
		<td>Contato</td>
		<td>Telefone</td>
		<td>Ativo?</td>
	</tr>
<?php
	if($fetch_fornecedor > 0){
		do{
?>
	<tr>
		<td>
			<?php if(!empty($fetch_fornecedor['razao_social'])){echo $fetch_fornecedor['razao_social'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['nome_fantasia'])){echo $fetch_fornecedor['nome_fantasia'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['tipo_fornecedor'])){echo $fetch_fornecedor['tipo_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['cnpj_fornecedor'])){echo $fetch_fornecedor['cnpj_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['inscricao_estadual'])){echo $fetch_fornecedor['inscricao_estadual'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['endereco_fornecedor'])){echo $fetch_fornecedor['endereco_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['email_fornecedor'])){echo $fetch_fornecedor['email_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['contato1_fornecedor'])){echo $fetch_fornecedor['contato1_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['telefone1_fornecedor'])){echo $fetch_fornecedor['telefone1_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['contato2_fornecedor'])){echo $fetch_fornecedor['contato2_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['telefone2_fornecedor'])){echo $fetch_fornecedor['telefone2_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['contato3_fornecedor'])){echo $fetch_fornecedor['contato3_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if(!empty($fetch_fornecedor['telefone3_fornecedor'])){echo $fetch_fornecedor['telefone3_fornecedor'];}else{echo "-";};?>
		</td>
		<td>
			<?php if($fetch_fornecedor['status']="1"){echo "Sim";}else{echo "Não";};?>
		</td>
	</tr>
<?php
		}while($fetch_fornecedor = $exibir_fornecedor->fetch(PDO::FETCH_ASSOC));
	};
?>
	<tr>
		<td colspan='14' style="text-align: right; border:none;">Criado por Marlon Breno Gera</td>
	</tr>
</table>
</body>
</html>