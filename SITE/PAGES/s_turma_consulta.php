<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
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
        .turma path {
            fill: #043140;
        }

        .turmas-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .turmas-table th,
        .turmas-table td {
            padding: 12px;
            /* Ajuste o espaçamento interno */
            text-align: left;
            border: 1px solid #ddd;
            /* Adicione bordas às células */
        }

        .turmas-table th {
            background-color: #009155;
            /* Cor de fundo para os cabeçalhos */
            color: #fff;
            /* Cor do texto nos cabeçalhos */
        }

        .turmas-table tbody tr:hover {
            background-color: #f5f5f5;
            /* Cor de fundo das linhas ao passar o cursor */
        }
    </style>
</head>

<body>

    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

    <?php
    // Inclua aqui os arquivos PHP necessários
    // Aqui você pode incluir sua conexão com o banco de dados, por exemplo:
    include '../conexao.php';

    // Verifica se uma sessão já está ativa
    if (session_status() == PHP_SESSION_NONE) {
        // Se não houver sessão ativa, inicia a sessão
        session_start();
    }
    ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>RELATÓRIO DE TURMAS</h1>
                <div class="php">
                    <?php echo $date; ?><!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown; ?><!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>


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
                        <th>Ações</th> <!-- Nova coluna para os botões -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta SQL para obter todas as turmas
                    $query = "SELECT * FROM Turma";

                    // Executar a consulta
                    $result = mysqli_query($conn, $query);

                    // Verificar se a consulta retornou algum resultado
                    if (mysqli_num_rows($result) > 0) {
                        // Loop através de todas as linhas da tabela
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['Turma_Cod'] . "</td>";
                            echo "<td>" . $row['Turma_Horario'] . "</td>";
                            echo "<td>" . $row['Turma_Vagas'] . "</td>";
                            echo "<td>" . $row['Turma_Dias'] . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($row['Turma_Inicio'])) . "</td>"; // Data no formato brasileiro
                            echo "<td><a href='s_turma_detalhes.php?id=" . $row['Turma_Cod'] . "' class='button-link'>Detalhes</a></td>"; // Link para detalhes da turma
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Nenhuma turma encontrada</td></tr>";
                    }

                    // Fechar a conexão com o banco de dados
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>