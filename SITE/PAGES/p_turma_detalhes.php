<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Resgata o ID do usuário logado
$usuarioId = $_SESSION['Usuario_id'];

// Consulta SQL para obter os detalhes da turma
include '../conexao.php'; // Inclua seu arquivo de conexão com o banco de dados
if (isset($_GET['turma_cod'])) {
    $idTurma = $_GET['turma_cod'];

    // Consulta SQL para obter os detalhes da turma com o ID fornecido
// Consulta SQL para obter os detalhes da turma com o ID fornecido
$queryTurma = "SELECT turma.turma_cod, turma.turma_horario, turma.turma_vagas, turma.turma_inicio, turma.turma_termino, turma.turma_obs,diassemana.nome_dia AS dia_semana
               FROM turma
               INNER JOIN diassemana ON turma.turma_dias =diassemana.id_dia
               WHERE turma.turma_cod = '$idTurma'";


    $queryNomeCurso = "SELECT curso_nome
                       FROM curso
                       INNER JOIN turma ON curso_cd = turma.curso_cd
                       WHERE turma.turma_cod = '$idTurma'";

    $queryNomeProfessor = "SELECT usuario_nome AS nome_professor
                           FROM usuario
                           INNER JOIN turma ON usuario.usuario_id = turma.usuario_usuario_cd
                           WHERE turma.turma_cod = '$idTurma'";

    // Executar a consulta para obter os detalhes da turma
    $resultadoTurma = mysqli_query($conn, $queryTurma);
    if (!$resultadoTurma) {
        die("Erro ao executar a consulta da turma: " . mysqli_error($conn));
    }

    // Verificar se a consulta retornou algum resultado
    if (mysqli_num_rows($resultadoTurma) > 0) {
        // Extrair os dados da turma
        $turma = mysqli_fetch_assoc($resultadoTurma);

        // Verificar se as chaves existem antes de acessá-las
        $codigoTurma = isset($turma['turma_cod']) ? $turma['turma_cod'] : "N/A";
        $horario = isset($turma['turma_horario']) ? $turma['turma_horario'] : "N/A";
        $vagas = isset($turma['turma_vagas']) ? $turma['turma_vagas'] : "N/A";
        $diaSemana = isset($turma['dia_semana']) ? $turma['dia_semana'] : "N/A";
        $observacoes = isset($turma['turma_obs']) ? $turma['turma_obs'] : "N/A";

        // Formatando as datas para o padrão brasileiro (DD/MM/AAAA)
        $dataInicio = isset($turma['turma_inicio']) ? date('d/m/Y', strtotime($turma['turma_inicio'])) : "N/A";
        $dataTermino = isset($turma['turma_termino']) ? date('d/m/Y', strtotime($turma['turma_termino'])) : "N/A";

        // Executar a consulta para obter o nome do curso
        $resultadoNomeCurso = mysqli_query($conn, $queryNomeCurso);
        if (!$resultadoNomeCurso) {
            $nomeCurso = "Curso não encontrado";
        } else {
            $rowNomeCurso = mysqli_fetch_assoc($resultadoNomeCurso);
            $nomeCurso = $rowNomeCurso['curso_nome'];
        }

        // Executar a consulta para obter o nome do professor
        $resultadoNomeProfessor = mysqli_query($conn, $queryNomeProfessor);
        if (!$resultadoNomeProfessor) {
            $nomeProfessor = "Professor não encontrado";
        } else {
            $rowNomeProfessor = mysqli_fetch_assoc($resultadoNomeProfessor);
            $nomeProfessor = $rowNomeProfessor['nome_professor'];
        }
    }
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
        .course-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .course-details h1,
        .course-details h2 {
            color: #043140;
            margin-bottom: 10px;
        }

        .course-details ul {
            list-style-type: none;
            padding: 0;
        }

        .course-details ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .course-details .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #043140;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .course-details .back-link:hover {
            background-color: #035A70;
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
            <h1>DETALHES DA TURMA</h1>
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
    <!-- Conteúdo principal da página -->
    <div class="course-details">
        <ul>
            <li><strong>Código da Turma:</strong> <?php echo $codigoTurma; ?></li>
            <li><strong>Horário:</strong> <?php echo $horario; ?>h</li>
            <li><strong>Vagas:</strong> <?php echo $vagas; ?></li>
            <li><strong>Dia da Semana:</strong> <?php echo $diaSemana; ?></li>
            <li><strong>Início:</strong> <?php echo $dataInicio; ?></li>
            <li><strong>Término:</strong> <?php echo $dataTermino; ?></li>
            <li><strong>Observações:</strong> <?php echo $observacoes; ?></li>
            <li><strong>Professor:</strong> <?php echo $nomeProfessor; ?></li>
            <li><strong>Curso:</strong> <?php echo $nomeCurso; ?></li>
        </ul>
    </div>
</main>

<div class="buttons">
    <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
</div>

<script src="../JS/dropdown.js"></script>
<script src="../JS/botao.js"></script>
<script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
