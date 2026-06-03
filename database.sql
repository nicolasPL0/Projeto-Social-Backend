CREATE DATABASE IF NOT EXISTS projeto_social;
USE projeto_social;

CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    nascimento DATE NOT NULL,
    sexo VARCHAR(20) NOT NULL,
    curso VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    telefone VARCHAR(20),
    endereco TEXT NOT NULL,
    resp_nome VARCHAR(100) NOT NULL,
    resp_tel VARCHAR(20) NOT NULL,
    resp2_nome VARCHAR(100),
    resp2_tel VARCHAR(20),
    cpf_aluno VARCHAR(20) NOT NULL,
    cpf_resp1 VARCHAR(20) NOT NULL,
    cpf_resp2 VARCHAR(20),
    obs TEXT,
    status VARCHAR(20) DEFAULT 'Ativo',
    criado_em VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS registros (
    id BIGINT PRIMARY KEY,
    tipo_ocorrencia VARCHAR(50) NOT NULL,
    tipo VARCHAR(20) NOT NULL,
    curso VARCHAR(50) NOT NULL,
    turma VARCHAR(50) NOT NULL,
    aluno VARCHAR(100) NOT NULL,
    matricula VARCHAR(20) NOT NULL,
    data_registro DATE,
    hora_registro TIME,
    motivo_saida VARCHAR(100),
    outro_motivo TEXT,
    observacoes TEXT,
    criado_em VARCHAR(20),
    criado_hora VARCHAR(10),
    lida TINYINT(1) DEFAULT 0,
    FOREIGN KEY (matricula) REFERENCES alunos(matricula) ON DELETE CASCADE ON UPDATE CASCADE
);
