drop database if exists CLAU;
CREATE DATABASE CLAU;
USE CLAU;

CREATE TABLE Enderecos (
  Enderecos_id INT NOT NULL AUTO_INCREMENT,
  Enderecos_Cep CHAR(8) NOT NULL,
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
  Respon_Cpf CHAR(11) NOT NULL,
  Respon_Rg VARCHAR(10) NOT NULL,
  Respon_Parentesco VARCHAR(100) NOT NULL,
  PRIMARY KEY (Respon_id),
  UNIQUE INDEX Respon_Cpf_UNIQUE (Respon_Cpf ASC) 
)ENGINE = InnoDB;

CREATE TABLE Usuario (
  Usuario_id INT NOT NULL AUTO_INCREMENT,
  Usuario_Nome VARCHAR(80) NOT NULL,
  Usuario_Apelido VARCHAR (50) NOT NULL,
  Usuario_Email VARCHAR(100) NOT NULL,
  Usuario_Sexo CHAR(1) NOT NULL,
  Usuario_Cpf CHAR(11) NOT NULL,
  Usuario_Rg VARCHAR(10) NOT NULL,
  Usuario_Nascimento DATE NOT NULL,
  Usuario_EstadoCivil VARCHAR(20) NOT NULL,
  Usuario_Fone VARCHAR(13) NOT NULL,
  Usuario_Fone_Recado VARCHAR(13) NULL,
  Usuario_Login VARCHAR(100) NOT NULL,
  Usuario_Senha VARCHAR(45) NOT NULL,
  Responsavel_Respon_cd INT NULL,
  Usuario_Obs VARCHAR(5000) NULL,
  Enderecos_Enderecos_cd INT NOT NULL,
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Funcionario que cadastrou - automatico',
  Usuario_Status CHAR(1) DEFAULT 1,
  Usuario_Foto VARCHAR(255) NULL,
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
  Curso_Desc VARCHAR(50) NOT NULL,
  Curso_Duracao INT NOT NULL,
  Curso_PreRequisito VARCHAR(5000) NOT NULL,
  Curso_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Curso_Status CHAR(1) DEFAULT 1,
  PRIMARY KEY (Curso_id)
)ENGINE = InnoDB;

CREATE TABLE Turma (
  Turma_Cod CHAR(12) NOT NULL,
  Turma_Horario TIME NOT NULL,
  Turma_Vagas INT NOT NULL,
  Turma_Dias INT(3) NOT NULL,
  Turma_Obs VARCHAR(1000) NULL,
  Turma_Inicio DATE NOT NULL,
  Turma_Status CHAR(1) DEFAULT 1,
  Turma_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Turma_Cod),
  Usuario_Usuario_cd int not null, -- chave estrageira dps
  curso_cd int not null, -- chave estrageira dps
  foreign key (Usuario_Usuario_cd) references Usuario(Usuario_id),
  foreign key (curso_cd) references Curso(curso_id)
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

CREATE TABLE Chamada (
  Chamada_id INT NOT NULL AUTO_INCREMENT,
  Chamada_Data DATE NOT NULL,
  PRIMARY KEY (Chamada_id))
ENGINE = InnoDB;

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
  Aluno_Turma_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (Aluno_Turma_id),
  CONSTRAINT fk_Aluno_Turma_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id),
  CONSTRAINT fk_Aluno_Turma_Turma1 FOREIGN KEY (Turma_Turma_Cod) REFERENCES Turma (Turma_Cod)
) ENGINE=InnoDB;

CREATE TABLE Aula (
  Aula_Aluno_Turma_cd INT NOT NULL,
  Chamada_Chamada_cd INT NOT NULL,
  Aula_Presenca CHAR(1) NOT NULL COMMENT '1 - presença ou 0 - falta',
  Aula_Ocorrencia TEXT NULL,
  PRIMARY KEY (Aula_Aluno_Turma_cd, Chamada_Chamada_cd),
  CONSTRAINT fk_Aula_Aluno_Turma1 FOREIGN KEY (Aula_Aluno_Turma_cd) REFERENCES Aluno_Turma (Aluno_Turma_id),
  CONSTRAINT fk_Aula_Chamada1 FOREIGN KEY (Chamada_Chamada_cd) REFERENCES Chamada (Chamada_id)
) ENGINE=InnoDB;

