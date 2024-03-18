use clau;

select * from aluno_turma;

select * from chamada;

select * from aula;

select * from usuario;

show tables;

select * from turma;

delete from turma where turma_vagas =  21;

select * from curso;

UPDATE turma
SET Turma_Horario_Termino = "12:00:00"
WHERE Turma_Cod = "INF2024003";

update turma
set turma_dias = 2
where turma_cod ="INF2024003";


select * from usuario;
select * from registro_usuario;



SET SQL_SAFE_UPDATES = 0;

select * from registro_usuario;

select * from tipo;


SHOW COLUMNS FROM usuario;
