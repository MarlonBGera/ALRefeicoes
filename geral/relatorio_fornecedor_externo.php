<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Relatório de Fornecedor Externo</h2>
	<form method="post" class="form_producao" action="relatorio_externo.php" target="_blank">
		<div class="inputs">
			<div class="label_input">
				<label>Data Inicial</label>
				<input type="date" name="data_inicial_externo">
			</div>
			<div class="label_input">
				<label>Data Final</label>
				<input type="date" name="data_final_externo">
			</div>
			<div class="label_input">
				<label>Fornecedor</label>
				<select name="fornecedor_externo">
					<option disabled selected>Selecione--></option>
				<?php
				if($fetch_fornecedor_externo > 0):
					do{
				?>
				<option><?=$fetch_fornecedor_externo['nome_fantasia'];?></option>
				<?php
				}while($fetch_fornecedor_externo = $exibir_fornecedor_externo->fetch(PDO::FETCH_ASSOC));
				endif;
				?>
				</select>
			</div>
			<div class="label_input">
				<label>Forma do Relatório</label>
				<select name="forma_relatorio_externo">
					<option>Diários</option>
					<option>Total</option>
				</select>
			</div>
		</div>
			<input type="submit" class="buton_submit" name="relatorio_externo">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>