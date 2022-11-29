<?php
//VERIFICANDO SE FOI APERTADO O BOTAO DE LOGAR
if(isset($_POST['logar'])):
//INICIANDO A SESSÃO
session_start();
//BUSCA AS VARIAVEIS DIGITADAS
$login = $_POST['login'];
$senha = $_POST['senha'];
//CONSULTA NO BANCO DE DADOS PELO USUARIO E SENHA DIGITADOS
$sql = "SELECT * FROM users WHERE login = '".$login."' AND senha = '". $senha . "'";
//VERIFICA SE O USUARIO EXISTE E RETORNA A QUANTIDADE
$resultado = $PDO->prepare($sql);
$resultado->execute();
//RETORNA A QUANTIDADE DE CONTAS
$contaresultado = $resultado->fetch(PDO::FETCH_ASSOC);
//VERIFICA E PEGA O USUARIO E SENHA PARA USARMOS NA PROXIMA PAGINA E PULA A PAGINA PARA O LOCAL PRINCIPAL
if ($login === $contaresultado['login'] && $senha === $contaresultado['senha'] && $contaresultado['status'] === '1'):
	$_SESSION['login'] = $login;
	$_SESSION['senha'] = $senha;
	header('location: geral/home.php');
else:
	echo "<script>alert('Nome de usuário ou senha está incorreto ou você não tem permissões!')</script>";
endif;
endif;
?>