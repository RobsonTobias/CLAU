<?php

include '../conexao.php';

// Verifica se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Processar o upload da imagem
    $pastaDestino = "../IMAGE/PROFILE/";

    $nomeArquivo = basename($_FILES["imagem"]["name"]);
    $caminhoCompleto = $pastaDestino . $nomeArquivo;
    $uploadOk = true;

    // Verifique se o arquivo é uma imagem
    if (getimagesize($_FILES["imagem"]["tmp_name"]) === false) {
        echo "O arquivo não é uma imagem.";
        $uploadOk = false;
    }

    // Verifique o tamanho do arquivo
    if ($_FILES["imagem"]["size"] > 500000) { // 500KB
        echo "Desculpe, seu arquivo é muito grande.";
        $uploadOk = false;
    }

    // Permitir certos formatos de arquivo
    $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
    if ($tipoArquivo != "jpg" && $tipoArquivo != "png" && $tipoArquivo != "jpeg") {
        echo "Desculpe, apenas JPG, JPEG, PNG são permitidos.";
        $uploadOk = false;
    }

    // Verifique se $uploadOk está definido como false por um erro
    if (!$uploadOk) {
        echo "Desculpe, seu arquivo não foi enviado.";
    } else {
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoCompleto)) {
            echo "O arquivo " . htmlspecialchars(basename($_FILES["imagem"]["name"])) . " foi enviado.";

            // Escapar as entradas do usuário
            $nome = $conn->real_escape_string($_POST['nome']);
            $apelido = $conn->real_escape_string($_POST['apelido']);
            $email = $conn->real_escape_string($_POST['email']);
            $sexo = $conn->real_escape_string($_POST['sexo']);
            $cpf = $conn->real_escape_string($_POST['cpf']);
            $rg = $conn->real_escape_string($_POST['rg']);
            $nascimento = $conn->real_escape_string($_POST['nascimento']);
            $estadocivil = $conn->real_escape_string($_POST['civil']);
            $celular = $conn->real_escape_string($_POST['celular']);
            $telrecado = $conn->real_escape_string($_POST['recado']);
            $obs = $conn->real_escape_string($_POST['obs']);

            $cep = $conn->real_escape_string($_POST['cep']);
            $logradouro = $conn->real_escape_string($_POST['logradouro']);
            $numero = $conn->real_escape_string($_POST['numero']);
            $bairro = $conn->real_escape_string($_POST['bairro']);
            $complemento = $conn->real_escape_string($_POST['complemento']);
            $cidade = $conn->real_escape_string($_POST['cidade']);
            $estado = $conn->real_escape_string($_POST['estado']);
            // Adicione aqui mais campos conforme necessário

            // Inserir dados no banco de dados
            $end = "INSERT INTO Enderecos (Enderecos_Cep, Enderecos_Rua, Enderecos_Numero, Enderecos_Complemento, Enderecos_Bairro, Enderecos_Cidade, Enderecos_Uf) VALUES ('$cep', '$logradouro','$numero', '$complemento', '$bairro', '$cidade', '$estado')";

            if ($conn->query($end) === TRUE) {
                $enderecosCd = $conn->insert_id;
                echo "Endereço inserido com sucesso. ID: " . $enderecosCd;
            } else {
                echo "Erro ao inserir endereço: " . $conn->error;
            }

            $usuariocd = $_SESSION['Usuario_id'];

            $sql = "INSERT INTO Usuario (Usuario_Nome, Usuario_Apelido, Usuario_Email, Usuario_Sexo, Usuario_Cpf, Usuario_Rg, Usuario_Nascimento, Usuario_EstadoCivil, Usuario_Fone, Usuario_Fone_Recado, Usuario_Login, Usuario_Senha, Usuario_Obs, Enderecos_Enderecos_cd, Usuario_Usuario_cd, Usuario_Foto) VALUES ('$nome', '$apelido', '$email', '$sexo', '$cpf','$rg','$nascimento','$estadocivil','$celular','$telrecado','$apelido', 'escola123','$obs','$enderecosCd','$usuariocd','$caminhoCompleto')";

            if ($conn->query($sql) === TRUE) {
                $ultimoUsuario = $conn->insert_id;
                echo "Usuario inserido com sucesso. ID: " . $ultimoUsuario;
            } else {
                echo "Erro ao inserir usuario: " . $conn->error;
            }

            $registro = "INSERT INTO Registro_Usuario (Usuario_Usuario_cd, Tipo_Tipo_cd) VALUES ('$ultimoUsuario',2)";

            if ($conn->query($registro) === TRUE) {
                header("Location: ../PAGES/m_funcionario_cad.php");
                exit;
            } else {
                echo "Erro: " . $registro . "<br>" . $conn->error;
            }
            
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    }
}
?>