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
        .top{
            position: relative;
            display: flex;
            width: 100%;
            justify-content:center;
            align-items: flex-end;
        }
        .top a{
            text-decoration: none;
            color: #4CAF50;
            position: absolute;
            right: 11%;
            bottom: 3px;
            display: flex;
            transition: 0.2s ease-in-out;
        }
        .top a:hover{
            opacity: 0.5;
        }

        .top a img{
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
            color:#233939
            /* Centraliza o texto */
        }

        /* Removendo as bordas internas das células */
        th,
        td {
            border-bottom: 1px solid #ddd;
            
            /* Linha sutil no fundo de cada célula */
        }

        .titulos th{
            background-color: #2E2E2E;
            color: white;
            cursor: default;
        }
    </style>

</head>

<body>

    <?php include('../PHP/data.php'); ?>
    <?php include('../PHP/sidebar/menu.php'); ?>
    <?php include('../PHP/redes.php'); ?>
    <?php include('../PHP/dropdown.php'); ?>

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

    <main>

<div class="top"><h1>Lista de Cursos</h1>
        <a href="s_curso_cad.php"><img src="../ICON/sinal-mais.svg" alt="">Adicionar Curso</a></div>
        
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
</body>

</html>