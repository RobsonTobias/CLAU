<?php
require_once '../COMPONENTS/head.php';
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

// Verifica se o parâmetro POST 'Tipo_Tipo_cd' está definido
if (isset($_POST['Tipo_Tipo_cd']) && !empty($_POST['Tipo_Tipo_cd'])) {
    // Valida e sanitiza o parâmetro POST
    $tipo_tipo_cd = filter_input(INPUT_POST, 'Tipo_Tipo_cd', FILTER_VALIDATE_INT);
    
    if ($tipo_tipo_cd !== false && $tipo_tipo_cd > 0 && $tipo_tipo_cd <= 2) {
        // Parâmetro válido, define a sessão
        $_SESSION['Tipo_Tipo_cd'] = $tipo_tipo_cd;
    } else {
        // Parâmetro inválido, redireciona para logout ou outra página de erro
        header("Location: ../logout.php");
        exit();
    }
}

// Verifica se o usuário tem a permissão correta para a página
if (!isset($_SESSION['Tipo_Tipo_cd']) || $_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
    exit();
}
$titulo = 'HOME'; //Título da página, que fica sobre a data
?>

    <link rel="stylesheet" href="../STYLE/style_home.css">
    <style>
        .home path{
            fill: #043140;
        }
    </style>

<body>
<?php require_once '../COMPONENTS/headerHome.php' ?>

    <main>
        <a href="s_professores.php" class="item"><img src="../ICON/professores.svg" alt="Professores">
            <p>Professores</p>
        </a>
        <a href="s_coordenador.php" class="item"><img src="../ICON/coordenacao.svg" alt="Coordenador">
            <p>Coordenadores</p>
        </a>
        <a href="s_alunos.php" class="item"><img src="../ICON/aluno.svg" alt="Alunos">
            <p>Alunos</p>
        </a>
        <a href="s_turma.php" class="item"><img src="../ICON/turma.svg" alt="Turma">
            <p>Turma</p>
        </a>
        <a href="s_curso.php" class="item"><img src="../ICON/cursos.svg" alt="Cursos">
            <p>Cursos</p>
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