<?php
include '../conexao.php';
include '../PHP/data.php';
include '../PHP/sidebar/menu.php';
include '../PHP/redes.php';
include '../PHP/dropdown.php';

function SelecionandoTurma()
{
    global $conn;

    $sqlTurmaSelect = 'SELECT Turma_Cod FROM Turma';
    $turmaSelecionada = mysqli_query($conn, $sqlTurmaSelect);

    // Retornar o resultado da consulta SQL
    return $turmaSelecionada;
}

function AlunosFaltosos($turmaSelecionada)
{
    global $conn;

    if (isset($_POST['turma'])) {
        // Extrair o valor da turma selecionada
        $turmaSelecionada = $_POST['turma'];

        $sql = 'SELECT AT.*, T.*, C.*,
                    U.Usuario_Nome AS aluno,
                    (SELECT ROUND((COUNT(CASE WHEN presenca = 1 THEN 1 END) / COUNT(*) * 100), 0) as frequencia
                    FROM chamada
                    WHERE AT.Turma_Turma_Cod = "' . $turmaSelecionada . '") as frequencia
                FROM Aluno_Turma AT 
                JOIN Turma T ON AT.Turma_Turma_Cod = T.Turma_Cod 
                JOIN Curso C ON T.Curso_cd = C.Curso_id 
                JOIN Usuario U ON T.Usuario_Usuario_cd = U.Usuario_id
                HAVING frequencia < 75';

        $alunosFaltosos = mysqli_query($conn, $sql);

        return $alunosFaltosos;
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
        .aluno path {
            fill: #043140;
        }
    </style>
</head>

<body>
    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>ALUNOS FALTOSOS</h1>
                <div class="php">
                    <?php echo $date; ?>
                </div>
            </div>
            <div class="user">
                <?php echo $dropdown; ?>
            </div>
        </div>
        <hr>
    </header>
    <div>
        <?php echo $sidebarHTML; ?>
    </div>
    <main>
        <form method="post">
            <select class="form-control" name="turma" required id="turma">
                <option disabled selected>Selecione a turma</option>
                <?php
                $listar1 = SelecionandoTurma();
                while ($l1 = $listar1->fetch_assoc()) {
                    echo '<option value ="' . $l1["Turma_Cod"] . '">' . $l1["Turma_Cod"] . '</option>';
                }
                ?>
            </select>
            <input type="submit"value="Pesquisar">
        </form>
        <table>
            <thead>
                <tr>
                    <th>Nome do aluno</th>
                    <th>Presença</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_POST['turma'])) {
                    $turmaSelecionada = $_POST['turma'];
                    $alunosFaltosos = AlunosFaltosos($turmaSelecionada);
                    if ($alunosFaltosos && mysqli_num_rows($alunosFaltosos) > 0) {
                        while ($l = mysqli_fetch_assoc($alunosFaltosos)) {
                            echo '<tr>';
                            echo '<td>' . $l['aluno'] . '</td>';
                            echo '<td>' . $l['frequencia'] . '%</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="2">Nenhum aluno faltoso encontrado.</td></tr>';
                    }
                } else {
                    echo '<tr><td colspan="2">Selecione uma turma para visualizar os alunos faltosos.</td></tr>';
                }
                ?>
            </tbody>
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
