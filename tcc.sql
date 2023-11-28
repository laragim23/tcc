-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Nov-2023 às 17:18
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tcc`
--
CREATE DATABASE IF NOT EXISTS `tcc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tcc`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `endereco` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `cpf`, `telefone`, `cidade`, `estado`, `endereco`, `status`) VALUES
(17, 'Lara de Souza Gimenez', '150.955.169-77', '(44) 99753-4307', 'Cruzeiro do Oeste', 'Selecione', 'Rua Walter Vollbrecht 599', 'inativo'),
(18, 'Iara Agnelo', '084.343.659-01', '(44) 99754-1578', 'Cruzeiro do Oeste', 'PR', 'Rua Walter Vollbrecht 599', ''),
(22, 'Camila Rocha', '946.598.569-48', '(44) 94589-4385', '', 'Selecione', '', ''),
(23, 'Daniela Costa', '568.468.838-74', '(44) 92859-4385', '', 'Selecione', '', ''),
(30, 'João Bidoia', '150.955.169-77', '', '', 'Selecione', '', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `compravenda`
--

CREATE TABLE `compravenda` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vendedor_id` int(11) DEFAULT NULL,
  `desconto` double NOT NULL,
  `datacriacao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `compravenda`
--

INSERT INTO `compravenda` (`id`, `cliente_id`, `vendedor_id`, `desconto`, `datacriacao`) VALUES
(18, 22, 0, 0, '2023-11-23 15:52:13'),
(38, 17, 1, 0, '2023-11-28 08:38:12'),
(39, 17, NULL, 0, '2023-11-28 08:38:12'),
(40, 30, 1, 0, '2023-11-28 08:49:56'),
(41, 30, NULL, 0, '2023-11-28 08:49:56');

-- --------------------------------------------------------

--
-- Estrutura da tabela `compravendaproduto`
--

CREATE TABLE `compravendaproduto` (
  `id` int(11) NOT NULL,
  `compravenda_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valorunitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `compravendaproduto`
--

INSERT INTO `compravendaproduto` (`id`, `compravenda_id`, `produto_id`, `quantidade`, `valorunitario`) VALUES
(21, 38, 21, 1, 229.9),
(22, 40, 21, 1, 229.9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `condicional`
--

CREATE TABLE `condicional` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `condicional`
--

INSERT INTO `condicional` (`id`, `cliente_id`, `vendedor_id`, `data`) VALUES
(26, 17, 1, '2023-11-25 11:06:28'),
(27, 17, 0, '2023-11-25 11:06:28');

-- --------------------------------------------------------

--
-- Estrutura da tabela `condicionalproduto`
--

CREATE TABLE `condicionalproduto` (
  `id` int(11) NOT NULL,
  `condicional_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valorunitario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `condicionalproduto`
--

INSERT INTO `condicionalproduto` (`id`, `condicional_id`, `produto_id`, `quantidade`, `valorunitario`) VALUES
(14, 26, 17, 1, 129.9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `valor` float NOT NULL,
  `codBarras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `nome`, `sigla`, `valor`, `codBarras`) VALUES
(9, 'CAMISETA COM ALÇAS E NERVURAS', '', 89.9, 3253),
(15, 'TOP COM TIRAS', '', 119.9, 4424),
(16, 'CAMISETA CROPPED COM NERVURAS', '', 79.9, 3255),
(18, 'VESTIDO CURTO JUSTO', '', 159.9, 4174),
(19, 'TOP CROPPED CANELADO DE MALHA', '', 129.9, 3519),
(20, 'VESTIDO JUSTO MIDI COM DETALHES FRANZIDOS', '', 179.9, 4174),
(21, 'CALÇA FLUIDA WIDE LEG', '', 229.9, 9929),
(22, 'JEANS MOM FIT E CINTURA ALTA', '', 259.9, 7223);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `tipo` char(1) NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `usuario`, `senha`, `tipo`, `data`) VALUES
(12, 'Lara Gimenez', 'laradesouzagimenez23@gmail.com', 'lara', '123@', '1', '2023-11-18 10:53:44');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `valorTotal` float NOT NULL,
  `formaPagamento` varchar(20) NOT NULL,
  `quantidadeParcelas` varchar(20) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendedor`
--

CREATE TABLE `vendedor` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `vendedor`
--

INSERT INTO `vendedor` (`id`, `nome`, `telefone`, `endereco`, `status`) VALUES
(1, 'Maria Silva', '(44) 99840-9328', 'Rua Paraná 300', 'inativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `compravenda`
--
ALTER TABLE `compravenda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente` (`cliente_id`),
  ADD KEY `vendedor_id` (`vendedor_id`);

--
-- Índices para tabela `compravendaproduto`
--
ALTER TABLE `compravendaproduto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compravenda` (`compravenda_id`),
  ADD KEY `fk_produto` (`produto_id`);

--
-- Índices para tabela `condicional`
--
ALTER TABLE `condicional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cliente_condicional` (`cliente_id`),
  ADD KEY `fk_vendedor` (`vendedor_id`);

--
-- Índices para tabela `condicionalproduto`
--
ALTER TABLE `condicionalproduto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_condicional` (`condicional_id`),
  ADD KEY `fk_produto` (`produto_id`) USING BTREE;

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendedor_id` (`vendedor_id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `fk_produto_venda` (`produto_id`);

--
-- Índices para tabela `vendedor`
--
ALTER TABLE `vendedor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `compravenda`
--
ALTER TABLE `compravenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `compravendaproduto`
--
ALTER TABLE `compravendaproduto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `condicional`
--
ALTER TABLE `condicional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `condicionalproduto`
--
ALTER TABLE `condicionalproduto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `vendedor`
--
ALTER TABLE `vendedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `compravenda`
--
ALTER TABLE `compravenda`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `compravendaproduto`
--
ALTER TABLE `compravendaproduto`
  ADD CONSTRAINT `fk_compravenda` FOREIGN KEY (`compravenda_id`) REFERENCES `compravenda` (`id`),
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`);

--
-- Limitadores para a tabela `condicional`
--
ALTER TABLE `condicional`
  ADD CONSTRAINT `fk_cliente_condicional` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`);

--
-- Limitadores para a tabela `condicionalproduto`
--
ALTER TABLE `condicionalproduto`
  ADD CONSTRAINT `fk_condicional` FOREIGN KEY (`condicional_id`) REFERENCES `condicional` (`id`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `fk_cliente_venda` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`),
  ADD CONSTRAINT `fk_produto_venda` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `fk_vendedor_venda` FOREIGN KEY (`vendedor_id`) REFERENCES `vendedor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
