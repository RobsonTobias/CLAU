<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 5){
    header("Location: ../logout.php");
}

$titulo = 'DETALHES DA TURMA'; //Título da página, que fica sobre a data
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
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .turma path{
            fill: #043140;
        }
    </style>
</head>
<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>
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
        $query = "SELECT Turma.*, curso.curso_nome AS Nome_Curso, Usuario.Usuario_Nome AS Nome_Professor
                  FROM Turma
                  INNER JOIN curso ON Turma.curso_cd = curso.curso_id
                  INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_ID
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

<style>
        .course-details {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .course-details h1,
        .course-details h2 {
            color: #043140;
            margin-bottom: 10px;
        }

        .course-details ul {
            list-style-type: none;
            padding: 0;
        }

        .course-details ul li {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .course-details .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #043140;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .course-details .back-link:hover {
            background-color: #035A70;
        }
    </style>
<div>
    <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
</div>
    
<main>
    <div class="course-details">
    <?php if(isset($turma)) : ?>
        <ul>
            <li><strong>Código da Turma:</strong> <?php echo $turma['Turma_Cod']; ?></li>
            <li><strong>Horário de inicio:</strong> <?php echo $turma['Turma_Horario']; ?>h</li>
            <li><strong>Horário de termino:</strong> <?php echo $turma['Turma_Horario_Termino']; ?>h</li>
            <li><strong>Vagas:</strong> <?php echo $turma['Turma_Vagas']; ?></li>
            <li><strong>Dias de Aula:</strong> <?php echo $dias_aula_turma_texto; ?></li>
            <li><strong>Início:</strong> <?php echo date('d/m/Y', strtotime($turma['Turma_Inicio'])); ?></li>
            <li><strong>Término:</strong> <?php echo date('d/m/Y', strtotime($turma['Turma_Termino'])); ?></li>
            <li><strong>Observações:</strong> <?php echo $turma['Turma_Obs']; ?></li>
            <li><strong>Professor:</strong> <?php echo $turma['Nome_Professor']; ?></li>
            <li><strong>Curso:</strong> <?php echo $turma['Nome_Curso']; ?></li>
        </ul>

        <p class="back-link" onclick="voltar()">Voltar</p>
    <?php else : ?>
        <p>Nenhum detalhe da turma encontrado.</p>
    <?php endif; ?>
    </div>
</main>

<div class="buttons">
    <!-- Aqui pode ser incluído o código PHP para exibir o botão de fale conosco -->
</div>

<script src="../JS/Utils.js"></script>
<script src="../JS/dropdown.js"></script>
<script src="../JS/botao.js"></script>
<script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
