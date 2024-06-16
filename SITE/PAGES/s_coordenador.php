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
$tipoUsuario = 5;
$informacao = 'EDITAR INFORMAÇÕES';
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
                <?php require_once '../COMPONENTS/turmaLeciona.php'; ?>
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
                window.location.href = "s_professores_editar.php?userId=" + selectedUserId;
            } else {
                alert("Por favor, selecione um professor antes de editar.");
            }
        }

        function buscarTurmas(userId) {
            $.ajax({
                url: '../PHP/turma_professor.php', // URL do endpoint no servidor
                type: 'GET',
                data: { userId: userId }, // Passa o userId como parâmetro para a consulta
                dataType: 'json', // Espera-se que a resposta seja JSON
                success: function (response) {
                    // Limpa a tabela antes de adicionar novos dados
                    var tabelaTurmas = document.getElementById('tabela-turma');
                    tabelaTurmas.innerHTML = '';

                    // Verifica se a resposta contém turmas
                    if (response && response.length > 0) {
                        let contador = 0;
                        response.forEach(function (turma) {
                            const classeLinha = (contador % 2 === 0) ? 'linha-par' : 'linha-impar';
                            // Cria uma nova linha na tabela para cada turma
                            var linha = document.createElement('tr');
                            linha.className = classeLinha;
                            linha.innerHTML = `
                        <td>${turma.Turma_Cod}</td>
                        <td>${turma.Curso_Nome}</td>
                        <td class="text-center">${turma.Total_Alunos}</td>
                    `;
                            // Adiciona a nova linha na tabela
                            tabelaTurmas.appendChild(linha);
                            linha.addEventListener('click', function () {
                                window.location.href = `s_turma_detalhes.php?id=${turma.Turma_Cod}`;
                            });
                            contador++;
                        });
                    } else {
                        // Caso não haja turmas, mostra uma mensagem na tabela
                        tabelaTurmas.innerHTML = '<tr><td colspan="3">Nenhuma turma encontrada para este professor.</td></tr>';
                    }
                },
                error: function () {
                    alert('Erro ao buscar turmas do professor.');
                }
            });
        }

    </script>


</body>

</html>