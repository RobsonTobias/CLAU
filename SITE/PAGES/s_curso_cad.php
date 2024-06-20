<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
$home = 's_curso.php';
$titulo = 'CADASTRO DE CURSO'; //Título da página, que fica sobre a data
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

        .campoModulo label {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .adicionarModulo {
            border-radius: 50%;
            height: 20px;
            width: 20px;
            font-size: 16px;
            font-weight: bolder;
            display: flex;
            justify-content: center;
            background-color: #4CAF50;
            border: none;
            color: #FFFFFF;
        }

        .removerModulo {
            border-radius: 50%;
            height: 20px;
            width: 20px;
            font-size: 16px;
            font-weight: bolder;
            display: flex;
            justify-content: center;
            background-color: #F24E1E;
            border: none;
            color: #FFFFFF;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php require_once '../COMPONENTS/header.php' ?>

    <main>
        <!-- <a class="back-link" href="s_curso_consulta.php"> < </a> -->
        <div class="geral">
            <p>Novo Curso</p>
            <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                <div class="info">
                    <div class="dados">
                        <div class="linha">
                            <label for="nome">
                                <p>NOME DO CURSO:</p>
                                <input type="text" id="nome" name="nome" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="sigla">
                                <p>SIGLA:</p>
                                <input type="text" id="sigla" name="sigla" maxlength="3" required>
                            </label>
                            <label for="carga_horaria">
                                <p>CARGA HORÁRIA:</p>
                                <input type="number" id="carga_horaria" name="carga_horaria"
                                    oninput="limitarValor(this,400)" required>
                            </label>
                            <label for="duracao">
                                <p>DURAÇÃO (meses):</p>
                                <input type="number" id="duracao" name="duracao" min="0" oninput="limitarValor(this,36)"
                                    required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="pre_requisito">
                                <p>PRÉ-REQUISITO:</p>
                                <input id="pre_requisito" name="pre_requisito" rows="4" cols="50"
                                    value="Sem pré-requisito!"></input>
                            </label>
                        </div>
                        <div>
                            <label for="descricao" class="obs_aluno">
                                <p>DESCRIÇÃO:</p>
                                <textarea id="descricao" name="descricao" placeholder="Descrição do curso" required
                                    style="width: 100%;"></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <div class="dados" style="width: 100%; gap: 5px;">
                        <div class="linha" style="gap:5px;">
                            <p>ADICIONAR MÓDULOS</p>
                            <button class="adicionarModulo" type="button" onclick="adicionarCampoModulo()">+</button>
                        </div>
                        <div class="modulo" id="camposModulos">
                            <div class="campoModulo">
                                <label for="modulo">
                                    <p>Módulo:</p>
                                    <input type="text" name="modulos[]" required>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="botao func">
                    <button class="cadastrar" type="submit">CADASTRAR</button>
                    <button class="limpar" type="button" onclick="limpar()">LIMPAR</button>
                </div>
            </form>


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
                            window.location.href = "s_curso_consulta.php"; // Redireciona para a nova página
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
            novoCampo.appendChild(label);

            var p = document.createElement('p');
            p.textContent = 'Módulo:';
            label.appendChild(p);

            var input = document.createElement('input');
            input.type = 'text';
            input.name = 'modulos[]';
            input.required = true;
            label.appendChild(input);

            var botaoRemover = document.createElement('button');
            botaoRemover.type = 'button';
            botaoRemover.textContent = '-';
            botaoRemover.classList.add('removerModulo');
            botaoRemover.onclick = function () {
                divCampos.removeChild(novoCampo);
            };
            label.appendChild(botaoRemover);

            divCampos.appendChild(novoCampo);
        }
    </script>
</body>

</html>