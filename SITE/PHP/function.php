<?php
function ListarUsuario($tipoUsuario)
{
    $sql = "SELECT Usuario_id, Usuario_Nome, Usuario_Email FROM Usuario
            INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
            Where Registro_Usuario.Tipo_Tipo_cd = $tipoUsuario and Usuario_Status = 1";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhum usuário encontrado!';
    }
}

function ListarInfoUsuario($userId)
{
    $sql = "SELECT * FROM Usuario
            INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
            WHERE Usuario_id = $userId";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhum usuário encontrado!';
    }
}

function Coordenador($userId)
{
    $sql = "SELECT EXISTS (
            SELECT 1 FROM Registro_Usuario
            WHERE Usuario_Usuario_cd = $userId AND Tipo_Tipo_cd = 5
            ) AS resultado";
    $res = $GLOBALS['conn']->query($sql);
    $row = $res->fetch_assoc();
    return $row['resultado'] == 1;
}

function ListarCurso()
{
    $sql = "SELECT Curso_id, Curso_Nome, Curso_Sigla FROM Curso";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhum curso encontrado!';
    }
}

function ListarTurma()
{
    $sql = "SELECT Curso_Nome, Turma_Cod, Usuario_Apelido, Turma_Vagas, COUNT(Aluno_Turma.Usuario_Usuario_cd) AS matriculados FROM Turma
    INNER JOIN Curso ON Turma.curso_cd = Curso.Curso_id
    INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_id 
    LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
    GROUP BY Curso.Curso_id, Turma.Turma_Cod";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhuma turma encontrada!';
    }
}

function ListarProfessor()
{
    $sql = "SELECT Usuario_id, Usuario_Apelido FROM Usuario
            INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
            WHERE Registro_Usuario.Tipo_Tipo_cd = 4";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhuma professor encontrado!';
    }
}

?>