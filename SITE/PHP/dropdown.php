<?php
session_start();
include '../conexao.php';

if (isset($_SESSION['Usuario']) && !empty($_SESSION['Usuario'])) {
    $Nome = $_SESSION['Usuario'];

    $dropdown ='
    <p>' . $Nome . '</p>
    <div class="dropdown">
        <img src="https://placekitten.com/400/400" alt="Perfil" onclick="myFunction()"   class="dropbtn">
        <div style="height:70px;width:70px; position:absolute" onclick="myFunction()" class="dropbtn hover"></div>
        <div id="myDropdown" class="dropdown-content">
            <a href="perfil.php">Perfil</a>
            <a href="notificacoes.php">Notificação</a>
            <a href="../index.html">Sair</a>
        </div>
    </div>
    ';
} else {
    // Se $_SESSION['Usuario'] não está definido ou está vazio, trate o erro de acordo
    echo "Usuário não está definido ou está vazio.";
}
?>