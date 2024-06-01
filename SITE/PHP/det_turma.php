<?php
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$turmaId = $_GET['userId'];

// Consulta para obter detalhes do usuário
$sql = "SELECT *, Curso.Curso_Nome AS Curso, Usuario.Usuario_Apelido AS professor FROM Turma
INNER JOIN Curso ON Curso.Curso_id = Turma.curso_cd
INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_id 
LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
WHERE Turma_Cod = ?
GROUP BY Curso.Curso_id, Turma.Turma_Cod";
$stmt = $conn->prepare($sql);

session_start();
$_SESSION['TurmaId'] = $turmaId;

// Verificar se a declaração foi preparada corretamente
if ($stmt === false) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("s", $turmaId);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$conn->close();
?>
