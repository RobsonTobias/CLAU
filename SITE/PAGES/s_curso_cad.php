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
        .curso path {
            fill: #043140;
        }

        main {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        label,
        input,
        textarea {
            width: calc(50% - 7.5px);
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Estilos dos alertas */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #043140;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .back-link:hover {
            background-color: #035A70;
        }
    </style>
    <script>
        function limitarValor(input, limite) {
        if (input.value > limite) {
            input.value = limite;
        }
    }
    </script>

</head>

<body>

    <?php include('../PHP/data.php'); ?>
    <?php include('../PHP/sidebar/menu.php'); ?>
    <?php include('../PHP/redes.php'); ?>
    <?php include('../PHP/dropdown.php'); ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CADASTRO DE CURSOS</h1>
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
        <a class="back-link" href="s_curso_consulta.php">
            <</a>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                    <label for="nome">Nome do Curso:</label>
                    <input type="text" id="nome" name="nome" required><br><br>

                    <label for="sigla">Sigla:</label>
                    <input type="text" id="sigla" name="sigla" maxlength="3" required><br><br>

                    <label for="carga_horaria">Carga Horária:</label>
                    <input type="number" id="carga_horaria" name="carga_horaria" oninput="limitarValor(this,400)" required><br><br>

                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" required><br><br>

                    <label for="duracao">Duração (em meses):</label>
                    <input type="number" id="duracao" name="duracao" min="0" oninput="limitarValor(this,36)" required><br><br>

                    <label for="pre_requisito">Pré-requisito:</label>
                    <textarea id="pre_requisito" name="pre_requisito" rows="4" cols="50" required></textarea><br><br>

                    <h2>Adicionar Módulos</h2>

                    <div id="camposModulos">
                        <div class="campoModulo">
                            <label for="modulo">Módulo:</label>
                            <input type="text" name="modulos[]" required>
                            <button type="button" onclick="adicionarCampoModulo()">Adicionar Módulo</button>
                        </div>
                    </div>

                    <input type="submit" name="submit" value="Registrar Curso e Módulos">

                </form>


                <script>
                    function adicionarCampoModulo() {
                        var divCampos = document.getElementById('camposModulos');

                        var novoCampo = document.createElement('div');
                        novoCampo.classList.add('campoModulo');

                        var label = document.createElement('label');
                        label.textContent = 'Módulo:';
                        novoCampo.appendChild(label);

                        var input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'modulos[]';
                        input.required = true;
                        novoCampo.appendChild(input);

                        var botaoRemover = document.createElement('button');
                        botaoRemover.type = 'button';
                        botaoRemover.textContent = 'Remover';
                        botaoRemover.onclick = function () {
                            divCampos.removeChild(novoCampo);
                        };
                        novoCampo.appendChild(botaoRemover);

                        divCampos.appendChild(novoCampo);
                    }
                </script>

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "CLAU";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Verificando a conexão
                    if ($conn->connect_error) {
                        die("Conexão falhou: " . $conn->connect_error);
                    }

                    // Inserir informações do curso
                    $nome = $_POST['nome'];
                    $sigla = $_POST['sigla'];
                    $carga_horaria = $_POST['carga_horaria'];
                    $descricao = $_POST['descricao'];
                    $duracao = $_POST['duracao'];
                    $pre_requisito = $_POST['pre_requisito'];

                    $sql_curso = "INSERT INTO curso (Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito)
            VALUES ('$nome', '$sigla', '$carga_horaria', '$descricao', '$duracao', '$pre_requisito')";

                    if ($conn->query($sql_curso) === TRUE) {
                        echo "<script>alert('Curso inserido com sucesso!')</script>";
                        $curso_id = $conn->insert_id; // Obtém o ID do curso inserido
                
                        // Inserir informações dos módulos (se existirem)
                        if (isset($_POST['modulos'])) {
                            $modulos = $_POST['modulos'];

                            foreach ($modulos as $modulo_nome) {
                                // Verificar se o módulo já existe na tabela
                                $sql_verificar_modulo = "SELECT Modulo_id FROM modulo WHERE Modulo_Nome = '$modulo_nome'";
                                $result = $conn->query($sql_verificar_modulo);

                                if ($result->num_rows > 0) {
                                    // O módulo já existe na tabela, obter o ID do módulo existente
                                    $row = $result->fetch_assoc();
                                    $modulo_id = $row["Modulo_id"];
                                } else {
                                    // O módulo não existe na tabela, inseri-lo
                                    $sql_inserir_modulo = "INSERT INTO modulo (Modulo_Nome, Modulo_Desc, Modulo_Registro, Modulo_Status)
                                        VALUES ('$modulo_nome', 'Descrição do módulo', current_timestamp(), '1')";

                                    if ($conn->query($sql_inserir_modulo) === TRUE) {
                                        // Obter o ID do módulo recém-inserido
                                        $modulo_id = $conn->insert_id;
                                    } else {
                                        echo "Erro ao inserir módulo: " . $conn->error;
                                    }
                                }

                                // Associar o módulo ao curso na tabela modulo_curso
                                $sql_associar_modulo_curso = "INSERT INTO modulo_curso (Modulo_Modulo_cd, Curso_Curso_cd, Modulo_Curso_Registro)
                                            VALUES ('$modulo_id', '$curso_id', current_timestamp())";

                                if ($conn->query($sql_associar_modulo_curso) !== TRUE) {
                                    echo "Erro ao associar módulo ao curso: " . $conn->error;
                                }
                            }
                        }
                    } else {
                        echo "Erro ao inserir curso: " . $conn->error;
                    }

                    $conn->close(); // Fecha a conexão com o banco de dados
                }
                ?>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/utils.js"></script>
</body>

</html>