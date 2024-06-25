<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$home = 's_home.php';
$titulo = 'RELATÓRIO DE TURMAS';
$paginaDestino = 's_turma_cad.php';
$elemento = 'Turma';
?>

<style>
    .turma path {
        fill: #043140;
    }
</style>

<body>

    <?php require_once '../COMPONENTS/header.php' ?>




    <div class="container-fluid justify-content-center">
        <div class="d-flex form-group justify-content-center mt-3" style="margin-left: 76px;">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group d-flex justify-content-between align-items-center">
                            <div class="col-sm">
                                <h5>Lista de Turmas</h5>
                            </div>
                            <div><?php require_once '../COMPONENTS/add2.php'; ?></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Código da Turma</th>
                                        <th class="text-center">Horário</th>
                                        <th class="text-center">Vagas</th>
                                        <th class="text-center">Dias</th>
                                        <th class="text-center">Início</th>
                                        <th class="text-center">Ações</th> <!-- Nova coluna para os botões -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Consulta SQL para obter todas as turmas
                                    $query = "SELECT * FROM Turma where turma_status = 1";

                                    // Executar a consulta
                                    $result = mysqli_query($conn, $query);

                                    // Verificar se a consulta retornou algum resultado
                                    if (mysqli_num_rows($result) > 0) {
                                        // Loop através de todas as linhas da tabela
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['Turma_Cod'] . "</td>";
                                            echo "<td class='text-center'>" . date('H:i', strtotime($row['Turma_Horario'])) . "</td>";
                                            echo "<td class='text-center'>" . $row['Turma_Vagas'] . "</td>";
                                            echo "<td class='text-center'>" . $row['Turma_Dias'] . "</td>";
                                            echo "<td class='text-center'>" . date('d/m/Y', strtotime($row['Turma_Inicio'])) . "</td>"; // Data no formato brasileiro
                                            echo "<td class='text-center'><a href='s_turma_detalhes.php?id=" . $row['Turma_Cod'] . "' class='btn btn-primary btn-sm'>Detalhes</a></td>"; // Link para detalhes da turma
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6'>Nenhuma turma encontrada</td></tr>";
                                    }

                                    // Fechar a conexão com o banco de dados
                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>