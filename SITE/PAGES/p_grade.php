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

// Consulta SQL para obter as turmas do professor logado
include '../conexao.php';
$sql = "SELECT turma.turma_cod, turma.turma_horario, turma.turma_horario_termino, turma.turma_dias
        FROM turma
        WHERE turma.usuario_usuario_cd = $usuarioId and turma_status = 1";

$resultado = mysqli_query($conn, $sql);
if (!$resultado) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}

// Array para armazenar as turmas do professor
$turmas = array();
while ($linha = mysqli_fetch_assoc($resultado)) {
    $turmas[] = $linha;
}

// Definindo um array com 20 cores pastéis
$cores = array(
    '#8c78ff', '#649bfa', '#97f7ad', '#f1fa93', '#4e87bf',
    '#3a593d', '#F8BBD0', '#FFCCBC', '#C8E6C9', '#FFF9C4',
    '#FFECB3', '#D1C4E9', '#B39DDB', '#E1BEE7', '#F48FB1',
    '#FFAB91', '#FFCC80', '#FFE082', '#FFF176', '#AED581'
);

// Array para armazenar as cores das turmas
$cores_turmas = array();

// Associa uma cor pastel a cada turma
foreach ($turmas as $index => $turma) {
    $cores_turmas[$turma['turma_cod']] = $cores[$index % count($cores)];
}

$titulo = 'GRADE HORÁRIA';
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
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 4px;
        }
        th {
            background-color:#61d4a8;
        }
        .horario .vago {
            background-color: #f96e6e;
            padding: 5px;
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
        <?php echo $sidebarHTML; ?>
    </div>

    <main>
        <table>
            <tr>
                <th class="invisible"></th>
                <?php
                $dias_semana = array(
                    1 => 'Segunda-feira',
                    2 => 'Terça-feira',
                    3 => 'Quarta-feira',
                    4 => 'Quinta-feira',
                    5 => 'Sexta-feira',
                    6 => 'Sábado'
                );

                foreach ($dias_semana as $dia) {
                    echo "<th>$dia</th>";
                }
                ?>
            </tr>
            <?php
            for ($i = 8; $i <= 20; $i++) {
                $hora = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";
                echo "<tr>";
                echo "<td>$hora</td>";
                foreach ($dias_semana as $dia_numero => $dia_nome) {
                    echo "<td class='horario'>";
                    $aula_encontrada = false;
                    foreach ($turmas as $turma) {
                        $diasAulaTurma = $turma['turma_dias'];
                        $dias_turma = str_split($diasAulaTurma);

                        $dia_numero_turma = intval($dia_numero);
                        $turma_inicio = strtotime($turma['turma_horario']);
                        $turma_termino = strtotime($turma['turma_horario_termino']);

                        if (in_array($dia_numero_turma, $dias_turma) && $i >= date('H', $turma_inicio) && $i < date('H', $turma_termino)) {
                            $codigo_turma = $turma['turma_cod'];
                            $cor_turma = $cores_turmas[$codigo_turma]; // Pega a cor associada à turma
                            echo "<div style='background-color: {$cor_turma}; padding: 5px;'>" . $codigo_turma . "</div>";
                            $aula_encontrada = true;
                            break;
                        }
                    }
                    if (!$aula_encontrada) {
                        echo "<div class='vago'>Vago</div>";
                    }
                    echo "</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </main>

    <div class="buttons">
        <?php echo $redes; ?>
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
