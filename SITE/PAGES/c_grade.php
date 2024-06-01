<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Inclua seu arquivo de conexão com o banco de dados
include '../conexao.php';

// Array para armazenar as turmas do professor
$turmas = array();
$nome_professor = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Professor_id'])) {
    // Coleta o ID do professor selecionado
    $professor_id = $_POST['Professor_id'];
    
    // Consulta SQL para obter o nome do professor selecionado
    $sql_nome_professor = "SELECT Usuario_Nome FROM Usuario WHERE Usuario_id = $professor_id";
    $resultado_nome_professor = mysqli_query($conn, $sql_nome_professor);
    if ($linha = mysqli_fetch_assoc($resultado_nome_professor)) {
        $nome_professor = $linha['Usuario_Nome'];
    }
    
    // Consulta SQL para obter as turmas do professor selecionado
    $sql = "SELECT turma.turma_cod, turma.turma_horario, turma.turma_horario_termino, turma.turma_dias
            FROM turma
            WHERE turma.usuario_usuario_cd = $professor_id";  // Filtra pelo ID do professor selecionado
    
    $resultado = mysqli_query($conn, $sql);
    if (!$resultado) {
        die("Erro ao executar a consulta: " . mysqli_error($conn));
    }
    
    // Preenche o array com os dados das turmas
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $turmas[] = $linha;
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
        .turmas {
            background-color: #a5d6a7;
            padding: 5px;
        }
        .horario {
            border: 1px solid #ddd;
            background-color: #fff;
        }
        .horario .vago {
            background-color: #ff2222;
            padding: 5px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .professor-name {
            margin-bottom: 20px;
            text-align: center;
            font-size: 20px;
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
                <div class="php"><?php echo $date;?></div>
            </div>
            <div class="user"><?php echo $dropdown;?></div>
        </div>
        <hr>
    </header>
    <div><?php echo $sidebarHTML;?></div>
    <form method="post" action="">
        <label for="Professor_id">Selecione um professor:</label>
        <select id="Professor_id" name="Professor_id">
            <?php
            // Consulta SQL para obter os nomes dos professores
            $sql = "SELECT U.Usuario_id, U.Usuario_Nome FROM Usuario U
                    INNER JOIN Registro_Usuario RU ON U.Usuario_id = RU.Usuario_Usuario_cd
                    INNER JOIN Tipo T ON RU.Tipo_Tipo_cd = T.Tipo_id
                    WHERE T.Tipo_id = 4"; // Assumindo que o ID para professores é 4 na tabela Tipo

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["Usuario_id"] . "'>" . $row["Usuario_Nome"] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum professor encontrado</option>";
            }

            $conn->close();
            ?>
        </select>
        <input type="submit" value="Visualizar Grade">
    </form>

    <!-- Exibir o nome do professor -->
    <?php if (!empty($nome_professor)) : ?>
        <h2>Grade Horária do Professor: <?php echo $nome_professor; ?></h2>
    <?php endif; ?>

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
        <?php echo $redes;?>
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
