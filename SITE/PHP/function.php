<?php
function ListarUsuario($tipoUsuario)
{
    $sql = "SELECT Usuario_id, Usuario_Nome, Usuario_Email FROM Usuario
            INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
            Where Registro_Usuario.Tipo_Tipo_cd = '" . $tipoUsuario . "' and Usuario_Status = 1";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhum usuário encontrado!';
    }
}

function ListarInfoUsuario($userId)
{
    $sql = "SELECT * FROM Usuario
            INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
            WHERE Usuario_id = $userId";
    $res = $GLOBALS['conn']->query($sql);
    if ($res->num_rows > 0) {
        return $res;
    } else {
        echo 'Nenhum usuário encontrado!';
    }
}
?>