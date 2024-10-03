-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03/10/2024 às 20:37
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `maisautonomia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividades`
--

CREATE TABLE `atividades` (
  `id_atividades` int(5) NOT NULL,
  `titulo_atividades` varchar(30) NOT NULL,
  `desc_atividades` varchar(130) NOT NULL,
  `tag_atividades` varchar(10) NOT NULL,
  `id_servicos` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `id_avaliacao` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_servicos` int(5) NOT NULL,
  `titulo_avaliacao` varchar(30) NOT NULL,
  `desc_avaliacao` varchar(130) NOT NULL,
  `range_avaliacao` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `formacao_experiencia`
--

CREATE TABLE `formacao_experiencia` (
  `id_form_exp` int(5) NOT NULL,
  `titulo_form_exp` varchar(30) NOT NULL,
  `id_user` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(5) NOT NULL,
  `titulo_perfil` varchar(30) NOT NULL,
  `valor_perfil` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servicos` int(5) NOT NULL,
  `titulo_servicos` varchar(30) NOT NULL,
  `desc_servicos` varchar(130) NOT NULL,
  `valor_servicos` int(7) NOT NULL,
  `prazo_servicos` datetime NOT NULL,
  `id_cliente` int(5) NOT NULL,
  `id_autonomo` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_user` int(5) NOT NULL,
  `nome_user` varchar(100) NOT NULL,
  `email_user` varchar(70) NOT NULL,
  `senha_user` varchar(30) NOT NULL,
  `telefone_user` int(15) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `cep_user` int(8) NOT NULL,
  `avatar_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `id_user_perfil` int(5) NOT NULL,
  `id_user` int(5) NOT NULL,
  `id_perfil` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`id_atividades`),
  ADD KEY `id_servicos` (`id_servicos`);

--
-- Índices de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`id_avaliacao`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_servicos` (`id_servicos`);

--
-- Índices de tabela `formacao_experiencia`
--
ALTER TABLE `formacao_experiencia`
  ADD PRIMARY KEY (`id_form_exp`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servicos`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`);

--
-- Índices de tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`id_user_perfil`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_perfil` (`id_perfil`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id_atividades` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `id_avaliacao` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `formacao_experiencia`
--
ALTER TABLE `formacao_experiencia`
  MODIFY `id_form_exp` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servicos` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_user` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  MODIFY `id_user_perfil` int(5) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `atividades_ibfk_1` FOREIGN KEY (`id_servicos`) REFERENCES `servicos` (`id_servicos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_servicos`) REFERENCES `servicos` (`id_servicos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `formacao_experiencia`
--
ALTER TABLE `formacao_experiencia`
  ADD CONSTRAINT `formacao_experiencia_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD CONSTRAINT `usuario_perfil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `usuario` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
