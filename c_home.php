<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
$_SESSION['Tipo_Tipo_cd'] = 5;
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
        .home path{
            fill: #043140;
        }
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
                <h1>HOME</h1>
                <div class="php">
                    <?php echo $date;?><!--  Mostrar o data atual -->
                </div>
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
        <a href="p_chamada.php" class="item"><img src="../ICON/chamada.svg" alt="Chamada_Diario">
            <p>Chamadas e Diário de Classe</p>
        </a>
        <a href="p_notas.php" class="item"><img src="../ICON/nota.svg" alt="Notas">
            <p>Notas</p>
        </a>
        <a href="c_escolha_aluno.php" class="item"><img src="../ICON/aluno.svg" alt="Aluno">
            <p>Aluno</p>
        </a>
        <a href="c_turma.php" class="item"><img src="../ICON/turma.svg" alt="Turma">
            <p>Turma</p>
        </a>
        <a href="c_planejamento.php" class="item"><img src="../ICON/planejamento.svg" alt="Planejamento">
            <p>Planejamento</p>
        </a>
        <a href="p_prova.php" class="item"><img src="../ICON/prova.svg" alt="Provas e Atividades">
            <p>Provas e Atividades</p>
        </a>
        <a href="c_grade.php" class="item"><img src="../ICON/grade.svg" alt="Grade_Horaria">
            <p>Grade Horária</p>
        </a>
        <a href="p_calendario.php" class="item"><img src="../ICON/calendario.svg" alt="Calendario">
            <p>Calendário</p>
        </a>
    </main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>
