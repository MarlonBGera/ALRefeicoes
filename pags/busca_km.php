<?php
	header("Content-Type: text/html; charset=utf-8", true);
	include('connect.php');
	if(isset($_GET['placa'])){
		$busca_valor = $_GET['placa'];
		if(empty($busca_valor) || $busca_valor == null || $busca_valor == "Selecione -->"){
			echo "0";
		}else{
			$sql = "SELECT * FROM `fornecimento_local` WHERE placa_veiculo = '".$busca_valor."' ORDER BY km_veiculo DESC";
			$query = $PDO->prepare($sql);
			$query->execute();
			$rows = $query->fetch(PDO::FETCH_ASSOC);
			echo $rows['km_veiculo'];
		}
	}
?>