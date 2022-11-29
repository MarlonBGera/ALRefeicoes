<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Relatório de Fornecedor Local</h2>
	<form method="post" class="form_producao" action="relatorio_local.php" target="_blank">
		<div class="inputs">
			<div class="label_input">
				<label>Data Inicial</label>
				<input type="date" name="data_inicial_local">
			</div>
			<div class="label_input">
				<label>Data Final</label>
				<input type="date" name="data_final_local">
			</div>
			<div class="label_input">
				<label>Fornecedor</label>
				<select name="fornecedor_local">
					<option disabled selected>Selecione--></option>
				<?php
				if($fetch_fornecedor_local > 0):
					do{
				?>
				<option><?=$fetch_fornecedor_local['nome_fantasia'];?></option>
				<?php
				}while($fetch_fornecedor_local = $exibir_fornecedor_local->fetch(PDO::FETCH_ASSOC));
				endif;
				?>
				</select>
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
				<label>Forma do Relatório</label>
				<select name="forma_relatorio_local">
					<option>Diários</option>
					<option>Total</option>
				</select>
			</div>
		</div>
			<input type="submit" class="buton_submit" name="relatorio_local">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>