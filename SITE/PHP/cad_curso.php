<?php

include '../conexao.php';

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inserir informações do curso
    $nome = $_POST['nome'];
    $sigla = $_POST['sigla'];
    $carga_horaria = $_POST['carga_horaria'];
    $descricao = $_POST['descricao'];
    $duracao = $_POST['duracao'];
    $pre_requisito = $_POST['pre_requisito'];

    $sql_curso = "INSERT INTO curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito)
            VALUES ('$nome', '$sigla', '$carga_horaria', '$descricao', '$duracao', '$pre_requisito')";

    if ($conn->query($sql_curso) === TRUE) {
        // echo "<script>alert('Curso inserido com sucesso!')</script>";
        $curso_id = $conn->insert_id; // Obtém o ID do curso inserido
        $_SESSION['cursoId'] = $curso_id;

        // Inserir informações dos módulos (se existirem)
        if (isset($_POST['modulos'])) {
            $modulos = $_POST['modulos'];

            foreach ($modulos as $modulo_nome) {
                // Verificar se o módulo já existe na tabela
                $sql_verificar_modulo = "SELECT Modulo_id FROM modulo WHERE Modulo_Nome = '$modulo_nome'";
                $result = $conn->query($sql_verificar_modulo);

                if ($result->num_rows > 0) {
                    // O módulo já existe na tabela, obter o ID do módulo existente
                    $row = $result->fetch_assoc();
                    $modulo_id = $row["Modulo_id"];
                } else {
                    // O módulo não existe na tabela, inseri-lo
                    $sql_inserir_modulo = "INSERT INTO Modulo (Modulo_Nome, Modulo_Desc) VALUES ('$modulo_nome', 'Descrição do módulo')";

                    if ($conn->query($sql_inserir_modulo) === TRUE) {
                        // Obter o ID do módulo recém-inserido
                        $modulo_id = $conn->insert_id;
                    } else {
                        echo "Erro ao inserir módulo: " . $conn->error;
                    }
                }

                // Associar o módulo ao curso na tabela modulo_curso
                $sql_associar_modulo_curso = "INSERT INTO Modulo_Curso (Modulo_Modulo_cd, Curso_Curso_cd) VALUES ('$modulo_id', '$curso_id')";

                if ($conn->query($sql_associar_modulo_curso) !== TRUE) {
                    echo "Erro ao associar módulo ao curso: " . $conn->error;
                } else{
                    echo "Cadastro realizado com sucesso!";
                }
            }
        }
    } else {
        echo "Erro ao inserir curso: " . $conn->error;
    }
}
?>