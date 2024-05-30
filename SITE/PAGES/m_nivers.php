<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 1){
    header("Location: ../logout.php");
}
$home = 'm_home.php';
include '../conexao.php'; // Inclui o script de conexão ao banco de dados



$query = "SELECT DISTINCT Usuario.Usuario_Nome, Usuario.Usuario_Nascimento
FROM Usuario
JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
WHERE MONTH(Usuario.Usuario_Nascimento) = MONTH(CURRENT_DATE())
AND Registro_Usuario.Tipo_Tipo_cd != 3
ORDER BY DAY(Usuario.Usuario_Nascimento) ASC;";



$result = $conn->query($query); // Executa a consulta
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLAU - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="../PHP/sidebar/menu.css">
    <link rel="stylesheet" href="../STYLE/botao.css" />
    <link rel="stylesheet" href="../STYLE/data.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        body {
                font-family: Arial, sans-serif;
                font-family: 'Roboto', sans-serif;
            }

        table {
                width: 100%; 
                border-collapse: collapse
            }
        th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                font-family: 'Roboto', sans-serif;
            }
        th { background-color: #5effc9; }
    </style>
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>ANIVERSARIANTES DO MÊS</h1>
                <div class="php">
                    <?php echo $date;?><!--  Mostrar o data atual -->
                </div>
                <?php require_once '../COMPONENTS/buttonBack.php' ?>
            </div>

            <div class="user">
                <?php echo $dropdown;?><!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>
    
    <main>
    <?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data de Aniversário</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row["Usuario_Nome"] ?></td>
                    <td><?= date('d/m', strtotime($row["Usuario_Nascimento"])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum aniversariante encontrado.</p>
<?php endif; ?>
    </main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>