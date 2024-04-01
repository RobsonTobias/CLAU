<?php
session_start();

if (!isset($_SESSION['Usuario_id'])) {
    header("Location: index.html");
    exit();
}

$usuarioId = $_SESSION['Usuario_id'];
include '../conexao.php'; // Certifique-se que este arquivo contém a conexão MySQLi correta.

// Inicializa variáveis
$cursoCod = '';
$modulos = [];

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

// Consulta para buscar todos os cursos para o <select>
$resultadoCursos = mysqli_query($conn, "SELECT Curso_id, Curso_Nome FROM Curso");
if (!$resultadoCursos) {
    die("Erro ao executar a consulta de cursos: " . mysqli_error($conn));
}
if (isset($_POST['submitAula'])) {
    $moduloId = $_POST['moduloSelect'];
    $aulaAssunto = $_POST['aulaAssunto'];
    $aulaDescricao = $_POST['aulaDescricao'];

    $sqlInsertAula = "INSERT INTO Aulas (Modulo_Modulo_id, Aula_Assunto, Aula_Descricao) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $sqlInsertAula)) {
        mysqli_stmt_bind_param($stmt, "iss", $moduloId, $aulaAssunto, $aulaDescricao);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Aula lançada com sucesso!</p>";
        } else {
            echo "<p>Erro ao lançar aula: " . mysqli_error($conn) . "</p>";
        }
        
        mysqli_stmt_close($stmt);
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../STYLE/style_home.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
    

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

    .form-input, .form-select, .form-textarea, button {
        width: calc(100% - 20px);
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
        resize: vertical; /* Permite ao usuário ajustar a altura da textarea */
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
                <h1>PLANEJAMENTO DIDÁTICO</h1>
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
    <form action="" method="post" class="form-container">
    <div class="form-section">
        <label for="cursoSelect">Curso:</label>
        <select id="cursoSelect" name="cursoSelect" class="form-select" onchange="this.form.submit()">
        <option value="">Selecione um curso</option>
        <?php while($curso = mysqli_fetch_assoc($resultadoCursos)): ?>
            <option value="<?php echo $curso['Curso_id']; ?>" <?php if($cursoCod == $curso['Curso_id']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($curso['Curso_Nome']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <?php if (!empty($modulos)): ?>
        <label for="moduloSelect">Módulo:</label>
        <select id="moduloSelect" name="moduloSelect" class="form-select">
        <option value="">Selecione um módulo</option>
        <?php foreach ($modulos as $modulo): ?>
            <option value="<?php echo $modulo['id']; ?>">
                <?php echo htmlspecialchars($modulo['nome']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="aulaAssunto">Assunto da Aula:</label>
        <input type="text" id="aulaAssunto" name="aulaAssunto" required class="form-input">
    </div>

    <div class="vertical-line"></div>
    <div class="form-section">
        <label for="aulaDescricao">Descrição:</label>
        <textarea id="aulaDescricao" name="aulaDescricao" class="form-textarea"></textarea>
        <button type="submit" name="submitAula">Lançar Aula</button>
    </div>
<?php endif; ?>
    <!-- Adicionar botão de submit se necessário -->
</form>
</main>


    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>