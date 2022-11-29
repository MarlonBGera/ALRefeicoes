-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 16-Set-2017 às 03:20
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alrefeicoes`
--
CREATE DATABASE IF NOT EXISTS `alrefeicoes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `alrefeicoes`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

DROP TABLE IF EXISTS `fornecedor`;
CREATE TABLE `fornecedor` (
  `id` int(11) NOT NULL,
  `tipo_fornecedor` varchar(50) NOT NULL,
  `razao_social` varchar(50) NOT NULL,
  `nome_fantasia` varchar(50) NOT NULL,
  `cnpj_fornecedor` varchar(50) NOT NULL,
  `inscricao_estadual` varchar(50) NOT NULL,
  `endereco_fornecedor` varchar(50) NOT NULL,
  `telefone1_fornecedor` varchar(50) NOT NULL,
  `telefone2_fornecedor` varchar(50) DEFAULT NULL,
  `telefone3_fornecedor` varchar(50) DEFAULT NULL,
  `email_fornecedor` varchar(50) NOT NULL,
  `contato1_fornecedor` varchar(50) NOT NULL,
  `contato2_fornecedor` varchar(50) DEFAULT NULL,
  `contato3_fornecedor` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento_externo`
--

DROP TABLE IF EXISTS `fornecimento_externo`;
CREATE TABLE `fornecimento_externo` (
  `id` int(11) NOT NULL,
  `unidade_producao` varchar(50) DEFAULT NULL,
  `nota_fiscal` varchar(50) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `fornecedor_externo` varchar(50) DEFAULT NULL,
  `valor_total` varchar(50) DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `forma_antecipado` varchar(50) DEFAULT NULL,
  `forma_avista` varchar(50) DEFAULT NULL,
  `quantidade_parcela` varchar(5) DEFAULT NULL,
  `parcela` varchar(50) DEFAULT NULL,
  `data_unico` date DEFAULT NULL,
  `valor_unico` varchar(50) DEFAULT NULL,
  `pago` int(11) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `hora_cadastro` time DEFAULT NULL,
  `usuario_cadastro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento_externo2`
--

DROP TABLE IF EXISTS `fornecimento_externo2`;
CREATE TABLE `fornecimento_externo2` (
  `id` int(11) NOT NULL,
  `unidade_producao` varchar(50) DEFAULT NULL,
  `nota_fisca` varchar(50) DEFAULT NULL,
  `data_emissao` date DEFAULT NULL,
  `fornecedor_externo` varchar(50) DEFAULT NULL,
  `valor_total` varchar(50) DEFAULT NULL,
  `forma_pagamento` varchar(50) DEFAULT NULL,
  `forma_antecipado` varchar(50) DEFAULT NULL,
  `data_antecipado` date DEFAULT NULL,
  `forma_avista` varchar(50) DEFAULT NULL,
  `data_avista` date DEFAULT NULL,
  `quantidade_parcela` varchar(5) DEFAULT NULL,
  `data_unico` date DEFAULT NULL,
  `valor_unico` varchar(50) DEFAULT NULL,
  `primeiro_vencimento` date DEFAULT NULL,
  `valor_primeiro` varchar(50) DEFAULT NULL,
  `segundo_vencimento` date DEFAULT NULL,
  `valor_segundo` varchar(50) DEFAULT NULL,
  `terceiro_vencimento` date DEFAULT NULL,
  `valor_terceiro` varchar(50) DEFAULT NULL,
  `quarto_vencimento` date DEFAULT NULL,
  `valor_quarto` varchar(50) DEFAULT NULL,
  `quinto_vencimento` date DEFAULT NULL,
  `valor_quinto` varchar(50) DEFAULT NULL,
  `sexto_vencimento` date DEFAULT NULL,
  `valor_sexto` varchar(50) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `hora_cadastro` time DEFAULT NULL,
  `usuario_cadastro` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecimento_local`
--

DROP TABLE IF EXISTS `fornecimento_local`;
CREATE TABLE `fornecimento_local` (
  `id` int(11) NOT NULL,
  `unidade_producao` varchar(50) NOT NULL,
  `data_compra` varchar(50) NOT NULL,
  `fornecedor_local` varchar(50) NOT NULL,
  `produto_local` varchar(50) NOT NULL,
  `quantidade` varchar(20) NOT NULL,
  `valor_unitario` varchar(50) NOT NULL,
  `total_produto` varchar(50) NOT NULL,
  `motorista_veiculo` varchar(50) DEFAULT NULL,
  `placa_veiculo` varchar(50) DEFAULT NULL,
  `km_veiculo` varchar(50) DEFAULT NULL,
  `km_antigo` varchar(50) DEFAULT NULL,
  `consumo_combustivel` varchar(50) DEFAULT NULL,
  `pago` int(11) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `motorista`
--

DROP TABLE IF EXISTS `motorista`;
CREATE TABLE `motorista` (
  `id` int(11) NOT NULL,
  `nome_motorista` varchar(50) NOT NULL,
  `numero_cnh` varchar(50) NOT NULL,
  `categoria_cnh` varchar(50) NOT NULL,
  `validade_cnh` date NOT NULL,
  `idade` varchar(20) NOT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `fornecedor` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `unidade_medida` varchar(50) NOT NULL,
  `preco_unitario` varchar(20) NOT NULL,
  `pergunta_combustivel` varchar(3) NOT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_producao`
--

DROP TABLE IF EXISTS `unidade_producao`;
CREATE TABLE `unidade_producao` (
  `id` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `unidade` varchar(50) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

DROP TABLE IF EXISTS `veiculo`;
CREATE TABLE `veiculo` (
  `id` int(11) NOT NULL,
  `descricao_veiculo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `placa_veiculo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `km_veiculo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `proprietario_veiculo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `renavan_veiculo` varchar(20) CHARACTER SET latin1 NOT NULL,
  `consumo_veiculo` varchar(50) CHARACTER SET latin1 NOT NULL,
  `data_cadastro` date NOT NULL,
  `hora_cadastro` time NOT NULL,
  `usuario_cadastro` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecimento_externo`
--
ALTER TABLE `fornecimento_externo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecimento_externo2`
--
ALTER TABLE `fornecimento_externo2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fornecimento_local`
--
ALTER TABLE `fornecimento_local`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motorista`
--
ALTER TABLE `motorista`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unidade_producao`
--
ALTER TABLE `unidade_producao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `fornecimento_externo`
--
ALTER TABLE `fornecimento_externo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecimento_externo2`
--
ALTER TABLE `fornecimento_externo2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fornecimento_local`
--
ALTER TABLE `fornecimento_local`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `motorista`
--
ALTER TABLE `motorista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `unidade_producao`
--
ALTER TABLE `unidade_producao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
