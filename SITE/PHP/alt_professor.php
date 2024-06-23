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
    $caminhoCompleto = $_SESSION['original']['imagem'];

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
    $camposParaVerificar = [
        'nome' => $_POST['nome'],
        'apelido' => $_POST['apelido'],
        'email' => $_POST['email'],
        'sexo' => $_POST['sexo'],
        'cpf' => preg_replace('/[^0-9]/', '', $_POST['cpf']),
        'rg' => preg_replace('/[^0-9]/', '', $_POST['rg']),
        'nascimento' => $_POST['nascimento'],
        'civil' => $_POST['civil'],
        'celular' => preg_replace('/[^0-9]/', '', $_POST['celular']),
        'recado' => preg_replace('/[^0-9]/', '', $_POST['recado']),
        'obs' => $_POST['obs'],
        'imagem' => $caminhoCompleto,
        'cep' => preg_replace('/[^0-9]/', '', $_POST['cep']),
        'logradouro' => $_POST['logradouro'],
        'numero' => $_POST['numero'],
        'bairro' => $_POST['bairro'],
        'complemento' => $_POST['complemento'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
    ];

    $alterado = false;
    foreach ($camposParaVerificar as $campo => $valor) {
        if (isset($_SESSION['original'][$campo]) && $valor != $_SESSION['original'][$campo]) {
            $alterado = true;
            break;
        }
    }

    $isCoordenador = isset($_POST['coordenador']) ? 1 : 0;
    $alterouCoordenador = false;
    $userId = $_POST['usuario_id'];

    // Verificar se houve alteração na coordenação
    if ($isCoordenador != Coordenador($userId)) {
        $alterouCoordenador = true;
    }

    if (empty($erroMsg)) {
        if ($alterado) {
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

            // Verificar se o endereço já existe (com base no CEP e no número)
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
                // Atualizar informações do usuário
                $sql = "UPDATE Usuario SET Usuario_Nome = ?, Usuario_Apelido = ?, Usuario_Email = ?, Usuario_Sexo = ?, Usuario_Cpf = ?, Usuario_Rg = ?, Usuario_Nascimento = ?, Usuario_EstadoCivil = ?, Usuario_Fone = ?, Usuario_Fone_Recado = ?, Usuario_Obs = ?, Usuario_Foto = ?, Enderecos_Enderecos_cd = ? WHERE Usuario_id = ?";
                
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sssssssssssssi", $nome, $apelido, $email, $sexo, $cpf, $rg, $nascimento, $estadocivil, $celular, $telrecado, $obs, $caminhoCompleto, $enderecoId, $userId);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        echo "Dados do usuário atualizados com sucesso";
                    }
                    $stmt->close();
                } else {
                    $erroMsg .= "Erro ao preparar consulta: " . $conn->error;
                }
            }
        }

        if (empty($erroMsg) && $alterouCoordenador) {
            // Atualizar a coordenação
            if ($isCoordenador) {
                // Verificar se já existe um registro para o tipo coordenador
                $sqlCheck = "SELECT 1 FROM Registro_Usuario WHERE Usuario_Usuario_cd = ? AND Tipo_Tipo_cd = 5";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->bind_param("i", $userId);
                $stmtCheck->execute();
                $stmtCheck->store_result();

                if ($stmtCheck->num_rows === 0) {
                    // Inserir novo registro se não existir
                    $sqlInsert = "INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd) VALUES (?, 5)";
                    $stmtInsert = $conn->prepare($sqlInsert);
                    $stmtInsert->bind_param("i", $userId);
                    $stmtInsert->execute();
                    $stmtInsert->close();
                }
                $stmtCheck->close();
            } else {
                // Remover o registro se existir e não estiver marcado
                $sqlDelete = "DELETE FROM Registro_Usuario WHERE Usuario_Usuario_cd = ? AND Tipo_Tipo_cd = 5";
                $stmtDelete = $conn->prepare($sqlDelete);
                $stmtDelete->bind_param("i", $userId);
                $stmtDelete->execute();
                $stmtDelete->close();
            }
            echo "Coordenação atualizada com sucesso";
        }

        if (empty($erroMsg)) {
            echo "Dados do usuário atualizados com sucesso";
            exit;
        }
    }

    if (!empty($erroMsg)) {
        echo $erroMsg;
    }
}
function Coordenador($userId)
{
    $sql = "SELECT EXISTS (
            SELECT 1 FROM Registro_Usuario
            WHERE Usuario_Usuario_cd = $userId AND Tipo_Tipo_cd = 5
            ) AS resultado";
    $res = $GLOBALS['conn']->query($sql);
    $row = $res->fetch_assoc();
    return $row['resultado'] == 1;
}
?>
