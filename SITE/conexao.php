<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Clau_teste";

// Cria uma conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica a conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>
