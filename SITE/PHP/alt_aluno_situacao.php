<?php
include('../conexao.php'); // Caminho para seu script de conexão

// Verifica se há uma requisição POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtem os dados da requisição
    $situacao = $_POST['situacao'] ?? '';
    $usuarioId = $_POST['aluno_turma_id'] ?? '';

    // Validação simples (adapte conforme necessário)
    if (!in_array($situacao, ['Ativo', 'Inativo']) || !is_numeric($usuarioId)) {
        echo "Dados inválidos.";
        exit;
    }

    // Prepara a consulta SQL para atualizar a situação
    $situacaoNova = $situacao == 'Ativo' ? 1 : 0; // Supondo que '1' seja ativo e '0' seja inativo na sua tabela
    $sql = "UPDATE Aluno_Turma SET Aluno_Turma_Status = ? WHERE Aluno_Turma_id = ?";

    // Prepara a consulta
    if ($stmt = $conn->prepare($sql)) {
        // Vincula os parâmetros (s para string, i para inteiro)
        $stmt->bind_param("ii", $situacaoNova, $usuarioId);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "Situação alterada com sucesso!";
        } else {
            echo "Erro ao atualizar a situação.";
        }

        // Fecha o statement
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }
} else {
    echo "Requisição inválida.";
}
?>
