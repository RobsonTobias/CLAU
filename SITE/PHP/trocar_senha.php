<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexão com o banco de dados (substitua os valores conforme necessário)
    include '../conexao.php';

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtém o ID do usuário logado
    $usuarioId = $_SESSION['Usuario_id'];

    // Obtém os valores do formulário
    $senha_antiga = $_POST['senha_antiga'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verifica se a nova senha e a confirmação são iguais
    if ($nova_senha != $confirmar_senha) {
        echo "As senhas não coincidem.";
        exit();
    }

    // Verifica se a senha antiga está correta
    $stmt = $conn->prepare("SELECT Usuario_Senha FROM Usuario WHERE Usuario_id = ? LIMIT 1");
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se a consulta retornou algum resultado
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($senha_bd);
        $stmt->fetch();

        // Verifica se a senha antiga está correta
        if (password_verify($senha_antiga, $senha_bd)) {
            // Hash da nova senha
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            // Atualiza a senha no banco de dados
            $stmt = $conn->prepare("UPDATE Usuario SET Usuario_Senha = ? WHERE Usuario_id = ?");
            $stmt->bind_param("si", $nova_senha_hash, $usuarioId);
            $stmt->execute();

            // Verifica se a senha foi atualizada com sucesso
            if ($stmt->affected_rows == 1) {
                echo "Senha atualizada com sucesso.";
            } else {
                echo "Erro ao atualizar a senha.";
            }
        } else {
            echo "Senha antiga incorreta.";
        }
    } else {
        echo "Usuário não encontrado.";
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
}
?>