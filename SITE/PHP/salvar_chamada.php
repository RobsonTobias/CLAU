<?php
session_start();
include '../conexao.php';

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turmaCod = mysqli_real_escape_string($conn, $_POST['turma']);
    $moduloId = mysqli_real_escape_string($conn, $_POST['modulo']);
    $dataAula = mysqli_real_escape_string($conn, $_POST['dataAula']);
    $descricaoAula = mysqli_real_escape_string($conn, $_POST['descricaoAula']);
    $presencasEnviadas = $_POST['presenca'] ?? [];

    $sqlAula = "INSERT INTO aula (cod_turma, id_modulo, descricao, data_aula) VALUES ('$turmaCod', '$moduloId', '$descricaoAula', '$dataAula')";
    if (!mysqli_query($conn, $sqlAula)) {
        // Imprime um alerta de erro e redireciona para a página de chamada
        echo "<script>alert('Erro ao inserir a aula: " . addslashes(mysqli_error($conn)) . "'); window.location.href = '../PAGES/p_chamada.php';</script>";
        exit;
    }
    $aulaId = mysqli_insert_id($conn);

    $erroPresenca = false;
    $sqlAlunos = "SELECT Aluno_Turma_id FROM aluno_turma WHERE turma_turma_cod = '$turmaCod'";
    $resultadoAlunos = mysqli_query($conn, $sqlAlunos);

    while ($aluno = mysqli_fetch_assoc($resultadoAlunos)) {
        $idAlunoTurma = $aluno['Aluno_Turma_id'];
        $presenca = isset($presencasEnviadas[$idAlunoTurma]) ? '1' : '0';
        $sqlPresenca = "INSERT INTO chamada (id_aula, id_aluno_turma, presenca) VALUES ('$aulaId', '$idAlunoTurma', '$presenca')";
        
        if (!mysqli_query($conn, $sqlPresenca)) {
            $erroPresenca = true;
        }
    }

    if ($erroPresenca) {
        // Imprime um alerta de erro e redireciona para a página de chamada
        echo "<script>alert('Erro ao registrar algumas presenças.'); window.location.href = '../PAGES/p_chamada.php';</script>";
    } else {
        // Imprime um alerta de sucesso e redireciona para a página de chamada
        echo "<script>alert('Chamada registrada com sucesso!'); window.location.href = '../PAGES/p_chamada.php';</script>";
    }
} else {
    header("Location: form_chamada.php");
    exit();
}
?>
