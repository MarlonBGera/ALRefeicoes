<?php
	header("Content-Type: text/html; charset=utf-8", true);
	include('connect.php');
	if(isset($_GET['fornecedor'])){
		$busca_produto = $_GET['fornecedor'];
		if(empty($busca_produto) || $busca_produto == null || $busca_produto == "Selecione -->"){
			echo "<option selected disabled>Selecione --></option>";
		}else{
			$sql = "SELECT * FROM produto WHERE fornecedor = '".$busca_produto."'";
			$query = $PDO->prepare($sql);
			$query->execute();
			$rows = $query->fetch(PDO::FETCH_ASSOC);
			if($rows > 0):
				do{
				echo "<option>".$rows['descricao']."</option>";
			}while($rows = $query->fetch(PDO::FETCH_ASSOC));
			endif;
		}
	}
?>