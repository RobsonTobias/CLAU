<?php
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$userId = $_GET['userId'];

// Consulta para obter detalhes do usuário
$sql = "SELECT * FROM Curso 
INNER JOIN Modulo_Curso on Modulo_Curso.Curso_Curso_cd = Curso.Curso_id  
INNER JOIN Modulo on Modulo.Modulo_id = Modulo_Curso.Modulo_id
WHERE Curso_id = ?";
$stmt = $conn->prepare($sql);

session_start();
$_SESSION['CursoSelecionado'] = $userId;

// Verificar se a declaração foi preparada corretamente
if ($stmt === false) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);

$stmt->close();
$conn->close();
?>
