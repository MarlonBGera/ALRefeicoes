<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Cadastro Veículo</h2>
	<form method="post" class="form_producao">
		<div class="label_input">
			<label>Descrição Veículo</label>
			<input type="text" name="descricao_veiculo">
		</div>
		<div class="label_input">
			<label>Placa</label>
			<input type="text" name="placa_veiculo">
		</div>
		<div class="label_input">
			<label>KM Atual</label>
			<input type="text" name="km_veiculo">
		</div>
		<div class="label_input">
			<label>Proprietário do Veículo</label>
			<select name="proprietario_veiculo">
				<option selected disabled>Selecione --></option>
				<option>Locadora</option>
				<option>Próprio</option>
			</select>
		</div>
		<div class="label_input">
			<label>RENAVAN</label>
			<input type="text" name="renavan_veiculo">
		</div>
		<div class="label_input">
			<label>Consumo Ideal</label>
			<input type="text" name="consumo_veiculo">
		</div>
			<input type="submit" class="buton_submit" name="cadastro_veiculo">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>