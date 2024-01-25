<?php
header('Content-Type: application/json');

include '../conexao.php';

// Checar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$userId = $_GET['userId'];

// Consulta para obter detalhes do usuário
$sql = "SELECT * FROM Usuario 
INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd  
INNER JOIN Registro_Usuario on Registro_Usuario.Usuario_Usuario_cd = Usuario.Usuario_id
WHERE Usuario_id = ?";
$stmt = $conn->prepare($sql);

$endId = "SELECT Enderecos_Enderecos_cd FROM Usuario
INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
WHERE Usuario_id = ?";

session_start();
$_SESSION['UsuarioSelecionado'] = $userId;
$_SESSION['EnderecoId'] = $endId;

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
