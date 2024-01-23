<?php

include '../conexao.php';

function validaCPF($cpf)
{
    $cpf = preg_replace('/\D/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erroMsg = '';
    $cadastroSucesso = false;

    $apelido = $conn->real_escape_string($_POST['apelido']); // Substitua 'login' pelo nome do campo de login no seu formulário

    // Verificar se o login já existe
    $queryLogin = "SELECT Usuario_id FROM Usuario WHERE Usuario_Login = '$apelido'";
    $resultLogin = $conn->query($queryLogin);
    if ($resultLogin && $resultLogin->num_rows > 0) {
        $erroMsg .= "O login já está em uso.";
    }

    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $queryCpf = "SELECT * FROM Usuario WHERE Usuario_Cpf = '$cpf'";
    $resultCpf = $conn->query($queryCpf);
    if ($resultCpf && $resultCpf->num_rows > 0) {
        $erroMsg .= "CPF já cadastrado.";
    }

    $email = $conn->real_escape_string($_POST['email']);
    $queryEmail = "SELECT Usuario_id FROM Usuario WHERE Usuario_Email = '$email'";
    $resultEmail = $conn->query($queryEmail);
    if ($resultEmail && $resultEmail->num_rows > 0) {
        $erroMsg .= "O email já está cadastrado.";
    }

    if (!$erroMsg) {
        $nomeArquivo = basename($_FILES["imagem"]["name"]);
        $caminhoCompleto = "../IMAGE/PROFILE/" . $nomeArquivo;
        $uploadOk = true;

        if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
            $uploadOk = false;
            $erroMsg .= "Não é uma imagem.";
        }

        if ($_FILES["imagem"]["size"] > 500000) {
            $uploadOk = false;
            $erroMsg .= "Arquivo muito grande.";
        }

        $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
        if ($tipoArquivo != "jpg" && $tipoArquivo != "png" && $tipoArquivo != "jpeg") {
            $uploadOk = false;
            $erroMsg .= "Desculpe, apenas JPG, JPEG, PNG são permitidos.";
        }

        if ($uploadOk && move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoCompleto)) {
            $nome = $conn->real_escape_string($_POST['nome']);
            
            $sexo = $conn->real_escape_string($_POST['sexo']);

            if (!validaCPF($cpf)) {
                $erroMsg .= "CPF inválido.";
            } else {
                $rg = preg_replace('/[^0-9]/', '', $_POST['rg']);
                $nascimento = $conn->real_escape_string($_POST['nascimento']);
                $estadocivil = $conn->real_escape_string($_POST['civil']);
                $celular = preg_replace('/[^0-9]/', '', $_POST['celular']);
                $telrecado = preg_replace('/[^0-9]/', '', $_POST['recado']);
                $obs = $conn->real_escape_string($_POST['obs']);
                $cep = $conn->real_escape_string($_POST['cep']);
                $logradouro = $conn->real_escape_string($_POST['logradouro']);
                $numero = $conn->real_escape_string($_POST['numero']);
                $bairro = $conn->real_escape_string($_POST['bairro']);
                $complemento = $conn->real_escape_string($_POST['complemento']);
                $cidade = $conn->real_escape_string($_POST['cidade']);
                $estado = $conn->real_escape_string($_POST['estado']);

                $end = "INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Complemento, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf) VALUES ('$cep', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$estado')";
                if ($conn->query($end) === TRUE) {
                    $enderecosCd = $conn->insert_id;
                    $usuariocd = $_SESSION['Usuario_id'];
                    $sql = "INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Fone_Recado, Usuario_Login, Usuario_Senha, Usuario_Obs, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Foto) VALUES ('$nome', '$apelido', '$email', '$sexo', '$cpf', '$rg', '$nascimento', '$estadocivil', '$celular', '$telrecado', '$apelido', 'escola123', '$obs', '$enderecosCd', '$usuariocd', '$caminhoCompleto')";
                    if ($conn->query($sql) === TRUE) {
                        $ultimoUsuario = $conn->insert_id;
                        $registro = "INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd) VALUES ('$ultimoUsuario', 4)";
                        if ($conn->query($registro) === TRUE) {
                            echo "Cadastro realizado com sucesso!";
                            
                            $cadastroSucesso = true;
                        } else {
                            $erroMsg .= '"Erro ao inserir no registro de usuário: " . $conn->error';
                        }
                    } else {
                        $erroMsg .= '"Erro ao inserir usuário: " . $conn->error';
                    }
                } else {
                    $erroMsg .= '"Erro ao inserir endereço: " . $conn->error';
                }
            }
        } else {
            $erroMsg .= "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    }

    

    if (!empty($erroMsg)) {
        echo $erroMsg;
    }
}
?>