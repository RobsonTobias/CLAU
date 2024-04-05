<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

$usuarioId = $_SESSION['Usuario_id'];
include '../conexao.php';

// Variáveis para armazenar os inputs
$turmaCod = '';
$moduloId = '';
$dataAula = '';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turmaCod = $_POST['turma'];
    $moduloId = $_POST['modulo'];
    $dataAula = $_POST['dataAula'];
}

// Consulta SQL para obter as turmas e os módulos
$sqlTurmas = "SELECT turma_cod FROM turma WHERE usuario_usuario_cd = '$usuarioId'";
$resultadoTurmas = mysqli_query($conn, $sqlTurmas);

$sqlModulos = "SELECT modulo_id, modulo_nome FROM modulo";
$resultadoModulos = mysqli_query($conn, $sqlModulos);

// Consulta para obter os alunos se a turma e o módulo foram selecionados
$alunos = null;
if (!empty($turmaCod) && !empty($moduloId)) {
    $sqlAlunos = "SELECT aluno_turma.Aluno_Turma_id, usuario.usuario_nome
    FROM aluno_turma
    INNER JOIN usuario ON aluno_turma.usuario_usuario_cd = usuario.usuario_id
    WHERE aluno_turma.turma_turma_cod = '$turmaCod'";

    $alunos = mysqli_query($conn, $sqlAlunos);
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
        .chamada path{
            stroke: #043140;
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
                <h1>LISTA DE CHAMADA E DIÁRIO DE CLASSE</h1>
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
    <h1>Lançamento de Chamada</h1>
    <form action="" method="post">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" id="turma" required>
            <option value="">Selecione uma turma</option>
            <?php while ($linhaTurma = mysqli_fetch_assoc($resultadoTurmas)) {
                echo "<option value='{$linhaTurma['turma_cod']}'" . ($linhaTurma['turma_cod'] == $turmaCod ? ' selected' : '') . ">{$linhaTurma['turma_cod']}</option>";
            } ?>
        </select>

        <label for="modulo">Selecione o Módulo:</label>
        <select name="modulo" id="modulo" required>
            <option value="">Selecione um módulo</option>
            <?php while ($linhaModulo = mysqli_fetch_assoc($resultadoModulos)) {
                echo "<option value='{$linhaModulo['modulo_id']}'" . ($linhaModulo['modulo_id'] == $moduloId ? ' selected' : '') . ">{$linhaModulo['modulo_nome']}</option>";
            } ?>
        </select>

        <label for="dataAula">Data da Aula:</label>
        <input type="date" name="dataAula" id="dataAula" value="<?php echo $dataAula; ?>" required>

        <!-- Novo campo para a descrição da aula -->
        <label for="descricaoAula">Descrição da Aula:</label>
        <textarea name="descricaoAula" id="descricaoAula" rows="4" required></textarea>

        <button type="submit">Carregar Alunos</button>
    </form>

    <?php if (!empty($alunos) && mysqli_num_rows($alunos) > 0): ?>
        <form action="../PHP/salvar_chamada.php" method="post">
        <table>
    <tr>
        <th>Nome do Aluno</th>
        <th>Presença</th>
    </tr>
    <?php while ($aluno = mysqli_fetch_assoc($alunos)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($aluno['usuario_nome']) . "</td>";
    echo "<td><input type='checkbox' name='presenca[" . $aluno['Aluno_Turma_id'] . "]'></td>";
    echo "</tr>";
} ?>

</table>

            <input type="hidden" name="turma" value="<?php echo htmlspecialchars($turmaCod); ?>">
            <input type="hidden" name="modulo" value="<?php echo htmlspecialchars($moduloId); ?>">
            <input type="hidden" name="dataAula" value="<?php echo htmlspecialchars($dataAula); ?>">
            <!-- Passar a descrição da aula para o script de salvar -->
            <input type="hidden" name="descricaoAula" value="<?php echo htmlspecialchars($_POST['descricaoAula']); ?>">
            <button type="submit">Salvar Chamada</button>
        </form>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>Nenhum aluno encontrado para esta turma e módulo.</p>
    <?php endif; ?>
</main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>