<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Resgata o ID do usuário logado
$usuarioId = $_SESSION['Usuario_id'];

// Consulta SQL para obter as turmas do professor logado
include '../conexao.php'; // Inclua seu arquivo de conexão com o banco de dados
$sql = "SELECT turma.turma_cod, turma.turma_horario, turma.turma_horario_termino, turma.turma_dias
        FROM turma
        WHERE turma.usuario_usuario_cd = $usuarioId";  // Filtra pelo ID do usuário logado

$resultado = mysqli_query($conn, $sql);
if (!$resultado) {
    die("Erro ao executar a consulta: " . mysqli_error($conn));
}

// Array para armazenar as turmas do professor
$turmas = array();

// Preenche o array com os dados das turmas
while ($linha = mysqli_fetch_assoc($resultado)) {
    $turmas[] = $linha;
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
        .grade path{
            fill: #043140;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color:#61d4a8;
        }
        /* Estilo para células com turma do professor */
        .turmas {
            background-color: #a5d6a7;
            padding: 5px; /* Espaçamento interno para melhor visualização */
        }

        .horario {
            border: 1px solid #ddd; /* Adicione uma borda para melhorar a aparência */
            background-color: #fff; /* Cor de fundo padrão */
        }

        .horario .vago {
            background-color: #ff2222; /* Cor de fundo vermelha para horários vagos */
            padding: 5px; /* Espaçamento interno para melhor visualização */
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
                <h1>GRADE HORÁRIA</h1>
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
                    // Verifica se há alguma turma do professor nesse horário e dia
                    $aula_encontrada = false;
                    foreach ($turmas as $turma) {
                        $diasAulaTurma = $turma['turma_dias'];
                        $dias_turma = str_split($diasAulaTurma); // Converte a string para um array de caracteres

                        $dia_numero_turma = intval($dia_numero);
                        $turma_inicio = strtotime($turma['turma_horario']);
                        $turma_termino = strtotime($turma['turma_horario_termino']);

                        if (in_array($dia_numero_turma, $dias_turma) && $i >= date('H', $turma_inicio) && $i < date('H', $turma_termino)) {
                            echo "<div class='turmas'>" . $turma['turma_cod'] . "</div>";
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
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
