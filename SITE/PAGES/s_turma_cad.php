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
        .turma path {
            fill: #043140;
        }

        /* Estilo para o formulário */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            /* Defina a largura desejada */
            max-width: 800px;
            /* Defina a largura máxima se necessário */
            margin: 0 auto;
            /* Centraliza o formulário na página */
            display: flex;
            flex-direction: column;
            /* Organiza os campos em uma única coluna */
        }

        form label {
            font-weight: bold;
            color: #043140;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="time"],
        form input[type="date"],
        form select,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form select {
            cursor: pointer;
        }

        form textarea {
            height: 100px;
        }

        /* Botão de enviar */
        form input[type="submit"] {
            background-color: #043140;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #024028;
        }

        /* Estilo para o campo de texto do código dos dias selecionados */
        #codigo_dias {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #043140;
        }
    </style>
</head>

<body>

    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CADASTRO DE TURMAS</h1>
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
        <h2>Cadastro de Turmas</h2>
        <form action="../PHP/cad_turma.php" method="post">
            <label for="Turma_Cod">Código da Turma:</label>
            <input type="text" id="Turma_Cod" name="Turma_Cod" readonly required><br><br>
            <label for="Turma_Inicio">Curso</label>
            <select id="Curso_id" name="Curso_id" onchange="atualizarCodigoTurma()">
                <?php
                // Conexão com o banco de dados
                include '../conexao.php';

                // Verifica a conexão
                if ($conn->connect_error) {
                    die("Conexão falhou: " . $conn->connect_error);
                }

                // Consulta SQL para obter os nomes e siglas dos cursos
                $sql = "SELECT Curso_id, Curso_Nome, Curso_Sigla FROM Curso";
                $result = $conn->query($sql);

                // Loop para exibir os resultados como opções no menu suspenso
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["Curso_Sigla"] . "'>" . $row["Curso_Nome"] . "</option>";
                    }
                } else {
                    echo "<option>Nenhum curso encontrado</option>";
                }

                // Fecha a conexão com o banco de dados
                $conn->close();
                ?>
            </select>

            <label for="Turma_Horario">Horário de inicio:</label>
            <input type="time" id="Turma_Horario_inicio" name="Turma_Horario_inicio" required><br><br>
            <label for="Turma_Horario">Horário de termino:</label>
            <input type="time" id="Turma_Horario_termino" name="Turma_Horario_termino" required><br><br>

            <label for="Turma_Vagas">Vagas:</label>
            <input type="number" id="Turma_Vagas" name="Turma_Vagas" required><br><br>

            <label for="Turma_Dias">Dias:</label><br>
            <?php
            // Array de dias da semana
            $dias_semana = array(
                1 => 'Segunda-feira',
                2 => 'Terça-feira',
                3 => 'Quarta-feira',
                4 => 'Quinta-feira',
                5 => 'Sexta-feira',
                6 => 'Sábado'
            );

            // Loop para exibir os dias da semana como caixas de seleção
            foreach ($dias_semana as $id_dia => $nome_dia) {
                echo "<label><input type='checkbox' name='Turma_Dias[]' value='$id_dia'>$nome_dia</label><br>";
            }
            ?>
            <br>
            <!-- Campo de texto para mostrar os dias selecionados -->
            <input type="hidden" id="codigo_dias" name="codigo_dias" readonly>
            <br>

            <label for="Turma_Obs">Observações:</label>
            <textarea id="Turma_Obs" name="Turma_Obs"></textarea><br><br>

            <label for="Turma_Inicio">Data de Início:</label>
            <input type="date" id="Turma_Inicio" name="Turma_Inicio" required><br><br>



            <label for="Turma_Termino">Data de Término:</label>
            <input type="date" id="Turma_Termino" name="Turma_Termino" required><br><br>
            <label for="Professor_id">Professor:</label>
            <select id="Professor_id" name="Professor_id">
                <?php
                // Conexão com o banco de dados
                include '../conexao.php';

                // Consulta SQL para obter os nomes dos professores
                $sql = "SELECT U.Usuario_id, U.Usuario_Nome FROM Usuario U
                        INNER JOIN Registro_Usuario RU ON U.Usuario_id = RU.Usuario_Usuario_cd
                        INNER JOIN Tipo T ON RU.Tipo_Tipo_cd = T.Tipo_id
                        WHERE T.Tipo_id = 4"; // Assumindo que o ID para professores é 4 na tabela Tipo
                // Aqui estamos assumindo que o ID do tipo 'Professor' é 4
                
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
            </select><br><br>
            <input type="submit" value="Enviar">
        </form>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script>
        // Script para atualizar o campo de texto com os dias selecionados
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const codigoDias = document.getElementById('codigo_dias');

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    let codigo = '';
                    checkboxes.forEach(function (cb) {
                        if (cb.checked) {
                            codigo += cb.value;
                        }
                    });
                    codigoDias.value = codigo;
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const horarioInicioInput = document.getElementById('Turma_Horario_inicio');
            const dataInicioInput = document.getElementById('Turma_Inicio');
            const codigoTurmaInput = document.getElementById('Turma_Cod');

            // Monitore mudanças nos inputs relevantes e nos checkboxes
            horarioInicioInput.addEventListener('change', atualizarCodigoTurma);
            dataInicioInput.addEventListener('change', atualizarCodigoTurma);
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', atualizarCodigoTurma);
            });

            function atualizarCodigoTurma() {
                const cursoSelect = document.getElementById('Curso_id');
                const siglaCurso = cursoSelect.value; // Agora pega a sigla diretamente do select
                const horarioInicio = horarioInicioInput.value;
                const dataInicio = new Date(dataInicioInput.value);
                let diasCodigo = '';
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                    diasCodigo += checkbox.value;
                });

                const horarioCodigo = horarioInicio.replace(':', '').substring(0, 2);
                const mesInicio = (dataInicio.getMonth() + 1).toString().padStart(2, '0');
                const anoInicio = dataInicio.getFullYear().toString().substring(2, 4);

                const codigoTurma = `${siglaCurso}${horarioCodigo}${diasCodigo}${mesInicio}${anoInicio}`;
                codigoTurmaInput.value = codigoTurma;
            }

            // Inicializa o código da turma ao carregar a página, caso já existam valores predefinidos
            atualizarCodigoTurma();
        });

    </script>
</body>

</html>