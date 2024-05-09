drop database if exists CLAU;
CREATE DATABASE CLAU;
USE CLAU;

CREATE TABLE Enderecos (
  Enderecos_id INT NOT NULL AUTO_INCREMENT,
  Enderecos_Cep CHAR(9) NOT NULL,
  Enderecos_Rua VARCHAR(100) NOT NULL,
  Enderecos_Numero INT(10) NOT NULL,
  Enderecos_Complemento VARCHAR(10) NULL,
  Enderecos_Bairro VARCHAR(100) NOT NULL,
  Enderecos_Cidade VARCHAR(100) NOT NULL,
  Enderecos_Uf VARCHAR(100) NOT NULL,
  PRIMARY KEY (Enderecos_id)
)ENGINE = InnoDB;

CREATE TABLE Responsavel (
  Respon_id INT NOT NULL AUTO_INCREMENT,
  Respon_Nome VARCHAR(100) NOT NULL,
  Respon_Fone VARCHAR(13) NOT NULL,
  Respon_Cpf CHAR(14) NOT NULL,
  Respon_Rg VARCHAR(14) NOT NULL,
  Respon_Parentesco VARCHAR(100) NOT NULL,
  PRIMARY KEY (Respon_id),
  UNIQUE INDEX Respon_Cpf_UNIQUE (Respon_Cpf ASC) 
)ENGINE = InnoDB;

CREATE TABLE Usuario (
  Usuario_id INT NOT NULL AUTO_INCREMENT,
  Usuario_Nome VARCHAR(100) NOT NULL,
  Usuario_Apelido VARCHAR (50) NOT NULL,
  Usuario_Email VARCHAR(100) NOT NULL,
  Usuario_Sexo CHAR(1) NOT NULL,
  Usuario_Cpf CHAR(14) NOT NULL,
  Usuario_Rg VARCHAR(14) NOT NULL,
  Usuario_Nascimento DATE NOT NULL,
  Usuario_EstadoCivil VARCHAR(20) NOT NULL,
  Usuario_Fone VARCHAR(15) NOT NULL,
  Usuario_Fone_Recado VARCHAR(15) NULL,
  Usuario_Login VARCHAR(100) NOT NULL,
  Usuario_Senha VARCHAR(45) NOT NULL,
  Responsavel_Respon_cd INT NULL,
  Usuario_Obs VARCHAR(5000) NULL,
  Enderecos_Enderecos_cd INT NOT NULL,
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Funcionario que cadastrou - automatico',
  Usuario_Status CHAR(1) DEFAULT 1,
  Usuario_Foto VARCHAR(255) NULL,
  Usuario_Matricula INT (6) NULL,
  PRIMARY KEY (Usuario_id),
  UNIQUE INDEX Aluno_Cpf_UNIQUE (Usuario_Cpf ASC),
  UNIQUE INDEX Aluno_Email_UNIQUE (Usuario_Email ASC),
  UNIQUE INDEX Usuario_Login_UNIQUE (Usuario_Login ASC),
  CONSTRAINT fk_Usuario_Responsavel1 FOREIGN KEY (Responsavel_Respon_cd) REFERENCES Responsavel (Respon_id),
  CONSTRAINT fk_Usuario_Enderecos1 FOREIGN KEY (Enderecos_Enderecos_cd) REFERENCES Enderecos (Enderecos_id),
  CONSTRAINT fk_Usuario_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id)
)ENGINE = InnoDB;

CREATE TABLE Curso (
  Curso_id INT NOT NULL AUTO_INCREMENT,
  Curso_Nome VARCHAR(100) NOT NULL,
  Curso_Sigla CHAR(3) NOT NULL,
  Curso_Carga_horaria INT(10) NOT NULL,
  Curso_Desc VARCHAR(500) NOT NULL,
  Curso_Duracao INT NOT NULL,
  Curso_PreRequisito VARCHAR(500) NOT NULL,
  Curso_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Curso_Status CHAR(1) DEFAULT 1,
  PRIMARY KEY (Curso_id)
)ENGINE = InnoDB;

