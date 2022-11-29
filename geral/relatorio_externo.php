<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Lançamento Fornecedor Externo</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">
</head>
<?php
	if(!isset($_POST['relatorio_externo'])){
		header('Location: relatorio_fornecedor_externo.php');
	}//Verificando se o input de fornecedor está marcado como Selecionar->> ou se estão em branco
	 //Caso esteja será direcionado a uma pagina de error!!!
	elseif(empty($_POST['fornecedor_externo'])){
		header('Location: ../pags/404.php');
	}
	include('../pags/connect.php');
	//Determinando uma data de inicio e fim para a busca
	//Caso Data inicial e final esteja em branco
	$inicio_mes = date('Y-m')."-01";
	$final_mes = date('Y-m-t');

	//Verificando se o valor de data inicial foi preenchido.
	//Caso nao tenha sido preenchido jogamos o valor do primeido dia do mes.
	if(empty($_POST['data_inicial_externo'])){
		$inicio_local = $inicio_mes;
	}else{
		$inicio_local = $_POST['data_inicial_externo'];
	};

	//Verificando se o valor da data final foi preenchido.
	//Caso nao tenha sido preenchido jogamos o valor do ultimo dia do mes.
	if(empty($_POST['data_final_externo'])){
		$final_local = $final_mes;
	}else{
		$final_local = $_POST['data_final_externo'];
	};

	//Verificando se foi escolhido fornecedor foi escolhido
	//Caso nao seja será utilizado todos os fornecedores cadastrados.
	if(empty($_POST['fornecedor_externo'])){
		//SQL QUE SELECIONA TODOS OS DADOS DO BANCO PARA EXIBIÇÃO.
		//CASO NAO TENHA SIDO ESCOLHIDO NENHUM FORNECEDOR
		//IRÁ PEGAR TODOS OS FORNECEDORES ENTRE A DATA DE INICIO E FIM.
		$sql_relatorio_externo = "SELECT * FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."' ORDER BY `data_emissao` ASC";
		//SQL QUE SELECIONA TODOS OS VALORES PARA CALCULAR O TOTAL.
		$sqlsoma_total = "SELECT SUM(valor_total) AS total_global FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `forma_pagamento` <> 'aprazo'";
		$sqlsoma_parcela = "SELECT SUM(valor_unico) AS valor_parcelas FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."'";
	}else{
		//SQL QUE SELECIONA TODOS OS DADOS DO BANCO PARA EXIBIÇÃO.
		//CASO TENHA SIDO ESCOLHIDO ALGUM FORNECEDOR.
		$sql_relatorio_externo = "SELECT * FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `fornecedor_externo` = '".$_POST['fornecedor_externo']."' ORDER BY `data_emissao` ASC";
		//SQL QUE SELECIONA TODOS OS VALORES PARA CALCULAR O TOTAL.
		$sqlsoma_total = "SELECT SUM(valor_total) AS total_global FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `forma_pagamento` <> 'aprazo' AND `fornecedor_externo` = '".$_POST['fornecedor_externo']."'";
		$sqlsoma_parcela = "SELECT SUM(valor_unico) AS valor_parcelas FROM fornecimento_externo WHERE `data_emissao` BETWEEN '".$inicio_local."' AND '".$final_local."' AND `fornecedor_externo` = '".$_POST['fornecedor_externo']."'";
	};
	$relatorio_externo = $PDO->prepare($sql_relatorio_externo);
	$relatorio_externo->execute();
	$exibir_relatorio_externo = $relatorio_externo->fetch(PDO::FETCH_ASSOC);

	$soma_parcela_externo = $PDO->prepare($sqlsoma_parcela);
	$soma_parcela_externo->execute();
	$parcela_externo = $soma_parcela_externo->fetch(PDO::FETCH_ASSOC);
	$echo_parcela_externo = $parcela_externo['valor_parcelas'];

	$soma_total_externo = $PDO->prepare($sqlsoma_total);
	$soma_total_externo->execute();
	$total_externo = $soma_total_externo->fetch(PDO::FETCH_ASSOC);
	$echo_total_externo = $total_externo['total_global'];
?>
<body style="text-align: center;">
<div class="topo_relatorio">
	<div class="logo_marca"></div>
	<div class="informacoes_sistema">
		<h3>Sistema Controle Financeiro - Açailândia</h3>
		<h5 style="margin: 5px 0px 0px 0px;font-size: 15px;">Relatório de Lançamento dos Fornecedores Externo</h5>
	</div>	
</div>
<table class="tabela_relatorio">
	<tr>
		<td colspan='7' style="font-size: 12px;border:none; text-align: left;">
			Relatório do Fornecedor <span style="font-weight: bold;"><?=$_POST['fornecedor_externo'];?></span> no Período de <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($inicio_local));?></span> a <span style="font-weight: bold;"><?=date('d/m/Y',strtotime($final_local));?>
		</td>
	</tr>
