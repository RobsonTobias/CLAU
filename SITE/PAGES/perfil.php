<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.php");
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
$stmt = $conn->prepare("SELECT u.Usuario_Nome, u.Usuario_RG, u.Usuario_Nascimento, u.Usuario_Fone, r.Registro_Data 
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

        main {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            padding: 20px;
        }

        .perfil-info {
            flex: 1;
            margin-right: 20px;
        }

        .perfil-info p {
            margin: 5px 0;
        }

        .perfil-info h2 {
            margin-bottom: 10px;
        }

        form {
            flex: 1;
            max-width: 400px;
        }

        form label,
        form input {
            display: block;
            margin-bottom: 10px;
        }

        hr {
            width: 100%;
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ccc;
        }

        .buttons {
            margin-top: 20px;
        }
    </style>
</head>

<body>

<?php include('../PHP/data.php');?>
<?php include('../PHP/sidebar/menu.php');?>
<?php include('../PHP/redes.php');?>
<?php include('../PHP/dropdown.php');?>

<header>
    <div class="title">
        <div class="nomedata closed">
            <h1>PERFIL</h1>
            <div class="php">
                <?php echo $date;?><!--  Mostrar o data atual -->
            </div>
        </div>

        <div class="user">
            <?php echo $dropdown;?><!-- Mostra o usuario, foto e menu dropdown -->
        </div>
    </div>
    <hr>
</header>

<div>
    <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
</div>

<main>
    <div class="perfil-info">
        <h2>Informações do Perfil</h2>
        <p><strong>Nome:</strong> <?php echo $nome; ?></p>
        <p><strong>RG:</strong> <?php echo $rg; ?></p>
        <p><strong>Data de Nascimento:</strong> <?php echo $nascimento; ?></p>
        <p><strong>Telefone:</strong> <?php echo $fone; ?></p>
        <p><strong>Data de Registro:</strong> <?php echo $data_registro; ?></p>
    </div>

    <form action="../php/trocar_senha.php" method="post">
        <h2>Trocar Senha</h2>
        <label for="senha_antiga">Senha Antiga:</label>
        <input type="password" id="senha_antiga" name="senha_antiga" required>
        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>
        <label for="confirmar_senha">Confirmar Nova Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        <button type="submit">Trocar Senha</button>
    </form>
</main>

<hr>

<div class="buttons">
    <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
</div>

<script src="../JS/dropdown.js"></script>
<script src="../JS/botao.js"></script>
<script src="../PHP/sidebar/menu.js"></script>
</body>
</html>
