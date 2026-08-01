-- =======================================================
-- BANCO DE DADOS: turismo_caninde
-- CONEXÃO CÂNIONS - Conectando você ao melhor do Velho Chico
-- =======================================================

CREATE DATABASE IF NOT EXISTS `turismo_caninde` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `turismo_caninde`;

-- -------------------------------------------------------
-- 1. TABELA: usuarios_admin
-- -------------------------------------------------------
DROP TABLE IF EXISTS `usuarios_admin`;
CREATE TABLE `usuarios_admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha_hash` VARCHAR(255) NOT NULL,
  `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserção do Usuário Administrador Inicial (admin@conexaocanions.com.br / admin123)
INSERT INTO `usuarios_admin` (`nome`, `email`, `senha_hash`) VALUES
('Administrador Conexão Cânions', 'admin@conexaocanions.com.br', '$2y$10$EeIdmqBFuvap4bA5qUhOk.XfgnS48KRoFV8K.R.A.grcRLPbMG0om');

-- -------------------------------------------------------
-- 2. TABELA: restaurantes
-- -------------------------------------------------------
DROP TABLE IF EXISTS `restaurantes`;
CREATE TABLE `restaurantes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(255) NOT NULL,
  `categoria` VARCHAR(255) NOT NULL,
  `cidade` VARCHAR(100) NOT NULL DEFAULT 'Canindé de São Francisco',
  `prato_destaque` VARCHAR(255) NOT NULL,
  `endereco` TEXT NOT NULL,
  `telefone` VARCHAR(50) NOT NULL,
  `imagem` VARCHAR(255) DEFAULT 'assets/images/canions_xingo.jpg',
  `status` ENUM('pendente', 'aprovado') NOT NULL DEFAULT 'pendente',
  `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserção dos Restaurantes Iniciais (Canindé de São Francisco & Piranhas)
INSERT INTO `restaurantes` (`nome`, `categoria`, `cidade`, `prato_destaque`, `endereco`, `telefone`, `imagem`, `status`) VALUES
('Restaurante Karrancas', 'Peixes & Frutos do Rio', 'Canindé de São Francisco', 'Tucunaré Frito & Surubim ao Molho de Camarão', 'Orla do Cânion do Xingó - Canindé de São Francisco', '(79) 99844-3311', 'assets/images/canions_xingo.jpg', 'aprovado'),
('Restaurante O Castanho', 'Culinária Sertaneja', 'Canindé de São Francisco', 'Carne de Sol com Macaxeira & Peixe Grelhado', 'Reserva Ecológica do Castanho - Sertão', '(79) 99912-8844', 'assets/images/rota_cangaco.jpg', 'aprovado'),
('Nalva Cozinha Autoral', 'Culinária Nordestina', 'Piranhas', 'Surubim ao Molho de Camarão & Cartola Sertaneja', 'Centro Histórico - Piranhas / AL', '(82) 99988-1122', 'assets/images/cordel_art.jpg', 'aprovado'),
('Sabor do Sertão', 'Comida Caseira', 'Canindé de São Francisco', 'Galinha Caipira com Pirão & Doces Típicos', 'Rua do Comércio, nº 45 - Centro', '(79) 98822-7700', 'assets/images/cordel_art.jpg', 'aprovado'),
('Flor de Cactos Restaurante', 'Comida Típica & Peixes', 'Piranhas', 'Tilápia Grelhada com Ervas Finas & Baião de Dois', 'Orla Fluvial - Piranhas / AL', '(82) 99877-3344', 'assets/images/bode_assado.jpg', 'aprovado'),
('Restaurante Bode Assado do Sertão', 'Comida Típica / Churrasco', 'Canindé de São Francisco', 'Bode Assado na Brasa & Pirão de Queijo', 'Av. Principal, nº 310 - Canindé de São Francisco', '(79) 99811-2233', 'assets/images/bode_assado.jpg', 'aprovado'),
('Restaurante & Bar da Orla', 'Petiscaria & Frutos do Rio', 'Canindé de São Francisco', 'Caldinho de Peixe & Caipirinhas da Caatinga', 'Orla Fluvial - Canindé de São Francisco', '(79) 99888-5544', 'assets/images/hero_canyons.jpg', 'aprovado'),
('Cabana do Velho Chico', 'Peixes & Frutos do Rio', 'Canindé de São Francisco', 'Surubim Grelhado no Espeto & Pirão de Camarão', 'Orla Fluvial, Lote 12 - Canindé de São Francisco', '(79) 99765-4321', 'assets/images/canions_xingo.jpg', 'pendente'),
('Churrascaria Sertão Vivo', 'Churrasco & Carne de Sol', 'Canindé de São Francisco', 'Picanha Suína na Brasa & Queijo Assado com Melaço', 'Av. Beira Rio, nº 88 - Centro', '(79) 99822-1144', 'assets/images/bode_assado.jpg', 'pendente');

-- -------------------------------------------------------
-- 3. TABELA: banners
-- -------------------------------------------------------
DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `imagem_url` VARCHAR(255) NOT NULL,
  `ativo` TINYINT(1) DEFAULT 1,
  `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserção de Banners Iniciais
INSERT INTO `banners` (`titulo`, `imagem_url`, `ativo`) VALUES
('Cânions do Xingó - Beleza Natural de Canindé', 'assets/images/hero_canyons.jpg', 1),
('Rota do Cangaço & Grota do Angico', 'assets/images/rota_cangaco.jpg', 1),
('Usina Hidrelétrica do Xingó', 'assets/images/usina_xingo.jpg', 1);
