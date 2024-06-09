<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
	// Se não houver sessão ativa, inicia a sessão
	session_start();
}
if ($_SESSION['Tipo_Tipo_cd'] != 2) {
	header("Location: ../logout.php");
}
$home = 's_home.php'; //utilizado pelo botão voltar
$titulo = 'RELATÓRIO DE ALUNOS'; //Título da página, que fica sobre a data
$paginaDestino = 's_alunos_cad.php'; //utilizado para redirecionar para a página de cadastro
$elemento = 'Aluno'; //utilizado no texto de adicionar
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
	<link rel="stylesheet" href="../STYLE/relatorio.css">
	<link rel="icon" href="../ICON/C.svg" type="image/svg">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<style>
		.aluno path {
			fill: #043140;
		}

		.ajuste {
			width: 100%;
		}

		.centro {
			text-align: center;
		}

		main {
			display: flex;
		}

		.pesquisa p {
			min-width: 0;
			margin-bottom: 0;
		}
	</style>
</head>

<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?php include ('../PHP/data.php'); ?>
	<?php include ('../PHP/sidebar/menu.php'); ?>
	<?php include ('../PHP/redes.php'); ?>
	<?php include ('../PHP/dropdown.php'); ?>

	<?php require_once '../COMPONENTS/header.php' ?>

	<div>
		<?php echo $sidebarHTML; ?><!--  Mostrar o menu lateral -->
	</div>

	<main class="ajuste">
		<div class="pesquisa">
			<div class="d-flex row justify-content-between teste">
				<p>Pesquisar:</p>
				<?php require_once '../COMPONENTS/add.php'; ?>
			</div>
			<input type="text" id="searchInput" placeholder="Digite um nome para pesquisar">
			<table class="table table-hover">
				<tr>
					<th>NOME</th>
					<th>MATRÍCULA</th>
				</tr>
				<?php
				$sql = "SELECT * FROM Usuario
                INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                Where Registro_Usuario.Tipo_Tipo_cd = 3;";

				$contador = 0;
				$resultado = $conn->query($sql);
				if ($resultado && $resultado->num_rows > 0) {
					while ($row = $resultado->fetch_assoc()) {
						$classeLinha = ($contador % 2 == 0) ? 'linha-par' : 'linha-impar';
						echo "<tr data-id='" . $row["Usuario_id"] . "' class='" . $classeLinha . "' onclick='mostrarDetalhes(this)'>";
						echo "<td class='nomeusuario'>" . $row["Usuario_Nome"] . "</td>";
						echo "<td class='matricula'>" . $row["Usuario_Matricula"] . "</td>";
						echo "</tr>";
						$contador++;
					}
				} else {
					echo "<tr><td colspan='2'>Nenhum aluno encontrado.</td></tr>";
				}
				?>
			</table>
		</div>
		<div class="informacoes">
			<div class="informacao">
				<div class="titulo">
					<p>Informações Pessoais</p>
					<button class="editar" type="button" onclick="informacao()">INFORMAÇÃO DO ALUNO</button>
				</div>
				<div class="infofuncionario">
					<div class="func">
						<div class="foto">
							<img id="imagemExibida" src="../ICON/perfil.svg" alt="foto">
						</div>
						<div class="info-func">
							<div class="modal1">Nome:
								<div class="texto" id="modalNome"></div>
							</div>
							<div class="linha">
								<div class="col1 modal1">Nascimento: <div class="texto" id="modalNascimento"></div>
								</div>
								<div class="col2 modal1" for="idade">Idade: <div class="texto" id="modalIdade"></div>
								</div>
							</div>
							<div class="linha">
								<div class="col1 modal1">CPF: <div class="texto" id="modalCpf"></div>
								</div>
								<div class="col2 modal1">RG: <div class="texto" id="modalRg"></div>
								</div>
							</div>
							<div class="linha">
								<div class="col1 modal1">Sexo: <div class="texto" id="modalSexo"></div>
								</div>
								<div class="col2 modal1">E-mail: <div class="texto" id="modalEmail"></div>
								</div>
							</div>
							<div class="linha">
								<div class="col1 modal1">Celular: <div class="texto" id="modalCelular"></div>
								</div>
								<div class="col2 modal1">Data de Ingresso: <div class="texto" id="modalIngresso"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="obs-func">
						<p id="modalObs">Nenhuma informação cadastrada!</p>
					</div>
				</div>
				<div class="endereco">
					<p>Endereço</p>
					<div class="linha">
						<div class="col1 cola modal1">Logradouro: <div class="texto" id="modalLogradouro"></div>
						</div>
						<div class="col2 colb modal1">Nº: <div class="texto" id="modalNumero"></div>
						</div>
					</div>
					<div class="linha">
						<div class="col1 cola modal1">Complemento: <div class="texto" id="modalComplemento"></div>
						</div>
						<div class="col2 colb modal1">CEP: <div class="texto" id="modalCep"></div>
						</div>
					</div>
					<div class="linha">
						<div class="col1 cola modal1">Bairro: <div class="texto" id="modalBairro"></div>
						</div>
						<div class="col2 colb modal1">Cidade: <div class="texto" id="modalCidade"></div>
						</div>
						<div class="col3 colc modal1">UF: <div class="texto" id="modalUf"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

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

		function informacao() {
			if (selectedUserId) {
				window.location.href = "s_alunos_info.php?userId=" + selectedUserId;
			} else {
				alert("Por favor, selecione um aluno.");
			}
		}
	</script>

</body>

</html>