<?php
include 'conexao.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $senha = $_POST['password'];

    $sql = "SELECT * FROM Usuario WHERE Usuario_Login = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $senhaHash = $row['Usuario_Senha'];
        if (password_verify($senha, $senhaHash)) {
            $nomeUsuario = $row['Usuario_Apelido'];
            $UsuarioId = $row['Usuario_id'];
            $usuariofoto = $row['Usuario_Foto'];

            $sqlLogin = "INSERT INTO Login (Usuario_Usuario_cd) VALUES ('$UsuarioId')";
            mysqli_query($conn, $sqlLogin);

            $sqlRegistroUsuario = "SELECT * FROM Registro_Usuario WHERE Usuario_Usuario_cd = '$UsuarioId'";
            $resultRegistroUsuario = mysqli_query($conn, $sqlRegistroUsuario);

            if (mysqli_num_rows($resultRegistroUsuario) == 1) {
                $rowRegistroUsuario = mysqli_fetch_assoc($resultRegistroUsuario);
                $permissao = $rowRegistroUsuario['Tipo_Tipo_cd'];
            } elseif (mysqli_num_rows($resultRegistroUsuario) > 1) {
                $permissoes = array();
                while ($rowRegistroUsuario = mysqli_fetch_assoc($resultRegistroUsuario)) {
                    array_push($permissoes, $rowRegistroUsuario['Tipo_Tipo_cd']);
                }
                session_start();
                $_SESSION['Permissoes'] = $permissoes;
                $_SESSION['Usuario_Nome'] = $nomeUsuario;
                $_SESSION['Usuario_id'] = $UsuarioId;
                $_SESSION['Usuario_Foto'] = $usuariofoto;
                $_SESSION['Tipo_Tipo_cd'] = '';
                header("Location: PAGES/login2.php");
            } else {
                $permissao = 0;
            }

            session_start();
            $_SESSION['Usuario_Nome'] = $nomeUsuario;
            $_SESSION['Tipo_Tipo_cd'] = $permissao;
            $_SESSION['Usuario_id'] = $UsuarioId;
            $_SESSION['Usuario_Foto'] = $usuariofoto;

            if ($permissao == 1) {
                header("location: PAGES/m_home.php?tipo=success");
            } elseif ($permissao == 2) {
                header("location: PAGES/s_home.php?tipo=success");
            } elseif ($permissao == 3) {
                header("Location: PAGES/a_home.php?tipo=success");
            } elseif ($permissao == 4) {
                header("location: PAGES/p_home.php?tipo=success");
            } elseif ($permissao == 5) {
                header("location: PAGES/c_home.php?tipo=success");
            } else {
                echo 'Permissão não concedida';
            }
        }
        else{
            header("Location:index.php?tipo=erro");
        }
    } else {
        header("Location:index.php?tipo=erro");
    }
}
?>