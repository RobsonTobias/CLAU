<?php

include '../conexao.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Certifique-se de que ambos os IDs estão disponíveis
if (isset($_SESSION['AlunoId'], $_SESSION['TurmaId'])) {
    $alunoId = $_SESSION['AlunoId'];
    $turmaId = $_SESSION['TurmaId'];

    // Verificar se o aluno já está cadastrado na turma
    $sqlCheck = "SELECT * FROM Aluno_Turma WHERE Usuario_Usuario_cd = ? AND Turma_Turma_Cod = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    if ($stmtCheck) {
        $stmtCheck->bind_param("is", $alunoId, $turmaId);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        if ($resultCheck->num_rows > 0) {
            echo "Aluno já cadastrado na turma.";
        } else {
            // Preparar a declaração SQL para inserir o novo cadastro
            $sqlInsert = "INSERT INTO Aluno_Turma (Usuario_Usuario_cd, Turma_Turma_Cod) VALUES (?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            if ($stmtInsert) {
                // Vincular os parâmetros e executar
                $stmtInsert->bind_param("is", $alunoId, $turmaId);
                if ($stmtInsert->execute()) {
                    echo "Cadastro realizado com sucesso!";
                } else {
                    echo "Erro ao inserir cadastro: " . $stmtInsert->error;
                }
                $stmtInsert->close();
            } else {
                echo "Erro ao preparar declaração: " . $conn->error;
            }
        }
        $stmtCheck->close();
    } else {
        echo "Erro ao preparar declaração de verificação: " . $conn->error;
    }
} else {
    echo "ID do aluno ou da turma não disponível.";
}

$conn->close();

?>