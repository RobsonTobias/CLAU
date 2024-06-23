<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if ($_SESSION['Tipo_Tipo_cd'] != 5) {
    header("Location: ../logout.php");
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
$sqlTurmas = "SELECT turma_cod FROM turma WHERE turma_status = 1";
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

// Consulta para obter código das turmas e nomes dos professores
$sqlTurmasProfessores = "SELECT turma.turma_cod, usuario.usuario_nome AS professor_nome
                         FROM turma
                         JOIN usuario ON turma.usuario_usuario_cd = usuario.usuario_id";
$resultadoTurmasProfessores = mysqli_query($conn, $sqlTurmasProfessores);

include '../PHP/data.php';
include '../PHP/sidebar/menu.php';
include '../PHP/redes.php';
include '../PHP/dropdown.php';

$titulo = 'LISTA DE CHAMADA E DIÁRIO DE CLASSE'; //Título da página, que fica sobre a data
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
        .chamada path {
            stroke: #043140;
        }
        /* Estilo para a tabela */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1em;
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
        }
        table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
            font-weight: bold;
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
        }
        table tbody tr {
            border-bottom: 1px solid #dddddd;
        }
        table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }
        table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
    </style>
</head>

<body>
<?php require_once '../COMPONENTS/header.php' ?>
    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Código da Turma</th>
                    <th>Nome do Professor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultadoTurmasProfessores) {
                    while ($row = mysqli_fetch_assoc($resultadoTurmasProfessores)) {
                        echo "<tr>";
                        echo "<td>" . $row['turma_cod'] . "</td>";
                        echo "<td>" . $row['professor_nome'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
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
