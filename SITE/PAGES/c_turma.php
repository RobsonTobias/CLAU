<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 5){
    header("Location: ../logout.php");
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
        .turmas-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* Adiciona uma sombra leve para destacar a tabela */
        }

        .turmas-table th, .turmas-table td {
            padding: 12px 15px; /* Aumenta o espaçamento interno para conforto visual */
            border: 1px solid #ddd; /* Linhas sutis para não sobrecarregar visualmente */
            text-align: left;
        }

        .turmas-table th {
            background-color: #4CAF50; /* Um verde mais vibrante para cabeçalhos */
            color: #fff;
        }

        .turmas-table tbody tr:hover {
            background-color: #f5f5f5; /* Efeito de hover mais suave */
        }

        .turmas-table tbody tr:nth-child(odd) {
            background-color: #f9f9f9; /* Alternando cores de fundo para linhas para melhor leitura */
        }

        .button-link {
            text-decoration: none;
            color: white;
            background-color: #009578; /* Cor sincronizada com o cabeçalho para um design coeso */
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button-link:hover {
            background-color: #007B5E; /* Mudança de cor no hover para interatividade */
        }
    </style>
</head>
<body>
    <?php include('../PHP/data.php');?>
    <?php include('../PHP/sidebar/menu.php');?>
    <?php include('../PHP/redes.php');?>
    <?php include('../PHP/dropdown.php');?>
    <?php require_once '../COMPONENTS/header.php' ?>
    
    <div><?php echo $sidebarHTML; ?></div>
    <main>
        <div class="tabela-turmas">
            <table class="turmas-table">
                <thead>
                    <tr>
                        <th>Código da Turma</th>
                        <th>Horário</th>
                        <th>Vagas</th>
                        <th>Dias</th>
                        <th>Início</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../conexao.php';
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $query = "SELECT * FROM Turma";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['Turma_Cod'] . "</td>";
                            echo "<td>" . $row['Turma_Horario'] . "</td>";
                            echo "<td>" . $row['Turma_Vagas'] . "</td>";
                            echo "<td>" . $row['Turma_Dias'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['Turma_Inicio'])) . "</td>";
                            echo "<td><a href='c_turma_detalhes.php?id=" . $row['Turma_Cod'] . "' class='button-link'>Detalhes</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhuma turma encontrada</td></tr>";
                    }
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <div class="buttons"><?php echo $redes; ?></div>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
