<?php
// Verifica se uma sessão já está ativa
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

if (isset($_SESSION['Usuario_Nome']) && !empty($_SESSION['Usuario_Nome'])) {
    $Nome = htmlspecialchars($_SESSION['Usuario_Nome']);
    $Foto = htmlspecialchars($_SESSION['Usuario_Foto']);

    $dropdown ='
    <p>' . $Nome . '</p>
    <div class="Mydropdown">
        <img src="' . $Foto . '" alt="Perfil" onclick="myFunction()" class="dropbtn">
        <div style="height:70px;width:70px; position:absolute" onclick="myFunction()" class="dropbtn hover"></div>
        <div id="myDropdown" class="dropdown-content">
            <a href="perfil.php">Perfil</a>
            <!-- <a href="login2.php">Trocar Usuário</a>  PRECISA ADICIONAR A CONDIÇÃO DE APARECER QUANDO TIVER MAIS DE UM TIPO--> 
            <a href="../logout.php">Sair</a>
        </div>
    </div>
    ';
} else {
    // Se $_SESSION['Usuario'] não está definido ou está vazio, trate o erro de acordo
    echo "Usuário não está definido ou está vazio.";
}
?>