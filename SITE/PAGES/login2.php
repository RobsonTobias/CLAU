<?php
require_once '../COMPONENTS/head.php';

// Certifique-se de que a variável de sessão Permissoes existe e não está vazia
if (isset($_SESSION['Permissoes']) && !empty($_SESSION['Permissoes'])) {
    $permissoes = $_SESSION['Permissoes'];

} else {
    header('Location: index.php');
    exit();
}

$titulo = 'LOGIN'; //Título da página, que fica sobre a data
?>

<style>
    button {
        background-color: #043140;
        border: none;
    }

    form.item:hover button {
        background-color: #176204;
    }

    main {
        height: 100vh;
        margin: 0;
        align-items: center;
    }
</style>

<body>

    <main>
        <?php if (in_array(1, $permissoes)): ?>
            <form method="post" action="m_home.php" class="item">
                <input type="hidden" name="Tipo_Tipo_cd" value="1">
                <button type="submit"><img src="../ICON/diretor.svg" alt="Diretor">
                    <p>Diretor</p>
                </button>
            </form>
        <?php endif ?>

        <?php if (in_array(2, $permissoes)): ?>
            <form method="post" action="s_home.php" class="item">
                <input type="hidden" name="Tipo_Tipo_cd" value="2">
                <button type="submit"><img src="../ICON/funcionario.svg" alt="Secretaria">
                    <p>Secretaria</p>
                </button>
            </form>
        <?php endif ?>

        <?php if (in_array(3, $permissoes)): ?>
            <form method="post" action="a_home.php" class="item">
                <input type="hidden" name="Tipo_Tipo_cd" value="3">
                <button type="submit"><img src="../ICON/aluno.svg" alt="Alunos">
                    <p>Aluno</p>
                </button>
            </form>
        <?php endif ?>

        <?php if (in_array(4, $permissoes)): ?>
            <form method="post" action="p_home.php" class="item">
                <input type="hidden" name="Tipo_Tipo_cd" value="4">
                <button type="submit"><img src="../ICON/professores.svg" alt="Professores">
                    <p>Professor</p>
                </button>
            </form>
        <?php endif ?>

        <?php if (in_array(5, $permissoes)): ?>
            <form method="post" action="c_home.php" class="item">
                <input type="hidden" name="Tipo_Tipo_cd" value="5">
                <button type="submit"><img src="../ICON/coordenacao.svg" alt="Coordenacao">
                    <p>Coordenação</p>
                </button>
            </form>
        <?php endif ?>
    </main>

</body>

</html>