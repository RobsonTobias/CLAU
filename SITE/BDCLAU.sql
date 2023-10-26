create database Clau_teste;

use Clau_teste;

Create table tb_usuario (
    IdUsuario int auto_increment,
    Usuario varchar(15) not null,
    Senha varchar(15) not null,
    primary Key (IdUsuario)
);

insert into tb_usuario (IdUsuario,Usuario,Senha) values
	(default,'professor','professor'),
    (default,'aluno','aluno'),
    (default,'admin','admin'),
    (default,'coordenacao','coordenacao');
    
select *  from tb_usuario;

-- drop database Clau_teste;