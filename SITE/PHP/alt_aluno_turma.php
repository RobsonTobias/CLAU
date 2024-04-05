<?php
// Inclua o arquivo de conexão com o banco de dados
include('../conexao.php'); // Caminho para seu script de conexão

// Verifique se os dados necessários foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os valores enviados pelo AJAX
    $novaTurma = $_POST['turma'] ?? '';
    $alunoTurmaId = $_POST['aluno_turma_id'] ?? '';

    // Prepara a query SQL para atualizar a turma do aluno
    $sql = "UPDATE Aluno_Turma SET Turma_Turma_Cod = ? WHERE Aluno_Turma_id = ?";

    // Prepara a declaração para execução
    $stmt = $conn->prepare($sql);

    if($stmt) {
        // Vincula os parâmetros ao comando SQL
        $stmt->bind_param("si", $novaTurma, $alunoTurmaId);

        // Executa a query
        if($stmt->execute()) {
            // Se a query foi bem-sucedida, envia uma resposta positiva
            echo "Atualização realizada com sucesso.";
        } else {
            // Caso a query falhe, envia uma mensagem de erro
            echo "Erro ao atualizar a turma do aluno.";
        }
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta.";
    }
} else {
    // Caso os dados necessários não tenham sido enviados
    echo "Dados insuficientes para a atualização.";
}
?>
