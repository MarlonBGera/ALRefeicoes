<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Fornecedor Local - Combustível</title>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
</head>
<?php
	if(!isset($_POST['relatorio_combustivel'])){
		header('Location: combustivel.php');
	}//Verificando se os input de fornecedor e unidade de produção estão marcados como Selecionar->> ou se estão em branco
	 //Caso esteja será direcionado a uma pagina de error!!!
	elseif(empty($_POST['fornecedor_combustivel']) || empty($_POST['veiculo_combustivel']) || empty($_POST['unidade_producao'])){
		header('Location: pags/error.php');
	}
	include('../pags/connect.php');

	//Verificando se a pessoa quer as informações da primeira ou segunda quinzena do mes
	//Determina a variavel de inicio de quinzena para cada escolha feita pelo cliente
	if(empty($_POST['data_inicial_combustivel'])){	
		$inicio = date('Y-m')."-01";
	}else{
		$inicio = $_POST['data_inicial_combustivel'];
	}

	if(empty($_POST['data_final_combustivel'])){
		$final = date('Y-m-t');
	}else{
		$final = $_POST['data_final_combustivel'];
	}

	//Verifica se as informações estao limpas ou nao
	//E monta a SQL dependendo de quais informações foram escolhidas pelo usuario
	$sql_busca_combustivel = "SELECT * FROM `fornecimento_local` WHERE `data_compra` BETWEEN '".$inicio."' AND '".$final."' AND `motorista_veiculo` <> '' AND `placa_veiculo` = '".$_POST['veiculo_combustivel']."' AND `fornecedor_local` = '".$_POST['fornecedor_combustivel']."' AND `unidade_producao` = '".$_POST['unidade_producao']."' ORDER BY placa_veiculo ASC";

	$sql_soma_combustivel = "SELECT SUM(total_produto) AS total_global FROM `fornecimento_local` WHERE `data_compra` BETWEEN '".$inicio."' AND '".$final."' AND `motorista_veiculo` <> '' AND `placa_veiculo` = '".$_POST['veiculo_combustivel']."' AND `fornecedor_local` = '".$_POST['fornecedor_combustivel']."' AND `unidade_producao` = '".$_POST['unidade_producao']."'";

		$select = $PDO->prepare($sql_busca_combustivel);
		$select->execute();
		$rows_select = $select->fetch(PDO::FETCH_ASSOC);

		$soma_total = $PDO->prepare($sql_soma_combustivel);
		$soma_total->execute();
		$rowssoma_total = $soma_total->fetch(PDO::FETCH_ASSOC);
		$echo_total = $rowssoma_total['total_global'];
?>
<body>
<div class="topo_relatorio">
	<div class="logo_marca"></div>
	<div class="informacoes_sistema">
		<h3>Sistema Controle Financeiro - Açailândia</h3>
		<h5 style="margin: 5px 0px 0px 0px;font-size: 15px;">Relatório de Lançamento dos Fornecedores Locais - Combustível</h5>
	</div>	
</div>
<table class="tabela_relatorio">
	<tr>
		<td colspan='7' style="font-size: 12px;border:none;">
			Relatório da <span style="font-weight: bold;"><?=$_POST['unidade_producao'];?></span> no Período de <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($inicio));?></span> a <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($final));?></span> do Veículo <span style="font-weight: bold;"><?=$_POST['veiculo_combustivel'];?></span> do Fornecedor <span style="font-weight: bold;"><?=$_POST['fornecedor_combustivel'];?></span>.
		</td>
	</tr>
	<tr style="font-weight: bold">
		<td>Dia do Abastecimento</td>
		<td>Dia da Semana</td>
		<td>Motorista</td>
		<td>KM</td>
		<td>Quantidade</td>
		<td>Consumo</td>
		<td>Combustível</td>
		<td>Valor Unitário</td>
		<td>Valor Total</td>
	</tr>
<?php
	if($rows_select > 0){
		do{
			if(date('l', strtotime($rows_select['data_compra'])) == "Monday"){
				$semana = "Segunda-Feira";
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Tuesday"){
				$semana = "Terça-Feira";			
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Wednesday"){
				$semana = "Quarta-Feira";			
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Thursday"){
				$semana = "Quinta-Feira";			
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Friday"){
				$semana = "Sexta-Feira";			
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Saturday"){
				$semana = "Sábado";			
			}elseif(date('l', strtotime($rows_select['data_compra'])) == "Sunday"){
				$semana = "Domingo";			
			}else{
				echo "Dia da semana não disponivel!";
			};
?>
	<tr>
		<td style="text-align: center;"><?=date('d/m/Y',strtotime($rows_select['data_compra']));?></td>
		<td style="text-align: center;"><?=$semana;?></td>
		<td style="text-align: center;"><?=$rows_select['motorista_veiculo'];?></td>
		<td style="text-align: center;"><?=$rows_select['km_veiculo'];?></td>
		<td style="text-align: center;"><?=$rows_select['quantidade'];?></td>
		<td style="text-align: center;"><?=number_format($rows_select['consumo_combustivel'],2,',','.');?></td>
		<td style="text-align: center;"><?=$rows_select['produto_local'];?></td>
		<td style="text-align: center;"><?=number_format($rows_select['valor_unitario'],2,',','.');?></td>
		<td style="text-align: center;"><?=number_format($rows_select['total_produto'],2,',','.');?></td>
	</tr>
<?php
		}while($rows_select = $select->fetch(PDO::FETCH_ASSOC));
	}else{
		echo "<tr><td colspan='11' style='text-align: center;'>Não há nenhuma informação deste veículo.</td></tr>";
	};
?>
	<tr>
		<td colspan='8' style="text-align: right;font-weight: bold;">TOTAL:</td>
		<td style="text-align: center;font-weight: bold;"><?=number_format($echo_total,2,',','.');?></td>
	</tr>
</table>
</body>
</html>