create table Ocorrencia(
	ocorrencia_id int not null,
	Aluno_Turma_cd INT NOT NULL,
	mensagem TEXT not null,
    Usuario_Usuario_cd int not null,
    Ocorrencia_Registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ocorrencia_id),
    FOREIGN KEY (Aluno_Turma_cd) REFERENCES Aluno_Turma (Aluno_Turma_id),
    FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id)
);

CREATE TABLE Nota (
  Usuario_Usuario_cd INT NOT NULL COMMENT 'Aluno',
  Avaliacoes_Avaliacoes_cd INT NOT NULL,
  Nota_Valor INT(100) NOT NULL,
  Nota_Data DATETIME NOT NULL,
  PRIMARY KEY (Usuario_Usuario_cd, Avaliacoes_Avaliacoes_cd),
  CONSTRAINT fk_Nota_Usuario1 FOREIGN KEY (Usuario_Usuario_cd) REFERENCES Usuario (Usuario_id),
  CONSTRAINT fk_Nota_Avaliacoes1 FOREIGN KEY (Avaliacoes_Avaliacoes_cd) REFERENCES Avaliacoes (Avaliacoes_id)
)ENGINE = InnoDB;


ALTER TABLE turma ADD Turma_Termino DATE;

-- Dados da tabela Tipo
INSERT INTO Tipo (Tipo_Descricao)
VALUES	('Master'),
		('Secretaria'),
		('Aluno'),
        ('Professor'),
        ('Coordenador');
        
-- Endereço do usuário MASTER na tabela Endereços
INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf)
VALUES ('12246260','Avenida Salmão','570','Parque Residencial Aquarius','São José dos Campos','São Paulo');

-- Cadastro do usuário MASTER na tabela Usuaário
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Master','Diretor','master@email.com','M','12345678900','123456789','2024-01-01','Solteiro','123456789','master','master',1,1,1,'../IMAGE/PROFILE/master.jpg');

INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Maria Pereira', 'Prof. Maria', 'mariapereira@email.com', 'F', '22233344455', 'MG1234567', '1975-04-20', 'Casada', '11987654321', 'mariap', 'senhasegura', 1, 1, 'A', '../IMAGE/PROFILE/mariapereira.jpg');

INSERT INTO Responsavel (Respon_Nome, Respon_Fone, Respon_Cpf, Respon_Rg, Respon_Parentesco)
VALUES ('João da Silva', '11987654321', '12345678901', 'MG1234567', 'Pai');

INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Fone_Recado, Usuario_Login, Usuario_Senha, Responsavel_Respon_cd, Usuario_Obs, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('Joao Silva', 'Joaozinho', 'joaosilva@email.com', 'M', '98765432100', '987654321', '2000-06-15', 'Solteiro', '11987654321', '1132109876', 'joaosilva', 'senha123', 1, 'Observação sobre o aluno', 1, 1, '1', '../IMAGE/PROFILE/joaosilva.jpg');


INSERT INTO Curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status)
VALUES ('Introdução à Programação', 'INT', 120, 'Curso básico de programação', 6, 'Nenhum pré-requisito', '1');

INSERT INTO Curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status)
VALUES ('Desenvolvimento Web', 'WEB', 200, 'Curso avançado de desenvolvimento de websites', 12, 'Introdução à Programação', '1');

INSERT INTO Curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status)
VALUES
('Ciência de Dados', 'CDD', 300, 'Curso de Ciência de Dados', 12, 'Nenhum pré-requisito', '1');



-- Cadastro do usuário como tipo MASTER na tabela Registro_Usuario
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (1,1);

INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (2,3);

