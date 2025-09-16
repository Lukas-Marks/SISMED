
-- Tabela Usuário (superclasse)
CREATE TABLE Usuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100),
    Email VARCHAR(100),
    Senha VARCHAR(100),
    Tipo ENUM('Recepcionista', 'Medico', 'ADM')
);

-- Tabela Recepcionista
CREATE TABLE Recepcionista (
    ID INT PRIMARY KEY,
    Telefone VARCHAR(20),
    Endereco VARCHAR(150),
    FOREIGN KEY (ID) REFERENCES Usuario(ID)
);

-- Tabela Médico
CREATE TABLE Medico (
    ID INT PRIMARY KEY,
    Especialidade VARCHAR(100),
    Telefone VARCHAR(20),
    Endereco VARCHAR(150),
    Disponibilidade VARCHAR(100),
    FOREIGN KEY (ID) REFERENCES Usuario(ID)
);

-- Tabela ADM
CREATE TABLE ADM (
    ID INT PRIMARY KEY,
    FOREIGN KEY (ID) REFERENCES Usuario(ID)
);

-- Tabela Paciente
CREATE TABLE Paciente (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(100),
    CPF VARCHAR(14),
    DataNascimento DATE,
    Endereco VARCHAR(150),
    Telefone VARCHAR(20),
    Email VARCHAR(100),
    DocAnexados TEXT
);

-- Tabela Consulta
CREATE TABLE Consulta (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Data DATE,
    Hora TIME,
    Motivo VARCHAR(255),
    Status ENUM('Agendada', 'Cancelada', 'Realizada'),
    PacienteID INT,
    MedicoID INT,
    FOREIGN KEY (PacienteID) REFERENCES Paciente(ID),
    FOREIGN KEY (MedicoID) REFERENCES Medico(ID)
);

-- Tabela Prontuário
CREATE TABLE Prontuario (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Altura VARCHAR(10),
    Peso VARCHAR(10),
    Alergias TEXT,
    Doencas TEXT,
    PacienteID INT,
    FOREIGN KEY (PacienteID) REFERENCES Paciente(ID)
);

-- Tabela Prescrição
CREATE TABLE Prescricao (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    Medicamento VARCHAR(100),
    Dosagem VARCHAR(50),
    Frequencia VARCHAR(50),
    Duracao INT,
    ConsultaID INT,
    FOREIGN KEY (ConsultaID) REFERENCES Consulta(ID)
);