CREATE TABLE Turma (
  Turma_Cod CHAR(12) NOT NULL,
  Turma_Horario TIME NOT NULL,
  Turma_Horario_Termino TIME NOT NULL,
  Turma_Vagas INT NOT NULL,
  Turma_Dias INT(3) NOT NULL,
  Turma_Obs VARCHAR(1000) NULL,
  Turma_Inicio DATE NOT NULL,
  Turma_Termino DATE NULL,
  Turma_Status CHAR(1) DEFAULT 1,
  Turma_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Turma_Cod),
  Usuario_Usuario_cd int not null, -- chave estrageira dps
  Curso_cd int not null, -- chave estrageira dps
  foreign key (Usuario_Usuario_cd) references Usuario(Usuario_id),
  foreign key (Curso_cd) references Curso(Curso_id)
)ENGINE = InnoDB;

CREATE TABLE Modulo (
  Modulo_id INT NOT NULL AUTO_INCREMENT,
  Modulo_Nome VARCHAR(100) NOT NULL,
  Modulo_Desc VARCHAR(500) NOT NULL,
  Modulo_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Modulo_Status CHAR(1) DEFAULT 1,
  PRIMARY KEY (Modulo_id)
)ENGINE = InnoDB;

CREATE TABLE Modulo_Curso (
  Modulo_Curso_id INT NOT NULL AUTO_INCREMENT,
  Modulo_Modulo_cd INT NOT NULL,
  Curso_Curso_cd INT NOT NULL,
  Modulo_Curso_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Modulo_Curso_id),
  CONSTRAINT fk_Modulo_Curso_Modulo1 FOREIGN KEY (Modulo_Modulo_cd) REFERENCES Modulo (Modulo_id),
  CONSTRAINT fk_Modulo_Curso_Curso1 FOREIGN KEY (Curso_Curso_cd) REFERENCES Curso (Curso_id)
)ENGINE = InnoDB;

CREATE TABLE Avaliacoes (
  Avaliacoes_id INT NOT NULL AUTO_INCREMENT,
  Avaliacoes_Desc VARCHAR(50) NULL,
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Professor',
  Modulo_Curso_cd INT NOT NULL,
  PRIMARY KEY (Avaliacoes_id),
  CONSTRAINT fk_Avaliacoes_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id),
  CONSTRAINT fk_Avaliacoes_Modulo1 FOREIGN KEY (Modulo_Curso_cd) REFERENCES Modulo_Curso (Modulo_Curso_id)
)ENGINE = InnoDB;

CREATE TABLE Tipo (
  Tipo_id INT NOT NULL AUTO_INCREMENT,
  Tipo_Descricao VARCHAR(100) NOT NULL,
  PRIMARY KEY (Tipo_id)
)ENGINE = InnoDB;

CREATE TABLE Mensagem (
  Mensagem_id INT NOT NULL AUTO_INCREMENT,
  Mensagem_Desc MEDIUMTEXT NOT NULL,
  Mensagem_Data DATETIME NOT NULL,
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Funcionario',
  PRIMARY KEY (Mensagem_id),
  CONSTRAINT fk_Mensagem_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id)
)ENGINE = InnoDB;

CREATE TABLE Registro_Usuario (
  Usuario_Usuario_cd INT NOT NULL,
  Tipo_Tipo_cd INT NOT NULL,
  Registro_Data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Usuario_Usuario_cd, Tipo_Tipo_cd),
  CONSTRAINT fk_Registro_Usuario_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id),
  CONSTRAINT fk_Registro_Usuario_Tipo1 FOREIGN KEY (Tipo_Tipo_cd) REFERENCES Tipo (Tipo_id)
)ENGINE = InnoDB;

CREATE TABLE Mensagem_Usuario (
  Mensagem_Mensagem_cd INT NOT NULL,
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Aluno',
  Mensagem_Usuario_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Mensagem_Mensagem_cd, Usuario_Usuario_cd),
  CONSTRAINT fk_Mensagem_Usuario_Mensagem1 FOREIGN KEY (Mensagem_Mensagem_cd) REFERENCES Mensagem (Mensagem_id),
  CONSTRAINT fk_Mensagem_Usuario_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id)
)ENGINE = InnoDB;

CREATE TABLE Aluno_Turma (
  Aluno_Turma_id INT NOT NULL AUTO_INCREMENT,
  Usuario_Usuario_cd INT NOT NULL,
  Turma_Turma_Cod CHAR(12) NOT NULL,
  Aluno_Turma_Status CHAR(1) DEFAULT "1", -- 1 para ativo, 0 para inativo
  Aluno_Turma_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Aluno_Turma_id),
  CONSTRAINT fk_Aluno_Turma_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id),
  CONSTRAINT fk_Aluno_Turma_Turma1 FOREIGN KEY (Turma_Turma_Cod) REFERENCES Turma (Turma_Cod)
) ENGINE=InnoDB;

