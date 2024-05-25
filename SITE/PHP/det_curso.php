<?php
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$userId = $_GET['userId'];

// Consulta para obter detalhes do curso
$sql = "SELECT Curso.Curso_Nome, Curso.Curso_Sigla, Curso.Curso_Status, Modulo.Modulo_Nome 
        FROM Curso 
        INNER JOIN Modulo_Curso ON Modulo_Curso.Curso_Curso_cd = Curso.Curso_id  
        INNER JOIN Modulo ON Modulo.Modulo_id = Modulo_Curso.Modulo_id
        WHERE Curso.Curso_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Erro na preparação: " . $conn->error);
}

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>
