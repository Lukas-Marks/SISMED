-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/10/2025 às 01:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(100) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `especialidade` varchar(50) DEFAULT NULL,
  `medico` varchar(100) DEFAULT NULL,
  `data_consulta` date DEFAULT NULL,
  `horario` time DEFAULT NULL,
  `tipo_consulta` enum('Presencial','Teleconsulta') DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('Confirmado','Cancelado') DEFAULT 'Confirmado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `nome_completo`, `cpf`, `data_nascimento`, `telefone`, `especialidade`, `medico`, `data_consulta`, `horario`, `tipo_consulta`, `observacoes`, `status`) VALUES
(1, 'Scarlat Torres da Silva', '4366620025', '1996-07-28', '1185495216', 'Cardiologia', '', '2025-10-26', '10:50:00', 'Presencial', '', 'Confirmado'),
(2, 'Scarlat Torres da Silva', '4366620025', '1996-07-28', '1185495216', 'Cardiologia', 'Dr. Marcos', '2025-10-20', '10:00:00', 'Presencial', 'primeira consulta', 'Cancelado'),
(3, 'Scarlat Torres da Silva', '4366620025', '1996-07-28', '', 'Cardiologia', '', '2025-10-25', '09:30:00', 'Presencial', 'hfufhg', 'Confirmado');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
