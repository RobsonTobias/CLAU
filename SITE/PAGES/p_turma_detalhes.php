<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 4){
    header("Location: ../logout.php");
}

// Resgata o ID do usuário logado
$usuarioId = $_SESSION['Usuario_id'];

// Consulta SQL para obter os detalhes da turma
include '../conexao.php'; // Inclua seu arquivo de conexão com o banco de dados
if (isset($_GET['turma_cod'])) {
    $idTurma = $_GET['turma_cod'];

    // Consulta SQL para obter os detalhes da turma com o ID fornecido
    $queryTurma = "SELECT turma.turma_cod, turma.turma_horario,turma.turma_horario_termino, turma.turma_vagas, turma.turma_inicio, turma.turma_termino, turma.turma_obs, turma.Turma_Dias
               FROM turma
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
        $horario_termino = isset($turma['turma_horario_termino']) ? $turma['turma_horario_termino'] : "N/A";
        $vagas = isset($turma['turma_vagas']) ? $turma['turma_vagas'] : "N/A";
        $observacoes = isset($turma['turma_obs']) ? $turma['turma_obs'] : "N/A";

        // Formatando as datas para o padrão brasileiro (DD/MM/AAAA)
        $dataInicio = isset($turma['turma_inicio']) ? date('d/m/Y', strtotime($turma['turma_inicio'])) : "N/A";
        $dataTermino = isset($turma['turma_termino']) ? date('d/m/Y', strtotime($turma['turma_termino'])) : "N/A";

        // Obtendo os dias de aula da turma
        $diasAulaTurma = isset($turma['Turma_Dias']) ? $turma['Turma_Dias'] : "";
        $dias_aula_turma_texto = ""; // Inicializando a variável para armazenar os nomes dos dias de aula da turma

        if (!empty($diasAulaTurma)) {
            // Array associativo com os nomes dos dias da semana
            $dias_semana = array(
                1 => 'Segunda-feira',
                2 => 'Terça-feira',
                3 => 'Quarta-feira',
                4 => 'Quinta-feira',
                5 => 'Sexta-feira',
                6 => 'Sábado'
            );

            // Convertendo os dias da turma para array
            $dias_turma = str_split($diasAulaTurma); // Converte a string para um array de caracteres

            // Array para armazenar os nomes dos dias de aula da turma
            $dias_aula_turma_nomes = array();

            // Itera sobre cada caractere da string convertida
            foreach ($dias_turma as $dia) {
                // Obtém o número do dia da semana atual
                $dia_numero = intval($dia);

                // Verifica se o número do dia existe no array de dias da semana
                if (array_key_exists($dia_numero, $dias_semana)) {
                    // Adiciona o nome do dia ao array de dias de aula da turma
                    $dias_aula_turma_nomes[] = $dias_semana[$dia_numero];
                }
            }

            // Concatena os nomes dos dias de aula da turma separados por vírgula
            $dias_aula_turma_texto = implode(', ', $dias_aula_turma_nomes);
        }

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
$titulo = 'DETALHES DA TURMA'; //Título da página, que fica sobre a data
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

<?php require_once '../COMPONENTS/header.php' ?>

<div>
    <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
</div>

<main>
    <!-- Conteúdo principal da página -->
    <div class="course-details">
        <ul>
            <li><strong>Código da Turma:</strong> <?php echo $codigoTurma; ?></li>
            <li><strong>Horário:</strong> <?php echo $horario; ?>h</li>
            <li><strong>Horário:</strong> <?php echo $horario_termino; ?>h</li>
            <li><strong>Vagas:</strong> <?php echo $vagas; ?></li>
            <li><strong>Início:</strong> <?php echo $dataInicio; ?></li>
            <li><strong>Término:</strong> <?php echo $dataTermino; ?></li>
            <li><strong>Observações:</strong> <?php echo $observacoes; ?></li>
            <li><strong>Professor:</strong> <?php echo $nomeProfessor; ?></li>
            <li><strong>Curso:</strong> <?php echo $nomeCurso; ?></li>
            <li><strong>Dias de Aula:</strong> <?php echo $dias_aula_turma_texto; ?></li>
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
