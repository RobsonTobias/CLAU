<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLAU - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="../PHP/sidebar/menu.css">
    <link rel="stylesheet" href="../STYLE/botao.css" />
    <link rel="stylesheet" href="../STYLE/data.css">
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .curso path {
            fill: #043140;
        }

        

        /* As linhas pares terão uma cor de fundo */
        tr:nth-child(even) {
            background-color: #D9D9D9;

            /* ou a cor clara de sua escolha */
        }

        /* As linhas ímpares terão outra cor de fundo */
        tr:nth-child(odd) {
            background-color: #B0B0B0;
            /* ou a cor escura de sua escolha */
        }

        /* Estilo para o hover que indica clicabilidade */
        tr:hover {
            background-color: #b4e0e0;
            /* ou a cor que deseja usar no hover */
            cursor: pointer;
            /* Altera o cursor para indicar que é clicável */
        }

        .row{
            flex-wrap: nowrap;
            align-items: flex-start;
        }
        



        main {
            margin: 0;
            padding: 0;
            margin-top: 2%;
            gap: 1rem;
        }

        .principal {
            background-color: #E7E7E7;
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 0 0.313rem 0.063rem #00000040;
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.375em;
            font-weight: bold;
            color: #233939;
            margin: 0;
        }

        p {
            margin: 0;
        }

        .teste {
            margin: 0;
        }

        .adicionar {
            border-radius: 50%;
            height: 1.25rem;
            width: 1.25rem;
            font-size: 1em;
            font-weight: bolder;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #4CAF50;
            border: none;
            color: #FFFFFF;
        }

        a p {
            color: #4CAF50;
            font-weight: bolder;
            margin-left: 0.5em;
        }

        a:hover {
            text-decoration: none;
            opacity: 0.5;
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

</head>

<body>

    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>RELATÓRIO DE CURSOS</h1>
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

    <main class="row">
        <div class="card principal">
            <div class="row justify-content-between teste">
                <p class="card-title">Lista de Cursos</p>
                <a href="s_curso_cad.php" class="row d-flex align-items-center teste">
                    <button class="adicionar" type="button">+</button>
                    <p>Adicionar Curso</p>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="">Curso</th>
                            <th class="text-center">Sigla</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM curso";
                        $resultado = $conn->query($sql);
                        if ($resultado && $resultado->num_rows > 0) {
                            while ($row = $resultado->fetch_assoc()) {
                                ?>
                                <tr data-id='"<?php $row['$curso_id']; ?>"'>
                                    <td class="text-left" onclick='mostrarDetalhes(this)'><?php echo $row['Curso_Nome']; ?></td>
                                    <td class="text-center"><?php echo $row['Curso_Sigla']; ?></td>
                                    <td class="text-center"><?php echo ($row['Curso_Status'] == 1 ? "Ativo" : "Inativo"); ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='2'>Nenhum curso encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card principal">
            <div class="card info">
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
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>

    <script>
        var selectedCursoId; // Variável global para armazenar o ID do usuário selecionado

        function mostrarDetalhes(elemento) {
            selectedCursoId = elemento.getAttribute('data-id'); // Atualiza a variável global

            $.ajax({
                url: '../PHP/det_curso.php',
                type: 'GET',
                data: { userId: selectedCursoId }, // Deve ser selectedUserId, não userId
                success: function (response) {
                    // Aqui você vai lidar com a resposta
                    exibirDetalhesUsuario(response);
                },
                error: function () {
                    alert("Erro ao obter dados do usuário.");
                }
            });
        }
    </script>
</body>

</html>