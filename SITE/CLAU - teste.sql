drop database if exists CLAU;

CREATE DATABASE CLAU;

USE CLAU;

CREATE TABLE Endereco (
  id INT NOT NULL AUTO_INCREMENT,
  cep CHAR(9) NOT NULL,
  rua VARCHAR(100) NOT NULL,
  numero INT(10) NOT NULL,
  complemento VARCHAR(10) NULL,
  bairro VARCHAR(100) NOT NULL,
  cidade VARCHAR(100) NOT NULL,
  estado VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE Responsavel (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  fone VARCHAR(15) NOT NULL,
  cpf CHAR(14) NOT NULL UNIQUE,
  rg VARCHAR(14) NOT NULL,
  parentesco VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE Usuario (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  apelido VARCHAR (50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  sexo CHAR(1) NOT NULL,
  cpf CHAR(14) NOT NULL UNIQUE,
  rg VARCHAR(14) NOT NULL,
  data_nascimento DATE NOT NULL,
  estado_civil VARCHAR(20) NOT NULL,
  fone VARCHAR(15) NOT NULL,
  fone_recado VARCHAR(15) NULL,
  login VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(45) NOT NULL,
  cd_responsavel INT NULL,
  obs TEXT NULL,
  cd_endereco INT NOT NULL,
  cd_cadastrante INT NOT NULL COMMENT 'Funcionario que cadastrou - automatico',
  status CHAR(1) DEFAULT 1,
  foto VARCHAR(255) NULL,
  matricula INT (6) NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (cd_responsavel) REFERENCES Responsavel (id),
  FOREIGN KEY (cd_endereco) REFERENCES Endereco (id),
  FOREIGN KEY (cd_cadastrante) REFERENCES Usuario (id)
) ENGINE = InnoDB;

CREATE TABLE Curso (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  sigla CHAR(3) NOT NULL,
  carga_horaria INT(10) NOT NULL,
  descricao VARCHAR(500) NOT NULL,
  duracao INT NOT NULL,
  pre_requisito VARCHAR(500) NOT NULL,
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status CHAR(1) DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE Turma (
  codigo CHAR(12) NOT NULL,
  horario_inicio TIME NOT NULL,
  horario_termino TIME NOT NULL,
  vagas INT NOT NULL,
  dias INT(3) NOT NULL,
  obs VARCHAR(1000) NULL,
  data_inicio DATE NOT NULL,
  data_termino DATE NULL,
  status CHAR(1) DEFAULT 1,
  cd_professor INT NOT NULL,
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  cd_criador INT NOT NULL,
  cd_curso INT NOT NULL,
  PRIMARY KEY (codigo),
  FOREIGN KEY (cd_professor) REFERENCES Usuario(id),
  FOREIGN KEY (cd_criador) REFERENCES Usuario(id),
  FOREIGN KEY (cd_curso) REFERENCES Curso(id)
) ENGINE = InnoDB;

CREATE TABLE Modulo (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao VARCHAR(500) NOT NULL,
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status CHAR(1) DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE ModuloCurso (
  id INT NOT NULL AUTO_INCREMENT,
  cd_modulo INT NOT NULL,
  cd_curso INT NOT NULL,
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (cd_modulo) REFERENCES Modulo (id),
  FOREIGN KEY (cd_curso) REFERENCES Curso (id)
) ENGINE = InnoDB;

CREATE TABLE Avaliacao (
  id INT NOT NULL AUTO_INCREMENT,
  descricao VARCHAR(50) NULL,
  cd_professor INT NOT NULL COMMENT 'Professor',
  cd_modulo_curso INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (cd_professor) REFERENCES Usuario (id),
  FOREIGN KEY (cd_modulo_curso) REFERENCES ModuloCurso (id)
) ENGINE = InnoDB;

CREATE TABLE Chamada (
  id INT NOT NULL AUTO_INCREMENT,
  data_registro DATE NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE Tipo (
  id INT NOT NULL AUTO_INCREMENT,
  descricao VARCHAR(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE = InnoDB;

CREATE TABLE Mensagem (
  id INT NOT NULL AUTO_INCREMENT,
  descricao MEDIUMTEXT NOT NULL,
  data_registro DATETIME NOT NULL,
  cd_funcionario INT NOT NULL COMMENT 'Funcionario',
  PRIMARY KEY (id),
  FOREIGN KEY (cd_funcionario) REFERENCES Usuario (id)
) ENGINE = InnoDB;

CREATE TABLE RegistroUsuario (
  cd_usuario INT NOT NULL,
  cd_tipo INT NOT NULL,
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (cd_usuario, cd_tipo),
  FOREIGN KEY (cd_usuario) REFERENCES Usuario (id),
  FOREIGN KEY (cd_tipo) REFERENCES Tipo (id)
) ENGINE = InnoDB;

CREATE TABLE MensagemAluno (
  cd_mensagem INT NOT NULL,
  cd_aluno INT NOT NULL COMMENT 'Aluno',
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (cd_mensagem, cd_aluno),
  FOREIGN KEY (cd_mensagem) REFERENCES Mensagem (id),
  FOREIGN KEY (cd_aluno) REFERENCES Usuario (id)
) ENGINE = InnoDB;

CREATE TABLE AlunoTurma (
  id INT NOT NULL AUTO_INCREMENT,
  cd_aluno INT NOT NULL COMMENT 'Aluno',
  cd_codigo_turma CHAR(12) NOT NULL COMMENT 'Código da turma',
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (cd_aluno) REFERENCES Usuario (id),
  FOREIGN KEY (cd_codigo_turma) REFERENCES Turma (codigo)
) ENGINE = InnoDB;

CREATE TABLE Aula (
  cd_aluno_turma INT NOT NULL,
  cd_chamada INT NOT NULL,
  presenca CHAR(1) NOT NULL COMMENT '1 - presença ou 0 - falta',
  ocorrencia TEXT NULL,
  PRIMARY KEY (cd_aluno_turma, cd_chamada),
  FOREIGN KEY (cd_aluno_turma) REFERENCES AlunoTurma (id),
  FOREIGN KEY (cd_chamada) REFERENCES Chamada (id)
) ENGINE = InnoDB;

create table Ocorrencia(
  id INT NOT NULL AUTO_INCREMENT,
  cd_aluno_turma INT NOT NULL,
  mensagem TEXT NOT NULL,
  cd_cadastrante INT NOT NULL COMMENT 'Quem fez o cadastro da ocorrência',
  data_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (cd_aluno_turma) REFERENCES AlunoTurma (id),
  FOREIGN KEY (cd_cadastrante) REFERENCES Usuario (id)
) ENGINE = InnoDB;

CREATE TABLE Nota (
  cd_aluno INT NOT NULL COMMENT 'Aluno',
  cd_avaliacao INT NOT NULL,
  valor INT(100) NOT NULL,
  data_registro DATETIME NOT NULL,
  PRIMARY KEY (cd_aluno, cd_avaliacao),
  FOREIGN KEY (cd_aluno) REFERENCES Usuario (id),
  FOREIGN KEY (cd_avaliacao) REFERENCES Avaliacao (id)
) ENGINE = InnoDB;

CREATE TABLE DiasSemana (
  id INT,
  nome VARCHAR(20),
  sigla CHAR(3),
  PRIMARY KEY (id)
) ENGINE = InnoDB;


-- *************************************************************** --
-- ************ FIM DAS TABELAS - ABAIXO INSERÇÕES *************** --
-- *************************************************************** --

-- Dados da tabela Tipo
INSERT INTO
  Tipo (descricao)
VALUES
  ('Master'),
  ('Secretaria'),
  ('Aluno'),
  ('Professor'),
  ('Coordenador');

-- Cadastro dos dias da semana
INSERT INTO
  DiasSemana (id, nome, sigla)
VALUES
  (1, 'Domingo', 'DOM'),
  (2, 'Segunda-feira', 'SEG'),
  (3, 'Terça-feira', 'TER'),
  (4, 'Quarta-feira', 'QUA'),
  (5, 'Quinta-feira', 'QUI'),
  (6, 'Sexta-feira', 'SEX'),
  (7, 'Sábado', 'SAB');

-- ---------------- --
-- MASTER / DIRETOR --
-- ---------------- --      
-- Endereço do usuário MASTER na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12246-260','Avenida Salmão','570','Parque Residencial Aquarius','São José dos Campos','São Paulo');

-- Cadastro do usuário MASTER na tabela Usuario
INSERT INTO
  Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Master','Diretor','master@email.com','F','123.456.789-00','12.345.678-9','1987-01-01','Solteiro','(12) 3456-7899','master','master',1,1,1,'../IMAGE/PROFILE/master.jpg');

-- Cadastro do usuário como tipo MASTER na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (1, 1);

-- -------------------- --
-- FIM MASTER / DIRETOR --
-- -------------------- --
-- ---------- --
-- SECRETARIA --
-- ---------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12240-030','Rua dos Alecrins','538','Jardim das Indústrias','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO
  Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Miguel Almeida Ferreira','Miguel','miguel.ferreira@email.com','M','904.276.838-07','11.111.111-1','1996-02-15','Solteiro','(11) 11111-1111','secretaria','secretaria',2,1,1,'../IMAGE/PROFILE/02.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (2, 2);

-- -------------- --
-- FIM SECRETARIA --
-- -------------- --
-- --------- --
-- PROFESSOR --
-- --------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12233-597','Rua Andrelândia','103','Bosque dos Eucaliptos','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO
 Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Evelyn Azevedo Pinto','Evelyn','evelyn.pinto@email.com','F','439.979.782-71','22.222.222-2','1989-03-26','Casada','(22) 2222-2222','professor','professor',3,2,1,'../IMAGE/PROFILE/03.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (3, 4);

-- ------------- --
-- FIM PROFESSOR --
-- ------------- --
-- ----------------------- --
-- COORDENADOR / PROFESSOR --
-- ----------------------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12242-530','Rua João Bicudo','258','Jardim Esplanada','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO
  Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Kiyumi Otsuka','Kiyumi','kiyumi.otsuka@email.com','F','658.285.418-62','33.333.333-3','1991-04-17','Solteira','(33) 33333-3333','coordenador','coordenador',4,2,1,'../IMAGE/PROFILE/01.png');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (4, 4),
  (4, 5);

-- --------------------------- --
-- FIM COORDENADOR / PROFESSOR --
-- --------------------------- --
-- -------- --
-- ALUNO 01 --
-- -------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12236-420','Rua Joana Soares Ferreira','1063','Cidade Morumbi','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO
  Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Laura Cunha Dias','Laura','laura.dias@email.com','F','135.577.066-13','44.444.444-4','2003-06-18','Solteira','(44) 4444-4444','aluno','aluno',5,2,1,'../IMAGE/PROFILE/04.png','240001');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (5, 3);

-- ------------ --
-- FIM ALUNO 01 --
-- ------------ --
-- -------- --
-- ALUNO 02 --
-- -------- --
-- Endereço do usuário na tabela Endereços
INSERT INTO
  Endereco (cep, rua, numero, bairro, cidade, estado)
VALUES
  ('12220-200','Rua Graúna','562','Vila Tatetuba','São José dos Campos','São Paulo');

-- Cadastro do usuário na tabela Usuario
INSERT INTO
  Usuario (nome, apelido, email, sexo, cpf, rg, data_nascimento, estado_civil, fone, login, senha, cd_endereco, cd_cadastrante, status, foto)
VALUES
  ('Vitória Pinto Carvalho','Vitória','vitoria.carvalho@email.com','F','142.763.597-83','44.333.555-8','2008-10-05','Solteira','(55) 55555-5555','aluno2','aluno2',6,2,1,'../IMAGE/PROFILE/05.png','240002');

-- Cadastro do usuário como tipo na tabela Registro_Usuario
INSERT INTO
  RegistroUsuario (cd_usuario, cd_tipo)
VALUES
  (6, 3);

-- ------------ --
-- FIM ALUNO 02 --
-- ------------ --
-- ------ --
-- CURSOS --
-- ------ --
INSERT INTO
  Curso (nome,sigla,carga_horaria,descricao,duracao,pre_requisito,status)
VALUES
  ('Informática','INF',150,'Curso de informática e pacote Office',18,'Nenhum pré-requisito','1'),
  ('Administração de Empresas','ADM',200,'Curso básico de Administração de Empresas',24,'Nenhum Pré-requisito','1'),
  ('Inglês','ING',200,'Curso de Inglês do básico ao avançado',24,'Nenhum Pré-requisito','1'),
  ('Web-Design','WEB',200,'Curso de Web-Design com programação de sites e edição',24,'Informática Básica','1');

-- ************* --
-- ** MÓDULOS ** --
-- ************* --  
-- ----------- --
-- INFORMATICA --
-- ----------- --
INSERT INTO
  Modulo (nome,descricao,status)
VALUES
  ('Introdução à Informática','Conhecimento básico de informática','1'),
  ('Windows','Principais funcionalidades do Windows','1'),
  ('Word', 'Funcionalidades do Word', '1'),
  ('Excel','Criação de planilhas com fórmulas','1'),
  ('Power Point', 'Criação de apresentações', '1'),
  ('Internet','Principais funcionalidades da Internet','1');

-- --------------------------- --
-- Associar módulos aos cursos --
-- --------------------------- --
INSERT INTO
  ModuloCurso (cd_modulo,cd_curso)
VALUES
  (1, 1),
  (2, 1),
  (3, 1),
  (4, 1),
  (5, 1),
  (6, 1);

-- *********************************************************** --
-- ************ INSERIR EDIÇÕES A PARTIR DAQUI *************** --
-- *********************************************************** --
select * from Usuario;

select * from Curso;

select * from Ocorrencia;

select * from turma;

select * from alunoturma;

select * from Ocorrencia;

SELECT * FROM Usuario
INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
INNER JOIN Registro_Usuario on Registro_Usuario.Usuario_Usuario_cd = Usuario.Usuario_id
INNER JOIN Aluno_Turma on Aluno_Turma.Usuario_Usuario_cd = Usuario.Usuario_id
INNER JOIN Ocorrencia on  Ocorrencia.Aluno_Turma_cd = Aluno_Turma.Aluno_Turma_id
WHERE Usuario.Usuario_id = 5;