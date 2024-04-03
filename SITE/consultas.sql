use clau;

select * from aluno_turma;


SELECT u.Usuario_Nome, at.Turma_Turma_Cod
FROM Usuario u
INNER JOIN Aluno_Turma at ON u.Usuario_id = at.Usuario_Usuario_cd
INNER JOIN Turma t ON at.Turma_Turma_Cod = t.Turma_Cod;

use clau;

select * from chamada;

select * from aula;

select * from usuario;

select usuario_nome, usuario_nascimento from usuario;


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


SELECT Turma.Turma_Cod, Curso.Curso_Nome
FROM Turma
JOIN Curso ON Turma.Curso_cd = Curso.Curso_id;

SELECT Modulo.Modulo_Nome, Curso.Curso_Nome
FROM Modulo
JOIN Modulo_Curso ON Modulo.Modulo_id = Modulo_Curso.Modulo_Modulo_cd
JOIN Curso ON Modulo_Curso.Curso_Curso_cd = Curso.Curso_id;

select * from nota;

show tables;

select * from modulo;
select * from modulo_curso;

select * from avaliacoes;

select * from notas;

SELECT
    U.Usuario_Nome AS NomeDoAluno,
    M.Modulo_Nome AS NomeDoModulo,
    N.nota AS Nota
FROM
    notas N
INNER JOIN aluno_turma AT ON N.id_aluno_turma = AT.Aluno_Turma_id
INNER JOIN usuario U ON AT.Usuario_Usuario_cd = U.Usuario_id
INNER JOIN modulo M ON N.id_modulo = M.Modulo_id where id_modulo = 5;


select * from aluno_turma;
select * from modulo;

select * from notas;

select * from Usuario;
select * from Curso;