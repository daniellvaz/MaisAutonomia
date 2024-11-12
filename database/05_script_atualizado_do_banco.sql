-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql104.infinityfree.com
-- Tempo de geração: 10/11/2024 às 08:54
-- Versão do servidor: 10.6.19-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `if0_37646179_mais_autonomia`
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
  `id_usuario` int(5) NOT NULL,
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
  `id_usuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formacao_experiencia`
--

INSERT INTO `formacao_experiencia` (`id_form_exp`, `titulo_form_exp`, `id_usuario`) VALUES
(1, 'Analise e desenvolvimento', 5),
(2, 'Curso de React', 5);

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
-- Estrutura para tabela `propostas`
--

CREATE TABLE `propostas` (
  `id_proposta` int(11) NOT NULL,
  `id_servico` int(11) NOT NULL,
  `valor_proposta` decimal(10,2) NOT NULL,
  `prazo_proposta` int(11) NOT NULL,
  `descricao_proposta` text NOT NULL,
  `data_criacao_proposta` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `status_proposta` enum('Rejeitada','Aprovada','Em Análise','') NOT NULL DEFAULT 'Em Análise'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `propostas`
--

INSERT INTO `propostas` (`id_proposta`, `id_servico`, `valor_proposta`, `prazo_proposta`, `descricao_proposta`, `data_criacao_proposta`, `id_usuario`, `status_proposta`) VALUES
(1, 2, '5800.00', 0, 'Teste', '2024-11-05 22:01:17', 4, 'Em Análise'),
(2, 4, '1400.00', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2024-11-05 22:14:46', 6, 'Em Análise'),
(3, 4, '720.00', 0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2024-11-05 22:17:19', 7, 'Em Análise'),
(4, 7, '4500.00', 0, 'Eu faco por esse preco\r\n', '2024-11-05 23:21:06', 6, 'Em Análise');

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servicos` int(5) NOT NULL,
  `titulo_servicos` varchar(30) NOT NULL,
  `desc_servicos` longtext NOT NULL,
  `valor_servicos` float NOT NULL,
  `prazo_servicos` datetime NOT NULL,
  `id_cliente` int(5) NOT NULL,
  `id_autonomo` int(5) DEFAULT NULL,
  `status_servicos` varchar(40) NOT NULL DEFAULT 'Criado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id_servicos`, `titulo_servicos`, `desc_servicos`, `valor_servicos`, `prazo_servicos`, `id_cliente`, `id_autonomo`, `status_servicos`) VALUES
(4, 'Desenvolvedor Front-end', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2000, '2024-12-28 00:00:00', 5, NULL, 'Criado'),
(5, 'Desenvolvedor Back-end', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3000, '2024-11-30 00:00:00', 5, NULL, 'Criado'),
(6, 'Fotografo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1500, '2024-11-28 00:00:00', 6, NULL, 'Criado'),
(7, 'Teste', 'Teste de servico', 5500, '2024-11-29 00:00:00', 5, NULL, 'Criado'),
(8, 'teste', 'feitoo\r\n', 3000, '2024-01-25 00:00:00', 8, NULL, 'Criado');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(5) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(70) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `telefone_usuario` varchar(15) NOT NULL,
  `cpf_cnpj` varchar(18) NOT NULL,
  `cep_usuario` varchar(8) NOT NULL,
  `avatar_usuario` varchar(255) NOT NULL DEFAULT 'https://ui-avatars.com/api/?name=MA&background=0d6efd&color=fff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`, `cpf_cnpj`, `cep_usuario`, `avatar_usuario`) VALUES
(5, 'Daniel Murilo Vaz', 'daniellmvaz@gmail.com', '$2y$10$E6zSE33JPlRNSp/W6hn2CuUW1UHjS9Xi7ficWYDFocYotW.2ruWa2', '(41) 99999-9999', '99.999.999/9999-99', '82410-47', 'http://maisautonomia.infy.uk/app/assets/upload/avatar_672aa965edde32.35862943.jpeg'),
(6, 'João da Silva', 'joao@email.com', '$2y$10$k0J4zLqGryDQsgeOXZ7NXeUtbDTeNwv2edPw3pN9CFelE83.TwRPO', '(41) 88888-8888', '88.888.888/8888-88', '82410-47', 'https://ui-avatars.com/api/?name=MA&background=0d6efd&color=fff'),
(7, 'Maria Aparecida', 'maria@email.com', '$2y$10$HnH/gtyyskFHOI7SPBy2AOBfT4X1mDWarvkx2Tr9puo1/B1fo7h56', '(41) 77777-7777', '77.777.777/7777-77', '82410-47', 'https://ui-avatars.com/api/?name=MA&background=0d6efd&color=fff'),
(8, 'Gabriel da Paz Rodrigues', 'gabrielpazrodriguessolucoes@gmail.com', '$2y$10$B9I1pnFSNNcHhKQG79luzuP7oSnJTos4BQHv53Yoo3jAs8T2QCili', '(41) 99606-6944', '000.888.777-66', '83326-25', 'http://maisautonomia.infy.uk/app/assets/upload/avatar_672bca84dd1799.88819662.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `id_user_perfil` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `id_perfil` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices de tabelas apagadas
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
  ADD KEY `id_servicos` (`id_servicos`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Índices de tabela `formacao_experiencia`
--
ALTER TABLE `formacao_experiencia`
  ADD PRIMARY KEY (`id_form_exp`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Índices de tabela `propostas`
--
ALTER TABLE `propostas`
  ADD PRIMARY KEY (`id_proposta`),
  ADD KEY `id_servico_proposta` (`id_servico`),
  ADD KEY `id_usuario_proposta` (`id_usuario`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servicos`),
  ADD KEY `id_autonomo` (`id_autonomo`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  ADD UNIQUE KEY `email_usuario` (`email_usuario`) USING BTREE;

--
-- Índices de tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`id_user_perfil`),
  ADD KEY `id_perfil` (`id_perfil`),
  ADD KEY `id_usuario` (`id_usuario`) USING BTREE;

--
-- AUTO_INCREMENT de tabelas apagadas
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
  MODIFY `id_form_exp` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id_perfil` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `propostas`
--
ALTER TABLE `propostas`
  MODIFY `id_proposta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servicos` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  MODIFY `id_user_perfil` int(5) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
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
  ADD CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_servicos`) REFERENCES `servicos` (`id_servicos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `formacao_experiencia`
--
ALTER TABLE `formacao_experiencia`
  ADD CONSTRAINT `formacao_experiencia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`id_autonomo`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `servicos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD CONSTRAINT `usuario_perfil_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
