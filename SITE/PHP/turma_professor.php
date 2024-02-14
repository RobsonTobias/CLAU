<?php
// Conexão com o banco de dados
header('Content-Type: application/json');
include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$userId = $_GET['userId'];

$sql = "SELECT Turma.Turma_Cod, Curso.Curso_Nome, COUNT(Aluno_Turma.Usuario_Usuario_cd) AS Total_Alunos 
FROM Turma
INNER JOIN Curso ON Turma.curso_cd = Curso.Curso_id
LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
WHERE Turma.Usuario_Usuario_cd = ?
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

echo json_encode($turmas);
$stmt->close();
$conn->close();
?>


