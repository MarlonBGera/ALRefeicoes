<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Lançamento Fornecedor Local</h2>
	<div>
		<a href="lancamentos_local.php" target="_blank"><div class="botao_visualizar">Verificar Lançamentos</div></a>
	</div>
	<form method="post" class="form_producao">
		<div class="inputs">
			<!-- Buscando a unidade de produção -->
			<div class="label_input">
				<label>Unidade de Produção</label>
				<select name="unidade_producao_local">
					<option selected disabled>Selecione --></option>
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
			<!-- Data da compra do produto -->
			<div class="label_input">
				<label>Data da Compra</label>
				<input type="date" name="data_compra_local" id="data_compra_local">
			</div>
			<!-- Buscando o produto -->
			<div class="label_input">
				<label>Fornecedor</label>
				<select name="fornecedor_local" id="fornecedor_local" onblur="getDados()">
					<option selected disabled>Selecione --></option>
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
			<!-- Buscando o produto -->
			<div class="label_input">
				<label>Produto</label>
				<select name="produto_local" id="produto_local" onblur="dados()">
					<option selected disabled>Selecione --></option>
				</select>
				<input type="hidden" name="pergunta_combustivel" id="pergunta_combustivel">
			</div>
			<!-- Quantidade a ser comprada -->
			<div class="label_input">
				<label>Quantidade</label>
				<input type="number" name="quantidade_local" id="quantidade_local" step="0.01">
				<input type="hidden" name="valor_produto" id="valor_produto">
			</div>
			<!-- Div que será mostrado caso seja combustivel -->
			<div id="combustivel" style="display: none;">
				<div class="label_input">
					<label>Motorista</label>
					<input type="text" name="motorista_combustivel">
				</div>
				<div class="label_input">
					<label>Placa do Veículo</label>
					<input type="text" name="veiculo_combustivel" id="veiculo_combustivel" onblur="km()">
				</div>
				<div class="label_input">
					<label>KM do Veículo</label>
					<input type="number" name="km_combustivel" id="km_combustivel">
				</div>
					<input type="hidden" name="km_antigo" id="km_antigo">
					<input type="hidden" name="consumo_combustivel" id="consumo_combustivel" readonly>
			</div>
		</div>
		<!-- Botao -->
			<input type="submit" class="buton_submit" name="cadastro_local">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>