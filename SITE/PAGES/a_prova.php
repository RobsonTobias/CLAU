<?php
    include ('../conexao.php');

    if (session_status() == PHP_SESSION_NONE) {
        // Se não houver sessão ativa, inicia a sessão
        session_start();
    }

    $userId = $_SESSION['Usuario_id'];

    // Consulta para recuperar informações do usuário
    $sql = "SELECT * FROM Aluno_Turma
    left JOIN Turma on Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
    left JOIN Curso on Curso.Curso_id = Turma.Curso_cd
    WHERE Aluno_Turma.Usuario_Usuario_cd = $userId";
    $result = $conn->query($sql);

    // Verificar se o usuário existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codTurma = $row['Turma_Cod'];
        $curso = $row['Curso_Nome'];
    } else {
        echo "Usuário não encontrado";
    }

    $home = 'a_home.php';
    $titulo = 'CONSULTA DA TURMA';
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
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .alunos path {
            fill: #043140;
        }
    </style>
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php include('../PHP/data.php');?>
    <?php include('../PHP/sidebar/menu.php');?>
    <?php include('../PHP/redes.php');?>
    <?php include('../PHP/dropdown.php');?>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div>
        <?php echo $sidebarHTML;?>
        <!--  Mostrar o menu lateral -->
    </div>

    <main>
    <div class="geral">
    <p>Informações da Turma</p>
    <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
        <div class="info">
            <div class="dados">
                <div class="linha">
                    <label for="codTurma" class="codTurma">
                        <p>Código da Turma:<span>*</span></p>
                        <input type="text" id="codTurma" name="codTurma" value="<?php echo $row['Turma_Cod']; ?>" required disabled>
                    </label>
                            <label for="status" class="status">
                                <p>Status:<span>*</span></p>
                                <input type="text" id="status" name="status" value="<?php 
                                    if ($row['Turma_Status'] == 1){
                                        echo "CURSANDO";
                                    } 
                                    else {
                                        echo "FINALIZADO";
                                    } ?>" required disabled>
                            </label>
                            </div>
                            <div class="linha">
                            <label for="curso" class="curso">
                                <p>Curso:<span>*</span></p>
                                <div class="select">
                                    <input type="text" name="curso" id="curso" value="<?php echo $row['Curso_Nome']; ?>" disabled></input>
                                </div>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="periodo" class="periodo">
                                <p>Periodo:<span>*</span></p>
                                <input type="periodo" id="periodo" name="periodo" value="<?php echo $row['Turma_Obs']; ?>" required disabled>
                            </label>
                            <label for="dias" class="dias">
                                <p>Dias por Semana<span>*</span></p>
                                <input type="text" id="dias" name="dias" value="<?php echo $row['Turma_Dias']; ?>" required disabled>
                            </label>

                        </div>
                        <div class="linha">

                            <label for="horarioIni" class="horarioIni">
                                <p>Horário-Início:<span>*</span></p>
                                <input type="text" id="horarioIni" name="horarioIni" value="<?php echo $row['Turma_Horario']; ?>" required disabled>
                            </label>
                            <label for="horarioTer" class="horarioTer">
                                <p>Horário-Término:<span>*</span></p>
                                <input type="text" id="horarioTer" name="horarioTer" value="<?php echo $row['Turma_Horario_Termino']; ?>"required disabled>
                            </label>
                        </div>
                        <div class="linha">

                            <label for="TurmaIni" class="TurmaIni">
                                <p>Turma-Início:<span>*</span></p>
                                <input type="text" id="TurmaIni" name="TurmaIni" value="<?php echo $row['Turma_Inicio']; ?>" required disabled>
                            </label>
                            <label for="TurmaTer" class="TurmaTer">
                                <p>Turma-Término:<span>*</span></p>
                                <input type="text" id="TurmaTer" name="TurmaTer" value="<?php echo $row['Turma_Termino']; ?>"required disabled>
                            </label>
                        </div>
                        
                        </div>
                    </div>
                    
                </div>
            </div>
            </form>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes;?>
        <!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/end.js"></script>
    <script>

        $(document).ready(function () {
            $("#form").on("submit", function (e) {
                e.preventDefault(); // Impede o envio normal do formulário

                var formData = new FormData(this);

                $.ajax({
                    url: '../PAGES/s_alunos_consulta.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Cadastro realizado com sucesso!")) {
                            $('#form').trigger("reset"); // Limpa o formulário
                            $('#imagemExibida').attr('src', 'https://placekitten.com/400/400');
                            alert("Cadastro realizado com sucesso!"); // Exibe um alerta de sucesso
                        } else {
                            alert(response); // Exibe outros alertas retornados pelo servidor
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });

        function limpar() {
            // Adicione a lógica para limpar os campos do formulário aqui
            document.getElementById('form').reset();
            
        }
        function exibirImagem() {
            const input = document.getElementById('imagemInput');
            const imagemExibida = document.getElementById('imagemExibida');

            if (input.files && input.files[0]) {
                const leitor = new FileReader();

                leitor.onload = function (e) {
                    imagemExibida.src = e.target.result;
                };

                leitor.readAsDataURL(input.files[0]);
            }
        }

        const handleZipCode = (event) => {
            let input = event.target
            input.value = zipCodeMask(input.value)
        }

        const zipCodeMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{5})(\d)/, '$1-$2')
            return value
        }

        const handlePhone = (event) => {
            let input = event.target
            input.value = PhoneMask(input.value)
        }

        const PhoneMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "($1) $2")
            value = value.replace(/(\d)(\d{4})$/, "$1-$2")
            return value
        }

        const handleCPF = (value) => {

            let input = event.target
            input.value = CPFMask(input.value)
        }

        const CPFMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d{2})/, "$1-$2")

            return value
        }

        const handleRG = (value) => {

            let input = event.target
            input.value = RGMask(input.value)
        }

        const RGMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d{1})/, "$1-$2")

            return value
        }
    </script>
</body>

</html>