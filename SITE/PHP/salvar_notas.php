<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

include '../conexao.php'; // Inclui o arquivo de conexão com o banco de dados
$mensagem = ""; // Inicializa a variável que vai armazenar a mensagem
$redirecionar = false; // Define a variável de controle para redirecionamento como false inicialmente

// Verifica se os dados foram enviados pelo formulário
if (isset($_POST['salvarNotas'], $_POST['turma'], $_POST['modulo'], $_POST['notas']) && is_array($_POST['notas'])) {
    $turmaCod = $_POST['turma'];
    $moduloId = $_POST['modulo'];
    $notas = $_POST['notas'];

    foreach ($notas as $usuarioId => $nota) {
        // Obtenção do id_aluno_turma
        $idAlunoTurma = getIdAlunoTurma($usuarioId, $turmaCod, $conn);

        if (!is_null($idAlunoTurma)) {
            // Verifica se a nota já existe
            if (notaExiste($idAlunoTurma, $moduloId, $conn)) {
                // Atualiza a nota
                $sql = "UPDATE notas SET nota = ? WHERE id_aluno_turma = ? AND id_modulo = ?";
            } else {
                // Insere a nova nota
                $sql = "INSERT INTO notas (id_aluno_turma, id_modulo, nota) VALUES (?, ?, ?)";
            }
            
            if ($stmt = $conn->prepare($sql)) {
                if (notaExiste($idAlunoTurma, $moduloId, $conn)) {
                    // Se a nota existe, passa os parâmetros para atualizar
                    $stmt->bind_param('dii', $nota, $idAlunoTurma, $moduloId);
                } else {
                    // Se a nota não existe, passa os parâmetros para inserir
                    $stmt->bind_param('iid', $idAlunoTurma, $moduloId, $nota);
                }
                
                if ($stmt->execute()) {
                    $mensagem = "Notas salvas com sucesso!";
                    $redirecionar = true;
                } else {
                    $mensagem = "Erro ao salvar as notas: " . $conn->error;
                }
            } else {
                $mensagem = "Erro ao preparar a consulta: " . $conn->error;
            }
        }
    }
} else {
    $mensagem = "Dados inválidos.";
}

// Imprime o script JavaScript para exibir a mensagem
if ($redirecionar) {
    // Se for para redirecionar, mostra o alerta e depois redireciona
    echo "<script type='text/javascript'>
            alert('$mensagem');
            window.location.href = '../pages/p_notas.php';
          </script>";
} else {
    // Se não for para redirecionar, apenas mostra o alerta
    echo "<script type='text/javascript'>alert('$mensagem');</script>";
}

function getIdAlunoTurma($usuarioId, $turmaCod, $conn) {
    $sql = "SELECT Aluno_Turma_id FROM aluno_turma JOIN turma ON aluno_turma.Turma_Turma_Cod = turma.Turma_Cod WHERE aluno_turma.Usuario_Usuario_cd = ? AND turma.Turma_Cod = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('is', $usuarioId, $turmaCod);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return $row['Aluno_Turma_id'];
        }
    }
    return null;
}

function notaExiste($idAlunoTurma, $moduloId, $conn) {
    $sql = "SELECT COUNT(*) FROM notas WHERE id_aluno_turma = ? AND id_modulo = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ii', $idAlunoTurma, $moduloId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }
    return false;
}
?>
