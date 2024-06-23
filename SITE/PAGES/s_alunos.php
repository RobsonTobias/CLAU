<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';


if ($_SESSION['Tipo_Tipo_cd'] != 2) {
	header("Location: ../logout.php");
}
require_once '../PHP/formatarInfo.php';
$home = 's_home.php'; //utilizado pelo botão voltar
$titulo = 'RELATÓRIO DE ALUNOS'; //Título da página, que fica sobre a data
$paginaDestino = 's_alunos_cad.php'; //utilizado para redirecionar para a página de cadastro
$elemento = 'Aluno'; //utilizado no texto de adicionar
$tipoUsuario = 3;
$informacao = 'MOSTRAR INFORMAÇÕES';
?>

<style>
	.aluno path {
		fill: #043140;
	}
</style>

<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?php require_once '../COMPONENTS/header.php' ?>


	<div class="container-fluid">
        <div class="d-flex form-group justify-content-center mt-3" style="margin-left: 76px;">
            <?php require_once '../COMPONENTS/pesquisaUsuario.php'; ?>
            <div class="col-sm-6">
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
					alert("Erro ao obter dados do usuário.");
				}
			});
		}

		function editar() {
			if (selectedUserId) {
				window.location.href = "s_alunos_info.php";
			} else {
				alert("Por favor, selecione um aluno.");
			}
		}
	</script>

</body>

</html>