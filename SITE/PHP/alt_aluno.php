<?php
include '../conexao.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erroMsg = '';

    // Processar o upload da imagem
    $pastaDestino = "../IMAGE/PROFILE/";
    $nomeArquivo = basename($_FILES["imagem"]["name"]);
    $caminhoCompleto = $nomeArquivo ? $pastaDestino . $nomeArquivo : $_SESSION['imagemOriginal'];
    $uploadOk = true;

    if (!empty($nomeArquivo)) {
        $caminhoCompleto = $pastaDestino . $nomeArquivo;

        // Verificar se o arquivo é uma imagem
        if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
            $erroMsg .= "O arquivo não é uma imagem.<br>";
            $uploadOk = false;
        }

        // Verificar o tamanho do arquivo
        if ($_FILES["imagem"]["size"] > 500000) {
            $erroMsg .= "Desculpe, seu arquivo é muito grande.<br>";
            $uploadOk = false;
        }

        // Permitir certos formatos de arquivo
        $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
        if ($tipoArquivo != "jpg" && $tipoArquivo != "png" && $tipoArquivo != "jpeg") {
            $erroMsg .= "Desculpe, apenas JPG, JPEG e PNG são permitidos.<br>";
            $uploadOk = false;
        }

        // Tentar fazer o upload da imagem
        if ($uploadOk && !move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoCompleto)) {
            $erroMsg .= "Desculpe, houve um erro ao enviar seu arquivo.<br>";
        }
    } else {
        // Manter a imagem original se nenhuma nova imagem for fornecida
        $caminhoCompleto = $_SESSION['original']['imagem'];
    }


    // Verificar se houve alterações nos campos
    $camposParaVerificar = ['nome', 'apelido', 'email', 'sexo', 'cpf', 'rg', 'nascimento', 'civil', 'celular', 'recado', 'obs', 'cep', 'logradouro', 'numero', 'bairro', 'complemento', 'cidade', 'estado'];
    $alterado = false;
    foreach ($camposParaVerificar as $campo) {
        if (isset($_SESSION[$campo . 'Original']) && $_POST[$campo] != $_SESSION[$campo . 'Original']) {
            $alterado = true;
            break;
        }
    }



    if (empty($erroMsg)) {
        // Escapar as entradas do usuário
        $nome = $conn->real_escape_string($_POST['nome']);
        $apelido = $conn->real_escape_string($_POST['apelido']);
        $sexo = $conn->real_escape_string($_POST['sexo']);
        $email = $conn->real_escape_string($_POST['email']);
        $rg = preg_replace('/[^0-9]/', '', $_POST['rg']);
        $nascimento = $conn->real_escape_string($_POST['nascimento']);
        $estadocivil = $conn->real_escape_string($_POST['civil']);
        $celular = preg_replace('/[^0-9]/', '', $_POST['celular']);
        $telrecado = preg_replace('/[^0-9]/', '', $_POST['recado']);
        $obs = $conn->real_escape_string($_POST['obs']);
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);

        $enderecoId = $_SESSION['EnderecoId'];

        $nomeResponsavel = $conn->real_escape_string($_POST['nome_responsavel']);
        $celularResponsavel = preg_replace('/[^0-9]/', '', $_POST['celular_responsavel']);
        $cpfResponsavel = preg_replace('/[^0-9]/', '', $_POST['cpf_responsavel']);
        $rgResponsavel = preg_replace('/[^0-9]/', '', $_POST['rg_responsavel']);
        $parentesco = $conn->real_escape_string($_POST['parentesco']);

        // Verificar se o endereço já existe (com base no CEP e no número)
        $cep = preg_replace('/[^0-9]/', '', $_POST['cep']);

        $userId = $_POST['usuario_id'];
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
                $enderecoId = $row['Enderecos_id'];
            } else {
                // O endereço não existe, insere um novo
                $logradouro = $conn->real_escape_string($_POST['logradouro']);
                $bairro = $conn->real_escape_string($_POST['bairro']);
                $complemento = $conn->real_escape_string($_POST['complemento']);
                $cidade = $conn->real_escape_string($_POST['cidade']);
                $estado = $conn->real_escape_string($_POST['estado']);

                $end = "INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Complemento, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf) VALUES ('$cep', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$estado')";
                if ($conn->query($end) === TRUE) {
                    $enderecoId = $conn->insert_id;
                } else {
                    $erroMsg .= "Erro ao inserir endereço: " . $conn->error;
                }
            }
        }

        if (empty($erroMsg)) {
            $queryResponsavel = "SELECT Respon_id FROM Responsavel WHERE Respon_Cpf = '$cpfResponsavel'";
            $resultResponsavel = $conn->query($queryResponsavel);
            if ($resultResponsavel->num_rows > 0) {
                // Já existe uma responsável com esse CPF cadastrada.
                $respRow = $resultResponsavel->fetch_assoc();
                $responsavelId = $respRow['Respon_id'];
            } else {
                // Não há nenhum  registro de responsável com esse CPF.
                // Inserindo a nova responsável no banco de dados e obtendo seu ID.
                $respon = "INSERT INTO Responsavel (Respon_Nome, Respon_Fone, Respon_Cpf, Respon_Rg, Respon_Parentesco) VALUES ('$nomeResponsavel', '$celularResponsavel', '$cpfResponsavel', '$rgResponsavel', '$parentesco')";
                if ($conn->query($respon) === TRUE) {
                    $responsavelId = $conn->insert_id;
                } else {
                    $erroMsg .= "Erro ao inserir responsável: " . $conn->error;
                }
            }
        }

        if (empty($erroMsg)) {
            // Atualizar informações do usuário
            $sql = "UPDATE Usuario SET Usuario_Nome = ?, Usuario_Apelido = ?, Usuario_Email = ?, Usuario_Sexo = ?, Usuario_Cpf = ?, Usuario_Rg = ?, Usuario_Nascimento = ?, Usuario_EstadoCivil = ?, Usuario_Fone = ?, Usuario_Fone_Recado = ?, Usuario_Login = ?, Usuario_Obs = ?, Usuario_Foto = ?, Enderecos_Enderecos_cd = ?, Responsavel_Respon_cd = ? WHERE Usuario_id = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssssssssssssiii", $nome, $apelido, $email, $sexo, $cpf, $rg, $nascimento, $estadocivil, $celular, $telrecado, $apelido, $obs, $caminhoCompleto, $enderecoId, $responsavelId, $userId);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Dados do usuário atualizados com sucesso";
                    exit;
                } else {
                    $erroMsg .= "Nenhuma alteração necessária ou erro ao atualizar os dados do usuário: " . $stmt->error . "<br>";
                }


                $stmt->close();
            } else {
                $erroMsg .= "Erro ao preparar consulta: " . $conn->error;
            }
        }
    }

    if (!empty($erroMsg)) {
        echo $erroMsg;
    }
}
?>