<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 3){
    header("Location: ../logout.php");
}

include '../conexao.php';
include ('../PHP/data.php');
include ('../PHP/sidebar/menu.php');
include ('../PHP/redes.php');
include ('../PHP/dropdown.php');



$turmaCod = '';
$cursoCod = '';
$moduloId = '';

if (isset($_SESSION['Usuario_Nome'])) {
    $userAluno = $_SESSION['Usuario_id'];
    $sqlNotas = 'select
        n.nota,
        ROUND((COUNT(CASE WHEN ch.presenca = 1 THEN 1 END) / COUNT(*) * 100), 0) AS Porcentagem_Presenca,
        t.Turma_Cod,
        c.Curso_Nome,
        m.Modulo_Nome,
        date_format(t.Turma_Inicio, "%m/%Y") as "Ano de Inicio"
    FROM
        notas n
    INNER JOIN
        Aluno_Turma at ON n.id_aluno_turma = at.Aluno_Turma_id
    INNER JOIN
        Turma t ON at.Turma_Turma_Cod = t.Turma_Cod
    INNER JOIN
        Curso c ON t.Curso_cd = c.Curso_id
    INNER JOIN
        Modulo m ON n.id_modulo = m.Modulo_id
    INNER JOIN
        Usuario u ON at.Usuario_Usuario_cd = u.Usuario_id
    LEFT JOIN
        chamada ch ON n.id_aluno_turma = ch.id_aluno_turma
        where Usuario_id = "' . $userAluno . '"
        GROUP BY
        u.Usuario_Nome, n.nota, t.Turma_Cod, c.Curso_Nome, m.Modulo_Nome, t.Turma_Inicio
        order by Curso_Nome, Modulo_Nome asc;';
    $resultadoNota = mysqli_query($conn, $sqlNotas);

    if (!$resultadoNota) {
        die("Erro ao executar a consulta: " . mysqli_error($conn));
    }
}

if (isset($_SESSION['Usuario_Nome'])) {
    $sqlNomear = 'select
        Usuario_Nome,
        Usuario_Matricula
        from Usuario
        where Usuario_id = "' . $userAluno . '";';
    $nomear = mysqli_query($conn, $sqlNomear);

    if (!$nomear) {
        die("Erro ao executar a consulta: " . mysqli_error($conn));
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
    <link rel="stylesheet" href="../STYLE/style_table.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .notas path {
            fill: #043140;
        }
    </style>
</head>

<body>

    

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>SUAS NOTAS</h1>
                <div class="php">
                    <?php echo $date; ?><!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown; ?><!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>

    <main>
    <div class="geral">
        <div class="info">
        <h2>
        <?php 
            $n = mysqli_fetch_assoc($nomear);
            echo $n['Usuario_Nome'];
        ?>
        </h2>
        <h2>Matricula N°: #
        <?php
            echo $n['Usuario_Matricula'];
        ?>
        </h2>
        </div>
    <table class="table">
                        <thead>
                            <tr>
                                <th>Modulo</th>
                                <th>Curso</th>
                                <th>Sua nota</th>
                                <th>Sua presença</th>
                                <th>Turma</th>
                                <th>Ano de Inicio</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($resultadoNota == null){
                            echo 'Sem nada aqui';
                        } else{
                        while ($l = mysqli_fetch_assoc($resultadoNota)) {
                        ?>
                                <tr>
                                    <td>
                                        <?php echo $l['Modulo_Nome']; ?>
                                    </td>

                                    <td>
                                        <?php echo $l['Curso_Nome']; ?>
                                    </td>

                                    <td>
                                        <?php echo $l['nota']; ?>
                                    </td>

                                    <td>
                                        <?php echo $l['Porcentagem_Presenca'],"%"?>
                                    </td>

                                    <td>
                                        <?php echo $l['Turma_Cod']; ?>
                                    </td>
                                    
                                    <td>
                                        <?php echo $l['Ano de Inicio']; ?>
                                    </td>    
                            <?php } }?>
                        </tbody>
    </table>
    </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>