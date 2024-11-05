-- --------------------------------------------------------
-- Servidor:                     localhost
-- Versão do servidor:           8.1.0 - MySQL Community Server - GPL
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para mais_autonomia
CREATE DATABASE IF NOT EXISTS `mais_autonomia` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mais_autonomia`;

-- Copiando estrutura para tabela mais_autonomia.atividades
CREATE TABLE IF NOT EXISTS `atividades` (
  `id_atividades` int NOT NULL AUTO_INCREMENT,
  `titulo_atividades` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_atividades` varchar(130) COLLATE utf8mb4_general_ci NOT NULL,
  `tag_atividades` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_servicos` int NOT NULL,
  PRIMARY KEY (`id_atividades`),
  KEY `id_servicos` (`id_servicos`),
  CONSTRAINT `atividades_ibfk_1` FOREIGN KEY (`id_servicos`) REFERENCES `servicos` (`id_servicos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.atividades: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela mais_autonomia.avaliacao
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id_avaliacao` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_servicos` int NOT NULL,
  `titulo_avaliacao` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_avaliacao` varchar(130) COLLATE utf8mb4_general_ci NOT NULL,
  `range_avaliacao` int NOT NULL,
  PRIMARY KEY (`id_avaliacao`),
  KEY `id_servicos` (`id_servicos`),
  KEY `id_usuario` (`id_usuario`) USING BTREE,
  CONSTRAINT `avaliacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `avaliacao_ibfk_2` FOREIGN KEY (`id_servicos`) REFERENCES `servicos` (`id_servicos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.avaliacao: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela mais_autonomia.formacao_experiencia
CREATE TABLE IF NOT EXISTS `formacao_experiencia` (
  `id_form_exp` int NOT NULL AUTO_INCREMENT,
  `titulo_form_exp` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `id_usuario` int NOT NULL,
  PRIMARY KEY (`id_form_exp`),
  KEY `id_usuario` (`id_usuario`) USING BTREE,
  CONSTRAINT `formacao_experiencia_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.formacao_experiencia: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela mais_autonomia.perfil
CREATE TABLE IF NOT EXISTS `perfil` (
  `id_perfil` int NOT NULL AUTO_INCREMENT,
  `titulo_perfil` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `valor_perfil` int NOT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.perfil: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela mais_autonomia.servicos
CREATE TABLE IF NOT EXISTS `servicos` (
  `id_servicos` int NOT NULL AUTO_INCREMENT,
  `titulo_servicos` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `desc_servicos` varchar(130) COLLATE utf8mb4_general_ci NOT NULL,
  `valor_servicos` float NOT NULL,
  `prazo_servicos` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `id_autonomo` int DEFAULT NULL,
  `status_servicos` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Criado',
  PRIMARY KEY (`id_servicos`),
  KEY `id_autonomo` (`id_autonomo`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `servicos_ibfk_1` FOREIGN KEY (`id_autonomo`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `servicos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.servicos: ~0 rows (aproximadamente)
INSERT INTO `servicos` (`id_servicos`, `titulo_servicos`, `desc_servicos`, `valor_servicos`, `prazo_servicos`, `id_cliente`, `id_autonomo`, `status_servicos`) VALUES
	(2, 'Teste', 'Teste de atualizacao de um serviço', 10000, '2024-11-26 00:00:00', 2, NULL, 'Em Andamento'),
	(3, 'Desenvolvimento de website', 'Precisamos de um website para uma pequena empresa de entrega. O site deve ser bonito e bem colorido.', 600, '2024-11-29 00:00:00', 2, NULL, 'Criado');

-- Copiando estrutura para tabela mais_autonomia.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email_usuario` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `senha_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefone_usuario` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `cpf_cnpj` varchar(18) COLLATE utf8mb4_general_ci NOT NULL,
  `cep_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'https://ui-avatars.com/api/?name=MA&background=0d6efd&color=fff',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `cpf_cnpj` (`cpf_cnpj`),
  UNIQUE KEY `email_usuario` (`email_usuario`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.usuario: ~0 rows (aproximadamente)
INSERT INTO `usuario` (`id_usuario`, `nome_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`, `cpf_cnpj`, `cep_usuario`, `avatar_usuario`) VALUES
	(2, 'Daniel Murilo Vaz', 'daniellmvaz@gmail.com', '$2y$10$EdL8CST1IhIe1giUm87qwud6.KXf00zaAZktq4AAD2rOavI9OIrWS', '(41) 99999-9999', '99.999.999/9999-99', '83508-430', 'https://ui-avatars.com/api/?name=MA&background=0d6efd&color=fff');

-- Copiando estrutura para tabela mais_autonomia.usuario_perfil
CREATE TABLE IF NOT EXISTS `usuario_perfil` (
  `id_user_perfil` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_perfil` int NOT NULL,
  PRIMARY KEY (`id_user_perfil`),
  KEY `id_perfil` (`id_perfil`),
  KEY `id_usuario` (`id_usuario`) USING BTREE,
  CONSTRAINT `usuario_perfil_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuario_perfil_ibfk_2` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela mais_autonomia.usuario_perfil: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
