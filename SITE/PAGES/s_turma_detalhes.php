<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
$home = 's_turma.php';
$titulo = 'DETALHES DA TURMA'; //Título da página, que fica sobre a data
?>
    <style>
        .turma path {
            fill: #043140;
        }

        main {
            display: flex;
            flex-direction: row;
        }

        .informacoes {
            gap: 20px;
        }

        .informacao p {
            font-size: 18px;
            font-weight: bold;
            color: #233939;
            min-width: 600px;
        }

        .linha {
            margin-top: 5px;
        }

        .infofuncionario {
            padding: 10px;
        }
        .texto{
            color: #212529;
        }
        p{
            margin-bottom: 0;
        }
    </style>

<body>

    <?php
    // Inclua aqui os arquivos PHP necessários
    // Aqui você pode incluir sua conexão com o banco de dados, por exemplo:
    include '../conexao.php';

    // Verifica se uma sessão já está ativa
    if (session_status() == PHP_SESSION_NONE) {
        // Se não houver sessão ativa, inicia a sessão
        session_start();
    }

    if (isset($_GET['id'])) {
        $id_turma = $_GET['id'];

        // Consulta SQL para obter os detalhes da turma com o ID fornecido
        $query = "SELECT Turma.*, curso.curso_nome AS Nome_Curso, Usuario.Usuario_Nome AS Nome_Professor,  COUNT(Aluno_Turma.Usuario_Usuario_cd) AS matriculados
                  FROM Turma
                  INNER JOIN curso ON Turma.curso_cd = curso.curso_id
                  INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_ID
                  LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
                  WHERE Turma.Turma_Cod = '$id_turma'";

        // Executar a consulta
        $result = mysqli_query($conn, $query);

        // Verificar se a consulta retornou algum resultado
        if (mysqli_num_rows($result) > 0) {
            // Extrair os dados da turma
            $turma = mysqli_fetch_assoc($result);

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
            $turma_dias = $turma['Turma_Dias'];
            $dias_turma = str_split($turma_dias); // Converte a string para um array de caracteres
    
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
    }
    ?>

<?php require_once '../COMPONENTS/header.php' ?>

    <main class="ajuste">
        <div class="pesquisa">
            <p>Alunos</p>
            <table class="table table-hover">
                <tr>
                    <th>MATRÍCULA</th>
                    <th>NOME</th>
                </tr>
                <?php
                $sql = "SELECT Usuario_id, Usuario_Matricula, Usuario_Nome FROM Usuario
                    INNER JOIN Aluno_Turma ON Usuario.Usuario_id = Aluno_Turma.Usuario_Usuario_cd
                    Where Aluno_Turma.Turma_Turma_Cod = '$id_turma' AND Aluno_Turma_Status = 1";

                $contador = 0;
                $resultado = $conn->query($sql);
                if ($resultado && $resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        $classeLinha = ($contador % 2 == 0) ? 'linha-par' : 'linha-impar';
                        echo "<tr data-id='" . $row["Usuario_id"] . "' class='" . $classeLinha . " apagado'>";
                        echo "<td class='nomeusuario'>" . $row["Usuario_Matricula"] . "</td>";
                        echo "<td class='emailusuario'>" . $row["Usuario_Nome"] . "</td>";
                        echo "</tr>";
                        $contador++;
                    }

                    $frequencia = "SELECT t.Turma_Cod, 
                        COUNT(c.presenca) AS Total_Chamadas, 
                        SUM(c.presenca = '1') AS Presencas, 
                        (SUM(c.presenca = '1') / COUNT(c.presenca)) * 100 AS Porcentagem_Presenca
                    FROM chamada c
                    JOIN aula a ON c.id_aula = a.id_aula
                    JOIN Turma t ON a.cod_turma = t.Turma_Cod
                    WHERE t.Turma_Cod = '$id_turma' GROUP BY t.Turma_Cod;";
                    $resultado_frequencia = $conn->query($frequencia);

                } else {
                    echo "<tr><td colspan='2'>Nenhum aluno encontrado.</td></tr>";
                }
                ?>
            </table>
        </div>
        <div class="informacoes">
            <div class="informacao">
                <p>Informações Gerais</p>
                <div class="infofuncionario">
                    <div class="col1 modal1">Curso: <div class="texto">
                            <?php echo $turma['Nome_Curso']; ?>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 modal1">Turma: <div class="texto">
                                <?php echo $turma['Turma_Cod']; ?>
                            </div>
                        </div>
                        <div class="col2 modal1">Professor: <div class="texto">
                                <?php echo $turma['Nome_Professor']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 modal1">Início: <div class="texto">
                                <?php echo date('d/m/Y', strtotime($turma['Turma_Inicio'])); ?>
                            </div>
                        </div>
                        <div class="col2 modal1">Término: <div class="texto">
                                <?php echo date('d/m/Y', strtotime($turma['Turma_Termino'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 modal1">Horário: <div class="texto">
                                <?php echo date('H:i', strtotime($turma['Turma_Horario'])); ?>h
                            </div>
                        </div>
                        <div class="col2 modal1">Dias de aula: <div class="texto">
                                <?php echo $dias_aula_turma_texto; ?>
                            </div>
                        </div>
                    </div>
                    <div class="obs-func" style="margin-inline: 0; margin-top: 5px;">
                        <p><?php echo $turma['Turma_Obs']; ?></p>
                    </div>
                </div>
            </div>
            <div class="informacao" style="margin-top: 20px;">
                <p>Informações Acadêmicas</p>
                <div class="infofuncionario">
                    <div class="linha" style="margin-top: 0;">
                        <div class="col1 modal1">Alunos matriculados: <div class="texto">
                                <?php echo $turma['matriculados']; ?>
                            </div>
                        </div>
                        <div class="col2 modal1">Máximo de alunos: <div class="texto">
                                <?php echo $turma['Turma_Vagas']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 modal1">Frequência:
                            <div class="texto"> <?php $resultado_frequencia ?> % </div>&nbsp;&nbsp;
                            <div class="barra-frequencia-container">
                                <div class="barra-frequencia" style="width:'<?php $resultado_frequencia ?>;%'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../JS/Utils.js"></script>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const linhas = document.querySelectorAll('.pesquisa .table tr[data-id]');
            linhas.forEach(function (linha) {
                linha.addEventListener('click', function () {
                    const alunoId = this.getAttribute('data-id');
                    // Chamada AJAX para configurar a sessão
                    $.ajax({
                        url: '../PHP/set_usuario_session.php',
                        type: 'GET',
                        data: { userId: alunoId },
                        success: function (response) {
                            console.log(response); // Log da resposta
                            window.location.href = `s_alunos_info.php?id=${alunoId}`; // Redirecionamento após configuração da sessão
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>