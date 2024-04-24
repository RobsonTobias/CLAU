<?php
session_start();  // Inicia a sessão
session_unset();  // Remove todas as variáveis de sessão
session_destroy(); // Destrói a sessão
header('Location: index.html'); // Redireciona o usuário para a página de login ou inicial
exit();
?>