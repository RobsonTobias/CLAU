<?php
// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (isset($_POST["Turma_Cod"]) && isset($_POST["Turma_Horario"]) && isset($_POST["Turma_Vagas"]) && isset($_POST["Turma_Dias"]) && isset($_POST["Turma_Inicio"]) && isset($_POST["Turma_Termino"]) && isset($_POST["Curso_id"]) && isset($_POST["Professor_id"])) {

        // Recupera os dados do formulário
        $Turma_Cod = $_POST["Turma_Cod"];
        $Turma_Horario = $_POST["Turma_Horario"];
        $Turma_Vagas = $_POST["Turma_Vagas"];
        $Turma_Dias = $_POST["Turma_Dias"];
        $Turma_Obs = ($_POST["Turma_Obs"] != "") ? $_POST["Turma_Obs"] : NULL;
        $Turma_Inicio = $_POST["Turma_Inicio"];
        $Turma_Termino = $_POST["Turma_Termino"];
        $Curso_id = $_POST["Curso_id"];
        $Professor_id = $_POST["Professor_id"]; // Recupera o ID do professor selecionado

        // Conexão com o banco de dados
        include '../conexao.php';

        // Verifica se o Professor_id corresponde a um professor
        $sql_professor_check = "SELECT Usuario_id FROM Usuario
                                INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                                WHERE Usuario_id = ? AND Tipo_Tipo_cd = 4"; // 4 é o ID para professores
        $stmt_professor_check = $conn->prepare($sql_professor_check);
        $stmt_professor_check->bind_param("i", $Professor_id);
        $stmt_professor_check->execute();
        $result_professor_check = $stmt_professor_check->get_result();
        $stmt_professor_check->close();

        if ($result_professor_check->num_rows == 0) {
            echo "Erro: O ID fornecido não corresponde a um professor válido.";
            exit;
        }

        // Inicia uma transação para garantir a atomicidade da operação
        $conn->begin_transaction();
        try {
            // Prepara e executa a declaração SQL para inserir os dados na tabela Turma
            $sql = "INSERT INTO Turma (Turma_Cod, Turma_Horario, Turma_Vagas, Turma_Dias, Turma_Obs, Turma_Inicio, Turma_Termino, Turma_status, curso_cd, Usuario_Usuario_cd) VALUES (?, ?, ?, ?, ?, ?, ?, '1', ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiisssii", $Turma_Cod, $Turma_Horario, $Turma_Vagas, $Turma_Dias, $Turma_Obs, $Turma_Inicio, $Turma_Termino, $Curso_id, $Professor_id);

            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir a turma: " . $stmt->error);
            }

            $stmt->close(); // Fechando a primeira declaração

            $conn->commit();
            echo "Turma inserida com sucesso e professor associado!";
        } catch (Exception $e) {
            // Se ocorreu algum erro, reverta a transação
            $conn->rollback();
            echo $e->getMessage();
        } finally {

            $conn->close();
        }
    } else {
        echo "Todos os campos obrigatórios devem ser preenchidos.";
    }
} else {
    echo "Erro: Requisição inválida.";
}
?>