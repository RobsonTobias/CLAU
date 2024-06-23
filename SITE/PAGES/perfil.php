<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Conexão com o banco de dados (substitua os valores conforme necessário)
include '../conexao.php';

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtém o ID do usuário logado
$usuarioId = $_SESSION['Usuario_id'];

// Consulta SQL para obter as informações do usuário, incluindo a data de registro
$stmt = $conn->prepare("SELECT u.Usuario_Nome, u.Usuario_RG, u.Usuario_Nascimento,u.Usuario_Foto, u.Usuario_Fone, r.Registro_Data 
                        FROM Usuario u 
                        INNER JOIN registro_usuario r ON u.Usuario_id = r.usuario_usuario_cd 
                        WHERE u.Usuario_id = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("i", $usuarioId);
if (!$stmt->execute()) {
    die("Erro na execução da consulta: " . $stmt->error);
}

$result = $stmt->get_result();

// Verifica se o usuário foi encontrado
if ($result->num_rows > 0) {
    // Exibe as informações do usuário
    while ($row = $result->fetch_assoc()) {
        $nome = $row['Usuario_Nome'];
        $rg = $row['Usuario_RG'];
        $foto = $row['Usuario_Foto'];

        // Formata a data de nascimento no padrão brasileiro
        $nascimento = date('d/m/Y', strtotime($row['Usuario_Nascimento']));

        $fone = $row['Usuario_Fone'];

        // Formata a data de registro no padrão brasileiro
        $data_registro = date('d/m/Y', strtotime($row['Registro_Data']));
    }
} else {
    echo "Usuário não encontrado.";
}

$stmt->close();
$conn->close();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @media (max-width: 750px) {
            .margin {
                margin-left: 75px;
            }
        }

        html {
            font-size: 62, 5%;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        header {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px;
            
        }

        .password-container i {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-40%);
            cursor: pointer;
            color:white
        }



        .card-body{
            background:#E7E7E7
        }

        input[type=password]{
            background-color: #949494;
            color: white;
        }
        input[type=password]:focus{
            background-color: #949494;
            color: white;
            border: black;
        }
        input[type=text]{
            background-color: #949494;
            color: white;
        }
        input[type=text]:focus{
            background-color: #949494;
            color: white;
        }

        .form-control:focus
        {
            box-shadow: none;
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
                <h1>PERFIL</h1>
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php echo $sidebarHTML; ?>
            </div>
            <div class="col-md-10 margin">
                <main class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow bg-white rounded">
                            <div class="card-body d-flex align-items-center flex-wrap">
                            <h2 class="mb-3">Informações do Perfil</h2>
                                <div>
                                    
                                    <p><strong>RG:</strong> <span id="rg"><?php echo $rg; ?></span></p>
                                    <p><strong>Data de Nascimento:</strong> <span
                                            id="nascimento"><?php echo $nascimento; ?></span></p>
                                    <p><strong>Telefone:</strong> <span id="fone"><?php echo $fone; ?></span></p>

                                    <p><strong>Data de Registro:</strong> <?php echo $data_registro; ?></p>
                                </div>
                                <img src="<?php echo $foto; ?>" alt="Foto do Usuário"
                                    class="rounded-circle img-thumbnail " style="width: 150px; height: 150px;">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow bg-white rounded">
                            <div class="card-body ">
                                <div class="mb-4 text-center">
                                    <h4 class="mt-3"><?php echo $nome; ?></h4>
                                </div>
                                <h2 class="mb-3">Trocar Senha</h2>
                                <form action="../php/trocar_senha.php" method="post">
                                    <div class="form-group password-container">
                                        <label for="senha_antiga">Senha Antiga:</label>
                                        <input type="password" id="senha_antiga" name="senha_antiga"
                                            class="form-control rounded-pill" required>
                                        
                                            <i class="bi bi-eye" onclick="togglePasswordVisibility('senha_antiga')"></i>
                                    </div>
                                    <div class="form-group password-container">
                                        <label for="nova_senha">Nova Senha:</label>
                                        <input type="password" id="nova_senha" name="nova_senha" class="form-control rounded-pill"
                                            required>
                                        
                                            <i class="bi bi-eye" onclick="togglePasswordVisibility('nova_senha')"></i>
                                    </div>
                                    <div class="form-group password-container">
                                        <label for="confirmar_senha">Confirmar Nova Senha:</label>
                                        <input type="password" id="confirmar_senha" name="confirmar_senha"
                                            class="form-control rounded-pill" required>
                                            <i class="bi bi-eye" onclick="togglePasswordVisibility('confirmar_senha')"></i>
                                            
                                    </div>
                                    <button type="submit" class="btn btn-primary">Trocar Senha</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </div>
    </div>


    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.7-beta.0/jquery.inputmask.min.js"></script>



    <script src="../JS/mask.js"></script>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>

    <script>
        function togglePasswordVisibility(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
    </script>
</body>

</html>