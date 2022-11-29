<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Lançamento Fornecedor Local</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">
</head>
<?php
	if(!isset($_POST['relatorio_local'])){
		header('Location: relatorio_fornecedor_local.php');
	}//Verificando se os input de fornecedor e unidade de produção estão marcados como Selecionar->> ou se estão em branco
	 //Caso esteja será direcionado a uma pagina de error!!!
	elseif(empty($_POST['fornecedor_local']) || empty($_POST['unidade_producao'])){
		header('Location: ../pags/404.php');
	}
include('../pags/connect.php');

	//Determinando uma data de inicio e fim para a busca
	//Caso Data inicial e final esteja em branco
	$inicio_mes = date('Y-m')."-01";
	$final_mes = date('Y-m-t');

	//Verificando se o valor de data inicial foi preenchido.
	//Caso nao tenha sido preenchido jogamos o valor do primeido dia do mes.
	if(empty($_POST['data_inicial_local'])){
		$inicio_local = $inicio_mes;
	}else{
		$inicio_local = $_POST['data_inicial_local'];
	};
	//Verificando se o valor da data final foi preenchido.
	//Caso nao tenha sido preenchido jogamos o valor do ultimo dia do mes.
	if(empty($_POST['data_final_local'])){
		$final_local = $final_mes;
	}else{
		$final_local = $_POST['data_final_local'];
	};

	//SQL QUE SELECIONA TODOS OS DADOS DO BANCO PARA EXIBIÇÃO.
	//CASO TENHA SIDO ESCOLHIDO ALGUM FORNECEDOR.
	$sql_relatorio_local = "SELECT * FROM fornecimento_local WHERE `data_compra` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `fornecedor_local` = '".$_POST['fornecedor_local']."' AND `unidade_producao` = '".$_POST['unidade_producao']."' ORDER BY `data_compra` ASC";
	//SQL QUE SELECIONA TODOS OS VALORES PARA CALCULAR O TOTAL.
	$sqlsoma_total = "SELECT SUM(total_produto) AS total_global FROM fornecimento_local WHERE `data_compra` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `fornecedor_local` = '".$_POST['fornecedor_local']."' AND `unidade_producao` = '".$_POST['unidade_producao']."'";

		$relatorio_local = $PDO->prepare($sql_relatorio_local);
		$relatorio_local->execute();
		$exibir_relatorio_local = $relatorio_local->fetch(PDO::FETCH_ASSOC);

		$soma_total_local = $PDO->prepare($sqlsoma_total);
		$soma_total_local->execute();
		$total_local = $soma_total_local->fetch(PDO::FETCH_ASSOC);
		$echo_total_local = $total_local['total_global'];

?>
<body style="text-align: center;">
<div class="topo_relatorio">
	<div class="logo_marca"></div>
	<div class="informacoes_sistema">
		<h3>Sistema Controle Financeiro - Açailândia</h3>
		<h5 style="margin: 5px 0px 0px 0px;font-size: 15px;">Relatório de Lançamento dos Fornecedores Locais</h5>
	</div>	
</div>
<table class="tabela_relatorio">
	<tr>
		<td colspan='7' style="font-size: 12px;border:none; text-align: left;">
			Relatório da <span style="font-weight: bold;"><?=$_POST['unidade_producao'];?></span> no Período de <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($inicio_local));?></span> a <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($final_local));?></span> do Fornecedor <span style="font-weight: bold;"><?=$_POST['fornecedor_local'];?></span>.
		</td>
	</tr>
<?php
	if($_POST['forma_relatorio_local'] == "Diários"){
?>
	<tr style="text-align: center; font-weight: bolder;">
		<td>Data da Compra</td>
		<td>Dia da Semana</td>
		<td>Produto</td>
		<td>Pago?</td>
		<td>Quantidade</td>
		<td>Valor Unitário</td>
		<td>Valor Total</td>
	</tr>
<?php
		if($exibir_relatorio_local > 0){
			do{
				//Buscando o dia da semana para o relatorio.
				if(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Monday"){
					$semana = "SEG";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Tuesday"){
					$semana = "TER";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Wednesday"){
					$semana = "QUA";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Thursday"){
					$semana = "QUI";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Friday"){
					$semana = "SEX";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Saturday"){
					$semana = "SAB";
				}elseif(date('l', strtotime($exibir_relatorio_local['data_compra'])) == "Sunday"){
					$semana = "DOM";
				}else{
					echo "Dia da semana não disponivel!";
				};
?>
	<tr>
		<td><?=date('d/m/Y',strtotime($exibir_relatorio_local['data_compra']));?></td>
		<td><?=$semana;?></td>
		<td><?=$exibir_relatorio_local['produto_local'];?></td>
		<td><?php if($exibir_relatorio_local['pago']){echo "Sim";}else{echo "Não";};?></td>
		<td><?=$exibir_relatorio_local['quantidade'];?></td>
		<td><?=number_format($exibir_relatorio_local['valor_unitario'],2,',','.');?></td>
		<td><?=number_format($exibir_relatorio_local['total_produto'],2,',','.');?></td>
	</tr>
<?php
			}while($exibir_relatorio_local = $relatorio_local->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "<tr><td colspan='8' style='text-align: center;'>Não possui dados cadastrado!</td></tr>";
		};
?>
	<tr>
		<td colspan='6' style="text-align: right;font-weight: bold;">TOTAL:</td>
		<td style="text-align: center;font-weight: bold;"><?=number_format($echo_total_local,2,',','.');?></td>
	</tr>
	<tr>
		<td colspan='7' style="text-align: right; border:none;">Criado por Marlon Breno Gera</td>
	</tr>
<?php
	}elseif($_POST['forma_relatorio_local'] == "Total"){
?>
	<tr style="text-align: center; font-weight: bolder;">
		<td>Unidade de Produção</td>
		<td>Fornecedor</td>
		<td>Pago?</td>
		<td>Valor Total</td>
	</tr>
<?php
		if($exibir_relatorio_local > 0){
			do{
?>
	<tr>
		<td><?=$exibir_relatorio_local['unidade_producao'] ;?></td>
		<td><?=$exibir_relatorio_local['fornecedor_local'] ;?></td>
		<td><?php if($exibir_relatorio_local['pago']){echo "Sim";}else{echo "Não";};?></td>
		<td><?="R$".number_format($exibir_relatorio_local['total_produto'],2,',','.');?></td>
	</tr>
<?php
			}while($exibir_relatorio_local = $relatorio_local->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "<tr><td colspan='4' style='text-align: center;'>Não possui dados cadastrado!</td></tr>";
		};
?>
	<tr>
		<td colspan='3' style="text-align: right;font-weight: bold;">TOTAL:</td>
		<td style="text-align: center;font-weight: bold;"><?="R$".number_format($echo_total_local,2,',','.');?></td>
	</tr>
	<tr>
		<td colspan='4' style="text-align: right; border:none;">Criado por Marlon Breno Gera</td>
	</tr>
<?php
	}else{
		header("Location: relatorio_fornecedor_local.php");
	};
?>
</table>
</body>
</html>