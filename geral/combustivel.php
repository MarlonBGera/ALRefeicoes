<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Relatório de Fornecedor Local - Combustível</h2>
	<form method="post" class="form_producao" action="relatorio_combustivel.php" target="_blank">
		<div class="inputs">
			<div class="label_input">
				<label>Data Inicial</label>
				<input type="date" name="data_inicial_combustivel">
			</div>
			<div class="label_input">
				<label>Data Final</label>
				<input type="date" name="data_final_combustivel">
			</div>
			<div class="label_input">
				<label>Unidade de Produção</label>
				<select name="unidade_producao">
					<option disabled selected>Selecione--></option>
				<?php
				if($fetch_unidade_ativo > 0):
					do{
				?>
				<option><?=$fetch_unidade_ativo['unidade'];?></option>
				<?php
				}while($fetch_unidade_ativo = $exibir_unidade_ativo->fetch(PDO::FETCH_ASSOC));
				endif;
				?>
				</select>
			</div>
			<div class="label_input">
				<label>Fornecedor</label>
				<select name="fornecedor_combustivel">
					<option disabled selected>Selecione--></option>
				<?php
				if($fetch_combustivel > 0):
					do{
				?>
				<option><?=$fetch_combustivel['fornecedor'];?></option>
				<?php
				}while($fetch_combustivel = $exibir_combustivel->fetch(PDO::FETCH_ASSOC));
				endif;
				?>
				</select>
			</div>
			<div class="label_input">
				<label>Veículo</label>
				<select name="veiculo_combustivel">
					<option disabled selected>Selecione--></option>
				<?php
				if($fetch_veiculo > 0):
					do{
				?>
				<option><?=$fetch_veiculo['placa_veiculo'];?></option>
				<?php
				}while($fetch_veiculo = $exibir_veiculo->fetch(PDO::FETCH_ASSOC));
				endif;
				?>
				</select>
			</div>
		</div>
			<input type="submit" class="buton_submit" name="relatorio_combustivel">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>