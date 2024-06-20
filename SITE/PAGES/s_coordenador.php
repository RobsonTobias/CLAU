<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$home = 's_home.php'; //utilizado pelo botão voltar
$titulo = 'RELATÓRIO DE COORDENADORES'; //Título da página, que fica sobre a data
$paginaDestino = 's_coordenador_cad.php'; //utilizado para redirecionar para a página de cadastro
$elemento = 'Coordenador'; //utilizado no texto de adicionar
$tipoUsuario = 5; // utilizado para o ListaUsuario
$informacao = 'EDITAR INFORMAÇÕES'; // utilizado no botão
require_once '../PHP/formatarInfo.php';
?>

<style>
    .coordenacao path {
        fill: #043140;
    }
</style>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex form-group justify-content-center mt-3" style="margin-left: 76px;">
            <?php require_once '../COMPONENTS/pesquisaUsuario.php'; ?>
            <div class="col-sm-7">
                <?php require_once '../COMPONENTS/infoUsuario.php'; ?>
            </div>
        </div>
    </div>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>
    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/exibirDetalhes.js"></script>
    <script src="../JS/pesquisa.js"></script>

    <script>
        var selectedUserId; // Variável global para armazenar o ID do usuário selecionado

        function mostrarDetalhes(elemento) {
            selectedUserId = elemento.getAttribute('data-id'); // Atualiza a variável global

            $.ajax({
                url: '../PHP/det_func.php',
                type: 'GET',
                data: { userId: selectedUserId }, // Deve ser selectedUserId, não userId
                success: function (response) {
                    // Aqui você vai lidar com a resposta
                    exibirDetalhesUsuario(response);
                },
                error: function () {
                    alert("10-Erro ao obter dados do usuário.");
                }
            });
            buscarTurmas(selectedUserId);
        }

        function editar() {
            if (selectedUserId) {
                window.location.href = "s_coordenador_editar.php?userId=" + selectedUserId;
            } else {
                alert("Por favor, selecione um coordenador antes de editar.");
            }
        }
    </script>


</body>

</html>