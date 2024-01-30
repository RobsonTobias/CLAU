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
        $query = "SELECT * FROM Turma WHERE Turma_Cod = '$id_turma'";

        // Executar a consulta
        $result = mysqli_query($conn, $query);

        // Verificar se a consulta retornou algum resultado
        if (mysqli_num_rows($result) > 0) {
            // Extrair os dados da turma
            $turma = mysqli_fetch_assoc($result);

            // Formatando as datas para o padrão brasileiro (DD/MM/AAAA)
            $data_inicio = date('d/m/Y', strtotime($turma['Turma_Inicio']));
            $data_termino = date('d/m/Y', strtotime($turma['Turma_Termino']));
            
        }
    }
    
    ?>
?>

<?php 
    // Executar a consulta
    $result = mysqli_query($conn, $query);

    // Verifica se a consulta foi executada com sucesso
    if ($result && mysqli_num_rows($result) > 0) {
        // Extrair os dados da turma
        $turma = mysqli_fetch_assoc($result);
    }
?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>DETALHES DA TURMA</h1>
                <div class="php">
                    <?php echo $date;?><!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown;?><!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
        <style>
            .course-details {
                max-width: 800px;
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
    </header>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>
    
    <main>
    <div class="course-details">
    <?php if(isset($turma)) : ?>
        <ul>
    <li><strong>Código da Turma:</strong>
     <?php echo $turma['Turma_Cod']; ?>
    </li>
    <li><strong>Horário:</strong> <?php echo $turma['Turma_Horario']; ?>h</li>
    <li><strong>Vagas: </strong><?php echo $turma['Turma_Vagas']; ?></li>
    <li><strong>Dias: </strong><?php echo $turma['Turma_Dias']; ?></li>
    <li><strong>Início:</strong> <?php echo $data_inicio; ?></li>
    <li><strong>Término:</strong> <?php echo $data_termino; ?></li>
    <li><strong>Observações: </strong><?php echo $turma['Turma_Obs']; ?>
    <li><strong>Professor:</strong> <?php echo $turma['Usuario_Usuario_cd']; ?></li>
    <li><strong>Curso:</strong> <?php echo $turma['curso_cd']; ?></li>
    </ul>

    <p class="back-link" onclick="voltar()">Voltar para a lista de cursos</p>
<?php else : ?>
    <p>Nenhum detalhe da turma encontrado.</p>
<?php endif; ?>
</div>
    </main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/Utils.js"></script>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>