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
<div class="lancamento_externo">
	<div class="cabecalho_modal">
		<div class="cabecalho" style="width: 1000px; height: 25px;"><span style="font-size: 17pt; font-weight: bold;">Lançamentos de Fornecedor Externo</div>
	</div>
	<div class="ativo_users" style="height: 350px;">
		<div class="cabecalho_atualizar" style="width: 948px;">
			<div class="div_cabecalho_atualizar_especial">Emissão</div>
			<div class="div_cabecalho_atualizar">Unidade de Produção</div>
			<div class="div_cabecalho_atualizar">Fornecedor</div>
			<div class="div_cabecalho_atualizar_especial">Forma</div>
			<div class="div_cabecalho_atualizar_especial">Parcela</div>
			<div class="div_cabecalho_atualizar_especial">Valor Total</div>
			<div class="div_cabecalho_atualizar_acao">Pago?</div>
			<div class="div_cabecalho_atualizar_acao">Ação</div>
		</div>
		<?php
			if($fetch_LE > 0){
				do{
					if(isset($_POST['atualizar_LE'.$fetch_LE['id']])){
						$new_pago = $_POST['LE_pago_'.$fetch_LE['id']];

						$sql_LE = "UPDATE `fornecimento_externo` SET `pago` = :new_pago WHERE id = '".$_POST['LE_id']."'";
						$LE_pago = $PDO->prepare($sql_LE);
						$LE_pago->bindValue(":new_pago", $new_pago);
						$LE_pago->execute();
						echo "<script>alert('Dados atualizados com Sucesso!')</script>";
						echo "<script>location.href='lancamentos_externo.php';</script>";
					}
					if(isset($_POST['excluir_LE'.$fetch_LE['id']])){
						$sql_del_LE = "DELETE FROM `fornecimento_externo` WHERE `id` = '".$_POST['LE_id']."'";
						$del_LE = $PDO->prepare($sql_del_LE);
						$del_LE->execute();
						echo "<script>alert('Dados excluidos com Sucesso!')</script>";
						echo "<script>location.href='lancamentos_externo.php';</script>";
					}
		?>
		<form method="post" style="width: 948px;">
			<input type="hidden" name="LE_id" value="<?=$fetch_LE['id'];?>">
			<div class="infor_atualizar_especial"><?=date('d/m/Y',strtotime($fetch_LE['data_emissao']));?></div>
			<div class="infor_atualizar"><?=$fetch_LE['unidade_producao'];?></div>
			<div class="infor_atualizar"><?=$fetch_LE['fornecedor_externo'];?></div>
			<div class="infor_atualizar_especial">
				<?php 
					if($fetch_LE['forma_pagamento'] == "antecipado"){
						echo "Antecipado";
					}elseif($fetch_LE['forma_pagamento'] == "avista"){
						echo "À Vista";
					}elseif($fetch_LE['forma_pagamento'] == "aprazo"){
						echo "A Prazo";
					}else{
						echo "Não encontrado";
					};
				?>
			</div>
			<div class="infor_atualizar_especial">
				<?php
					if($fetch_LE['parcela'] != 0){
						echo $fetch_LE['parcela'];
					}else{
						echo "-";
					}
				?>
			</div>
			<div class="infor_atualizar_especial">
			<?php 
				if($fetch_LE['parcela'] != 0){
					echo str_replace(".", ",", $fetch_LE['valor_unico']);
				}else{
					echo str_replace(".", ",", $fetch_LE['valor_total']);
				};?>
			</div>
			<select name="LE_pago_<?=$fetch_LE['id'];?>">
			<?php
				if($fetch_LE['pago'] == 1){		
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
				<input type="submit" class="botao_editar" name="atualizar_LE<?=$fetch_LE['id'];?>" value title="Editar">
				<input type="submit" class="botao_excluir" name="excluir_LE<?=$fetch_LE['id'];?>" value title="Excluir">
			</div>
		</form>
		<?php
			}while($fetch_LE = $exibir_LE->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "Nenhum lançamento realizado!";
		}
		?>
	</div>
© 2017 - Nutribem<br>Todos os direitos reservados<br>Marlon Breno Gera
</div>
</body>
</html>