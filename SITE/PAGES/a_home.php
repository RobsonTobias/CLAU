<?php
require_once '../conexao.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['Tipo_Tipo_cd'] = 3;
?>

<?php
require_once '../PHP/toats/toats.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLAU - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../PHP/sidebar/menu.css">
    <link rel="stylesheet" href="../STYLE/botao.css" />
    <link rel="stylesheet" href="../STYLE/data.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="stylesheet" href="../PHP/notif/notif.css">
    <link rel="stylesheet" href="../PHP/toats/toats.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .home path{
            fill: #043140;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>
<header>
    <div id="recar" class="title">
        <div class="nomedata closed">
            <h1>HOME</h1>
            <div class="php">
                <?php echo $date; ?><!--  Mostrar a data atual -->
            </div>
        </div>
        
        <div class="user">
        <div class="dropleft">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-bell-fill"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <h3 class="text-center">Notificações</h3>
                <?php include_once '../PHP/notif/notif.php' ?>
            </div>
        </div>

            <?php echo $dropdown; ?><!-- Mostra o usuário, foto e menu dropdown -->
        </div>
    </div>
    <hr>
</header>

<div>
    <?php echo $sidebarHTML; ?><!-- Mostrar o menu lateral -->
</div>

<main>
    <a href="a_chamada.php" class="item"><img src="../ICON/chamada.svg" alt="Chamada_Diario">
        <p>Chamadas e Diário de Classe</p>
    </a>
    <a href="a_notas.php" class="item"><img src="../ICON/nota.svg" alt="Notas">
        <p>Notas</p>
    </a>
    <a href="a_aluno.php" class="item"><img src="../ICON/aluno.svg" alt="Aluno">
        <p>Aluno</p>
    </a>
    <a href="a_turma.php" class="item"><img src="../ICON/turma.svg" alt="Turma">
        <p>Turma</p>
    </a>
    <a href="a_planejamento.php" class="item"><img src="../ICON/planejamento.svg" alt="Planejamento">
        <p>Planejamento</p>
    </a>
    <a href="a_prova.php" class="item"><img src="../ICON/prova.svg" alt="Provas e Atividades">
        <p>Provas e Atividades</p>
    </a>
    <a href="a_grade.php" class="item"><img src="../ICON/grade.svg" alt="Grade_Horaria">
        <p>Grade Horária</p>
    </a>
    <a href="a_calendario.php" class="item"><img src="../ICON/calendario.svg" alt="Calendario">
        <p>Calendário</p>
    </a>
    <div class="local-toat-right">
        <?php 
        if (isset($_GET["tipo"])) {
            $tipo = $_GET['tipo'];
            echo toatsActive($tipo);
        }
        ?>
    </div>
</main>

<div class="buttons">
    <?php echo $redes; ?><!-- Mostrar o botão de fale conosco -->
</div>

<script src="../PHP/notif/notif.js"></script>
<script src="../PHP/toats/toats.js"></script>
<script src="../JS/dropdown.js"></script>
<script src="../JS/botao.js"></script>
<script src="../PHP/sidebar/menu.js"></script>

</body>
</html>
