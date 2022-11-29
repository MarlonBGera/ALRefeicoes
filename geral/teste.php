<link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
<div class="topo_relatorio">
	<img src="assets/img/logo.jpg" class="logo_relatorio"></img>
	<div class="titulo_relatorio">Pitty Cafeteria - Restaurant</div>
	<div class="social_relatorio">de Evane Lenz Bartomeu</div>
	<div class="info_topo_relatorio">Desayuno - Buffet - Marmitex - Alquiler de Local</div>
	<div class="info_topo_relatorio">Servicios para Eventos (Baby Shower, Coffee Break)</div>
	<div class="info_topo_relatorio">Copetin - Otros servicios personales no especificados</div>
	<div class="info_topo_relatorio">Restaurantes, Bares y Cantinas</div>
</div>
<div class="endereco_relatorio">
	Km. 3½ - Calle Sauces frente a la Fiscalía de CDE detrás de Personal<br>
	Whatsapp: (0981) 697 266 - Cel.: (0984) 332 448 - Ciudad del Este - Paraguay
</div>
<?php
	require_once('config/conexao.php');
		//SQL PARA PUXAR TODAS AS INFORMAÇÕES CASO A DATA INICIAL SEJA PREENCHIDA E O RESTO EM BRANCO.
		$sql_menordata = "SELECT min(data) AS menor_data FROM entrada_caixa";
		$menor_data = $PDO->prepare($sql_menordata);
		$menor_data->execute();
		$menordata = $menor_data->fetch(PDO::FETCH_ASSOC);
		$echo_menordata = $menordata['menor_data'];

		$sql_maiordata = "SELECT max(data) AS maior_data FROM entrada_caixa";
		$maior_data = $PDO->prepare($sql_maiordata);
		$maior_data->execute();
		$maiordata = $maior_data->fetch(PDO::FETCH_ASSOC);
		$echo_maiordata = $maiordata['maior_data'];
		
		$sql_clientesindb = "SELECT * FROM entrada_caixa";
		$clientedb = $PDO->prepare($sql_clientesindb);
		$clientedb->execute();
		$clienteindb = $clientedb->fetch(PDO::FETCH_ASSOC);

	if(isset($_POST['pesquisa_entrada'])){

		if(empty($_POST['entrada_inicio'])){
			$entrada_inicio = $menordata['menor_data'];
		}else{
			$entrada_inicio = $_POST['entrada_inicio'];
		};

		if(empty($_POST['entrada_final'])){
			$entrada_final = $maiordata['maior_data'];
		}else{
			$entrada_final = $_POST['entrada_final'];
		};

		if(empty($_POST['entrada_pagamento'])){
			$entrada_pagamento = 0;
		}else{
			$entrada_pagamento = $_POST['entrada_pagamento'];
		};

		if(empty($_POST['entrada_cliente'])){
			$entrada_cliente = 0;
		}else{
			$entrada_cliente = $_POST['entrada_cliente'];
		};

		if($entrada_pagamento == '0' && $entrada_cliente == '0'){
			//SQL PARA SELECIONAR A EXIBIÇÃO
			$sql_select = "SELECT * FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' ORDER BY `data` ASC";
			//SQL PARA CALCULAR O VALOR A SER PUXADO
			$sqlsoma_total = "SELECT SUM(total) AS total_global FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."'";

		}elseif ($entrada_pagamento !== '0' && $entrada_cliente == '0') {
			//SQL PARA SELECIONAR A EXIBIÇÃO
			$sql_select = "SELECT * FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `pagamento` = '".$entrada_pagamento."' ORDER BY `data` ASC";
			//SQL PARA CALCULAR O VALOR A SER PUXADO
			$sqlsoma_total = "SELECT SUM(total) AS total_global FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `pagamento` = '".$entrada_pagamento."'";

		}elseif ($entrada_pagamento == '0' && $entrada_cliente !== '0') {
			//SQL PARA SELECIONAR A EXIBIÇÃO
			$sql_select = "SELECT * FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `cliente` = '".$entrada_cliente."' ORDER BY `data` ASC";
			//SQL PARA CALCULAR O VALOR A SER PUXADO
			$sqlsoma_total = "SELECT SUM(total) AS total_global FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `cliente` = '".$entrada_cliente."'";

		}elseif ($entrada_pagamento !== '0' && $entrada_cliente !== '0') {
			//SQL PARA SELECIONAR A EXIBIÇÃO
			$sql_select = "SELECT * FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `pagamento` = '".$entrada_pagamento."' AND `cliente` = '".$entrada_cliente."' ORDER BY `data` ASC";
			//SQL PARA CALCULAR O VALOR A SER PUXADO
			$sqlsoma_total = "SELECT SUM(total) AS total_global FROM entrada_caixa WHERE `data` BETWEEN '".$entrada_inicio."' AND '".$entrada_final."' AND `pagamento` = '".$entrada_pagamento."' AND `cliente` = '".$entrada_cliente."'";

		}else{
			echo "<br><br>deu errado";
		};
			$select = $PDO->prepare($sql_select);
			$select->execute();
			$rows_select = $select->fetch(PDO::FETCH_ASSOC);

			$soma_total = $PDO->prepare($sqlsoma_total);
			$soma_total->execute();
			$rowssoma_total = $soma_total->fetch(PDO::FETCH_ASSOC);
			$echosoma_total = $rowssoma_total['total_global'];
?>
				<table class="table_entrada">
					<tr>
						<td colspan="9" class="titulo_tabela"><span>Fecha Inicio: <?=date('d/m/Y',strtotime($entrada_inicio));?>; Fecha Final: <?=date('d/m/Y',strtotime($entrada_final));?>; Pago: <?php if($entrada_pagamento == '0'){echo "Toda la información";}else{echo $entrada_pagamento;}?>; Cliente: <?php if($entrada_cliente == '0'){echo "Toda la información";}else{echo $entrada_cliente;}?>. </span></td>
					</tr>
					<tr>
						<td class="primeiro_td">Recibo</td>
						<td class="primeiro_td">La Fecha</td>
						<td class="primeiro_td">Mercaderías Y/O Servicios</td>
						<td class="primeiro_td">Pago</td>
						<td class="primeiro_td">Cliente</td>
						<td class="primeiro_td">Cantidad</td>
						<td class="primeiro_td">Valor Unitario</td>
						<td class="primeiro_td">Descuento</td>
						<td class="primeiro_td">Total</td>
					</tr>
					<?php
						if($rows_select > 0){
							do{
					?>
					<tr>
						<td class="segundo_td"><?=$rows_select['recibo'];?></td>
						<td class="segundo_td"><?=date('d/m/Y',strtotime($rows_select['data']));?></td>
						<td class="segundo_td"><?=$rows_select['item'];?></td>
						<td class="segundo_td"><?=$rows_select['pagamento'];?></td>
						<td class="segundo_td"><?=$rows_select['cliente'];?></td>
						<td class="segundo_td"><?=$rows_select['quantidade'];?></td>
						<td class="segundo_td"><?="Gs ".number_format($rows_select['val_unit'],2,',','.');?></td>
						<td class="segundo_td"><?="Gs ".number_format($rows_select['desconto'],2,',','.');?></td>
						<td class="segundo_td"><?="Gs ".number_format($rows_select['total'],2,',','.');?></td>
					</tr>
			<?php
						}while($rows_select = $select->fetch(PDO::FETCH_ASSOC));
						}else{
							echo "<tr><td colspan='9'>No hay información con estos parámetros!</td></tr>";
						};
			?>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td class="segundo_td">TOTAL</td>
						<td class="segundo_td"><?="Gs ".number_format($echosoma_total,2,',','.');?></td>
					</tr>
				</table>
<?php
		};
		if(isset($_POST['pesquisa_saida'])){
			//VERIFICANDO SE AS DATAS ESTÃO EM BRANCO;
			if(empty($_POST['saida_inicio'])){
				$saida_inicio = $menordata['menor_data'];
			}else{
				$saida_inicio = $_POST['saida_inicio'];
			}

			if(empty($_POST['saida_final'])){
				$saida_final = $maiordata['maior_data'];
			}else{
				$saida_final = $_POST['saida_final'];
			}

			//SQL PARA BUSCAR INFORMAÇÕES
			$sql_select = "SELECT * FROM saida_caixa WHERE `data` BETWEEN '".$saida_inicio."' AND '".$saida_final."' ORDER BY `data` ASC";
			$sqlsoma_total = "SELECT SUM(total) AS total_global FROM saida_caixa WHERE `data` BETWEEN '".$saida_inicio."' AND '".$saida_final."'";
			//EXECUTANDO SQL ACIMA
			$select = $PDO->prepare($sql_select);
			$select->execute();
			$rows_select = $select->fetch(PDO::FETCH_ASSOC);

			$soma_total = $PDO->prepare($sqlsoma_total);
			$soma_total->execute();
			$rowssoma_total = $soma_total->fetch(PDO::FETCH_ASSOC);
			$echosoma_total = $rowssoma_total['total_global'];

?>
	<table class="table_entrada">
		<tr>
			<td colspan="9" class="titulo_tabela"><span>Fecha Inicio: <?=date('d/m/Y',strtotime($saida_inicio));?>; Fecha Final: <?=date('d/m/Y',strtotime($saida_final));?>.</span></td>
		</tr>
		<tr>
			<td class="primeiro_td">Recibo</td>
			<td class="primeiro_td">Proveedor</td>
			<td class="primeiro_td">Mercaderías Y/O Servicios</td>
			<td class="primeiro_td">La Fecha</td>
			<td class="primeiro_td">Cantidad</td>
			<td class="primeiro_td">Valor Unitario</td>
			<td class="primeiro_td">Total</td>
		</tr>
		<?php
			if($rows_select > 0){
				do{
		?>
		<tr>
			<td class="segundo_td"><?=$rows_select['recibo'];?></td>
			<td class="segundo_td"><?=$rows_select['fornecedor'];?></td>
			<td class="segundo_td"><?=$rows_select['item'];?></td>
			<td class="segundo_td"><?=date('d/m/Y',strtotime($rows_select['data']));?></td>
			<td class="segundo_td"><?=$rows_select['quantidade'];?></td>
			<td class="segundo_td"><?="Gs ".number_format($rows_select['val_unit'],2,',','.');?></td>
			<td class="segundo_td"><?="Gs ".number_format($rows_select['total'],2,',','.');?></td>
		</tr>
		<?php
				}while($rows_select = $select->fetch(PDO::FETCH_ASSOC));
			}else{
				echo "<tr><td colspan='9'>No hay información con estos parámetros!</td></tr>";
			}
		?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td class="segundo_td">TOTAL</td>
			<td class="segundo_td"><?="Gs ".number_format($echosoma_total,2,',','.');?></td>
		</tr>
	</table>
<?php
};
?>

