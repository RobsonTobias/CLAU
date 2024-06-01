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

    // Função para obter o curso_id de uma turma
    function getCursoIdFromTurma($conn, $turmaCod) {
        $sqlCurso = "SELECT Curso_cd FROM turma WHERE turma_cod = ?";
        $stmt = mysqli_prepare($conn, $sqlCurso);
        mysqli_stmt_bind_param($stmt, "s", $turmaCod);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $cursoId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $cursoId;
    }

    $cursoId = getCursoIdFromTurma($conn, $turmaCod);

    // Consulta SQL para obter módulos vinculados ao curso da turma selecionada
    $sqlModulos = "SELECT modulo_id, modulo_nome FROM modulo
                   JOIN modulo_curso ON modulo.modulo_id = modulo_curso.modulo_modulo_cd
                   WHERE modulo_curso.curso_curso_cd = '$cursoId'";
} else {
    $sqlModulos = "SELECT modulo_id, modulo_nome FROM modulo WHERE 1 = 0"; // Inicialmente não carrega nenhum módulo
}

$resultadoModulos = mysqli_query($conn, $sqlModulos);

// Consulta SQL para obter as turmas
$sqlTurmas = "SELECT turma_cod FROM turma WHERE usuario_usuario_cd = '$usuarioId'";
$resultadoTurmas = mysqli_query($conn, $sqlTurmas);

// Consulta para obter os alunos se a turma e o módulo foram selecionados
$alunos = null;
if (!empty($turmaCod) && !empty($moduloId)) {
    $sqlAlunos = "SELECT aluno_turma.Aluno_Turma_id, usuario.usuario_nome
    FROM aluno_turma
    INNER JOIN usuario ON aluno_turma.usuario_usuario_cd = usuario.usuario_id
    WHERE aluno_turma.turma_turma_cod = '$turmaCod'";

    $alunos = mysqli_query($conn, $sqlAlunos);
}

include '../PHP/data.php';
include '../PHP/sidebar/menu.php';
include '../PHP/redes.php';
include '../PHP/dropdown.php';
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
    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>LISTA DE CHAMADA E DIÁRIO DE CLASSE</h1>
                <div class="php">
                    <?php echo $date; ?><!--  Mostrar a data atual -->
                </div>
            </div>
            <div class="user">
                <?php echo $dropdown; ?><!-- Mostra o usuário, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>
    
    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>
    <main>
    <h1>Lançamento de Chamada</h1>
    <form action="" method="post">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" id="turma" required onchange="this.form.submit()">
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

        <label for="descricaoAula">Descrição da Aula:</label>
        <textarea name="descricaoAula" id="descricaoAula" rows="4" required></textarea>

        <button type="submit">Carregar Alunos</button>
    </form>

    <?php if (!empty($alunos) && mysqli_num_rows($alunos) > 0): ?>
        <form id="formChamada" action="../PHP/salvar_chamada.php" method="post">
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
            <input type="hidden" name="descricaoAula" value="<?php echo htmlspecialchars($_POST['descricaoAula']); ?>">
            <button type="submit">Salvar Chamada</button>
        </form>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>Nenhum aluno encontrado para esta turma e módulo.</p>
    <?php endif; ?>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("formChamada").onsubmit = function(e) {
        e.preventDefault(); // Impede o envio inicial do formulário

        var turma = document.getElementById("turma").value;
        var modulo = document.getElementById("modulo").value;
        var dataAula = document.getElementById("dataAula").value;

        var formData = new FormData();
        formData.append('turma', turma);
        formData.append('modulo', modulo);
        formData.append('dataAula', dataAula);

        fetch('../PHP/verifica_aula.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === "existente") {
                alert("Já existe uma aula para esta turma, módulo e data.");
            } else if (data === "dia_incorreto") {
                alert("A data selecionada não corresponde aos dias de aula desta turma.");
            } else {
                // Se não existir, submete o formulário
                document.getElementById("formChamada").submit();
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    };
});
</script>
</body>
</html>
