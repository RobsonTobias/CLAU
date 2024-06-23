<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

$userId = $_SESSION['Usuario_id'];

// Consulta para recuperar informações do usuário
$sql = "SELECT * FROM Aluno_Turma
    LEFT JOIN Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
    LEFT JOIN Curso ON Curso.Curso_id = Turma.Curso_cd
    WHERE Aluno_Turma.Usuario_Usuario_cd = $userId";
$result = $conn->query($sql);

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
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .alunos path {
            fill: #043140;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        .info th, .info td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CONSULTA DA TURMA</h1>
                <div class="php">
                    <?php echo $date; ?>
                    <!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown; ?>
                <!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML; ?>
        <!--  Mostrar o menu lateral -->
    </div>

    <main>
        <?php
        if ($result->num_rows > 0) {
            // Iterar sobre os resultados da consulta
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="geral"  style="margin:30px">
                    <p>Informações da Turma</p>
                    <div class="info">
                        <!-- Exibir informações do curso em uma tabela -->
                        <table>
                            <tr>
                                <th>Código da Turma:</th>
                                <td><?php echo $row['Turma_Cod'] ?></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td><?php echo ($row['Turma_Status'] == 1 ? "CURSANDO" : "FINALIZADO") ?></td>
                            </tr>
                            <tr>
                                <th>Curso:</th>
                                <td><?php echo $row['Curso_Nome'] ?></td>
                            </tr>
                            <tr>
                                <th>Período:</th>
                                <td><?php echo $row['Turma_Obs'] ?></td>
                            </tr>
                            <tr>
                                <th>Dias por Semana:</th>
                                <td><?php echo $row['Turma_Dias'] ?></td>
                            </tr>
                            <tr>
                                <th>Horário Início:</th>
                                <td><?php echo $row['Turma_Horario'] ?></td>
                            </tr>
                            <tr>
                                <th>Horário Término:</th>
                                <td><?php echo $row['Turma_Horario_Termino'] ?></td>
                            </tr>
                            <tr>
                                <th>Turma Início:</th>
                                <td><?php echo $row['Turma_Inicio'] ?></td>
                            </tr>
                            <tr>
                                <th>Turma Término:</th>
                                <td><?php echo $row['Turma_Termino'] ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "Nenhum curso encontrado";
        }
        ?>
    </main>

    <div class="buttons">
        <?php echo $redes; ?>
        <!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/end.js"></script>
</body>

</html>
