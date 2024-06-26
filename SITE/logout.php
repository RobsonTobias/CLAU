<?php
session_start();
$_SESSION = array();
unset($_SESSION['id']);
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 84000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
header('Location: index.php'); // Redireciona o usuário para a página de login ou inicial
?>