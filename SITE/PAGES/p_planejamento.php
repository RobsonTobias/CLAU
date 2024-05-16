<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}
if($_SESSION['Tipo_Tipo_cd'] != 4){
    header("Location: ../logout.php");
}

$usuarioId = $_SESSION['Usuario_id'];
include '../conexao.php'; // Certifique-se que este arquivo contém a conexão MySQLi correta.

// Inicializa variáveis
$cursoCod = '';
$modulos = [];
$aulas = []; // Adicionado para armazenar aulas

// Verifica se um curso foi selecionado
if (isset($_POST['cursoSelect'])) {
    $cursoCod = $_POST['cursoSelect'];

    // Prepara a consulta para obter os módulos do curso selecionado
    $sqlModulos = "SELECT m.Modulo_id, m.Modulo_Nome
                   FROM Modulo AS m
                   INNER JOIN Modulo_Curso AS mc ON m.Modulo_id = mc.Modulo_Modulo_cd
                   WHERE mc.Curso_Curso_cd = ?";

    if ($stmt = mysqli_prepare($conn, $sqlModulos)) {
        // Vincula parâmetros para marcadores
        mysqli_stmt_bind_param($stmt, "i", $cursoCod);

        // Executa a consulta
        mysqli_stmt_execute($stmt);

        // Vincula as variáveis de resultado
        mysqli_stmt_bind_result($stmt, $moduloId, $moduloNome);

        // Busca os valores
        while (mysqli_stmt_fetch($stmt)) {
            $modulos[] = ['id' => $moduloId, 'nome' => $moduloNome];
        }

        // Fecha o statement
        mysqli_stmt_close($stmt);
    }
}

// Se um módulo foi selecionado, busca as aulas associadas a esse módulo
if (isset($_POST['moduloSelect'])) {
    $moduloId = $_POST['moduloSelect'];

    $sqlAulas = "SELECT Aula_id, Aula_Assunto, Aula_Descricao FROM Aulas WHERE Modulo_Modulo_id = ?";
    if ($stmt = mysqli_prepare($conn, $sqlAulas)) {
        mysqli_stmt_bind_param($stmt, "i", $moduloId);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $aulaId, $aulaAssunto, $aulaDescricao);

        while (mysqli_stmt_fetch($stmt)) {
            $aulas[] = ['id' => $aulaId, 'assunto' => $aulaAssunto, 'descricao' => $aulaDescricao];
        }

        mysqli_stmt_close($stmt);
    }
}

