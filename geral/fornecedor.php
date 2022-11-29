<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Cadastro de Fornecedor</h2>
	<div>
		<div class="botao_visualizar" id="fornecedores_cadastrados">Verificar Cadastrados</div>
	</div>
	<div id="conteudo_modal">
		<div class="cabecalho_modal">
			<div class="cabecalho">Fornecedores Cadastrados</div>
			<div class="close">X</div>
		</div>
		<div class="ativo_users">
			<div class="cabecalho_atualizar" style="width: 633px;">
				<div class="div_cabecalho_atualizar_especial">Tipo</div>
				<div class="div_cabecalho_atualizar">Fornecedor</div>
				<div class="div_cabecalho_atualizar">CNPJ</div>
				<div class="div_cabecalho_atualizar_acao">Ativo?</div>
				<div class="div_cabecalho_atualizar_acao">Ação</div>
			</div>
			<?php
				if($fetch_fornecedor > 0){
					do{
						if(isset($_POST['atualizar_fornecedor'.$fetch_fornecedor['id']])){
							$ativo_new = $_POST['fornecedor_ativo_'.$fetch_fornecedor['id']];

							$sql_ativo = "UPDATE `fornecedor` SET `status` = :ativo_new WHERE id = '".$_POST['fornecedor_id']."'";
							$ativo = $PDO->prepare($sql_ativo);
							$ativo->bindValue(":ativo_new", $ativo_new);
							$ativo->execute();
							echo "<script>alert('Dados atualizados com Sucesso!')</script>";
							echo "<script>location.href='fornecedor.php';</script>";
						}
			?>
			<form method="post" style="width: 633px;">
				<input type="hidden" name="fornecedor_id" value="<?=$fetch_fornecedor['id'];?>">
				<div class="infor_atualizar_especial"><?=$fetch_fornecedor['tipo_fornecedor'];?></div>
				<div class="infor_atualizar"><?=$fetch_fornecedor['nome_fantasia'];?></div>
				<div class="infor_atualizar"><?=$fetch_fornecedor['cnpj_fornecedor'];?></div>
				<select name="fornecedor_ativo_<?=$fetch_fornecedor['id'];?>">
				<?php
					if($fetch_fornecedor['status'] == 1){
				?>
					<option value="1" selected>Sim</option>
					<option value="2">Não</option>
				<?php
					}else{

				?>
					<option value="1">Sim</option>
					<option value="2" selected>Não</option>
				<?php
					}
				?>
				</select>
				<div class="botoes_acoes">
					<input type="submit" class="botao_editar" name="atualizar_fornecedor<?=$fetch_fornecedor['id'];?>" value title="Editar">
				</div>
			</form>
			<?php
				}while($fetch_fornecedor = $exibir_fornecedor->fetch(PDO::FETCH_ASSOC));
			}else{
				echo "Nenhum Fornecedor cadastrado!!!";
			}
			?>
		</div>
	</div>
	<form method="post" class="form_producao">
		<div class="inputs">
			<div class="label_input">
				<label>Tipo de Fornecedor</label>
				<select name="tipo_fornecedor">
					<option selected disabled>Selecione --></option>
					<option>Local</option>
					<option>Externo</option>
				</select>
			</div>
			<div class="label_input">
				<label>Razão Social</label>
				<input type="text" name="razao_fornecedor">
			</div>
			<div class="label_input">
				<label>Nome Fantasia</label>
				<input type="text" name="fantasia_fornecedor">
			</div>
			<div class="label_input">
				<label>CNPJ</label>
				<input type="text" name="cnpj_fornecedor">
			</div>
			<div class="label_input">
				<label>Inscrição Estadual</label>
				<input type="text" name="inscricao_estadual">
			</div>
			<div class="label_input">
				<label>Endereço Completo</label>
				<input type="text" name="endereco_fornecedor">
			</div>
			<div class="label_input">
				<label>E-mail</label>
				<input type="text" name="email_fornecedor">
			</div>
			<div class="label_input">
				<label>Contato 1</label>
				<input type="text" name="contato1_fornecedor">
			</div>
			<div class="label_input">
				<label>Telefone 1</label>
				<input type="text" name="telefone1_fornecedor">
			</div>
			<div class="label_input">
				<label>Contato 2</label>
				<input type="text" name="contato2_fornecedor">
			</div>
			<div class="label_input">
				<label>Telefone 2</label>
				<input type="text" name="telefone2_fornecedor">
			</div>
			<div class="label_input">
				<label>Contato 3</label>
				<input type="text" name="contato3_fornecedor">
			</div>
			<div class="label_input">
				<label>Telefone 3</label>
				<input type="text" name="telefone3_fornecedor">
			</div>
		</div>
			<input type="submit" class="buton_submit" name="cadastro_fornecedor">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>