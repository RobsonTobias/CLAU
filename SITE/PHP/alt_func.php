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
    if ($_FILES["imagem"]["size"] > 1000000) { // 1MB
        echo "Desculpe, seu arquivo é muito grande.";
        $uploadOk = false;
    }

    // Permitir certos formatos de arquivo
    $tipoArquivo = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
    if ($tipoArquivo != "jpg" && $tipoArquivo != "png" && $tipoArquivo != "jpeg") {
        echo "Desculpe, apenas JPG, JPEG e PNG são permitidos.";
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

            $enderecoId = $_SESSION['EnderecoId'];
            
            $end = "UPDATE Enderecos SET 
            Enderecos_Cep = '$cep', 
            Enderecos_Rua = '$logradouro', 
            Enderecos_Numero = '$numero', 
            Enderecos_Complemento = '$complemento', 
            Enderecos_Bairro = '$bairro', 
            Enderecos_Cidade = '$cidade', 
            Enderecos_Uf = '$estado'
            WHERE Enderecos_id = $enderecoId";

            // Execute a consulta no banco de dados
            // if ($conn->query($end) === TRUE) {
            //     echo "Endereço atualizado com sucesso";
            // } else {
            //     echo "Erro ao atualizar o endereço: " . $conn->error;
            // }

            $usuariocd = $_SESSION['Usuario_id'];
            $userId = $_SESSION['UsuarioSelecionado'];

            $sql = "UPDATE Usuario SET 
            Usuario_Nome = '$nome', 
            Usuario_Apelido = '$apelido', 
            Usuario_Email = '$email', 
            Usuario_Sexo = '$sexo', 
            Usuario_Cpf = '$cpf', 
            Usuario_Rg = '$rg', 
            Usuario_Nascimento = '$nascimento', 
            Usuario_EstadoCivil = '$estadocivil', 
            Usuario_Fone = '$celular', 
            Usuario_Fone_Recado = '$telrecado', 
            Usuario_Login = '$apelido',
            Usuario_Obs = '$obs',
            Usuario_Usuario_cd = '$usuariocd', 
            Usuario_Foto = '$caminhoCompleto'
            WHERE Usuario_id = $userId";

            // Execute a consulta no banco de dados
            if ($conn->query($sql) === TRUE) {
                echo "Dados do usuário atualizados com sucesso";
                header("Location: ../PAGES/m_funcionario.php");
                exit;
            } else {
                echo "Erro ao atualizar os dados do usuário: " . $conn->error;
            }
            
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
        }
    }
}
?>