<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 5){
    header("Location: ../logout.php");
}

$usuarioId = $_SESSION['Usuario_id'];
include '../conexao.php';

// Verifica se o formulário foi submetido via AJAX para buscar aulas
if (isset($_GET['turma'])) {
    $turmaCod = $_GET['turma'];

    $sqlAulas = "SELECT id_aula, descricao, data_aula FROM aula WHERE cod_turma = ?";
    $stmt = mysqli_prepare($conn, $sqlAulas);
    mysqli_stmt_bind_param($stmt, "s", $turmaCod);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idAula, $descricao, $dataAula);

    $aulas = [];
    while (mysqli_stmt_fetch($stmt)) {
        $aulas[] = ['id_aula' => $idAula, 'descricao' => $descricao, 'data_aula' => $dataAula];
    }

    mysqli_stmt_close($stmt);

    header('Content-Type: application/json');
    echo json_encode($aulas);
    exit();
}

// Verifica se o formulário foi submetido via AJAX para buscar alunos
if (isset($_GET['aula'])) {
    $aulaId = $_GET['aula'];

    $sqlAlunos = "SELECT chamada.id_chamada, usuario.usuario_nome, chamada.presenca
                  FROM chamada
                  JOIN aluno_turma ON chamada.id_aluno_turma = aluno_turma.Aluno_Turma_id
                  JOIN usuario ON aluno_turma.usuario_usuario_cd = usuario.usuario_id
                  WHERE chamada.id_aula = ?";
    $stmt = mysqli_prepare($conn, $sqlAlunos);
    mysqli_stmt_bind_param($stmt, "i", $aulaId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $idChamada, $usuarioNome, $presenca);

    $alunos = [];
    while (mysqli_stmt_fetch($stmt)) {
        $alunos[] = ['id_chamada' => $idChamada, 'usuario_nome' => $usuarioNome, 'presenca' => $presenca];
    }

    mysqli_stmt_close($stmt);

    header('Content-Type: application/json');
    echo json_encode($alunos);
    exit();
}

// Verifica se o formulário foi submetido via AJAX para atualizar a presença
if (isset($_POST['update_presenca'])) {
    $idChamada = $_POST['id_chamada'];
    $presenca = $_POST['presenca'];

    $sqlUpdatePresenca = "UPDATE chamada SET presenca = ? WHERE id_chamada = ?";
    $stmt = mysqli_prepare($conn, $sqlUpdatePresenca);
    mysqli_stmt_bind_param($stmt, "ii", $presenca, $idChamada);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo json_encode(['success' => $success]);
    exit();
}

// Consulta SQL para obter as turmas
$sqlTurmas = "SELECT turma_cod FROM turma WHERE turma_status = 1";
$resultadoTurmas = mysqli_query($conn, $sqlTurmas);

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
<?php require_once '../COMPONENTS/header.php' ?>
    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>
    <main>
    <h1>Lançamento de Chamada</h1>
    <form action="" method="post" id="formTurma">
        <label for="turma">Selecione a Turma:</label>
        <select name="turma" id="turma" required>
            <option value="">Selecione uma turma</option>
            <?php while ($linhaTurma = mysqli_fetch_assoc($resultadoTurmas)) {
                echo "<option value='{$linhaTurma['turma_cod']}'" . ($linhaTurma['turma_cod'] == $turmaCod ? ' selected' : '') . ">{$linhaTurma['turma_cod']}</option>";
            } ?>
        </select>
    </form>

    <form id="formChamada" action="" method="post">
        <input type="hidden" name="turmaCod" id="turmaCod">
        <label for="aula">Selecione a Aula:</label>
        <select name="aula" id="aula" required>
            <option value="">Selecione uma aula</option>
            <!-- Opções preenchidas dinamicamente via JavaScript -->
        </select>
        <button type="button" id="carregarAlunos">Carregar Alunos</button>
    </form>
    
    <div id="alunosList"></div>
    <button type="button" id="atualizarChamada">Atualizar Chamada</button>

    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script>
document.getElementById("turma").addEventListener("change", function() {
    var turmaCod = this.value;
    document.getElementById("turmaCod").value = turmaCod; // Set the hidden field
    if (turmaCod) {
        fetch(window.location.href + '?turma=' + turmaCod)
            .then(response => response.json())
            .then(data => {
                var aulaSelect = document.getElementById("aula");
                aulaSelect.innerHTML = '<option value="">Selecione uma aula</option>';
                data.forEach(function(aula) {
                    var option = document.createElement("option");
                    option.value = aula.id_aula;
                    option.text = `${aula.descricao} - ${aula.data_aula}`;
                    aulaSelect.appendChild(option);
                });
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    } else {
        document.getElementById("aula").innerHTML = '<option value="">Selecione uma aula</option>';
    }
});

document.getElementById("carregarAlunos").addEventListener("click", function() {
    var aulaId = document.getElementById("aula").value;
    if (aulaId) {
        fetch(window.location.href + '?aula=' + aulaId)
            .then(response => response.json())
            .then(data => {
                var alunosList = document.getElementById("alunosList");
                alunosList.innerHTML = '<h2>Alunos:</h2>';
                var ul = document.createElement("ul");
                data.forEach(function(aluno) {
                    var li = document.createElement("li");
                    li.innerHTML = `${aluno.usuario_nome} 
                                    <input type="checkbox" ${aluno.presenca == 1 ? 'checked' : ''} 
                                    data-id-chamada="${aluno.id_chamada}">`;
                    ul.appendChild(li);
                });
                alunosList.appendChild(ul);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    } else {
        document.getElementById("alunosList").innerHTML = '';
    }
});

document.getElementById("atualizarChamada").addEventListener("click", function() {
    var checkboxes = document.querySelectorAll("#alunosList input[type='checkbox']");
    checkboxes.forEach(function(checkbox) {
        var idChamada = checkbox.getAttribute("data-id-chamada");
        var presenca = checkbox.checked ? 1 : 0;

        var formData = new FormData();
        formData.append('update_presenca', true);
        formData.append('id_chamada', idChamada);
        formData.append('presenca', presenca);

        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Erro ao atualizar presença');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    });
});
</script>
</body>
</html>
