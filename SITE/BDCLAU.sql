create database Clau_teste;

use Clau_teste;

Create table tb_usuario (
    IdUsuario int auto_increment,
    Usuario varchar(15) not null,
    Senha varchar(15) not null,
    Nome varchar(30) not null,
    primary Key (IdUsuario)
);

insert into tb_usuario (IdUsuario,Usuario,Senha,Nome) values
	(default,'professor','professor','Luffy'),
    (default,'aluno','aluno','Naruto'),
    (default,'admin','admin','Zoro'),
    (default,'coordenacao','coordenacao','Tsunade');
    
select *  from tb_usuario;

-- drop database Clau_teste;