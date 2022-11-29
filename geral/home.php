<?php
	include('../include/topo.php');
	include('../include/corpo.php');
?>
<?php
	if($fetch_usuario['nivel'] == 1){
?>
<div class="botao_home" id="cadastro_usuario">Cadastro</div>
<div class="botao_home" id="usuarios_cadastrados">Usuários Cadastrados</div>
<?php
	}
?>
<div id="new_user">
	<div class="cabecalho_modal">
		<div class="cabecalho">Cadastro de usuário</div>
		<div class="close">X</div>
	</div>
	<form class="novo_usuario" method="post">
		<div class="label_input">
			<label>Login</label>
			<input type="text" name="cadastro_login" required>
		</div>
		<div class="label_input">
			<label>Senha</label>
			<input type="password" name="cadastro_senha" required>
		</div>
		<div class="label_input" style="margin-right: 25px;">
			<label>Nível de Acesso</label>
			<select name="cadastro_nivel" required>
				<option value="1">Administrador</option>
				<option value="2">Digitador</option>
			</select>
		</div>
		<input type="submit" class="buton_submit" name="botao_cadastro_usuario">
	</form>
</div>
<div id="users">
	<div class="cabecalho_modal">
		<div class="cabecalho">Usuários Cadastrados</div>
		<div class="close">X</div>
	</div>
		<div class="ativo_users">
			<div class="cabecalho_atualizar" style="width: 576px;">
				<div class="div_cabecalho_atualizar">Usuário</div>
				<div class="div_cabecalho_atualizar">Nível de Acesso</div>
				<div class="div_cabecalho_atualizar_acao">Ativo?</div>
				<div class="div_cabecalho_atualizar_acao">Ação</div>
			</div>
			<?php 
				if($fetch_users > 0){
					do{
						if(isset($_POST['atualizar_users'.$fetch_users['id']])){
							$ativo_new = $_POST['ativo_'.$fetch_users['id']];

							$sql_mudar_user = "UPDATE `users` SET `status`= :ativo_new WHERE id = '".$_POST['user_id']."'";
							$ativo_user = $PDO->prepare($sql_mudar_user);
							$ativo_user->bindValue(":ativo_new", $ativo_new);
							$ativo_user->execute();
							echo "<script>alert('Dados atualizados com Sucesso!')</script>";
							echo "<script>location.href='home.php';</script>";
						};
			?>
			<form method="post" style="width: 576px;">
				<input type="hidden" name="user_id" value="<?=$fetch_users['id'];?>">
				<div class="infor_atualizar"><?php echo $fetch_users['login']; ?></div>
				<div class="infor_atualizar"><?php if($fetch_users['nivel'] == 1){ echo "Administrador";}elseif($fetch_users['nivel'] == 2){ echo "Digitador";}; ?></div>
			<?php
				if($fetch_users['status'] == 1){
			?>
				<select name="ativo_<?=$fetch_users['id'];?>">
					<option value="1" selected>Sim</option>
					<option value="2">Não</option>
				</select>
			<?php
				}else{
			?>
				<select name="ativo_<?=$fetch_users['id'];?>">
					<option value="1">Sim</option>
					<option value="2" selected>Não</option>
				</select>
			<?php
				}
			?>
				<div class="botoes_acoes">
					<input type="submit" class="botao_editar" name="atualizar_users<?=$fetch_users['id'];?>" value title="Editar">
				</div>
			</form>
			<?php
					}while($fetch_users = $exibir_users->fetch(PDO::FETCH_ASSOC));
				}else{
					echo "Nenhum usuario cadastrado!";
				}
			?>
		</div>
</div>
<div id="fundo_modal"></div>
<?php
	include('../include/rodape.php');
?>