-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06/06/2025 às 19:32
-- Versão do servidor: 8.0.42
-- Versão do PHP: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `loginsporttown`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `camps`
--

CREATE TABLE `camps` (
  `id` int NOT NULL,
  `nome` varchar(500) NOT NULL,
  `nome_dono` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `senha` varchar(225) NOT NULL,
  `nicho` varchar(500) NOT NULL,
  `endereço` varchar(1000) NOT NULL,
  `imagem_anuncio` varchar(1000) NOT NULL,
  `imagem_quadra` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `camps`
--

INSERT INTO `camps` (`id`, `nome`, `nome_dono`, `email`, `senha`, `nicho`, `endereço`, `imagem_anuncio`, `imagem_quadra`) VALUES
(1, 'CAMP sales', 'Plasticos', 'plasticos@h.com', '123', 'Tênis de Mesa', 'Rua Pereira N°1556', 'jj', 'jj'),
(2, 'CAMP sales', 'Plasticos', 'plasticos@h.com', '123', 'Tênis de Mesa', 'Rua Pereira N°1556', 'jj', 'jj');

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id` int NOT NULL,
  `nome` varchar(500) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `email` varchar(500) NOT NULL,
  `senha` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id`, `nome`, `cnpj`, `email`, `senha`) VALUES
(3, 'Plasticos', '001002', 'plasticos@h.com', '$2y$10$fh236Kq/gkEMfMAWhGE5Gu.KMS8JIRnpvsqdfoVjywsAEjwWjYajm');

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `tipo` enum('usuario','empresa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(140) NOT NULL,
  `senha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(17, 'Heitor', 'lima@lima.com', '$2y$10$VeQv/j6aNCg5geXAVJpTgOmpX62WFibAfzVzzdBc/LXVmBwXCwS9C'),
(18, 'Witney', 'heitor.lima@aluno.ce.gov.br', '$2y$10$zW7dzJ42dZrJ3961H3VWb.JQJbODa3M70U7eKyGzulV.8JdN194FC'),
(21, 'kk', 'pp@pp.com', '$2y$10$VI4hn/bJPu7pVhmZeht8tu2t4Sy5ZMK8aYOoMhe.4IAx6IAlQYN6S');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `camps`
--
ALTER TABLE `camps`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `camps`
--
ALTER TABLE `camps`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
