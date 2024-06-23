<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
require_once '../PHP/formatarInfo.php';
$home = 's_professores.php'; //utilizado pelo botão voltar
$titulo = 'CADASTRO DE PROFESSOR'; //Título da página, que fica sobre a data
$elemento = 'Professor'; // Item que é utilizado para adicionar no Informações e condição do responsável
?>

<style>
    .professores path {
        fill: #043140;
    }
</style>


<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-center mt-3 mb-3" style="margin-left: 76px;">
            <div class="card col-sm-10">
                <div class="card-body p-2">
                    <h5 class="m-0">Informações do <?php echo $elemento; ?></h5>
                </div>
                <form id="form" class="form" method="post" enctype="multipart/form-data">
                    <?php require_once '../COMPONENTS/cadastroInfoUsuario.php'; ?>
                    <?php require_once '../COMPONENTS/cadastroEndereco.php'; ?>
                    <div id="botao" class="d-flex justify-content-between">
                        <div class="d-flex row align-items-center">
                            <div class="texto">Adicionar Professor como Coordenador?</div>
                            <input type="checkbox" name="coordenador" id="coordenador" class="rounded-pill" style="width:1rem; margin-left: 10px;">
                        </div>
                        <div>
                            <button class="cadastrar" type="submit">CADASTRAR</button> &nbsp &nbsp
                            <button class="limpar" type="button" onclick="limpar()">LIMPAR</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>

    <div class="buttons">
        <?php echo $redes; ?>
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/end.js"></script>
    <script src="../JS/informacao.js"></script>
    <script>
        $(document).ready(function () {
            $("#form").on("submit", function (e) {
                e.preventDefault(); // Impede o envio normal do formulário

                var formData = new FormData(this);

                $.ajax({
                    url: '../PHP/cad_professor.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Cadastro realizado com sucesso!")) {
                            $('#form').trigger("reset"); // Limpa o formulário
                            $('#imagemExibida').attr('src', '../ICON/perfil.svg');
                            alert("10-Cadastro realizado com sucesso!"); // Exibe um alerta de sucesso
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
    </script>
</body>

</html>