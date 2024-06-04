<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 4){
    header("Location: ../logout.php");
}

// Resgata o ID do usuário logado
$usuarioId = $_SESSION['Usuario_id'];

// Consulta SQL para obter as turmas do professor
include '../conexao.php'; // Inclua seu arquivo de conexão com o banco de dados
$sql = "SELECT turma.turma_cod, usuario.usuario_nome AS professor_responsavel
        FROM turma
        INNER JOIN usuario ON usuario.usuario_id = turma.usuario_usuario_cd
        WHERE usuario.usuario_id = $usuarioId"; // Substitua pelo nome correto das tabelas e campos

$resultado = mysqli_query($conn, $sql);
if (!$resultado) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}
$titulo = 'RELATÓRIO DE TURMAS'; //Título da página, que fica sobre a data
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
        .turma path{
            fill: #043140;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #176204;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>

<?php require_once '../COMPONENTS/header.php' ?>

<div>
    <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
</div>
<main>
    <table border="1">
        <thead>
            <tr>
                <th>Código da Turma</th>
                <th>Professor Responsável</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($linha = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td><a href='p_turma_detalhes.php?turma_cod=" . $linha['turma_cod'] . "'>" . $linha['turma_cod'] . "</a></td>";
                echo "<td>" . $linha['professor_responsavel'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<div class="buttons">
    <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
</div>

<script src="../JS/dropdown.js"></script>
<script src="../JS/botao.js"></script>
<script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
