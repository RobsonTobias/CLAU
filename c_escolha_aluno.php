<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
// Certifique-se de que a variável de sessão Permissoes existe e não está vazia
if (isset($_SESSION['Permissoes']) && !empty($_SESSION['Permissoes'])) {
    $permissoes = $_SESSION['Permissoes'];
} else {
    // Se não houver permissões definidas, redirecione de volta para a página de login ou trate o erro
    header('Location: index.html');
    exit();
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
    <link rel="stylesheet" href="../STYLE/login.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>
<?php include '../PHP/sidebar/menu.php';?>


<header>
        <div class="title">
            <div class="nomedata closed">
                <h1>ESCOLHA</h1>
                <div class="php">
                    <?php echo $date; ?>
                </div>
            </div>
            <div class="user">
                <?php echo $dropdown; ?>
            </div>
        </div>
        <hr>
    </header>
    <div>
        <?php echo $sidebarHTML; ?>
    </div>

    <main>
        <?php if (in_array(4, $permissoes)):?>
            <a href="p_alunos_relatorio.php" class="item"><img src="../ICON/professores.svg" alt="Professores"><p>Alunos</p>
            </a>
        <?php endif?>

        <?php if (in_array(5, $permissoes)):?>
            <a href="c_alunos_faltosos.php" class="item"><img src="../ICON/coordenacao.svg" alt="Coordenacao"><p>Alunos faltosos</p>
            </a>
        <?php endif?>
    </main>

    <div class="buttons">
        <?php echo $redes; ?>
    </div>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>