-- Supondo que o ID de Maria Pereira inserido na tabela Usuario seja 3
INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (3, 4);

INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Fone_Recado, Usuario_Login, Usuario_Senha, Responsavel_Respon_cd, Usuario_Obs, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES ('secretaria', 'Joaozinho', 'joaosilva@mail.com', 'M', '98765432101', '987654321', '2000-06-15', 'Solteiro', '11987654321', '1132109876', 'secretaria', 'secretaria', 1, 'Observação sobre o aluno', 1, 1, '1', '../IMAGE/PROFILE/joaosilva.jpg');





-- Insira os módulos
INSERT INTO Modulo (Modulo_Nome, Modulo_Desc, Modulo_Status)
VALUES
('Introdução ao Python', 'Módulo de Python para iniciantes', '1'),
('Estatística Aplicada', 'Estatística básica para Ciência de Dados', '1');

-- Associar módulos aos cursos
INSERT INTO Modulo_Curso (Modulo_Modulo_cd, Curso_Curso_cd)
VALUES
(1, 3), 
(2, 3);

-- Insira as turmas associadas aos cursos
INSERT INTO Turma (Turma_Cod, Turma_Horario, Turma_Vagas, Turma_Dias, Turma_Obs, Turma_Inicio, Turma_Status, curso_cd, Usuario_Usuario_cd)
VALUES
('TURMA202402', '08:00:00', 30, 5, 'Turma de Inglês Básico', '2024-02-01', '1',1 ,3), 
('TURMA202403', '19:00:00', 25, 3, 'Turma noturna de Ciência de Dados', '2024-03-01', '1', 2, 3); 



INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES
('Ana Silva', 'Ana', 'anasilva@email.com', 'F', '33344455566', 'SP9876543', '1990-05-20', 'Solteira', '11998765432', 'anasilva', 'senha123', 1, 1, '1', '../IMAGE/PROFILE/anasilva.jpg'),
('Carlos Pereira', 'Carlos', 'carlospereira@email.com', 'M', '44455566677', 'RJ1234567', '1992-07-15', 'Solteiro', '21987654321', 'carlosp', 'senha123', 1, 1, '1', '../IMAGE/PROFILE/carlos.jpg');

-- Agora associe os alunos às turmas
INSERT INTO Aluno_Turma (Usuario_Usuario_cd, Turma_Turma_Cod)
VALUES
(4, 'TURMA202403');


-- Insercoes necessarias para funcionar a de professor
INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Login, Usuario_Senha, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Status, Usuario_Foto)
VALUES 
('João Almeida', 'Prof. João', 'joaoalmeida@email.com', 'M', '33322211100', 'MG8765432', '1980-03-10', 'Casado', '21987654321', 'joaoa', 'senha123', 1, 1, '1', '../IMAGE/PROFILE/joao.jpg');

INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (4, 2);

INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd)
VALUES (7, 4);


INSERT INTO Turma (Turma_Cod, Turma_Horario, Turma_Vagas, Turma_Dias, Turma_Obs, Turma_Inicio, Turma_Status, curso_cd, Usuario_Usuario_cd)
VALUES ('TURMA202404', '10:00:00', 20, 3, 'Turma de teste', '2024-04-01', '1',3, 7);



select * from enderecos;
use clau;

select * from aluno_turma;
select * from modulo_curso;
select * from curso;
select * from turma;
select * from usuario;
select * from Registro_Usuario;
show tables;

SHOW COLUMNS FROM TURMA;

CREATE TABLE DiasSemana (
    id_dia INT PRIMARY KEY,
    nome_dia VARCHAR(20)
);

select * from diasSemana;

INSERT INTO DiasSemana (id_dia, nome_dia) VALUES
(1, 'Segunda-feira'),
(2, 'Terça-feira'),
(3, 'Quarta-feira'),
(4, 'Quinta-feira'),
(5, 'Sexta-feira'),
(6, 'Sábado');

SELECT * FROM DIASSEMANA;
select * from turma;