CREATE TABLE aula (
    id_aula INT AUTO_INCREMENT PRIMARY KEY,
    cod_turma char(12),
    id_modulo INT,
    descricao VARCHAR(255),
    data_aula DATE,
    data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cod_turma) REFERENCES Turma(Turma_cod), 
    FOREIGN KEY (id_modulo) REFERENCES Modulo(Modulo_id)
);

CREATE TABLE notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno_turma INT NOT NULL,
    id_modulo INT NOT NULL,
    nota DECIMAL(3,1) NOT NULL,
    CONSTRAINT fk_notas_aluno_turma FOREIGN KEY (id_aluno_turma) REFERENCES aluno_turma(Aluno_Turma_id),
    CONSTRAINT fk_notas_modulo FOREIGN KEY (id_modulo) REFERENCES modulo(modulo_id)
) ENGINE=InnoDB;

CREATE TABLE Aulas (
  Aula_id INT NOT NULL AUTO_INCREMENT,
  Modulo_Modulo_id INT NOT NULL,
  Aula_Assunto VARCHAR(255) NOT NULL,
  Aula_Descricao TEXT NOT NULL,
  PRIMARY KEY (Aula_id),
  CONSTRAINT fk_Aulas_Modulo FOREIGN KEY (Modulo_Modulo_id) REFERENCES Modulo (Modulo_id)
) ENGINE=InnoDB;

create table Ocorrencia(
	Ocorrencia_id int not null,
	Aluno_Turma_cd INT NOT NULL,
	Mensagem TEXT not null,
    Usuario_Usuario_cd int not null,
    Ocorrencia_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Ocorrencia_id),
    FOREIGN KEY (Aluno_Turma_cd) REFERENCES Aluno_Turma (Aluno_Turma_id),
    FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id)
) ENGINE=InnoDB;

CREATE TABLE chamada (
    id_chamada INT AUTO_INCREMENT PRIMARY KEY,
    id_aula INT,
    id_aluno_turma INT,
    presenca char(1) not null, -- ou TINYINT, dependendo do seu SGBD
    FOREIGN KEY (id_aula) REFERENCES aula(id_aula),
    -- Assuma que você tem uma tabela chamada aluno_turma com uma coluna id representando id_aluno_turma
    FOREIGN KEY (id_aluno_turma) REFERENCES aluno_turma(Aluno_Turma_id) -- Substitua aluno_turma(id) conforme necessário
);

-- Dados da tabela Tipo
INSERT INTO Tipo (Tipo_Descricao)
VALUES	('Master'),
		('Secretaria'),
		('Aluno'),
        ('Professor'),
        ('Coordenador');

-- ---------------- --
-- MASTER / DIRETOR --
-- ---------------- --      
-- Endereço do usuário MASTER na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12246-260','Avenida Salmão','570','Parque Residencial Aquarius','São José dos Campos','São Paulo');

-- Cadastro do usuário MASTER na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Master','Diretor','master@email.com','F','123.456.789-00','12.345.678-9','1987-01-01','Solteiro','(12) 3456-7899','master','master',1,1,1,'../IMAGE/PROFILE/master.jpg');

-- Cadastro do usuário como tipo MASTER na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (1,1);
-- -------------------- --
-- FIM MASTER / DIRETOR --
-- -------------------- --

-- ---------- --
-- SECRETARIA --
-- ---------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12240-030','Rua dos Alecrins','538','Jardim das Indústrias','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Miguel Almeida Ferreira','Miguel','miguel.ferreira@email.com','M','904.276.838-07','11.111.111-1','1996-02-15','Solteiro','(11) 11111-1111','secretaria','secretaria',2,1,1,'../IMAGE/PROFILE/02.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (2,2);
-- -------------- --
-- FIM SECRETARIA --
-- -------------- --

-- --------- --
-- PROFESSOR --
-- --------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12233-597','Rua Andrelândia','103','Bosque dos Eucaliptos','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Evelyn Azevedo Pinto','Evelyn','evelyn.pinto@email.com','F','439.979.782-71','22.222.222-2','1989-03-26','Casada','(22) 2222-2222','professor','professor',3,2,1,'../IMAGE/PROFILE/03.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (3,4);
-- ------------- --
-- FIM PROFESSOR --
-- ------------- --

