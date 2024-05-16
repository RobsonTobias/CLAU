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

        .top {
            position: relative;
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: flex-end;
        }

        .top a {
            text-decoration: none;
            color: #4CAF50;
            position: absolute;
            right: 11%;
            bottom: 3px;
            display: flex;
            transition: 0.2s ease-in-out;
        }

        .top a:hover {
            opacity: 0.5;
        }

        .top a img {
            margin-right: 3px;
        }


        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            /* Centraliza a tabela */
            border-radius: 15px;
        }

        th {
            background-color: #f2f2f2;
            color: #000;

            /* ou a cor desejada para o texto do cabeçalho */
        }

        /* As linhas pares terão uma cor de fundo */
        tr:nth-child(even) {
            background-color: #eee;

            /* ou a cor clara de sua escolha */
        }

        /* As linhas ímpares terão outra cor de fundo */
        tr:nth-child(odd) {
            background-color: #ddd;
            /* ou a cor escura de sua escolha */
        }

        /* Estilo para o hover que indica clicabilidade */
        tr:hover {
            background-color: #ccc;
            /* ou a cor que deseja usar no hover */
            cursor: pointer;
            /* Altera o cursor para indicar que é clicável */
        }

        td {
            padding: 8px;
            text-align: center;
            color: #233939
                /* Centraliza o texto */
        }

        /* Removendo as bordas internas das células */
        th,
        td {
            border-bottom: 1px solid #ddd;

            /* Linha sutil no fundo de cada célula */
        }

        .titulos th {
            background-color: #2E2E2E;
            color: white;
            cursor: default;
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
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>Curso</th>
                            <th class="text-center">Sigla</th>
                            <th class="text-center">Duração</th>
                            <th class="text-center">Carga Horária</th>
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
                                    <td><?php echo $row['Curso_Sigla']; ?></td>
                                    <td><?php echo $row['Curso_Duracao']; ?> meses</td>
                                    <td><?php echo $row['Curso_Carga_horaria']; ?> horas</td>
                                    <td><?php echo ($row['Curso_Status'] == 1 ? "Ativo" : "Inativo"); ?></td>
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
        </div>





        <div class="top">
            <h1>Lista de Cursos</h1>
            <a href="s_curso_cad.php"><img src="../ICON/sinal-mais.svg" alt="">Adicionar Curso</a>
        </div>

        <table>
            <tr class="titulos">

                <th>ID do Curso</th>
                <th>Nome do Curso</th>
                <th>Sigla</th>
                <th>Carga Horária</th>
                <th>Descrição</th>
                <th>Duração</th>
                <th>Pré-requisito</th>
                <th>Status</th>

            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "CLAU";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if (!$conn) {
                die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
            }

            $sql = "SELECT Curso_id, Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status FROM curso";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Erro na consulta ao banco de dados: " . mysqli_error($conn));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr onclick=\"window.location='s_curso_detalhes.php?id={$row['Curso_id']}';\">";
                echo "<td>{$row['Curso_id']}</td>";
                echo "<td>{$row['Curso_Nome']}</td>";
                echo "<td>{$row['Curso_Sigla']}</td>";
                echo "<td>{$row['Curso_Carga_horaria']}</td>";
                echo "<td>{$row['Curso_Desc']}</td>";
                echo "<td>{$row['Curso_Duracao']}</td>";
                echo "<td>{$row['Curso_PreRequisito']}</td>";
                echo "<td>" . ($row['Curso_Status'] == 1 ? "Ativo" : "Inativo") . "</td>";
                echo "</tr>";
            }
            mysqli_close($conn);
            ?>
        </table>
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