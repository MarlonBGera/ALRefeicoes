<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>A. L. Refeições Coletivas</title>
	<link rel="stylesheet" type="text/css" href="../assets/css/estilo.css">
	<script type="text/javascript" src="../assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery.maskMoney.js"></script>
	<script type="text/javascript" src="../assets/js/funcoes.js"></script>
</head>
<?php
	require_once('../pags/connect.php');
	require_once('../pags/funcoes.php');
?>
<body>
<div class="topo" style="width: 200px;">
<div class="logo"></div>
</div>
<div class="lancamento_local">
	<div class="cabecalho_modal">
		<div class="cabecalho" style="width: 1000px; height: 25px;"><span style="font-size: 17pt; font-weight: bold;">Lançamentos de Fornecedor Local</span></div>
	</div>
	<div class="ativo_users" style="height: 350px;">
		<div class="cabecalho_atualizar" style="width: 945px;">
			<div class="div_cabecalho_atualizar_especial"><span class="text_menor">Data da Compra</span></div>
			<div class="div_cabecalho_atualizar">Unidade de  Produção</div>
			<div class="div_cabecalho_atualizar">Fornecedor</div>
			<div class="div_cabecalho_atualizar">Produto</div>
			<div class="div_cabecalho_atualizar_especial">Valor Total</div>
			<div class="div_cabecalho_atualizar_acao">Pago?</div>
			<div class="div_cabecalho_atualizar_acao">Ação</div>
		</div>
		<?php
			if($fetch_LL > 0){
				do{
					if(isset($_POST['atualizar_LL'.$fetch_LL['id']])){
						$new_pago = $_POST['LL_pago_'.$fetch_LL['id']];

						$sql_LL = "UPDATE `fornecimento_local` SET `pago` = :new_pago WHERE id = '".$_POST['LL_id']."'";
						$LL_pago = $PDO->prepare($sql_LL);
						$LL_pago->bindValue(":new_pago", $new_pago);
						$LL_pago->execute();
						echo "<script>alert('Dados atualizados com Sucesso!')</script>";
						echo "<script>location.href='lancamentos_local.php';</script>";
					}
					if(isset($_POST['excluir_LL'.$fetch_LL['id']])){
						$sql_del_LL = "DELETE FROM `fornecimento_local` WHERE `id` = '".$_POST['LL_id']."'";
						$del_LL = $PDO->prepare($sql_del_LL);
						$del_LL->execute();
						echo "<script>alert('Dados excluidos com Sucesso!')</script>";
						echo "<script>location.href='lancamentos_local.php';</script>";
					}
		?>
		<form method="post" style="width: 945px;">
			<input type="hidden" name="LL_id" value="<?=$fetch_LL['id'];?>">
			<div class="infor_atualizar_especial"><?=date('d/m/Y',strtotime($fetch_LL['data_compra']));?></div>
			<div class="infor_atualizar"><?=$fetch_LL['unidade_producao'];?></div>
			<div class="infor_atualizar"><?=$fetch_LL['fornecedor_local'];?></div>
			<div class="infor_atualizar"><?=$fetch_LL['produto_local'];?></div>
			<div class="infor_atualizar_especial"><?=str_replace(".", ",", $fetch_LL['total_produto']);?></div>
			<select name="LL_pago_<?=$fetch_LL['id'];?>">
			<?php
				if($fetch_LL['pago'] == 1){		
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
				<input type="submit" class="botao_editar" name="atualizar_LL<?=$fetch_LL['id'];?>" value title="Editar">
				<input type="submit" class="botao_excluir" name="excluir_LL<?=$fetch_LL['id'];?>" value title="Excluir">
			</div>
		</form>
		<?php
			}while($fetch_LL = $exibir_LL->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "Nenhum lançamento realizado!";
		}
		?>
	</div>
	© 2017 - Nutribem<br>Todos os direitos reservados<br>Marlon Breno Gera
</div>
</body>
</html>