-- ----------------------- --
-- COORDENADOR / PROFESSOR --
-- ----------------------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12242-530','Rua João Bicudo','258','Jardim Esplanada','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Kiyumi Otsuka','Kiyumi','kiyumi.otsuka@email.com','F','658.285.418-62','33.333.333-3','1991-04-17','Solteira','(33) 33333-3333','coordenador','coordenador',4,2,1,'../IMAGE/PROFILE/01.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (4,4),(4,5);
-- --------------------------- --
-- FIM COORDENADOR / PROFESSOR --
-- --------------------------- --

-- -------- --
-- ALUNO 01 --
-- -------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12236-420','Rua Joana Soares Ferreira','1063','Cidade Morumbi','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto, Usuario_Matricula)
VALUES ('Laura Cunha Dias','Laura','laura.dias@email.com','F','135.577.066-13','44.444.444-4','2003-06-18','Solteira','(44) 4444-4444','aluno','aluno',5,2,1,'../IMAGE/PROFILE/04.png','240001');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (5,3);
-- ------------ --
-- FIM ALUNO 01 --
-- ------------ --

-- -------- --
-- ALUNO 02 --
-- -------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12220-200','Rua Graúna','562','Vila Tatetuba','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto, Usuario_Matricula)
VALUES ('Vitória Pinto Carvalho','Vitória','vitoria.carvalho@email.com','F','142.763.597-83','44.333.555-8','2008-10-05','Solteira','(55) 55555-5555','aluno2','aluno2',6,2,1,'../IMAGE/PROFILE/05.png','240002');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (6,3);
-- ------------ --
-- FIM ALUNO 02 --
-- ------------ --


-- ------ --
-- CURSOS --
-- ------ --
INSERT INTO Curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status)
VALUES 
('Informática', 'INF', 150, 'Curso de informática e pacote Office', 18, 'Nenhum pré-requisito', '1'),
('Administração de Empresas', 'ADM', 200, 'Curso básico de Administração de Empresas', 24, 'Nenhum Pré-requisito', '1'),
('Inglês', 'ING', 200, 'Curso de Inglês do básico ao avançado', 24, 'Nenhum Pré-requisito', '1'),
('Web-Design', 'WEB', 200, 'Curso de Web-Design com programação de sites e edição', 24, 'Informática Básica', '1');


-- ************* --
-- ** MÓDULOS ** --
-- ************* --  

-- ----------- --
-- INFORMATICA --
-- ----------- --
INSERT INTO Modulo (Modulo_Nome, Modulo_Desc, Modulo_Status)
VALUES
('Introdução à Informática', 'Conhecimento básico de informática', '1'),
('Windows', 'Principais funcionalidades do Windows', '1'),
('Word', 'Funcionalidades do Word', '1'),
('Excel', 'Criação de planilhas com fórmulas', '1'),
('Power Point', 'Criação de apresentações', '1'),
('Internet', 'Principais funcionalidades da Internet', '1');

-- --------------------------- --
-- Associar módulos aos cursos --
-- --------------------------- --
INSERT INTO Modulo_Curso (Modulo_Modulo_cd, Curso_Curso_cd)
VALUES
(1, 1), 
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1);




-- Inserir módulos para o curso de Administração de Empresas
INSERT INTO Modulo (Modulo_Nome, Modulo_Desc, Modulo_Status)
VALUES
('Fundamentos de Administração', 'Conceitos básicos e introdução à administração', '1'),
('Gestão Financeira', 'Princípios básicos de finanças e contabilidade', '1'),
('Marketing e Vendas', 'Conceitos fundamentais de marketing e técnicas de vendas', '1'),
('Gestão de Recursos Humanos', 'Fundamentos sobre o gerenciamento de pessoal', '1'),
('Empreendedorismo', 'Iniciação ao empreendedorismo e criação de novos negócios', '1'),
('Ética e Responsabilidade Social', 'Práticas de ética empresarial e responsabilidade social', '1');

-- Associar os módulos recém inseridos ao curso de Administração
-- Supondo que os IDs dos módulos inseridos sejam de 7 a 12
INSERT INTO Modulo_Curso (Modulo_Modulo_cd, Curso_Curso_cd)
VALUES
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2);



-- *********************************************************** --
-- ************ INSERIR EDIÇÕES A PARTIR DAQUI *************** --
-- *********************************************************** --

