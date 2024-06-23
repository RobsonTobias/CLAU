<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
$titulo = 'RELATÓRIO DE TURMAS'; //Título da página, que fica sobre a data
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
            fill: #004765;
        }

        .turmas-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
        font-family: Arial, sans-serif; /* Fonte mais moderna e legível */
    }

    .turmas-table th, .turmas-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0; /* Bordas mais sutis */
    }

    .turmas-table th {
        background-color: #0ae092; /* Cor de fundo neutra para os cabeçalhos */
        color: #333; /* Cor de texto mais suave */
        font-weight: normal;
        text-transform: uppercase; /* Letras maiúsculas aumentam a legibilidade */
    }

    .turmas-table tbody tr:hover {
        background-color: #f1f1f1; /* Hover com uma cor mais discreta */
    }

    /* Adicionando uma sombra sutil nas células do cabeçalho */
    .turmas-table th {
        box-shadow: inset 0 -1px 0 0 #e0e0e0;
    }

    /* Estilização do link como botão */
    .button-link {
        display: inline-block;
        padding: 5px 10px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
    }

    .button-link:hover {
        background-color: #45a049;
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

<?php require_once '../COMPONENTS/header.php' ?>

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
                    $query = "SELECT * FROM Turma where turma_status = 1";

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