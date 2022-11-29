<!DOCTYPE html>
<html>
<head>
	<title>A.L. Refeições Coletivas</title>
	<link rel="stylesheet" type="text/css" href="assets/css/estilo.css">
	<script type="text/javascript" src="assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.maskMoney.js"></script>
	<script type="text/javascript" src="assets/js/funcoes.js"></script>
</head>
<?php
	require_once('pags/connect.php'); require_once('pags/login.php');
?>
<body onload="goFocus('login')">
<div class="topo_logo"></div>
<div class="meio">
	<form method="post">
		<label>Login:</label>
		<input type="text" name="login" id="login" style="width: 200px;">
		<label>Senha:</label>
		<input type="password" name="senha" style="width: 200px;">
		<input type="submit" class="buton_submit" name="logar" value="Logar">
	</form>
</div>
</body>
</html>