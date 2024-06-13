<?php
include ('../conexao.php');

if (isset($_POST['curso_id'])) {
    $cursoId = $_POST['curso_id'];
    $sqlTurma = "SELECT Turma_Cod FROM Turma WHERE Curso_cd = ?";
    $stmtCurso = $conn->prepare($sqlTurma);
    $stmtCurso->bind_param("i", $cursoId);
    $stmtCurso->execute();
    $resultTurma = $stmtCurso->get_result();

    if ($resultTurma->num_rows > 0) {
        while ($rowCurso = $resultTurma->fetch_assoc()) {
            echo "<option value='" . $rowCurso["Turma_Cod"] . "'>" . $rowCurso["Turma_Cod"] . "</option>";
        }
    } else {
        echo "<option>Nenhuma Turma encontrada!</option>";
    }
} else {
    echo "<option>Curso não selecionado!</option>";
}
?>
