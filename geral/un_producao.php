<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<div class="conteudo">
	<h2>Cadastro Unidade de Produção</h2>
	<div>
		<div class="botao_visualizar" id="unidades_cadastradas">Verificar Cadastrados</div>
	</div>
	<div id="conteudo_modal">
		<div class="cabecalho_modal">
			<div class="cabecalho">Unidades de Produções Cadastrados</div>
			<div class="close">X</div>
		</div>
		<div class="ativo_users">
			<div class="cabecalho_atualizar" style="width: 528px;">
				<div class="div_cabecalho_atualizar">Cliente</div>
				<div class="div_cabecalho_atualizar">Unidade de Produção</div>
				<div class="div_cabecalho_atualizar_acao">Ativo?</div>
				<div class="div_cabecalho_atualizar_acao">Ação</div>
			</div>
			<?php
				if($fetch_unidade > 0){
					do{
						if(isset($_POST['atualizar_unidade'.$fetch_unidade['id']])){
							$ativo_new = $_POST['up_ativo_'.$fetch_unidade['id']];

							$sql_ativo = "UPDATE `unidade_producao` SET `status` = :ativo_new WHERE id = '".$_POST['unidade_id']."'";
							$ativo = $PDO->prepare($sql_ativo);
							$ativo->bindValue(":ativo_new", $ativo_new);
							$ativo->execute();
							echo "<script>alert('Dados atualizados com Sucesso!')</script>";
							echo "<script>location.href='un_producao.php';</script>";
						}
			?>
			<form method="post" style="width: 528px;">
				<input type="hidden" name="unidade_id" value="<?=$fetch_unidade['id'];?>">
				<div class="infor_atualizar"><?=$fetch_unidade['cliente'];?></div>
				<div class="infor_atualizar"><?=$fetch_unidade['unidade'];?></div>
				<?php
					if($fetch_unidade['status'] == 1){
				?>
					<select name="up_ativo_<?=$fetch_unidade['id'];?>">
						<option value="1" selected>Sim</option>
						<option value="2">Não</option>
					</select>
				<?php
					}else{
				?>
					<select name="up_ativo_<?=$fetch_unidade['id'];?>">
						<option value="1">Sim</option>
						<option value="2" selected>Não</option>
					</select>
				<?php
					}
				?>
				<div class="botoes_acoes">
					<input type="submit" class="botao_editar" name="atualizar_unidade<?=$fetch_unidade['id'];?>" value title="Editar">
				</div>
			</form>
			<?php
				}while($fetch_unidade = $exibir_unidade->fetch(PDO::FETCH_ASSOC));
			}else{
				echo "Não há Unidade de Produção Cadastrados!";
			}
			?>
		</div>
	</div>
	<form method="post" class="form_producao">
		<div class="inputs" style="width: 500px;">
			<div class="label_input" style="margin-left: 20%;">
				<label>Cliente</label>
				<input type="text" name="cliente_contrato">
			</div>
			<div class="label_input" style="margin-left: 32px;">
				<label>Unidade de Produção</label>
				<input type="text" name="nome_unidade">
			</div>
		</div>
			<input type="submit" class="buton_submit" name="cadastro_unidade">
	</form>
</div>
<?php
	include('../include/rodape.php');
?>