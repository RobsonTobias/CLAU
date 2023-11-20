<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM tb_usuario WHERE Usuario = '$usuario' AND Senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Credenciais corretas, obter o nome do usuário
        $row = mysqli_fetch_assoc($result);
        $nomeUsuario = $row['Nome'];
        $permissao = $row['IdPermissao'];

        // Iniciar a sessão e armazenar o nome do usuário na variável de sessão
        session_start();
        $_SESSION['Usuario'] = $nomeUsuario;
        $_SESSION['IdPermissao'] = $permissao; // Armazena o valor de permissao na sessão

        // Redirecionar para a página desejada após o login
        if ($permissao == 1) {
            header("location: PAGES/s_home.php");
        }
        elseif($permissao == 2){
            header("location: PAGES/c_home.php");
        }
        elseif($permissao == 3){
            header("location: PAGES/p_home.php");
        }
        elseif($permissao == 4){
            header("Location: PAGES/a_home.php");
        }
    } else {
        // Credenciais incorretas, exibir mensagem de erro
        header("Location:index.html");
    }
}
?>