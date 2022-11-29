<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Cadastro Produto</h2>
	<div>
		<div class="botao_visualizar" id="fornecedores_cadastrados">Verificar Cadastrados</div>
	</div>
	<div id="conteudo_modal">
		<div class="cabecalho_modal">
			<div class="cabecalho">Produtos Cadastrados</div>
			<div class="close">X</div>
		</div>
		<div class="ativo_users">
			<div class="cabecalho_atualizar" style="width: 576px;">
				<div class="div_cabecalho_atualizar">Fornecedor</div>
				<div class="div_cabecalho_atualizar">Produto</div>
				<div class="div_cabecalho_atualizar_especial">Preço</div>
				<div class="div_cabecalho_atualizar_acao">Ação</div>
			</div>
			<?php
				if($fetch_produto > 0){
					do{
						if(isset($_POST['atualizar_produto'.$fetch_produto['id']])){
							$valor_new = str_replace(".", "", str_replace("R$", "", $_POST['valor_produto_'.$fetch_produto['id']]));
							$preco_new = str_replace(",", ".", $valor_new);

							$sql_ativo = "UPDATE `produto` SET `preco_unitario` = :preco_new WHERE id = '".$_POST['produto_id']."'";
							$ativo = $PDO->prepare($sql_ativo);
							$ativo->bindValue(":preco_new", $preco_new);
							$ativo->execute();
							echo "<script>alert('Dados atualizados com Sucesso!')</script>";
							echo "<script>location.href='produto.php';</script>";
						}
			?>
			<script type="text/javascript">
				$(document).ready(function(){$('#money<?=$fetch_produto['id'];?>').maskMoney({prefix:'R$', decimal:",", thousands:"."});});
			</script>
			<form method="post" style="width: 576px; height: 20px;">
				<input type="hidden" name="produto_id" value="<?=$fetch_produto['id'];?>">
				<div class="infor_atualizar"><?=$fetch_produto['fornecedor'];?></div>
				<div class="infor_atualizar"><?=$fetch_produto['descricao'];?></div>

				<input type="text" id="money<?=$fetch_produto['id'];?>" style="width: 98px; height: 16px; border: 1px solid rgba(231,0,0,0.6);float: left;margin-left: 2.5px;margin-right: 2.5px;margin-top: 1px; margin-bottom: 0px;" name="valor_produto_<?=$fetch_produto['id'];?>" value="<?='R$'.number_format($fetch_produto['preco_unitario'],2,',','.');?>">
				<div class="botoes_acoes">
					<input type="submit" class="botao_editar" name="atualizar_produto<?=$fetch_produto['id'];?>" value title="Editar">
				</div>
			</form>
			<?php
				}while($fetch_produto = $exibir_produto->fetch(PDO::FETCH_ASSOC));
			}else{
				echo "Nenhum Produto cadastrado!!!";
			}
			?>
		</div>
	</div>
	<form method="post" class="form_producao">
		<div class="inputs">
			<div class="label_input">
				<label>Fornecedor</label>
				<select name="fornecedor_produto">
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
			<div class="label_input">
				<label>Especificação Completa</label>
				<input type="text" name="descricao_produto">
			</div>
			<div class="label_input">
				<label>Unidade de Medida</label>
				<input type="text" name="unidade_medida_produto">
			</div>
			<div class="label_input">
				<label>Preço Unitário</label>
				<input type="text" name="preco_produto" id="money" value="R$0,00">
			</div>
			<div class="label_input">
				<label>Combustível?</label>
				<div class="input_radio">
					<div>
						Sim: <input type="radio" name="pergunta_combustivel" value="sim">
					</div>
					<div>
						Não: <input type="radio" name="pergunta_combustivel" value="nao" checked>
					</div>
				</div>
			</div>
		</div>
			<input type="submit" class="buton_submit" name="cadastro_produto">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>