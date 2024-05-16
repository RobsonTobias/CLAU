<?php

include 'conexao.php';

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM Usuario WHERE Usuario_Login = '$usuario' AND Usuario_Senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Credenciais corretas, obter o nome do usuário
        $row = mysqli_fetch_assoc($result);
        $nomeUsuario = $row['Usuario_Apelido'];
        $UsuarioId = $row['Usuario_id'];
        $usuariofoto = $row['Usuario_Foto'];
        //$mudarSenha = $row['Mudar_Senha'];

        // Adicionar entrada na tabela Login
        $sqlLogin = "INSERT INTO Login (Usuario_Usuario_cd) VALUES ('$UsuarioId')";
        mysqli_query($conn, $sqlLogin);

        // Verificar se é necessário mudar a senha
        // if ($mudarSenha) {
        //     // Redirecionar para a página de mudança de senha
        //     $_SESSION['Usuario_id'] = $UsuarioId;
        //     header("Location: PAGES/change_password.php");
        //     exit;
        // }

        // Consulta para obter o valor de Tipo_Tipo_cd da tabela Registro_Usuario
        $sqlRegistroUsuario = "SELECT * FROM Registro_Usuario WHERE Usuario_Usuario_cd = '$UsuarioId'";
        $resultRegistroUsuario = mysqli_query($conn, $sqlRegistroUsuario);
        
        if (mysqli_num_rows($resultRegistroUsuario)==1) {
            $rowRegistroUsuario = mysqli_fetch_assoc($resultRegistroUsuario);
            $permissao = $rowRegistroUsuario['Tipo_Tipo_cd'];
        } elseif (mysqli_num_rows($resultRegistroUsuario)>1){
            $permissoes = array();
            while ($rowRegistroUsuario = mysqli_fetch_assoc($resultRegistroUsuario)) {
                array_push($permissoes, $rowRegistroUsuario['Tipo_Tipo_cd']);
            }
            session_start();
            $_SESSION['Permissoes'] = $permissoes;
            $_SESSION['Usuario_Nome'] = $nomeUsuario;
            $_SESSION['Usuario_id'] = $UsuarioId; // Armazena o Id do usuário na sessão
            $_SESSION['Usuario_Foto'] = $usuariofoto;
            $_SESSION['Tipo_Tipo_cd'] = '';
            header("Location: PAGES/login2.php");
        } else { 
            // Trate qualquer erro ao obter o valor de Tipo_Tipo_cd aqui
            // Por exemplo, você pode definir $permissao como um valor padrão ou redirecionar para uma página de erro
            $permissao = 0; // Defina um valor padrão ou lide com o erro de outra forma
        }

        // Iniciar a sessão e armazenar o nome do usuário na variável de sessão
        session_start();
        $_SESSION['Usuario_Nome'] = $nomeUsuario;
        $_SESSION['Tipo_Tipo_cd'] = $permissao; // Armazena o valor de permissao na sessão
        $_SESSION['Usuario_id'] = $UsuarioId; // Armazena o Id do usuário na sessão
        $_SESSION['Usuario_Foto'] = $usuariofoto;

        // Redirecionar para a página desejada após o login
        if ($permissao == 1) {
            header("location: PAGES/m_home.php");
        } elseif ($permissao == 2) {
            header("location: PAGES/s_home.php");
        } elseif ($permissao == 3) {
            header("Location: PAGES/a_home.php");
        } elseif ($permissao == 4) {
            header("location: PAGES/p_home.php");
        } elseif ($permissao == 5) {
            header("location: PAGES/c_home.php");
        } else{
            echo 'Permissão não concedida';
        }
    } else {
        // Credenciais incorretas, redireciona para a página de index.
        header("Location:index.html");
    }
}
?>