// Consulta para buscar todos os cursos para o <select>
$resultadoCursos = mysqli_query($conn, "SELECT Curso_id, Curso_Nome FROM Curso");
if (!$resultadoCursos) {
    die("Erro ao executar a consulta de cursos: " . mysqli_error($conn));
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .planejamento path{
            fill: #043140;
        }
        .content-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            /* Espaçamento entre os elementos */
            margin: 20px;
        }

        .main {
            flex: 1;
            /* Faz o formulário crescer e preencher o espaço disponível */
            max-width: 600px;
            /* Você pode ajustar isso conforme necessário */
        }

        .aulas-container {
            /* Faz o contêiner das aulas crescer e preencher o espaço disponível */
            width: 800px;
            /* Ajuste conforme necessário */
            background-color: #f9f9f9;
            /* Apenas um exemplo de cor de fundo */
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Outros estilos que você já definiu, mantenha-os como estão */


        .form-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px auto;
            max-width: 1000px;
        }

        .form-section {
            flex: 1;
            padding: 20px;
        }

        .vertical-line {
            width: 2px;
            background-color: #e7e7e7;
        }

        .form-input,
        .form-select,
        .form-textarea,
        button {
            width: 300px;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333333;
        }

        button {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #004494;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555555;
        }

        .form-textarea {
            height: 150px;
            resize: vertical;
            /* Permite ao usuário ajustar a altura da textarea */
        }

        .content-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            /* Alinha itens ao centro verticalmente */
            gap: 20px;
            height: 100vh;
            /* Faz o contêiner ocupar a altura total da tela */
            padding-top: 60px;
            /* Ajuste conforme necessário para não sobrepor ao header */
            padding-bottom: 60px;
            /* Espaço no fundo */
        }

        .aulas-container {
            width: 50%;
            /* Ajuste a largura conforme necessário */
            background-color: #EEEEEE;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            /* Garante que nada saia fora dos limites do contêiner */
            margin: auto;
            /* Ajuda na centralização */
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centraliza o conteúdo verticalmente dentro do contêiner */
        }

        .aulas-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .aulas-container ul {
            list-style-type: none;
            /* Remove os marcadores da lista */
            padding: 0;
        }

        .aulas-container ul li {
            background-color: #ffffff;
            padding: 10px 15px;
            margin-bottom: 10px;
            /* Espaçamento entre itens da lista */
            border-radius: 4px;
            /* Bordas arredondadas */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: block;
            color: #555;
            text-align: left;
        }


        .modal {
            display: none;
            /* Modal escondido inicialmente */
            position: fixed;
            /* Fica na frente de tudo */
            z-index: 1;
            /* Senta no topo */
            left: 0;
            top: 0;
            width: 100%;
            /* Largura total */
            height: 100%;
            /* Altura total */
            overflow: auto;
            /* Habilita scroll se necessário */
            background-color: rgba(0, 0, 0, 0.4);
            /* Cor de fundo */
        }

        .modal-content {
            background-color: #d0f2fa;
            border-radius: 8px;
            margin: 15% auto;
            /* 15% do topo e centralizado horizontalmente */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Pode ajustar para sua necessidade */
        }

        .modal-content h2 {
            font-style: italic;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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
                <h1>PLANEJAMENTO DIDÁTICO</h1>
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
    <div class="content-container">
        <main>
            <form action="" method="post" class="form-container">
                <div class="form-section">
                    <label for="cursoSelect">Curso:</label>
                    <select id="cursoSelect" name="cursoSelect" class="form-select" onchange="this.form.submit()">
                        <option value="">Selecione um curso</option>
                        <?php while ($curso = mysqli_fetch_assoc($resultadoCursos)) : ?>
                            <option value="<?php echo $curso['Curso_id']; ?>" <?php if ($cursoCod == $curso['Curso_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($curso['Curso_Nome']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <?php if (!empty($modulos)) : ?>
                        <label for="moduloSelect">Módulo:</label>
                        <select id="moduloSelect" name="moduloSelect" class="form-select" onchange="this.form.submit()">
                            <option value="">Selecione um módulo</option>
                            <?php foreach ($modulos as $modulo) : ?>
                                <option value="<?php echo $modulo['id']; ?>" <?php if (isset($_POST['moduloSelect']) && $_POST['moduloSelect'] == $modulo['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($modulo['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>



                    <?php endif; ?>




                    <!-- Adicionar botão de submit se necessário -->
            </form> <!-- Fim do formulário existente -->
        </main>

        <div id="aulasDiv" class="aulas-container">
            <?php if (!empty($aulas)) : ?>
                <h2>Aulas do Módulo Selecionado</h2>
                <ul>
                    <?php foreach ($aulas as $aula) : ?>
                        <li onclick="abrirModal('<?php echo addslashes($aula['assunto']); ?>', '<?php echo addslashes($aula['descricao']); ?>')">
                            <?php echo htmlspecialchars($aula['assunto']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php endif; ?>
        </div>

    </div>

    <!-- Modal -->
    <div id="aulaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModal()">&times;</span>
            <h2>Assunto da Aula</h2>
            <p id="aulaDescricao">Descrição da aula aqui...</p>
        </div>
    </div>


    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script>
        // Aguarda o carregamento completo do DOM
        document.addEventListener('DOMContentLoaded', function() {
            // Função para abrir o modal com os detalhes específicos
            window.abrirModal = function(assunto, descricao) {
                var modal = document.getElementById('aulaModal');
                modal.style.display = "block";
                modal.querySelector('h2').innerText = assunto;
                modal.querySelector('#aulaDescricao').innerText = descricao;
            }

            // Função para fechar o modal
            fecharModal = function() {
                var modal = document.getElementById('aulaModal');
                modal.style.display = "none";
            }
        });

        // Fecha o modal ao clicar fora dele
        window.onclick = function(event) {
            var modal = document.getElementById('aulaModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>



    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>