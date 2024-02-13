<?php
// Conexão com o banco de dados (substitua pelas suas credenciais)
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$userId = $_GET['userId'];


$sql = "SELECT Turma.Turma_cod, Curso.Curso_Nome, COUNT(Aluno_Turma.Usuario_Usuario_cd) AS Total_Alunos 
FROM Turma_Professor
INNER JOIN Turma ON Turma_Professor.Turma_Turma_Cod = Turma.Turma_Cod
INNER JOIN Modulo_Curso_Turma ON Turma.Turma_Cod = Modulo_Curso_Turma.Turma_Turma_Cod
INNER JOIN Modulo_Curso ON Modulo_Curso_Turma.Modulo_Curso_Modulo_Curso_cd = Modulo_Curso.Modulo_Curso_id
INNER JOIN Curso ON Modulo_Curso.Curso_Curso_cd = Curso.Curso_id
LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
WHERE Turma_Professor.Usuario_Usuario_cd = ?
AND Turma.Turma_Status = '1'
            GROUP BY Turma.Turma_Cod, Curso.Curso_Nome";
$stmt = $conn->prepare($sql);





$stmt->bind_param("i", $userId);
$stmt->execute();
$resultado = $stmt->get_result();

$turmas = array();

while ($row = $resultado->fetch_assoc()) {
    $turmas[] = $row;
}

// Fecha a conexão com o banco de dados
echo json_encode($turmas);

$stmt->close();
$conn->close();


