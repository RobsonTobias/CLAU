<?php
// Inicia a sessão PHP se ela ainda não foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o ID do usuário foi fornecido
if (isset($_GET['userId'])) {
    // Configura a variável de sessão com o ID do usuário fornecido
    $_SESSION['UsuarioSelecionado'] = $_GET['userId'];

    // Pode retornar uma mensagem de sucesso com o ID do usuário
    echo "Sessão configurada para o usuário: " . $_SESSION['UsuarioSelecionado'];
} else {
    // Retorna uma mensagem de erro se nenhum ID de usuário foi fornecido
    echo "Nenhum usuário fornecido.";
}
?>