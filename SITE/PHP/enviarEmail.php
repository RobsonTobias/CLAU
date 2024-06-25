<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';


// Carrega as variáveis de ambiente
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, '/../../.env');
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die('Não foi possível carregar o arquivo .env: ' . $e->getMessage());
}

function enviarEmailCadastro($email, $nome, $login)
{
    error_log("Entrou na função enviarEmailCadastro com $email e $nome."); // Log para verificação
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tcc.clau@gmail.com'; // Substitua pelas suas credenciais reais
        $mail->Password = $_ENV['EMAIL_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('tcc.clau@gmail.com', 'Sistema CLAU');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Bem-vindo à Escola';
        $mail->Body = "Olá $nome, <br> Bem-vindo à nossa escola!<br> Seu Usuário é $login, sua senha inicial são os 6 primeiros dígitos do CPF<br> Por favor alterar assim que possível";
        $mail->AltBody = 'Olá Seja Bem vindo à nossa escola';

        $mail->send();
        error_log("Email enviado com sucesso para $email.");
        echo 'E-mail enviado com sucesso';
    } catch (Exception $e) {
        error_log("Erro ao enviar email: " . $mail->ErrorInfo);
        echo "E-mail não pôde ser enviado. Erro: {$mail->ErrorInfo}";
    }
}

?>