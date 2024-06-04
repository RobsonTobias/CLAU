<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
	// Se não houver sessão ativa, inicia a sessão
	session_start();
}
$userId = $_SESSION['Usuario_id'];
$turmaId = $_SESSION['Usuario_id'];
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
	</style>
</head>

<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<?php include ('../PHP/data.php'); ?>
	<?php include ('../PHP/sidebar/menu.php'); ?>
	<?php include ('../PHP/redes.php'); ?>
	<?php include ('../PHP/dropdown.php'); ?>

	<header>
		<div class="title">
			<div class="nomedata closed">
				<h1>CONSULTA DAS TURMAS</h1>
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

	<main class="ajuste">
		<div class="pesquisa">
			<p>Pesquisar:</p>
			<input type="text" id="searchInput" placeholder="Digite um nome para pesquisar">
			<table class="table table-hover">
				<tr>
					<th>CURSO</th>
					<th>TURMA</th>
				</tr>
				<?php
				$sql = "SELECT * FROM Aluno_Turma
                left JOIN Turma on Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
                left JOIN Curso on Curso.Curso_id = Turma.Curso_cd
                WHERE Aluno_Turma.Usuario_Usuario_cd = $userId";
            

				$contador = 0;
				$resultado = $conn->query($sql);
				if ($resultado && $resultado->num_rows > 0) {
					while ($row = $resultado->fetch_assoc()) {
						$classeLinha = ($contador % 2 == 0) ? 'linha-par' : 'linha-impar';
						echo "<tr data-id='" . $row["Aluno_Turma_id"] . "' class='" . $classeLinha . "' onclick='mostrarDetalhes(this)'>";
						echo "<td class='nomeusuario'>" . $row["Curso_Nome"] . "</td>";
						echo "<td class='matricula'>" . $row["Turma_Cod"] . "</td>";
						echo "</tr>";
						$contador++;
					}
				} else {
					echo "<tr><td colspan='2'>Nenhuma turma encontrado.</td></tr>";
				}
				?>
			</table>
		</div>
		<div class="informacoes">
			<div class="informacao">
				<div class="titulo">
					<p>Informações da Turma</p>
				</div>
				<div class="infofuncionario">
					<div class="func">
						<div class="foto">
							<img id="imagemExibida" src="../ICON/perfil.svg" alt="foto">
						</div>
						<div class="info-func">
							<div class="modal">Código da Turma: <div class="texto" id="turmaCod" value="<?php echo $row['Turma_Cod']; ?>"></div>
							</div>
							<div class="linha">
								<div class="col1 modal">Status: <div class="texto" id="status" value="<?php 
                                    if ($row['Turma_Status'] == 1){
                                        echo "CURSANDO";
                                    } 
                                    else {
                                        echo "FINALIZADO";
                                    } ?>"></div>
								</div>
								<div class="col2 modal">Periodo: <div class="texto" id="periodo" value="<?php echo $row['Turma_Obs']; ?>"></div>
								</div>
							</div>
                            <div class="linha">
								<div class="col1 modal">Curso: <div class="texto" id="curso" value="<?php echo $row['Curso_Nome']; ?>"></div>
								</div>
								<div class="col2 modal">Dias por Semana : <div class="texto" id="dias" value="<?php echo $row['Turma_Dias']; ?>"></div>
								</div>
							</div>
							<div class="linha">
								<div class="col1 modal">Horário-Início: <div class="texto" id="horarioIni" value="<?php echo $row['Turma_Horario']; ?>"></div>
								</div>
								<div class="col2 modal">Horário-Término: <div class="texto" id="horarioTer" value="<?php echo $row['Turma_Horario_Termino']; ?>"></div>
								</div>
							</div>
							<div class="linha">
								<div class="col1 modal">Turma-Início: <div class="texto" id="turmaIni" value="<?php echo $row['Turma_Inicio']; ?>"></div>
								</div>
								<div class="col2 modal">Turma-Término: <div class="texto" id="turmaTer" value="<?php echo $row['Turma_Termino']; ?>"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="obs-func">
						<p id="modalObs">Nenhuma informação cadastrada!</p>
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

	<script src="../JS/pesquisa.js"></script>
	<script>


		var selectedUserId; // Variável global para armazenar o ID do usuário selecionado

		function mostrarDetalhes(elemento) {
			selectedUserId = elemento.getAttribute('data-id'); // Atualiza a variável global

			$.ajax({
				url: '../PHP/det_turma.php',
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
		function exibirDetalhesUsuario(dados) {

			var cod = document.getElementById('turmaCod');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Cod;
			} else {
				contNome = '<p>Não informado</p>';
				console.log(dados);
			}

			cod.innerHTML = contNome;
			cod.style.display = 'block';


			var status = document.getElementById('status');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Status;
			} else {
				contNome = '<p>Não informado</p>';
			}

			status.innerHTML = contNome;
			status.style.display = 'block';


			var curso = document.getElementById('periodo');
			var contNome = '';

			if (dados) {
				contNome += dados.Curso;
			} else {
				contNome = '<p>Não informado</p>';
			}

			curso.innerHTML = contNome;
			curso.style.display = 'block';


			var curso = document.getElementById('curso');
			var contNome = '';

			if (dados) {
				contNome += dados.Curso_Nome;
			} else {
				contNome = '<p>Não informado</p>';
			}

			curso.innerHTML = contNome;
			curso.style.display = 'block';


			var dias = document.getElementById('dias');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Dias;
			} else {
				contNome = '<p>Não informado</p>';
			}

			dias.innerHTML = contNome;
			dias.style.display = 'block';


			var horarioIni = document.getElementById('horarioIni');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Horario;
			} else {
				contNome = '<p>Não informado</p>';
			}

			horarioIni.innerHTML = contNome;
			horarioIni.style.display = 'block';


			var horarioTer = document.getElementById('horarioTer');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Horario_Termino;
			} else {
				contNome = '<p>Não informado</p>';
			}

			horarioTer.innerHTML = contNome;
			horarioTer.style.display = 'block';


			var turmaIni = document.getElementById('turmaIni');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Inicio;
			} else {
				contNome = '<p>Não informado</p>';
			}

			turmaIni.innerHTML = contNome;
			turmaIni.style.display = 'block';


			var termino = document.getElementById('turmaTer');
			var contNome = '';

			if (dados) {
				contNome += dados.Turma_Termino;
			} else {
				contNome = '<p>Não informado</p>';
			}

			termino.innerHTML = contNome;
			termino.style.display = 'block';

			



			
			
		}
	</script>

	
</body>

</html>