<?php
	if($_POST['forma_relatorio_externo'] == "Diários"){
?>
	<tr style="font-weight: bold;">
		<td>Nº Nota Fiscal</td>
		<td>Data de Emissão</td>
		<td>Data da Semana</td>
		<td>Fornecedor</td>
		<td>Valor Total</td>
		<td>Forma de Pagamento</td>
		<td>Modo de Pagamento</td>
		<td>Data de Pagamento</td>
		<td>Pago?</td>
		<td>Parcela</td>
		<td>Valor Parcela</td>
	</tr>
<?php
		if($exibir_relatorio_externo > 0){
			do{
				//Buscando o dia da semana para o relatorio.
				if(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Monday"){
					$semana = "SEG";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Tuesday"){
					$semana = "TER";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Wednesday"){
					$semana = "QUA";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Thursday"){
					$semana = "QUI";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Friday"){
					$semana = "SEX";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Saturday"){
					$semana = "SAB";
				}elseif(date('l', strtotime($exibir_relatorio_externo['data_emissao'])) == "Sunday"){
					$semana = "DOM";
				}else{
					echo "Dia da semana não disponivel!";
				};
?>
	<tr>
		<td><?=$exibir_relatorio_externo['nota_fiscal'];?></td>
		<td><?=date('d/m/Y',strtotime($exibir_relatorio_externo['data_emissao']));?></td>
		<td><?=$semana;?></td>
		<td><?=$exibir_relatorio_externo['fornecedor_externo'];?></td>
		<td><?="R$".number_format($exibir_relatorio_externo['valor_total'],2,',','.');?></td>
		<td style='text-align: center;'>
			<?php 
				if($exibir_relatorio_externo['forma_pagamento'] == "antecipado"){
					echo "Antecipado";
				}elseif($exibir_relatorio_externo['forma_pagamento'] == "avista"){
					echo "À Vista";
				}elseif($exibir_relatorio_externo['forma_pagamento'] == "aprazo"){
					echo "A Prazo";
				}else{
					echo "Não encontrado";
				};
			?>
		</td>
		<?php 
			if($exibir_relatorio_externo['forma_pagamento'] == "antecipado"){
				echo "<td>".$exibir_relatorio_externo['forma_antecipado']."</td>";
			}elseif($exibir_relatorio_externo['forma_pagamento'] == "avista"){
				echo "<td>".$exibir_relatorio_externo['forma_avista']."</td>";
			}else{
				echo "<td style='text-align: center;'>-</td>";
			};
		?>
		<?php 
			if($exibir_relatorio_externo['forma_pagamento'] == "antecipado"){
				echo "<td>".date('d/m/Y',strtotime($exibir_relatorio_externo['data_unico']))."</td>";
			}elseif($exibir_relatorio_externo['forma_pagamento'] == "avista"){
				echo "<td>".date('d/m/Y',strtotime($exibir_relatorio_externo['data_unico']))."</td>";
			}elseif($exibir_relatorio_externo['forma_pagamento'] == "aprazo"){
				echo "<td>".date('d/m/Y',strtotime($exibir_relatorio_externo['data_unico']))."</td>";
			}
		?>
		<td><?php if($exibir_relatorio_externo['pago'] == "1"){echo "Sim";}else{echo "Não";};?></td>
		<?php
			if($exibir_relatorio_externo['forma_pagamento'] == "aprazo"){
				echo "<td>".$exibir_relatorio_externo['parcela']."</td>";
			}else{
				echo "<td style='text-align: center;'>-</td>";
			};
		?>
		<?php
			if($exibir_relatorio_externo['forma_pagamento'] == "aprazo"){
				echo "<td>R$".number_format($exibir_relatorio_externo['valor_unico'],2,',','.')."</td>";
			}else{
				echo "<td style='text-align: center;'>-</td>";
			};
		?>
	</tr>
<?php
			}while($exibir_relatorio_externo = $relatorio_externo->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "<tr><td colspan='11'>Não tem nenhum dado cadastrado!</td></tr>";
		};
?>
	<tr>
		<td colspan='4' style="text-align: right;font-weight: bold;">TOTAL:</td>
		<td style="text-align: center;font-weight: bold;"><?="R$".number_format($echo_total_externo+$echo_parcela_externo,2,',','.');?></td>
		<td colspan='5' style="text-align: right;font-weight: bold;">TOTAL PARCELAS:</td>
		<td style="text-align: center;font-weight: bold;"><?="R$".number_format($echo_parcela_externo,2,',','.');?></td>
	</tr>
<?php
	}elseif($_POST['forma_relatorio_externo'] == "Total"){
?>
	<tr style="font-weight: bold;">
		<td>Nº Nota Fiscal</td>
		<td>Fornecedor</td>
		<td>Parcelado?</td>
		<td>Valor Total</td>
	</tr>
<?php
		if($exibir_relatorio_externo > 0){
			do{
?>	
	<tr>
		<td><?=$exibir_relatorio_externo['nota_fiscal'];?></td>
		<td><?=$exibir_relatorio_externo['fornecedor_externo'];?></td>
		<td><?php if($exibir_relatorio_externo['parcela'] == 0){echo "Não";}else{echo $exibir_relatorio_externo['parcela'];};?></td>
		<td><?php if($exibir_relatorio_externo['parcela'] == 0){echo $exibir_relatorio_externo['valor_total'];}else{echo $exibir_relatorio_externo['valor_unico'];};?></td>
	</tr>
<?php
			}while($exibir_relatorio_externo = $relatorio_externo->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "<tr><td colspan='4'>Não tem nenhum dado cadastrado!</td></tr>";
		};
?>
	<tr>
		<td colspan='3' style="text-align: right;font-weight: bold;">TOTAL:</td>
		<td style="text-align: center;font-weight: bold;"><?="R$".number_format($echo_total_externo+$echo_parcela_externo,2,',','.');?></td>
	</tr>
<?php
	}else{
		header("Location: relatorio_fornecedor_local.php");
	};
?>
	<tr>
		<td colspan='10' style="text-align: right; border:none;">Criado por Marlon Breno Gera</td>
	</tr>
</table>
</body>
</html>