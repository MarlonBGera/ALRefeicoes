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
<div class="topo">
	<div class="logo"></div>
	<div class="nome_empresa"><h2>A.L. Refeições Coletivas<br>Sistema Interno</h2></div>
	<div class="usuario">
		<div class="nome">Usuário: <?=$_SESSION['login'];?></div>
		<form method="post" class="logout">
			<input type="submit" class="botao_top" name="mudar_venda" value="Mudar para Compras">
			<input type="button" class="botao_top" id="trocar_senha" value="Mudar Senha">
			<input type="submit" class="botao_top" name="deslogar" value="Deslogar">
		</form>
	</div>
</div>
<div id="change_pass">
	<div class="cabecalho_modal">
		<div class="cabecalho">Modificando senha do usuário <span style="font-weight: bold;"><?php echo $_SESSION['login'];?></span></div>
		<div class="close">X</div>
	</div>
	<form class="novo_usuario" method="post">
		<div class="label_input">
			<label>Senha Antiga</label>
			<input type="password" name="pass_old" required>
		</div>
		<div class="label_input">
			<label>Nova Senha</label>
			<input type="password" name="pass_new" required>
		</div>
		<div class="label_input" style="margin-right: 25px;">
			<label>Confirmar Senha</label>
			<input type="password" name="re_pass_new" required>
		</div>
		<input type="submit" class="buton_submit" name="botao_trocar_senha">
	</form>
</div>
<div id="fundo_modal"></div>
