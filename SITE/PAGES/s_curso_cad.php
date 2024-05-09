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
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .curso path {
            fill: #043140;
        }

        label {
            width: 100%;
        }

        input {
            width: 100%;
        }

        /* main {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        } */

        /* form {
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
        /* .alert {
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
        } */
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

    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

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
        <!-- <a class="back-link" href="s_curso_consulta.php"> < </a> -->
        <div class="geral">
            <p>Novo Curso</p>
            <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                <div class="info">
                    <div class="dados">
                        <div class="linha">
                            <label for="nome">
                                <p>Nome do Curso:</p>
                                <input type="text" id="nome" name="nome" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="sigla">
                                <p>Sigla:</p>
                                <input type="text" id="sigla" name="sigla" maxlength="3" required>
                            </label>
                            <label for="carga_horaria">
                                <p>Carga Horária:</p>
                                <input type="number" id="carga_horaria" name="carga_horaria"
                                    oninput="limitarValor(this,400)" required>
                            </label>
                            <label for="duracao">
                                <p>Duração (em meses):</p>
                                <input type="number" id="duracao" name="duracao" min="0" oninput="limitarValor(this,36)"
                                    required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="pre_requisito">
                                <p>Pré-requisito:</p>
                                <input id="pre_requisito" name="pre_requisito" rows="4" cols="50" required></input>
                            </label>
                        </div>
                        <div>
                            <label for="descricao" class="obs_aluno">
                                <p>Descrição:</p>
                                <textarea id="descricao" name="descricao" placeholder="Descrição do curso"
                                    required style="width: 100%;"></textarea>
                            </label>
                        </div>








                        <h2>Adicionar Módulos</h2>

                        <div id="camposModulos">
                            <div class="campoModulo">
                                <label for="modulo">Módulo:</label>
                                <input type="text" name="modulos[]" required>
                                <button type="button" onclick="adicionarCampoModulo()">Adicionar Módulo</button>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </form>



            <div class="botao func">
                <button class="cadastrar" type="submit">CADASTRAR</button>
                <button class="limpar" type="button" onclick="limpar()">LIMPAR</button>
            </div>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/utils.js"></script>
    <script>
        $(document).ready(function () {
            $("#form").on("submit", function (e) {
                e.preventDefault(); // Impede o envio normal do formulário

                var formData = new FormData(this);

                $.ajax({
                    url: '../PHP/cad_curso.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Cadastro realizado com sucesso!")) {
                            $('#form').trigger("reset"); // Limpa o formulário
                            alert("Cadastro realizado com sucesso!"); // Exibe um alerta de sucesso
                            window.location.href = "s_curso_detalhes.php"; // Redireciona para a nova página
                        } else {
                            alert(response); // Exibe outros alertas retornados pelo servidor
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });

        function limpar() {
            // Adicione a lógica para limpar os campos do formulário aqui
            document.getElementById('form').reset();

        }

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
</body>

</html>