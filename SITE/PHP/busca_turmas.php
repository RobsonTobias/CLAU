<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['curso_id'])) {
    $_SESSION['curso_id'] = $_POST['curso_id'];
    echo "Curso ID armazenado na sessão.";
} else {
    echo "Curso ID não fornecido.";
}
?>