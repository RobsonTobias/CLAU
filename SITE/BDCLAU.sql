create database Clau_teste;

use Clau_teste;

create table tb_permissao(
	IdPermissao int auto_increment primary key,
    Descricao varchar(20) not null
    )engine=InnoDB default charset=utf8mb4;

insert into tb_permissao (IdPermissao,Descricao) values
	(default,'administracao'),
    (default,'coordenacao'),
    (default,'professor'),
    (default,'aluno');

Create table tb_usuario (
    IdUsuario int auto_increment primary key,
    Usuario varchar(15) not null,
    Senha varchar(15) not null,
    Nome varchar(30) not null,
    IdPermissao int not null,
    foreign key (IdPermissao) references tb_permissao(IdPermissao)    
)engine=InnoDB default charset=utf8mb4;

insert into tb_usuario (IdUsuario,Usuario,Senha,Nome,IdPermissao) values
	(default,'professor','professor','Luffy',3),
    (default,'aluno','aluno','Naruto',4),
    (default,'admin','admin','Zoro',1),
    (default,'coordenacao','coordenacao','Tsunade',2);
    
select * from tb_usuario;

-- drop database Clau_teste;