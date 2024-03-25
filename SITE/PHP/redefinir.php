<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../conexao.php';

// Carrega as variáveis de ambiente
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, 'phpdotenv.env');
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('Não foi possível carregar o arquivo .env: ' . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']); // Sanitiza o email

    // Verifica se o email existe no banco de dados
    $sql = "SELECT Usuario_id FROM Usuario WHERE Usuario_Email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Gerar nova senha
        $novaSenha = bin2hex(random_bytes(8)); // Gera uma senha aleatória

        // Criptografar a nova senha antes de salvar no banco
        $senhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);

        // Atualizar a senha no banco
        $atualizar = "UPDATE Usuario SET Usuario_Senha = '$senhaCriptografada' WHERE Usuario_Email = '$email'";
        if ($conn->query($atualizar) === TRUE) {
            // Configurar o PHPMailer e enviar o email
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tccclau@gmail.com'; // Substitua pelas suas credenciais reais
                $mail->Password = $_ENV['EMAIL_PASSWORD']; // Obtém a senha do arquivo .env
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinatários
                $mail->setFrom('tccclau@gmail.com', 'Sistema CLAU');
                $mail->addAddress($email);

                // Conteúdo do email
                $mail->isHTML(true);
                $mail->Subject = 'Sua nova senha';
                $mail->Body = 'Sua nova senha é: ' . $novaSenha;

                $mail->send();
                echo 'Email enviado com sucesso.';
            } catch (Exception $e) {
                echo "Erro ao enviar email: {$mail->ErrorInfo}";
            }
        } else {
            echo "Erro ao atualizar a senha.";
        }
    } else {
        echo "Email não encontrado.";
    }
} else {
    echo "Requisição inválida.";
}

?>
