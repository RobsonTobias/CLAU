<?php
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    echo json_encode(["error" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}

$userId = $_GET['userId'];

// Consulta para obter detalhes do curso
$sql = "SELECT Curso.Curso_Nome, Curso.Curso_Sigla, Curso.Curso_Status, Modulo.Modulo_Nome 
        FROM Curso 
        LEFT JOIN Modulo_Curso ON Modulo_Curso.Curso_Curso_cd = Curso.Curso_id  
        LEFT JOIN Modulo ON Modulo.Modulo_id = Modulo_Curso.Modulo_id
        WHERE Curso.Curso_id = ?;";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Erro na preparação: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

if (empty($data)) {
    echo json_encode(["error" => "Nenhum dado encontrado para este curso."]);
} else {
    echo json_encode($data);
}

$stmt->close();
$conn->close();
?>
