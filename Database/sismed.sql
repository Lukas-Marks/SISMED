
--
-- Banco de dados: `sismed`
--
CREATE DATABASE IF NOT EXISTS sismed;
USE sismed;
-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `nome_completo` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `medico` varchar(100) DEFAULT NULL,
  `data_consulta` datetime NOT NULL,
  `horario` time DEFAULT NULL,
  `tipo_consulta` varchar(50) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Confirmado',
  `medico_id` int(11) DEFAULT NULL,
  `medico_desejado` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `nome_completo`, `cpf`, `data_nascimento`, `telefone`, `especialidade`, `medico`, `data_consulta`, `horario`, `tipo_consulta`, `observacoes`, `status`, `medico_id`, `medico_desejado`) VALUES
(50, 'Senna', '12412', '0111-11-11', '1312', 'Cardiologia', NULL, '2025-10-20 14:00:00', NULL, 'Presencial', '', 'Confirmado', 61, 'Maria'),
(51, 'Hebe', '4h45h', '1111-11-11', '1312', 'Clínico Geral', NULL, '2025-10-20 11:00:00', NULL, 'Presencial', '', 'Confirmado', 44, 'Jefferson'),
(52, 'Axl rose', '12412', '0001-12-12', '13243', 'Pediatria', NULL, '2025-10-20 09:00:00', NULL, 'Presencial', '', 'Confirmado', 65, 'Will');

-- --------------------------------------------------------

--
-- Estrutura para tabela `consultas`
--

CREATE TABLE `consultas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `data_consulta` datetime NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('agendada','realizada','cancelada') DEFAULT 'agendada',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `horario` time NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicos`
--

CREATE TABLE `medicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `crm` varchar(20) NOT NULL,
  `especialidade` varchar(80) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicos`
--

INSERT INTO `medicos` (`id`, `nome`, `crm`, `especialidade`, `telefone`, `email`, `criado_em`) VALUES
(1, 'Dra. Maria Oliveira', 'CRM12345', 'Clínico Geral', '(11) 98888-8888', 'maria@sismed.com', '2025-09-14 00:31:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `endereco` varchar(200) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `altura` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `historico` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','medico','recepcionista') DEFAULT 'recepcionista',
  `token_recuperacao` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefone` varchar(20) DEFAULT NULL,
  `historico` text DEFAULT NULL,
  `funcao` varchar(100) NOT NULL,
  `especialidade` varchar(100) NOT NULL,
  `usuario` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `perfil`, `token_recuperacao`, `criado_em`, `telefone`, `historico`, `funcao`, `especialidade`, `usuario`) VALUES
(44, 'Jefferson', 'je@1.1', '$2y$10$g.TdW45iaRxgLZrEwX/dQeCSQck3247uq7M4bTOAj5wJW.dkj9JQK', NULL, NULL, '2025-10-05 18:20:52', '141', 'sdfsfs', 'Médico', 'Clínico Geral', 'je'),
(60, 'Joao', 'joao@1.1', '$2y$10$hwvNGKAvrF6o55gnXKMVm.9RmMd79CGUH0BAGY8/t1gSatSV8CHHq', 'recepcionista', NULL, '2025-10-12 19:26:01', '2342', 'g erg erg e', 'Recepcionista', '', 'joao'),
(61, 'Maria', 'maria@1.1', '$2y$10$txiVcnvXiYxTEP8dvGMeouhkmzYfgL/JId.Xr7V4oKO1GnLo5lv9e', 'recepcionista', NULL, '2025-10-12 19:26:40', '4242', 'r ger 34 ', 'Médico', 'Cardiologia', 'maria'),
(64, 'Marcos', 'marcos@1.1', '$2y$10$8jG.Avs0gXsuBOds6jcWC.MJ/lMsCJFqV1pvlhjIRzfZgTcJDMpAC', 'recepcionista', NULL, '2025-10-19 18:46:09', '484', '', 'Administrador', '', 'Marcos'),
(65, 'Will', 'will@1.1', '$2y$10$d/yBMD3erMc5198WpMnNEOnTutqcpVcqFcsUw8m50lqDlA2GCwi/m', 'recepcionista', NULL, '2025-10-19 21:46:26', '484', '', 'Médico', 'Pediatria', 'Will'),
(67, 'Administrador', 'admin@1.1', '$2y$10$88bODY5uNC/5/1LuHG8u0ez.KRgonlnBEP/0OczZOX9Eh5MZi2Ywu', 'recepcionista', NULL, '2025-10-26 23:03:59', '352r2r', '', 'Administrador', '', 'Administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `medico_id` (`medico_id`);

--
-- Índices de tabela `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crm` (`crm`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `consultas`
--
ALTER TABLE `consultas`
  ADD CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`medico_id`) REFERENCES `medicos` (`id`) ON DELETE CASCADE;
COMMIT;

