<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tb_usuario WHERE Usuario = '$usuario' AND Senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Credenciais corretas, redirecionar para a página desejada
        header("Location: PAGES/p_home.php");
    } else {
        // Credenciais incorretas, exibir mensagem de erro
        echo "Credenciais incorretas. Tente novamente.";
    }
}

mysqli_close($conn);
?>
