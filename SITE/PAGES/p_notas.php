<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 4){
    header("Location: ../logout.php");
}

$usuarioId = $_SESSION['Usuario_id'];
include '../conexao.php';

$turmaCod = '';
$cursoCod = '';
$moduloId = '';

// Se uma turma foi selecionada
if (isset($_POST['selecionarTurma'])) {
    $turmaCod = $_POST['turma'];

    // Consulta para obter o curso associado à turma selecionada
    $sqlCurso = "SELECT curso_cd FROM turma WHERE turma_cod = '$turmaCod'";
    $resultadoCurso = mysqli_query($conn, $sqlCurso);
    if ($resultadoCurso && $linhaCurso = mysqli_fetch_assoc($resultadoCurso)) {
        $cursoCod = $linhaCurso['curso_cd'];
    } else {
        die("Erro ao consultar o curso: " . mysqli_error($conn));
    }
}

// Se o botão para carregar alunos foi acionado
if (isset($_POST['lancarNotas'])) {
    $turmaCod = $_POST['turma'];
    $moduloId = $_POST['modulo'];
}

// Consulta para obter as turmas do professor
$sqlTurmas = "SELECT turma.turma_cod, turma.curso_cd, usuario.usuario_nome AS professor_responsavel
              FROM turma
              INNER JOIN usuario ON usuario.usuario_id = turma.usuario_usuario_cd
              WHERE usuario.usuario_id = $usuarioId and turma_status = 1";

$resultadoTurmas = mysqli_query($conn, $sqlTurmas);
if (!$resultadoTurmas) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}

$resultadoModulos = null;
if (!empty($cursoCod)) {
    // Consulta para obter os módulos do curso
    $sqlModulos = "SELECT modulo.modulo_id, modulo.modulo_nome
                   FROM modulo_curso
                   INNER JOIN modulo ON modulo_curso.modulo_modulo_cd = modulo.modulo_id
                   WHERE modulo_curso.curso_curso_cd = '$cursoCod'";
    $resultadoModulos = mysqli_query($conn, $sqlModulos);
    if (!$resultadoModulos) {
        die("Erro ao consultar módulos: " . mysqli_error($conn));
    }
}

// Consulta para obter os alunos da turma, se um módulo foi selecionado
$alunos = null;
if (!empty($turmaCod) && !empty($moduloId)) {
    $sqlAlunos = "SELECT usuario.usuario_id, usuario.usuario_nome
                  FROM aluno_turma
                  INNER JOIN usuario ON aluno_turma.usuario_usuario_cd = usuario.usuario_id
                  WHERE aluno_turma.turma_turma_cod = '$turmaCod'";
    $alunos = mysqli_query($conn, $sqlAlunos);
    if (!$alunos) {
        die("Erro ao consultar alunos: " . mysqli_error($conn));
    }
}

$titulo = 'LANÇAMENTO DE NOTAS'; //Título da página, que fica sobre a data
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
        .notas path{
            fill: #043140;
        }
    </style>
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>

<?php require_once '../COMPONENTS/header.php' ?>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>
    
        <main>
        <form action="" method="post">
    <label for="turma">Selecione a Turma:</label>
    <select name="turma" id="turma">
        <option value="">Selecione uma turma</option>
        <?php while ($linhaTurma = mysqli_fetch_assoc($resultadoTurmas)) {
            echo "<option value='{$linhaTurma['turma_cod']}'" . ($linhaTurma['turma_cod'] === $turmaCod ? ' selected' : '') . ">{$linhaTurma['turma_cod']}</option>";
        } ?>
    </select>
    <button type="submit" name="selecionarTurma">Selecionar Turma</button>
</form>

<?php if ($resultadoModulos && mysqli_num_rows($resultadoModulos) > 0): ?>
    <form action="" method="post">
        <label for="modulo">Selecione o Módulo:</label>
        <select name="modulo" id="modulo">
            <?php while ($linhaModulo = mysqli_fetch_assoc($resultadoModulos)) {
                echo "<option value='" . $linhaModulo['modulo_id'] . "'" . ($linhaModulo['modulo_id'] === $moduloId ? ' selected' : '') . ">" . $linhaModulo['modulo_nome'] . "</option>";
            } ?>
        </select>
        <input type="hidden" name="turma" value="<?php echo htmlspecialchars($turmaCod); ?>">
        <button type="submit" name="lancarNotas">Carregar Alunos</button>
    </form>
<?php endif; ?>

<?php if (!empty($alunos) && mysqli_num_rows($alunos) > 0): ?>
    <h2>Alunos da Turma: <?php echo htmlspecialchars($turmaCod); ?></h2>
    <form action="../PHP/salvar_notas.php" method="post">
        <table>
            <tr>
                <th>Nome do Aluno</th>
                <th>Nota</th>
            </tr>
            <?php while ($aluno = mysqli_fetch_assoc($alunos)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($aluno['usuario_nome']) . "</td>";
                echo "<td><input type='number' name='notas[" . $aluno['usuario_id'] . "]' min='0' max='10'></td>";
                echo "</tr>";
            } ?>
        </table>
        <input type="hidden" name="turma" value="<?php echo htmlspecialchars($turmaCod); ?>">
        <input type="hidden" name="modulo" value="<?php echo htmlspecialchars($moduloId); ?>">
        <button type="submit" name="salvarNotas">Salvar Notas</button>
    </form>
<?php elseif (isset($_POST['lancarNotas'])): ?>
    <p>Nenhum aluno encontrado para esta turma.</p>
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