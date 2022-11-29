<?php
header("Content-Type: text/html; charset=utf-8", true);
session_start();
	$user = $_SESSION['login'];
	if((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)):
		unset($_SESSION['login']);
		unset($_SESSION['senha']);
		header('location: ../index.php');
	endif;
	if(isset($_POST['deslogar'])){
		unset($_SESSION['login']);
		unset($_SESSION['senha']);
		header('location: ../index.php');
	};
	if(isset($_POST['mudar_venda'])){
		header('location: ../venda/index.php');
	}

	//Cadastrando novos usuarios
	if(isset($_POST['botao_cadastro_usuario'])){
		$login = $_POST['cadastro_login'];
		$senha = $_POST['cadastro_senha'];
		$nivel = $_POST['cadastro_nivel'];
		$status = "1";

		if(empty($login) || empty($senha) || empty($nivel)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_cadastro_usuario = "INSERT INTO `users`(`login`, `senha`, `nivel`, `status`) VALUES (:login, :senha, :nivel, :status)";
			$cadastro_usuario = $PDO->prepare($sql_cadastro_usuario);
			$cadastro_usuario->bindValue(":login", $login);
			$cadastro_usuario->bindValue(":senha", $senha);
			$cadastro_usuario->bindValue(":nivel", $nivel);
			$cadastro_usuario->bindValue(":status", $status);

			//Verificando se há um usuario com o mesmo login.
			$validar_usuario = $PDO->prepare("SELECT * FROM `users` WHERE `login` = ?");
			$validar_usuario->execute(array($login));

			if($validar_usuario->rowCount() == 0){
				$cadastro_usuario->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			}else{
				echo "<script>alert('Usuário repetido.')</script>";
			}
		}
	}

	//Modificando Senha de usuario logado.
	$sql_selecionar_usuario = "SELECT * FROM `users` WHERE `login` = '".$user."'";
	$exibir_usuario = $PDO->prepare($sql_selecionar_usuario);
	$exibir_usuario->execute();
	$fetch_usuario = $exibir_usuario->fetch(PDO::FETCH_ASSOC);
	if(isset($_POST['botao_trocar_senha'])){
		$senha_antiga = $_POST['pass_old'];
		$nova_senha = $_POST['pass_new'];
		$repetir_senha = $_POST['re_pass_new'];
		$user = $_SESSION['login'];

		if(empty($senha_antiga) || empty($nova_senha) || empty($repetir_senha)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}elseif($nova_senha <> $repetir_senha){
			echo "<script>alert('As senhas devem ser iguais!(Nova Senha e Confirmar Senha)')</script>";
		}elseif($senha_antiga <> $fetch_usuario['senha']){
			echo "<script>alert('Digite a Senha Antiga corretamente!')</script>";
		}else{
			$sql_troca_senha = "UPDATE `users` SET `senha` = '".$nova_senha."' WHERE `login` = '".$user."' AND `senha` = '".$senha_antiga."'";
			$troca_senha = $PDO->prepare($sql_troca_senha);
			$troca_senha->execute();
			echo "<script>alert('Senha alterada corretamente!')</script>";
		}
	}

	//Cadastrando Unidade de Produção
	if(isset($_POST['cadastro_unidade'])){
		$cliente = $_POST['cliente_contrato'];
		$unidade = $_POST['nome_unidade'];
		$status = "1";
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if(empty($cliente) || empty($unidade)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_unidade = "INSERT INTO `unidade_producao`(`cliente`, `unidade`, `status`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:cliente, :unidade, :status, :data, :hora, :usuario)";
			$cadastro_unidade = $PDO->prepare($sql_unidade);
			$cadastro_unidade->bindValue(":cliente", $cliente);
			$cadastro_unidade->bindValue(":unidade", $unidade);
			$cadastro_unidade->bindValue(":status", $status);
			$cadastro_unidade->bindValue(":data", $data);
			$cadastro_unidade->bindValue(":hora", $hora);
			$cadastro_unidade->bindValue(":usuario", $usuario);

			//Verifica se há algum contrato com a mesma numeração.
			$validar_unidade = $PDO->prepare("SELECT * FROM unidade_producao WHERE unidade = ?");
			$validar_unidade->execute(array($unidade));

			if($validar_unidade->rowCount() == 0):
				$cadastro_unidade->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			else:
				echo "<script>alert('Unidade de Produção repetido.')</script>";
			endif;
		}
	}
	//Cadastrando Fornecedor
	if(isset($_POST['cadastro_fornecedor'])){
		$cnpj = $_POST['cnpj_fornecedor'];
		$social = $_POST['razao_fornecedor'];
		$fantasia = $_POST['fantasia_fornecedor'];
		if(empty($_POST['tipo_fornecedor'])){
			$tipo = "0";
		}else{
			$tipo = $_POST['tipo_fornecedor'];
		};
		$estadual = $_POST['inscricao_estadual'];
		$endereco = $_POST['endereco_fornecedor'];
		$telefone1 = $_POST['telefone1_fornecedor'];
		$telefone2 = $_POST['telefone2_fornecedor'];
		$telefone3 = $_POST['telefone3_fornecedor'];
		$email = $_POST['email_fornecedor'];
		$contato1 = $_POST['contato1_fornecedor'];
		$contato2 = $_POST['contato2_fornecedor'];
		$contato3 = $_POST['contato3_fornecedor'];
		$status = "1";
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if($tipo == 'Externo'){
			if(empty($cnpj) || empty($social) || empty($fantasia) || empty($tipo) || empty($estadual) || empty($endereco) || empty($telefone1) || empty($email) || empty($contato1) || $tipo == "0"){
			echo "<script>alert('Faltou digitar um campo!')</script>";
			}else{
				$sql_fornecedor = "INSERT INTO `fornecedor`(`tipo_fornecedor`, `razao_social`, `nome_fantasia`, `cnpj_fornecedor`, `inscricao_estadual`, `endereco_fornecedor`, `telefone1_fornecedor`, `telefone2_fornecedor`, `telefone3_fornecedor`, `email_fornecedor`, `contato1_fornecedor`, `contato2_fornecedor`, `contato3_fornecedor`, `status`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:tipo, :social, :fantasia, :cnpj, :estadual, :endereco, :telefone1, :telefone2, :telefone3, :email, :contato1, :contato2, :contato3, :status, :data, :hora, :user)";
				$cadastro_fornecedor = $PDO->prepare($sql_fornecedor);
				$cadastro_fornecedor->bindValue(":tipo", $tipo);
				$cadastro_fornecedor->bindValue(":social", $social);
				$cadastro_fornecedor->bindValue(":fantasia", $fantasia);
				$cadastro_fornecedor->bindValue(":cnpj", $cnpj);
				$cadastro_fornecedor->bindValue(":estadual", $estadual);
				$cadastro_fornecedor->bindValue(":endereco", $endereco);
				$cadastro_fornecedor->bindValue(":telefone1", $telefone1);
				$cadastro_fornecedor->bindValue(":telefone2", $telefone2);
				$cadastro_fornecedor->bindValue(":telefone3", $telefone3);
				$cadastro_fornecedor->bindValue(":email", $email);
				$cadastro_fornecedor->bindValue(":contato1", $contato1);
				$cadastro_fornecedor->bindValue(":contato2", $contato2);
				$cadastro_fornecedor->bindValue(":contato3", $contato3);
				$cadastro_fornecedor->bindValue(":status", $status);
				$cadastro_fornecedor->bindValue(":data", $data);
				$cadastro_fornecedor->bindValue(":hora", $hora);
				$cadastro_fornecedor->bindValue(":user", $usuario);

				//Verificando se existe este fornecedor cadastrado
				$validar_fornecedor = $PDO->prepare("SELECT * FROM fornecedor WHERE cnpj_fornecedor = ?");
				$validar_fornecedor->execute(array($cnpj));

				if($validar_fornecedor->rowCount() == 0):
					$cadastro_fornecedor->execute();
					echo "<script>alert('Cadastro realizado com sucesso.')</script>";
				else:
					echo "<script>alert('Fornecedor repetido.')</script>";
				endif;
			}
		}elseif($tipo == 'Local'){
			if(empty($social) && empty($fantasia)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
			}else{
				$sql_fornecedor = "INSERT INTO `fornecedor`(`tipo_fornecedor`, `razao_social`, `nome_fantasia`, `cnpj_fornecedor`, `inscricao_estadual`, `endereco_fornecedor`, `telefone1_fornecedor`, `telefone2_fornecedor`, `telefone3_fornecedor`, `email_fornecedor`, `contato1_fornecedor`, `contato2_fornecedor`, `contato3_fornecedor`, `status`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:tipo, :social, :fantasia, :cnpj, :estadual, :endereco, :telefone1, :telefone2, :telefone3, :email, :contato1, :contato2, :contato3, :status, :data, :hora, :user)";
				$cadastro_fornecedor = $PDO->prepare($sql_fornecedor);
				$cadastro_fornecedor->bindValue(":tipo", $tipo);
				$cadastro_fornecedor->bindValue(":social", $social);
				$cadastro_fornecedor->bindValue(":fantasia", $fantasia);
				$cadastro_fornecedor->bindValue(":cnpj", $cnpj);
				$cadastro_fornecedor->bindValue(":estadual", $estadual);
				$cadastro_fornecedor->bindValue(":endereco", $endereco);
				$cadastro_fornecedor->bindValue(":telefone1", $telefone1);
				$cadastro_fornecedor->bindValue(":telefone2", $telefone2);
				$cadastro_fornecedor->bindValue(":telefone3", $telefone3);
				$cadastro_fornecedor->bindValue(":email", $email);
				$cadastro_fornecedor->bindValue(":contato1", $contato1);
				$cadastro_fornecedor->bindValue(":contato2", $contato2);
				$cadastro_fornecedor->bindValue(":contato3", $contato3);
				$cadastro_fornecedor->bindValue(":status", $status);
				$cadastro_fornecedor->bindValue(":data", $data);
				$cadastro_fornecedor->bindValue(":hora", $hora);
				$cadastro_fornecedor->bindValue(":user", $usuario);
				
				$cadastro_fornecedor->execute();
					echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			}
		}
	}
	//Cadastrando Produto
	if(isset($_POST['cadastro_produto'])){
		$descricao = $_POST['descricao_produto'];

		if(empty($_POST['fornecedor_produto'])){
			$fornecedor = "0";
		}else{
			$fornecedor = $_POST['fornecedor_produto'];
		}

		$unidade_medida = $_POST['unidade_medida_produto'];
		$preco_unitario = str_replace(".", "", str_replace("R$", "", $_POST['preco_produto']));
		$preco_produto = str_replace(",", ".", $preco_unitario);
		$pergunta_combustivel = $_POST['pergunta_combustivel'];
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if(empty($descricao) || empty($fornecedor) || empty($unidade_medida) || empty($preco_produto) || $fornecedor == "0" || $preco_produto == "0.00"){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_produto = "INSERT INTO `produto`(`fornecedor`, `descricao`, `unidade_medida`, `preco_unitario`, `pergunta_combustivel`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:fornecedor, :descricao, :unidade_medida, :preco_unitario, :pergunta_combustivel, :data, :hora, :user)";
			$cadastro_produto = $PDO->prepare($sql_produto);
			$cadastro_produto->bindValue(":fornecedor", $fornecedor);
			$cadastro_produto->bindValue(":descricao", $descricao);
			$cadastro_produto->bindValue(":unidade_medida", $unidade_medida);
			$cadastro_produto->bindValue(":preco_unitario", $preco_produto);
			$cadastro_produto->bindValue(":pergunta_combustivel", $pergunta_combustivel);
			$cadastro_produto->bindValue(":data", $data);
			$cadastro_produto->bindValue(":hora", $hora);
			$cadastro_produto->bindValue(":user", $usuario);

			//Verificando se existe este produto com o mesmo fornecedor cadastrado
			$sql_validar_produto = "SELECT * FROM `produto` WHERE `fornecedor` = ? AND `descricao` = ?";
			$validar_produto = $PDO->prepare($sql_validar_produto);
			$validar_produto->execute(array($fornecedor, $descricao));
			if($validar_produto->rowCount() == 0):
				$cadastro_produto->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			else:
				echo "<script>alert('Produto repetido do mesmo fornecedor.')</script>";
			endif;
		}
	}
	//Cadastrando Motorista para abastecimento
	if(isset($_POST['cadastro_motorista'])){
		$nome = $_POST['nome_motorista'];
		$cnh = $_POST['cnh_motorista'];
		$categoria = $_POST['categoria_motorista'];
		$validade = $_POST['validade_motorista'];
		$idade = $_POST['idade_motorista'];
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if(empty($nome) || empty($cnh) || empty($categoria) || empty($validade) || empty($idade)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_motorista = "INSERT INTO `motorista`(`nome_motorista`, `numero_cnh`, `categoria_cnh`, `validade_cnh`, `idade`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:nome, :cnh, :categoria, :validade, :idade, :data, :hora, :user)";
			$cadastro_motorista = $PDO->prepare($sql_motorista);
			$cadastro_motorista->bindValue(":nome", $nome);
			$cadastro_motorista->bindValue(":cnh", $cnh);
			$cadastro_motorista->bindValue(":categoria", $categoria);
			$cadastro_motorista->bindValue(":validade", $validade);
			$cadastro_motorista->bindValue(":idade", $idade);
			$cadastro_motorista->bindValue(":data", $data);
			$cadastro_motorista->bindValue(":hora", $hora);
			$cadastro_motorista->bindValue(":user", $usuario);

			//Verificando se existe o motorista já cadastrado
			$validar_motorista = $PDO->prepare("SELECT * FROM motorista WHERE numero_cnh = ?");
			$validar_motorista->execute(array($cnh));

			if($validar_motorista->rowCount() == 0):
				$cadastro_motorista->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			else:
				echo "<script>alert('Documento repetido.')</script>";
			endif;
		}
	}
	//Cadastrando Veiculos no sistema
	if(isset($_POST['cadastro_veiculo'])){
		$descricao = $_POST['descricao_veiculo'];
		$placa = $_POST['placa_veiculo'];
		$km = $_POST['km_veiculo'];
		if(empty($_POST['proprietario_veiculo'])){
			$proprietario = "0";
		}else{
			$proprietario = $_POST['proprietario_veiculo'];
		}
		$renavan = $_POST['renavan_veiculo'];
		$consumo = $_POST['consumo_veiculo'];
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if(empty($descricao) || empty($placa) || empty($km) || empty($proprietario) || empty($renavan) || empty($consumo) || $proprietario == "0"){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_veiculo = "INSERT INTO `veiculo`(`descricao_veiculo`, `placa_veiculo`, `km_veiculo`, `proprietario_veiculo`, `renavan_veiculo`, `consumo_veiculo`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:descricao, :placa, :km, :proprietario, :renavan, :consumo, :data, :hora, :user)";
			$cadastro_veiculo = $PDO->prepare($sql_veiculo);
			$cadastro_veiculo->bindValue(":descricao", $descricao);
			$cadastro_veiculo->bindValue(":placa", $placa);
			$cadastro_veiculo->bindValue(":km", $km);
			$cadastro_veiculo->bindValue(":proprietario", $proprietario);
			$cadastro_veiculo->bindValue(":renavan", $renavan);
			$cadastro_veiculo->bindValue(":consumo", $consumo);
			$cadastro_veiculo->bindValue(":data", $data);
			$cadastro_veiculo->bindValue(":hora", $hora);
			$cadastro_veiculo->bindValue(":user", $usuario);

			//Verificando se existe o mesmo veiculo cadastrado
			$validar_veiculo = $PDO->prepare("SELECT * FROM veiculo WHERE placa_veiculo = ?");
			$validar_veiculo->execute(array($placa));

			if($validar_veiculo->rowCount() == 0):
				$cadastro_veiculo->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			else:
				echo "<script>alert('Veículo repetido.')</script>";
			endif;
		}
	}
	
	//Lançamento de fornecedor Local
	if(isset($_POST['cadastro_local'])){
		if(empty($_POST['unidade_producao_local'])){
			$unidade = "0";
		}else{
			$unidade = $_POST['unidade_producao_local'];
		};
		$data_compra = $_POST['data_compra_local'];
		if(empty($_POST['fornecedor_local'])){
			$fornecedor = "0";
		}else{
			$fornecedor = $_POST['fornecedor_local'];
		}
		if(empty($_POST['produto_local'])){
			$produto = "0";
		}else{
			$produto = $_POST['produto_local'];
		}
		$quantidade = $_POST['quantidade_local'];
		$valor = $_POST['valor_produto'];
		$total = $quantidade * $valor;
		$total_db = number_format($total, 2, '.', '');
		if(empty($_POST['motorista_combustivel'])){
			$motorista = "";
		}else{
			$motorista = $_POST['motorista_combustivel'];
		}
		if(empty($_POST['veiculo_combustivel'])){
			$placa = "";
		}else{
			$placa = $_POST['veiculo_combustivel'];
		}
		if(empty($_POST['km_combustivel'])){
			$km = "";
		}else{
			$km = $_POST['km_combustivel'];
		}
		$km_antigo = $_POST['km_antigo'];
		$consumo = $_POST['consumo_combustivel'];
		$pago = "2";
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];

		if(empty($unidade) || empty($data_compra) || empty($fornecedor) || empty($produto) || empty($quantidade) || $unidade == "0" || $fornecedor == "0" || $produto == "0"){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_local = "INSERT INTO `fornecimento_local`(`unidade_producao`, `data_compra`, `fornecedor_local`, `produto_local`, `quantidade`, `valor_unitario`, `total_produto`, `motorista_veiculo`, `placa_veiculo`, `km_veiculo`, `km_antigo`, `consumo_combustivel`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :data_compra, :fornecedor, :produto, :quantidade, :valor, :total, :motorista, :placa, :km, :km_antigo, :consumo, :pago, :data, :hora, :user)";
			$cadastro_local = $PDO->prepare($sql_local);
			$cadastro_local->bindValue(":unidade", $unidade);
			$cadastro_local->bindValue(":data_compra", $data_compra);
			$cadastro_local->bindValue(":fornecedor", $fornecedor);
			$cadastro_local->bindValue(":produto", $produto);
			$cadastro_local->bindValue(":quantidade", $quantidade);
			$cadastro_local->bindValue(":valor", $valor);
			$cadastro_local->bindValue(":total", $total_db);
			$cadastro_local->bindValue(":motorista", $motorista);
			$cadastro_local->bindValue(":placa", $placa);
			$cadastro_local->bindValue(":km", $km);
			$cadastro_local->bindValue(":km_antigo", $km_antigo);
			$cadastro_local->bindValue(":consumo", $consumo);
			$cadastro_local->bindValue(":pago", $pago);
			$cadastro_local->bindValue(":data", $data);
			$cadastro_local->bindValue(":hora", $hora);
			$cadastro_local->bindValue(":user", $usuario);

			//validando registro
			$sql_validar_local = "SELECT * FROM `fornecimento_local` WHERE `unidade_producao` = ? AND `data_compra` = ? AND `fornecedor_local` = ? AND `produto_local` = ? AND `km_veiculo` = ?";
			$validar_local = $PDO->prepare($sql_validar_local);
			$validar_local->execute(array($unidade, $data_compra, $fornecedor, $produto, $km));

			if($validar_local->rowCount() == 0):
				$cadastro_local->execute();
				echo "<script>alert('Cadastro realizado com sucesso.')</script>";
			else:
				echo "<script>alert('Lançamento repetido.')</script>";
			endif;
		}
	}

	//Lançamento de fornecedor Externo
	if(isset($_POST['cadastro_externo'])){
		//Verificando se a unidade de produção foi selecionada.
		if(empty($_POST['unidade_producao_externo'])){
			echo "<script>alert('Faltou escolher a unidade de produção.')</script>";
		}else{
			$unidade = $_POST['unidade_producao_externo'];
		};

		//Verificando se o numero da nota fiscal foi preenchido.
		if(empty($_POST['nota_fiscal_externo'])){
			echo "<script>alert('Faltou preencher o número da nota fiscal.')</script>";
		}else{
			$nota_fiscal = $_POST['nota_fiscal_externo'];
		};

		$data_digitada = $_POST['data_emissao_externo'];
		$data_hoje = date('Y-m-d');

		$explode_digitada = explode('-', $data_digitada);
		$explode_hoje = explode('-', $data_hoje);
		$diferenca_ano = $explode_digitada[0] - $explode_hoje[0];
		$diferenca_mes = $explode_digitada[1] - $explode_hoje[1];
		$diferenca_dia = $explode_digitada[2] - $explode_hoje[2];
		
		if(empty($_POST['data_emissao_externo'])){
			echo "<script>alert('Faltou preencher a data de emissão.')</script>";
		}elseif($explode_digitada[0] > $explode_hoje[0]){
			echo "<script>alert('Ano digitado é maior que o de hoje.')</script>";
		}elseif($explode_digitada[1] > $explode_hoje[1]){
			echo "<script>alert('Mes digitado é maior que o de hoje.')</script>";
		}elseif($explode_digitada[2] > $explode_hoje[2]){
			if($explode_digitada[1] > $explode_hoje[1]){
				echo "<script>alert('Dia digitado é maior que o de hoje.')</script>";
			}else{
				$data_emissao = $_POST['data_emissao_externo'];
			};
		}else{
			$data_emissao = $_POST['data_emissao_externo'];
		};

		//Verificando se o fornecedor foi escolhido.
		if(empty($_POST['fornecedor_externo'])){
			echo "<script>alert('Faltou escolher o fornecedor.')</script>";
		}else{
			$fornecedor_externo = $_POST['fornecedor_externo'];
		};

		//Verificando se o valor total foi preenchido.
		if(empty($_POST['valor_total_externo']) || $_POST['valor_total_externo'] == "R$0,00"){
			echo "<script>alert('Faltou preencher o valor total.')</script>";
		}else{
			$valor_total = str_replace(".", "", str_replace("R$", "", $_POST['valor_total_externo']));
			$valor_total1 = str_replace(",", ".", $valor_total);
		};
		$data = date('Y/m/d');
		$hora = date('H:i:s');
		$usuario = $_SESSION['login'];
		//Verificando se a forma de pagamento foi escolhido.
		if(empty($_POST['forma_pagamento'])){
			echo "<script>alert('Faltou escolher qual a forma de pagamento.')</script>";
		}else{
			$forma_pagamento = $_POST['forma_pagamento'];
		};
		if(empty($unidade) || empty($nota_fiscal) || empty($data_emissao) || empty($fornecedor_externo) 
			|| empty($valor_total1) || $data_emissao > date('Y-m-d')){
			echo "<script>alert('Por favor digite os campos solicitados.')</script>";
		}else{
			//Verificando se a forma de pagamento foi antecipada.
			if($_POST['forma_pagamento'] == "antecipado"){

				//PAGAMENTO REALIZADO ENTAO SIM
				$pago = "1";

				//Verificando se a forma antecipado foi escolhido (Deposito, Boleto ou cheque)
				if(empty($_POST['forma_antecipado'])){
					echo "<script>alert('Faltou escolher a forma de pagamento antecipado.')</script>";
				}else{
					$forma_antecipado = $_POST['forma_antecipado'];
				};

				//Verificando se a data de pagamento foi preenchida.
				if(empty($_POST['data_pagamento_antecipado'])){
					echo "<script>alert('Faltou preencher a data de pagamento antecipado.')</script>";
				}else{
					$data_pagamento_antecipado = $_POST['data_pagamento_antecipado'];
				};

				//Enviando para o banco de dados os dados acima
				$sql_externo_antecipado = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `forma_antecipado`, `data_unico`, `pago`,  `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :forma_antecipado, :data_antecipado, :pago, :data, :hora, :user)";
				$cadastro_externo_antecipado = $PDO->prepare($sql_externo_antecipado);
				$cadastro_externo_antecipado->bindValue(":unidade", $unidade);
				$cadastro_externo_antecipado->bindValue(":nota", $nota_fiscal);
				$cadastro_externo_antecipado->bindValue(":emissao", $data_emissao);
				$cadastro_externo_antecipado->bindValue(":fornecedor", $fornecedor_externo);
				$cadastro_externo_antecipado->bindValue(":valor", $valor_total1);
				$cadastro_externo_antecipado->bindValue(":forma_pagamento", $forma_pagamento);
				$cadastro_externo_antecipado->bindValue(":forma_antecipado", $forma_antecipado);
				$cadastro_externo_antecipado->bindValue(":data_antecipado", $data_pagamento_antecipado);
				$cadastro_externo_antecipado->bindValue(":pago", $pago);
				$cadastro_externo_antecipado->bindValue(":data", $data);
				$cadastro_externo_antecipado->bindValue(":hora", $hora);
				$cadastro_externo_antecipado->bindValue(":user", $usuario);

				//Validando nota fiscal digitanda
				$sql_validar_externo_antecipado = "SELECT * FROM `fornecimento_externo` WHERE `nota_fiscal` = ? AND `fornecedor_externo` = ?";
				$validar_externo_antecipado = $PDO->prepare($sql_validar_externo_antecipado);
				$validar_externo_antecipado->execute(array($nota_fiscal, $fornecedor_externo));

				if($validar_externo_antecipado->rowCount() == 0):
					$cadastro_externo_antecipado->execute();
					echo "<script>alert('Cadastro realizado com sucesso.')</script>";
				else:
					echo "<script>alert('Lançamento repetido.')</script>";
				endif;

			//Verificando se a forma de pagamento foi à vista.
			}elseif($_POST['forma_pagamento'] == "avista"){

				//PAGAMENTO REALIZADO ENTAO SIM
				$pago = "1";

				//Verificando se a forma à vista foi escolhido (Deposito, Boleto ou cheque).
				if(empty($_POST['forma_avista'])){
					echo "<script>alert('Faltou escolher a forma de pagamento à vista.')</script>";
				}else{
					$forma_avista = $_POST['forma_avista'];
				};

				//Verificando se a data de pagamento foi preenchida.
				if(empty($_POST['data_pagamento_avista'])){
					echo "<script>alert('Faltou preencher a data de pagamento à vista.')</script>";
				}else{
					$data_pagamento_avista = $_POST['data_pagamento_avista'];
				};

				$sql_externo_avista = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `forma_avista`, `data_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :forma_avista, :data_avista, :pago, :data, :hora, :user)";
				$cadastro_externo_avista = $PDO->prepare($sql_externo_avista);
				$cadastro_externo_avista->bindValue(":unidade", $unidade);
				$cadastro_externo_avista->bindValue(":nota", $nota_fiscal);
				$cadastro_externo_avista->bindValue(":emissao", $data_emissao);
				$cadastro_externo_avista->bindValue(":fornecedor", $fornecedor_externo);
				$cadastro_externo_avista->bindValue(":valor", $valor_total1);
				$cadastro_externo_avista->bindValue(":forma_pagamento", $forma_pagamento);
				$cadastro_externo_avista->bindValue(":forma_avista", $forma_avista);
				$cadastro_externo_avista->bindValue(":data_avista", $data_pagamento_avista);
				$cadastro_externo_avista->bindValue(":pago", $pago);
				$cadastro_externo_avista->bindValue(":data", $data);
				$cadastro_externo_avista->bindValue(":hora", $hora);
				$cadastro_externo_avista->bindValue(":user", $usuario);
				
				//Validando nota fiscal digitanda
				$sql_validar_externo_avista = "SELECT * FROM `fornecimento_externo` WHERE `nota_fiscal` = ? AND `fornecedor_externo` = ?";
				$validar_externo_avista = $PDO->prepare($sql_validar_externo_avista);
				$validar_externo_avista->execute(array($nota_fiscal, $fornecedor_externo));

				if($validar_externo_avista->rowCount() == 0):
					$cadastro_externo_avista->execute();
					echo "<script>alert('Cadastro realizado com sucesso.')</script>";
				else:
					echo "<script>alert('Lançamento repetido.')</script>";
				endif;

			//Verificando se a forma de pagamento foi a prazo.
			}elseif($_POST['forma_pagamento'] == "aprazo"){

				//Pagamento aprazo = Não
				$pago = "2";

				//Verificando a quantidade de parcelas foi selecionada.
				if(empty($_POST['quantidade_parcela'])){
					echo "<script>alert('Faltou escolher a quantidade de parcela.')</script>";
				}else{
					$quantidade_parcela = $_POST['quantidade_parcela'];
				};

				//Criando Quantidade de Parcela
				$parcela = "1/1";
				$parcela1 = "1/".$quantidade_parcela;
				$parcela2 = "2/".$quantidade_parcela;
				$parcela3 = "3/".$quantidade_parcela;
				$parcela4 = "4/".$quantidade_parcela;
				$parcela5 = "5/".$quantidade_parcela;
				$parcela6 = "6/".$quantidade_parcela;

				//Verificando se a data da parcela unica foi preenchida.
				if(empty($_POST['data_parcela_unica'])){
					$data_parcela_unica = "00/00/0000";
				}else{
					$data_parcela_unica = $_POST['data_parcela_unica'];
				};

				//Verificando se a data da 1ª parcela foi preenchida.
				if(empty($_POST['primeiro_vencimento_externo'])){
					$primeiro_vencimento_externo = "00/00/0000";
				}else{
					$primeiro_vencimento_externo = $_POST['primeiro_vencimento_externo'];
				};

				//Verificando se o valor da 1ª parcela foi preenchido.
				if(empty($_POST['valor_primeiro_externo']) || $_POST['valor_primeiro_externo'] == "R$0,00"){
					$valor_primeiro_externo = "";
				}else{
					$valor_primeiro = str_replace(".", "", str_replace("R$", "", $_POST['valor_primeiro_externo']));
					$valor_primeiro_externo = str_replace(",", ".", $valor_primeiro);
				};

				//Verificando se a data da 2ª parcela foi preenchida.
				if(empty($_POST['segundo_vencimento_externo'])){
					$segundo_vencimento_externo = "00/00/0000";
				}else{
					$segundo_vencimento_externo = $_POST['segundo_vencimento_externo'];
				};

				//Verificando se o valor da 2ª parcela foi preenchido.
				if(empty($_POST['valor_segundo_externo']) || $_POST['valor_segundo_externo'] == "R$0,00"){
					$valor_segundo_externo = "";
				}else{
					$valor_segundo = str_replace(".", "", str_replace("R$", "", $_POST['valor_segundo_externo']));
					$valor_segundo_externo = str_replace(",", ".", $valor_segundo);
				};

				//Verificando se a data da 3ª parcela foi preenchida.
				if(empty($_POST['terceiro_vencimento_externo'])){
					$terceiro_vencimento_externo = "00/00/0000";
				}else{
					$terceiro_vencimento_externo = $_POST['terceiro_vencimento_externo'];
				};

				//Verificando se o valor da 3ª parcela foi preenchido.
				if(empty($_POST['valor_terceiro_externo']) || $_POST['valor_terceiro_externo'] == "R$0,00"){
					$valor_terceiro_externo = "";
				}else{
					$valor_terceiro = str_replace(".", "", str_replace("R$", "", $_POST['valor_terceiro_externo']));
					$valor_terceiro_externo = str_replace(",", ".", $valor_terceiro);
				};

				//Verificando se a data da 4ª parcela foi preenchida.
				if(empty($_POST['quarto_vencimento_externo'])){
					$quarto_vencimento_externo = "00/00/0000";
				}else{
					$quarto_vencimento_externo = $_POST['quarto_vencimento_externo'];
				};

				//Verificando se o valor da 4ª parcela foi preenchido.
				if(empty($_POST['valor_quarto_externo']) || $_POST['valor_quarto_externo'] == "R$0,00"){
					$valor_quarto_externo = "";
				}else{
					$valor_quarto = str_replace(".", "", str_replace("R$", "", $_POST['valor_quarto_externo']));
					$valor_quarto_externo = str_replace(",", ".", $valor_quarto);
				};

				//Verificando se a data da 5ª parcela foi preenchida.
				if(empty($_POST['quinto_vencimento_externo'])){
					$quinto_vencimento_externo = "00/00/0000";
				}else{
					$quinto_vencimento_externo = $_POST['quinto_vencimento_externo'];
				};

				//Verificando se o valor da 5ª parcela foi preenchido.
				if(empty($_POST['valor_quinto_externo']) || $_POST['valor_quinto_externo'] == "R$0,00"){
					$valor_quinto_externo = "";
				}else{
					$valor_quinto = str_replace(".", "", str_replace("R$", "", $_POST['valor_quinto_externo']));
					$valor_quinto_externo = str_replace(",", ".", $valor_quinto);
				};

				//Verificando se a data da 6ª parcela foi preenchida.
				if(empty($_POST['sexto_vencimento_externo'])){
					$sexto_vencimento_externo = "00/00/00000";
				}else{
					$sexto_vencimento_externo = $_POST['sexto_vencimento_externo'];
				};

				//Verificando se o valor da 6ª parcela foi preenchido.
				if(empty($_POST['valor_sexto_externo']) || $_POST['valor_sexto_externo'] == "R$0,00"){
					$valor_sexto_externo = "";
				}else{
					$valor_sexto = str_replace(".", "", str_replace("R$", "", $_POST['valor_sexto_externo']));
					$valor_sexto_externo = str_replace(",", ".", $valor_sexto);
				};

				//Verificar os valores das parcelas se batem com o valor total
				if($quantidade_parcela == "1"){
					$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela, :data_parcela, :valor_parcela, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela", $parcela);
						$cadastro_parcela->bindValue(":data_parcela", $data_parcela_unica);
						$cadastro_parcela->bindValue(":valor_parcela", $valor_total1);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
				}elseif($quantidade_parcela == "2"){
					$soma_parcelas = $valor_primeiro_externo + $valor_segundo_externo;
					$soma_moeda = number_format($soma_parcelas, 2, '.', '');
					if($soma_moeda !== $valor_total1){
					echo "<script>alert('Valor das parcelas não batem com o valor total.')</script>";
					}else{
						$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela1, :data_parcela1, :valor_parcela1, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela2, :data_parcela2, :valor_parcela2, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela1", $parcela1);
						$cadastro_parcela->bindValue(":data_parcela1", $primeiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela1", $valor_primeiro_externo);
						$cadastro_parcela->bindValue(":parcela2", $parcela2);
						$cadastro_parcela->bindValue(":data_parcela2", $segundo_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela2", $valor_segundo_externo);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
					};
				}elseif($quantidade_parcela == "3"){
					$soma_parcelas = $valor_primeiro_externo + $valor_segundo_externo + $valor_terceiro_externo;
					$soma_moeda = number_format($soma_parcelas, 2, '.', '');
					if($soma_moeda !== $valor_total1){
					echo "<script>alert('Valor das parcelas não batem com o valor total.')</script>";
					}else{
						$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela1, :data_parcela1, :valor_parcela1, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela2, :data_parcela2, :valor_parcela2, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela3, :data_parcela3, :valor_parcela3, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela1", $parcela1);
						$cadastro_parcela->bindValue(":data_parcela1", $primeiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela1", $valor_primeiro_externo);
						$cadastro_parcela->bindValue(":parcela2", $parcela2);
						$cadastro_parcela->bindValue(":data_parcela2", $segundo_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela2", $valor_segundo_externo);
						$cadastro_parcela->bindValue(":parcela3", $parcela3);
						$cadastro_parcela->bindValue(":data_parcela3", $terceiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela3", $valor_terceiro_externo);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
					};
				}elseif($quantidade_parcela == "4"){
					$soma_parcelas = $valor_primeiro_externo + $valor_segundo_externo + $valor_terceiro_externo + $valor_quarto_externo;
					$soma_moeda = number_format($soma_parcelas, 2, '.', '');
					if($soma_moeda !== $valor_total1){
					echo "<script>alert('Valor das parcelas não batem com o valor total.')</script>";
					}else{
						$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela1, :data_parcela1, :valor_parcela1, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela2, :data_parcela2, :valor_parcela2, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela3, :data_parcela3, :valor_parcela3, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela4, :data_parcela4, :valor_parcela4, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela1", $parcela1);
						$cadastro_parcela->bindValue(":data_parcela1", $primeiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela1", $valor_primeiro_externo);
						$cadastro_parcela->bindValue(":parcela2", $parcela2);
						$cadastro_parcela->bindValue(":data_parcela2", $segundo_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela2", $valor_segundo_externo);
						$cadastro_parcela->bindValue(":parcela3", $parcela3);
						$cadastro_parcela->bindValue(":data_parcela3", $terceiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela3", $valor_terceiro_externo);
						$cadastro_parcela->bindValue(":parcela4", $parcela4);
						$cadastro_parcela->bindValue(":data_parcela4", $quarto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela4", $valor_quarto_externo);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
					};
				}elseif($quantidade_parcela == "5"){
					$soma_parcelas = $valor_primeiro_externo + $valor_segundo_externo + $valor_terceiro_externo + $valor_quarto_externo + $valor_quinto_externo;
					$soma_moeda = number_format($soma_parcelas, 2, '.', '');
					if($soma_moeda !== $valor_total1){
					echo "<script>alert('Valor das parcelas não batem com o valor total.')</script>";
					}else{
						$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela1, :data_parcela1, :valor_parcela1, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela2, :data_parcela2, :valor_parcela2, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela3, :data_parcela3, :valor_parcela3, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela4, :data_parcela4, :valor_parcela4, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela5, :data_parcela5, :valor_parcela5, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela1", $parcela1);
						$cadastro_parcela->bindValue(":data_parcela1", $primeiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela1", $valor_primeiro_externo);
						$cadastro_parcela->bindValue(":parcela2", $parcela2);
						$cadastro_parcela->bindValue(":data_parcela2", $segundo_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela2", $valor_segundo_externo);
						$cadastro_parcela->bindValue(":parcela3", $parcela3);
						$cadastro_parcela->bindValue(":data_parcela3", $terceiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela3", $valor_terceiro_externo);
						$cadastro_parcela->bindValue(":parcela4", $parcela4);
						$cadastro_parcela->bindValue(":data_parcela4", $quarto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela4", $valor_quarto_externo);
						$cadastro_parcela->bindValue(":parcela5", $parcela5);
						$cadastro_parcela->bindValue(":data_parcela5", $quinto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela5", $valor_quinto_externo);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
					};
				}elseif($quantidade_parcela == "6"){
					$soma_parcelas = $valor_primeiro_externo + $valor_segundo_externo + $valor_terceiro_externo + $valor_quarto_externo + $valor_quinto_externo + $valor_sexto_externo;
					$soma_moeda = number_format($soma_parcelas, 2, '.', '');
					if($soma_moeda !== $valor_total1){
					echo "<script>alert('Valor das parcelas não batem com o valor total.')</script>";
					}else{
						$sql_parcela = "INSERT INTO `fornecimento_externo`(`unidade_producao`, `nota_fiscal`, `data_emissao`, `fornecedor_externo`, `valor_total`, `forma_pagamento`, `quantidade_parcela`, `parcela`, `data_unico`, `valor_unico`, `pago`, `data_cadastro`, `hora_cadastro`, `usuario_cadastro`) VALUES (:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela1, :data_parcela1, :valor_parcela1, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela2, :data_parcela2, :valor_parcela2, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela3, :data_parcela3, :valor_parcela3, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela4, :data_parcela4, :valor_parcela4, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela5, :data_parcela5, :valor_parcela5, :pago, :data, :hora, :user),(:unidade, :nota, :emissao, :fornecedor, :valor, :forma_pagamento, :quantidade_parcela, :parcela6, :data_parcela6, :valor_parcela6, :pago, :data, :hora, :user)";
						$cadastro_parcela = $PDO->prepare($sql_parcela);
						$cadastro_parcela->bindValue(":unidade", $unidade);
						$cadastro_parcela->bindValue(":nota", $nota_fiscal);
						$cadastro_parcela->bindValue(":emissao", $data_emissao);
						$cadastro_parcela->bindValue(":fornecedor", $fornecedor_externo);
						$cadastro_parcela->bindValue(":valor", $valor_total1);
						$cadastro_parcela->bindValue(":forma_pagamento", $forma_pagamento);
						$cadastro_parcela->bindValue(":quantidade_parcela", $quantidade_parcela);
						$cadastro_parcela->bindValue(":parcela1", $parcela1);
						$cadastro_parcela->bindValue(":data_parcela1", $primeiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela1", $valor_primeiro_externo);
						$cadastro_parcela->bindValue(":parcela2", $parcela2);
						$cadastro_parcela->bindValue(":data_parcela2", $segundo_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela2", $valor_segundo_externo);
						$cadastro_parcela->bindValue(":parcela3", $parcela3);
						$cadastro_parcela->bindValue(":data_parcela3", $terceiro_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela3", $valor_terceiro_externo);
						$cadastro_parcela->bindValue(":parcela4", $parcela4);
						$cadastro_parcela->bindValue(":data_parcela4", $quarto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela4", $valor_quarto_externo);
						$cadastro_parcela->bindValue(":parcela5", $parcela5);
						$cadastro_parcela->bindValue(":data_parcela5", $quinto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela5", $valor_quinto_externo);
						$cadastro_parcela->bindValue(":parcela6", $parcela6);
						$cadastro_parcela->bindValue(":data_parcela6", $sexto_vencimento_externo);
						$cadastro_parcela->bindValue(":valor_parcela6", $valor_sexto_externo);
						$cadastro_parcela->bindValue(":pago", $pago);
						$cadastro_parcela->bindValue(":data", $data);
						$cadastro_parcela->bindValue(":hora", $hora);
						$cadastro_parcela->bindValue(":user", $usuario);
						$cadastro_parcela->execute();
						echo "<script>alert('Cadastro realizado com sucesso.')</script>";
					};
				};
			};
		};
	};
	
	//Selecionando Fornecedor para listar na pagina de cadastro do produto
	$sql_selecionar_fornecedor = "SELECT * FROM fornecedor";
	$exibir_fornecedor = $PDO->prepare($sql_selecionar_fornecedor);
	$exibir_fornecedor->execute();
	$fetch_fornecedor = $exibir_fornecedor->fetch(PDO::FETCH_ASSOC);

	//Selecionando Fornecedor local para listar na pagina de registro.
	$sql_selecionar_fornecedor_local = "SELECT * FROM fornecedor WHERE tipo_fornecedor = 'Local' AND status = '1'";
	$exibir_fornecedor_local = $PDO->prepare($sql_selecionar_fornecedor_local);
	$exibir_fornecedor_local->execute();
	$fetch_fornecedor_local = $exibir_fornecedor_local->fetch(PDO::FETCH_ASSOC);

	//Selecionando Fornecedor Externo para listar na pagina de registro.
	$sql_selecionar_fornecedor_externo = "SELECT * FROM fornecedor WHERE tipo_fornecedor = 'Externo' AND status = '1'";
	$exibir_fornecedor_externo = $PDO->prepare($sql_selecionar_fornecedor_externo);
	$exibir_fornecedor_externo->execute();
	$fetch_fornecedor_externo = $exibir_fornecedor_externo->fetch(PDO::FETCH_ASSOC);

	//Selecionando as unidades de produção no banco de dados
	$sql_selecionar_unidade = "SELECT * FROM unidade_producao";
	$exibir_unidade = $PDO->prepare($sql_selecionar_unidade);
	$exibir_unidade->execute();
	$fetch_unidade = $exibir_unidade->fetch(PDO::FETCH_ASSOC);

	//Selecionando as unidades de produção ativos no banco de dados
	$sql_unidade_ativo = "SELECT * FROM unidade_producao WHERE status = '1'";
	$exibir_unidade_ativo = $PDO->prepare($sql_unidade_ativo);
	$exibir_unidade_ativo->execute();
	$fetch_unidade_ativo = $exibir_unidade_ativo->fetch(PDO::FETCH_ASSOC);

	//Selecionando o produto no bando de dados
	$sql_selecionar_produto = "SELECT * FROM produto";
	$exibir_produto = $PDO->prepare($sql_selecionar_produto);
	$exibir_produto->execute();
	$fetch_produto = $exibir_produto->fetch(PDO::FETCH_ASSOC);

	//Selecionando os dados da tabela fornecimento local no bando de dados
	$sql_selecionar_veiculo = "SELECT DISTINCT placa_veiculo FROM fornecimento_local WHERE placa_veiculo <> ''";
	$exibir_veiculo = $PDO->prepare($sql_selecionar_veiculo);
	$exibir_veiculo->execute();
	$fetch_veiculo = $exibir_veiculo->fetch(PDO::FETCH_ASSOC);

	//Selecionando os produtos que são combustivel no bando de dados
	$sql_selecionar_combustivel = "SELECT * FROM produto WHERE pergunta_combustivel = 'sim'";
	$exibir_combustivel = $PDO->prepare($sql_selecionar_combustivel);
	$exibir_combustivel->execute();
	$fetch_combustivel = $exibir_combustivel->fetch(PDO::FETCH_ASSOC);

	//Selecionando todos os usuarios do banco de dados
	$sql_selecionar_users = "SELECT * FROM users ORDER BY `status` ASC";
	$exibir_users = $PDO->prepare($sql_selecionar_users);
	$exibir_users->execute();
	$fetch_users = $exibir_users->fetch(PDO::FETCH_ASSOC);

	//Selecionando todos os lançamentos Locais
	//LL = Lançamento Local
	$sql_selecionar_LL = "SELECT * FROM `fornecimento_local` ORDER BY `pago` DESC, `data_compra` DESC";
	$exibir_LL = $PDO->prepare($sql_selecionar_LL);
	$exibir_LL->execute();
	$fetch_LL = $exibir_LL->fetch(PDO::FETCH_ASSOC);

	//Selecionando todos os lançamentos Externos
	//LE = Lançamento Externo
	$sql_selecionar_LE = "SELECT * FROM `fornecimento_externo` ORDER BY `pago` DESC";
	$exibir_LE = $PDO->prepare($sql_selecionar_LE);
	$exibir_LE->execute();
	$fetch_LE = $exibir_LE->fetch(PDO::FETCH_ASSOC);
?>