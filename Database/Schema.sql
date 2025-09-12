-- =============================================
-- SCHEMA INICIAL SISMED
-- Banco de dados para Sistema de Gestão Médica
-- =============================================

-- Criar o banco
CREATE DATABASE IF NOT EXISTS sismed;
USE sismed;

-- ========================
-- Tabela de Usuários (login)
-- ========================
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'medico', 'recepcionista') DEFAULT 'recepcionista',
    token_recuperacao VARCHAR(255) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- Tabela de Pacientes
-- ========================
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    data_nascimento DATE,
    telefone VARCHAR(15),
    endereco VARCHAR(200),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- Tabela de Médicos
-- ========================
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    crm VARCHAR(20) UNIQUE NOT NULL,
    especialidade VARCHAR(80),
    telefone VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ========================
-- Tabela de Consultas
-- ========================
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    data_consulta DATETIME NOT NULL,
    descricao TEXT,
    status ENUM('agendada', 'realizada', 'cancelada') DEFAULT 'agendada',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Relacionamentos
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
);

-- ========================
-- Inserts iniciais (admin e dados fictícios)
-- ========================
INSERT INTO usuarios (nome, email, senha, perfil)
VALUES ('Administrador', 'admin@sismed.com', '123456', 'admin');

INSERT INTO pacientes (nome, cpf, data_nascimento, telefone, endereco)
VALUES ('João da Silva', '123.456.789-00', '1985-05-20', '(11) 99999-9999', 'Rua A, 123');

INSERT INTO medicos (nome, crm, especialidade, telefone, email)
VALUES ('Dra. Maria Oliveira', 'CRM12345', 'Clínico Geral', '(11) 98888-8888', 'maria@sismed.com');

INSERT INTO consultas (paciente_id, medico_id, data_consulta, descricao, status)
VALUES (1, 1, '2025-09-15 14:00:00', 'Consulta de rotina', 'agendada');
