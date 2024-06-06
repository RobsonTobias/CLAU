<?php
include_once '../../conexao.php';

// Verifica se o método de requisição é POST e se os parâmetros necessários foram passados
if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST['id']) || empty($_POST['lida'])) {
    echo json_encode(array("success" => false, "error" => "Método de requisição inválido ou parâmetros ausentes."));
    exit;
}

$id = $_POST['id'];
$lida = $_POST['lida'];

// Convertendo para valores booleanos
$lida = ($lida === 'true') ? 'TRUE' : 'FALSE';

// Usando uma instrução preparada para evitar injeção SQL
$sqlAtualiza = 'UPDATE notificacao SET lida = ? WHERE id_notificacao = ?';

// Preparando a consulta
if ($stmt = $conn->prepare($sqlAtualiza)) {
    // Vinculando parâmetros
    $stmt->bind_param('si', $lida, $id);

    // Executando a consulta
    if ($stmt->execute()) {
        // Retorna uma resposta JSON indicando sucesso
        echo json_encode(array("success" => true));
    } else {
        // Retorna uma resposta JSON indicando erro
        echo json_encode(array("success" => false, "error" => "Erro ao atualizar o estado da notificação: " . $conn->error));
    }

    // Fechando o statement
    $stmt->close();
} else {
    // Retorna uma resposta JSON indicando erro
    echo json_encode(array("success" => false, "error" => "Erro ao preparar a consulta: " . $conn->error));
}
?>
