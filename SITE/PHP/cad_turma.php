<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["Turma_Cod"]) && 
        isset($_POST["Turma_Horario_inicio"]) && 
        isset($_POST["Turma_Horario_termino"]) && 
        isset($_POST["Turma_Vagas"]) && 
        isset($_POST["codigo_dias"]) &&
        isset($_POST["Turma_Inicio"]) && 
        isset($_POST["Turma_Termino"]) && 
        isset($_POST["Curso_id"]) && 
        isset($_POST["Professor_id"])
    ) {
        include '../conexao.php';

        // Captura a sigla do curso do formulário
        $Curso_sigla = $_POST["Curso_id"];

        // Busca o ID do curso usando a sigla
        $sql_curso = "SELECT Curso_id FROM Curso WHERE Curso_Sigla = ?";
        $stmt_curso = $conn->prepare($sql_curso);
        $stmt_curso->bind_param("s", $Curso_sigla);
        $stmt_curso->execute();
        $result_curso = $stmt_curso->get_result();
        if ($result_curso->num_rows > 0) {
            $row_curso = $result_curso->fetch_assoc();
            $Curso_id = $row_curso['Curso_id']; // Encontra o ID do curso correspondente
        } else {
            echo "<script>alert('Erro: Curso não encontrado.'); window.location.href = document.referrer;</script>";
            exit;
        }
        $stmt_curso->close();

        $Turma_Cod = $_POST["Turma_Cod"];
        $Turma_Horario_inicio = $_POST["Turma_Horario_inicio"];
        $Turma_Horario_termino = $_POST["Turma_Horario_termino"];
        $Turma_Vagas = $_POST["Turma_Vagas"];
        $Turma_Dias = $_POST["codigo_dias"];
        $Turma_Obs = !empty($_POST["Turma_Obs"]) ? $_POST["Turma_Obs"] : NULL;
        $Turma_Inicio = $_POST["Turma_Inicio"];
        $Turma_Termino = $_POST["Turma_Termino"];
        $Professor_id = $_POST["Professor_id"];

        $sql_professor_check = "SELECT Usuario_id FROM Usuario
                                INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                                WHERE Usuario_id = ? AND Tipo_Tipo_cd = 4";
        $stmt_professor_check = $conn->prepare($sql_professor_check);
        $stmt_professor_check->bind_param("i", $Professor_id);
        $stmt_professor_check->execute();
        $result_professor_check = $stmt_professor_check->get_result();
        $stmt_professor_check->close();

        if ($result_professor_check->num_rows == 0) {
            echo "<script>alert('Erro: O ID fornecido não corresponde a um professor válido.'); window.location.href = document.referrer;</script>";
            exit;
        }

        $conn->begin_transaction();
        try {
            $sql = "INSERT INTO Turma (Turma_Cod, Turma_Horario, Turma_Horario_Termino, Turma_Vagas, Turma_Dias, Turma_Obs, Turma_Inicio, Turma_Termino, Turma_Status, Curso_cd, Usuario_Usuario_cd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '1', ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssiisssii", $Turma_Cod, $Turma_Horario_inicio, $Turma_Horario_termino, $Turma_Vagas, $Turma_Dias, $Turma_Obs, $Turma_Inicio, $Turma_Termino, $Curso_id, $Professor_id);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir a turma: " . $stmt->error);
            }

            $stmt->close();
            $conn->commit();
            echo "<script>alert('Turma inserida com sucesso e professor associado!'); window.location.href = '../PAGES/s_turma_cad.php'</script>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('" . $e->getMessage() . "'); window.location.href = document.referrer;</script>";
        } finally {
            $conn->close();
        }
    } else {
        echo "<script>alert('Todos os campos obrigatórios devem ser preenchidos.'); window.location.href = document.referrer;</script>";
    }
} else {
    echo "<script>alert('Erro: Requisição inválida.'); window.location.href = document.referrer;</script>";
}
?>
