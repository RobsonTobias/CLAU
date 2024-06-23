<?php
if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
$titulo = 'DETALHES DO CURSO'; //Título da página, que fica sobre a data
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
    </style>
</head>

<body>

    <?php include('../PHP/data.php'); ?>
    <?php include('../PHP/sidebar/menu.php'); ?>
    <?php include('../PHP/redes.php'); ?>
    <?php include('../PHP/dropdown.php'); ?>

    <?php require_once '../COMPONENTS/header.php' ?>

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
    <div>
        <?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
    </div>

    <main>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "CLAU";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if (!$conn) {
            die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
        }

        if (isset($_GET['id'])) {
            $curso_id = $_GET['id'];


            // Consulta para obter os detalhes do curso
            $sql = "SELECT Curso_id, Curso_Nome, Curso_Sigla, Curso_Carga_horaria, Curso_Desc, Curso_Duracao, Curso_PreRequisito, Curso_Status FROM curso WHERE Curso_id = $curso_id";

            $sql_num_turmas = "SELECT COUNT(*) AS num_turmas FROM Turma WHERE curso_cd = $curso_id";
    
            $result_num_turmas = mysqli_query($conn, $sql_num_turmas);
            
            if (!$result_num_turmas) {
                die("Erro na consulta do número de turmas: " . mysqli_error($conn));
            }
            
            $row_num_turmas = mysqli_fetch_assoc($result_num_turmas);
            $num_turmas = $row_num_turmas['num_turmas'];

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Erro na consulta ao banco de dados: " . mysqli_error($conn));
            }

            $curso_info = mysqli_fetch_assoc($result);

            // Consulta para obter os módulos associados
            $sql_modulos = "SELECT modulo.Modulo_Nome FROM modulo
                        INNER JOIN modulo_curso ON modulo_curso.Modulo_Modulo_cd = modulo.Modulo_id
                        WHERE modulo_curso.Curso_Curso_cd = $curso_id";

            $result_modulos = mysqli_query($conn, $sql_modulos);

            if (!$result_modulos) {
                die("Erro na consulta dos módulos: " . mysqli_error($conn));
            }
            

            ?>
            <div class="course-details">

                <div>
               
                <h1>Detalhes do Curso</h1>
                <ul>
                    <li><strong>Nome do Curso:</strong>
                        <?php echo $curso_info['Curso_Nome']; ?>
                    </li>
                    <li><strong>Sigla:</strong>
                        <?php echo $curso_info['Curso_Sigla']; ?>
                    </li>
                    <li><strong>Carga Horária:</strong>
                        <?php echo $curso_info['Curso_Carga_horaria']; ?>
                    </li>
                    <li><strong>Descrição:</strong>
                        <?php echo $curso_info['Curso_Desc']; ?>
                    </li>
                    <li><strong>Duração:</strong>
                        <?php echo $curso_info['Curso_Duracao']; ?>
                    </li>
                    <li><strong>Pré-requisito:</strong>
                        <?php echo $curso_info['Curso_PreRequisito']; ?>
                    </li>
                    <li><strong>Status:</strong>
                        <?php echo ($curso_info['Curso_Status'] == "1") ? "Ativo" : "Inativo"; ?>
                    </li>
                    <li><strong>Quantidade de Turmas:</strong> <?php echo $num_turmas; ?></li>
                </ul>

                <h2>Módulos do Curso</h2>
                <ul>
                    <?php
                    if (mysqli_num_rows($result_modulos) > 0) {
                        while ($row_modulo = mysqli_fetch_assoc($result_modulos)) {
                            echo "<li>{$row_modulo['Modulo_Nome']}</li>";
                        }
                    } else {
                        echo "<li>Nenhum módulo associado a este curso.</li>";
                    }
                    ?>
                </ul>
                
                <p class="back-link" onclick="voltar()">Voltar para a lista de cursos</p>
                <?php
        } else {
            echo "ID do curso não especificado.";
        }

        mysqli_close($conn);
        ?>
        </div>
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