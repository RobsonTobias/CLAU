<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

// Verifica se o parâmetro POST 'Tipo_Tipo_cd' está definido
if (isset($_POST['Tipo_Tipo_cd']) && !empty($_POST['Tipo_Tipo_cd'])) {
    // Valida e sanitiza o parâmetro POST
    $tipo_tipo_cd = filter_input(INPUT_POST, 'Tipo_Tipo_cd', FILTER_VALIDATE_INT);
    
    if ($tipo_tipo_cd !== false && $tipo_tipo_cd > 0 && $tipo_tipo_cd <= 5) {
        // Parâmetro válido, define a sessão
        $_SESSION['Tipo_Tipo_cd'] = $tipo_tipo_cd;
    } else {
        // Parâmetro inválido, redireciona para logout ou outra página de erro
        header("Location: ../logout.php");
        exit();
    }
}

// Verifica se o usuário tem a permissão correta para a página
if (!isset($_SESSION['Tipo_Tipo_cd']) || $_SESSION['Tipo_Tipo_cd'] != 5) {
    header("Location: ../logout.php");
    exit();
}
$titulo = 'HOME'; //Título da página, que fica sobre a data
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

<?php require_once '../COMPONENTS/headerHome.php' ?>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>
    
    <main>
        <a href="c_sub_chamada.php" class="item"><img src="../ICON/chamada.svg" alt="Chamada_Diario">
            <p>Chamadas e Diário de Classe</p>
        </a>
        <a href="c_notas.php" class="item"><img src="../ICON/nota.svg" alt="Notas">
            <p>Notas</p>
        </a>
        <a href="c_alunos_relatorio.php" class="item"><img src="../ICON/aluno.svg" alt="Aluno">
            <p>Aluno</p>
        </a>
        <a href="c_turma.php" class="item"><img src="../ICON/turma.svg" alt="Turma">
            <p>Turma</p>
        </a>
        <a href="c_planejamento.php" class="item"><img src="../ICON/planejamento.svg" alt="Planejamento">
            <p>Planejamento</p>
        </a>
        <a href="c_frequencia.php" class="item"><img src="../ICON/prova.svg" alt="Provas e Atividades">
            <p>Frequência</p>
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
