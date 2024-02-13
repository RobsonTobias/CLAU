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
        $caminhoCompleto = $nomeArquivo ? "../IMAGE/PROFILE/" . $nomeArquivo : "../IMAGE/PROFILE/default.png";
        $uploadOk = $nomeArquivo ? true : false;
        $erroImagem = "Por favor, adicione uma imagem.";

        if ($nomeArquivo) {
            // Verifica se o arquivo é uma imagem
            if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
                $uploadOk = false;
                $erroImagem .= "Não é uma imagem.";
            }
            // Verifica o tamanho do arquivo
            if ($_FILES["imagem"]["size"] > 1000000) { // 1MB
                $uploadOk = false;
                $erroImagem .= "Arquivo muito grande.";
            }
            // Permitir certos formatos de arquivo
            $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
            if ($tipoArquivo != "jpg" && $tipoArquivo != "png" && $tipoArquivo != "jpeg") {
                $uploadOk = false;
                $erroImagem .= "Desculpe, apenas JPG, JPEG, PNG são permitidos.";
            }
        } else {
            $uploadOk = false;
            $erroImagem = "Por favor, adicione uma imagem.";
        }

        if (!$uploadOk) {
            $erroMsg .= $erroImagem;
        }


        $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);

        // Verificar se o CEP tem o formato correto (8 dígitos)
        if (strlen($cep) != 8) {
            $erroMsg .= "O CEP fornecido é inválido.";
        } else {
            $numero = $conn->real_escape_string($_POST['numero']);
            $complemento = $conn->real_escape_string($_POST['complemento']);
            $queryEndereco = "SELECT Enderecos_id FROM Enderecos WHERE Enderecos_Cep = '$cep' AND Enderecos_Numero = '$numero' AND Enderecos_Complemento = '$complemento'";
            $resultEndereco = $conn->query($queryEndereco);

            if ($resultEndereco && $resultEndereco->num_rows > 0) {
                // O endereço já existe, pega o ID existente
                $row = $resultEndereco->fetch_assoc();
                $enderecosCd = $row['Enderecos_id'];
            } else {
                // O endereço não existe, insere um novo
                $logradouro = $conn->real_escape_string($_POST['logradouro']);
                $bairro = $conn->real_escape_string($_POST['bairro']);
                $complemento = $conn->real_escape_string($_POST['complemento']);
                $cidade = $conn->real_escape_string($_POST['cidade']);
                $estado = $conn->real_escape_string($_POST['estado']);

                $end = "INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Complemento, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf) VALUES ('$cep', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$estado')";
                if ($conn->query($end) === TRUE) {
                    $enderecosCd = $conn->insert_id;
                } else {
                    $erroMsg .= "Erro ao inserir endereço: " . $conn->error;
                }
            }
        }

        $cpf_responsavel = preg_replace('/[^0-9]/', '', $_POST['cpf_responsavel']);
        $queryCpfResp = "SELECT * FROM Responsavel WHERE Respon_Cpf = '$cpf_responsavel'";
        $resultCpfResp = $conn->query($queryCpfResp);
        if ($resultCpfResp && $resultCpfResp->num_rows > 0) {
            // O responsável já existe, pega o ID existente
            $row = $resultCpfResp->fetch_assoc();
            $responCd = $row['Respon_id'];
        } else {
            // O responsável não existe, insere um novo
            $nome_responsavel = $conn->real_escape_string($_POST['nome_responsavel']);
            $celular_responsavel = preg_replace('/[^0-9]/', '', $_POST['celular_responsavel']);
            $rg_responsavel = preg_replace('/[^0-9]/', '', $_POST['rg_responsavel']);
            $parentesco = $conn->real_escape_string($_POST['parentesco']);

            $resp = "INSERT INTO Responsavel (Respon_Nome, Respon_Fone, Respon_Cpf, Respon_Rg, Respon_Parentesco)
            VALUES ('$nome_responsavel','$celular_responsavel', '$cpf_responsavel', '$rg_responsavel', '$parentesco')";

            if ($conn->query($resp) === TRUE) {
                $responCd = $conn->insert_id;
            } else {
                $erroMsg .= "Erro ao inserir responsável: " . $conn->error;
            }
        }



        if (!$erroMsg && $uploadOk) {
            $nome = $conn->real_escape_string($_POST['nome']);
            $sexo = $conn->real_escape_string($_POST['sexo']);
            $rg = preg_replace('/[^0-9]/', '', $_POST['rg']);
            $nascimento = $conn->real_escape_string($_POST['nascimento']);
            $estadocivil = $conn->real_escape_string($_POST['civil']);
            $celular = preg_replace('/[^0-9]/', '', $_POST['celular']);
            $telrecado = preg_replace('/[^0-9]/', '', $_POST['recado']);
            $obs = $conn->real_escape_string($_POST['obs']);

            // Verifique se move_uploaded_file foi bem-sucedido
            $uploadResultado = move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoCompleto);
            if (!$nomeArquivo || $uploadResultado) {
                $usuariocd = $_SESSION['Usuario_id'];
                $sql = "INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Fone_Recado, Usuario_Login, Usuario_Senha, Responsavel_Respon_cd, Usuario_Obs, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Foto) VALUES ('$nome', '$apelido', '$email', '$sexo', '$cpf', '$rg', '$nascimento', '$estadocivil', '$celular', '$telrecado', '$apelido', 'escola123', '$responCd', '$obs', '$enderecosCd', '$usuariocd', '$caminhoCompleto')";
                if ($conn->query($sql) === TRUE) {
                    $ultimoUsuario = $conn->insert_id;
                    $registro = "INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd) VALUES ('$ultimoUsuario', 3)";
                    if ($conn->query($registro) === TRUE) {
                        echo "Cadastro realizado com sucesso!";
                        $cadastroSucesso = true;
                    } else {
                        $erroMsg .= "Erro ao inserir no registro de usuário: " . $conn->error;
                    }
                } else {
                    $erroMsg .= "Erro ao inserir usuário: " . $conn->error;
                }
            } else {
                $erroMsg .= "Erro ao enviar arquivo de imagem.";
            }
        } else {
            if ($nomeArquivo) {
                $erroMsg .= "Erro ao enviar arquivo de imagem.";
            } else {
                $erroMsg .= $erroImagem;
            }
        }
    }


    if (!empty($erroMsg)) {
        echo "Erro no cadastro: ";
        echo "$erroMsg";
    }
}
?>