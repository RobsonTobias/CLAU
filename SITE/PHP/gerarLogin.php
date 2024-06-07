<?php
function gerarLoginUnico($conn, $primeiroNome, $ultimoNome)
{
    $baseLogin = strtolower($primeiroNome . '.' . $ultimoNome);
    $login = $baseLogin;
    $contador = 1;

    while (true) {
        $queryLogin = "SELECT Usuario_id FROM Usuario WHERE Usuario_Login = '$login'";
        $resultLogin = $conn->query($queryLogin);
        if ($resultLogin->num_rows == 0) {
            break;
        }
        $login = $baseLogin . $contador;
        $contador++;
    }

    return $login;
}
?>