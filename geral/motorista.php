<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Cadastro Motorista</h2>
	<form method="post" class="form_producao">
		<div class="label_input">
			<label>Nome Completo</label>
			<input type="text" name="nome_motorista">
		</div>
		<div class="label_input">
			<label>Numero da CNH</label>
			<input type="text" name="cnh_motorista">
		</div>
		<div class="label_input">
			<label>Categoria da CNH</label>
			<input type="text" name="categoria_motorista">
		</div>
		<div class="label_input">
			<label>Validade da CNH</label>
			<input type="date" name="validade_motorista">
		</div>
		<div class="label_input">
			<label>Idade do Motorista</label>
			<input type="text" name="idade_motorista">
		</div>
			<input type="submit" class="buton_submit" name="cadastro_motorista">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>