<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}

$userId = $_SESSION['UsuarioSelecionado'] ?? null;
if (!$userId) {
    die("Usuário não selecionado. Por favor, faça a seleção do usuário antes de prosseguir.");
}

$_SESSION['AlunoId'] = $userId;

$sql = "SELECT U.*, E.*, RU.*, ROUND(DATEDIFF(CURDATE(), U.Usuario_Nascimento)/365) AS Idade FROM Usuario U JOIN Enderecos E ON U.Enderecos_Enderecos_cd = E.Enderecos_id JOIN Registro_Usuario RU ON U.Usuario_id = RU.Usuario_Usuario_cd WHERE U.Usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Usuário não encontrado.");
}

$sqlTurma = "SELECT AT.*, T.*, C.*, U.Usuario_Nome AS Professor, (SELECT ROUND((COUNT(CASE WHEN presenca = '1' THEN 1 END) / COUNT(*) * 100), 0) FROM chamada WHERE chamada.id_aluno_turma = AT.Aluno_Turma_id) AS Frequencia FROM Aluno_Turma AT JOIN Turma T ON AT.Turma_Turma_Cod = T.Turma_Cod JOIN Curso C ON T.Curso_cd = C.Curso_id JOIN Usuario U ON T.Usuario_Usuario_cd = U.Usuario_id WHERE AT.Usuario_Usuario_cd = ?";
$stmtTurma = $conn->prepare($sqlTurma);
$stmtTurma->bind_param("i", $userId);
$stmtTurma->execute();
$resultTurmas = $stmtTurma->get_result();

// Consulta para recuperar ocorrências do aluno
$sqlOcorrencias = "SELECT * FROM Ocorrencia O JOIN Aluno_Turma AT ON O.Aluno_Turma_cd = AT.Aluno_Turma_id WHERE AT.Usuario_Usuario_cd = ? ORDER BY Ocorrencia_Registro DESC";
$stmtOcorrencias = $conn->prepare($sqlOcorrencias);
$stmtOcorrencias->bind_param("i", $userId);
$stmtOcorrencias->execute();
$resultOcorrencias = $stmtOcorrencias->get_result();

$home = 's_alunos.php'; //utilizado pelo botão voltar
$titulo = 'INFORMAÇÃO DO ALUNO'; //Título da página, que fica sobre a data
$informacao = 'EDITAR INFORMAÇÕES'; // utilizado no botão
require_once '../PHP/formatarInfo.php';
?>

<style>
    .aluno path {
        fill: #043140;
    }

    main {
        align-items: center;
    }

    .barra-frequencia-container {
        background-color: #233939;
        border-radius: 10px;
        overflow: hidden;
        width: 100%;
    }

    .barra-frequencia {
        height: 20px;
        background-color: #4CAF50;
        text-align: center;
        line-height: 20px;
        color: white;
        border-radius: 10px;
        /* Arredonda apenas os cantos esquerdos */
    }

    #ocorrencias {
        gap: 10px;
        display: flex;
        flex-direction: column;
    }

    .margin {
        margin-top: 1px;
    }

    .scroll-div-vertical {
        height: 350px;
        overflow-y: auto;
    }

    .clicavel {
        cursor: pointer;
    }



    .centralizar {
        justify-content: center;
        margin-left: 50px;
    }

    .informacao2 {
        background-color: #E7E7E7;
        border-radius: 20px;
        box-shadow: 0 0 5px 1px #00000040;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-width: 50%;
    }
</style>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var globalCursoId = null;

            function mostrarDetalhes(elemento) {
                var turmaCod = elemento.getAttribute('data-turma-cod');
                globalCursoId = elemento.getAttribute('data-curso-id').trim();
                document.getElementById('turmaAtual').textContent = turmaCod;

                // Redefinir o botão "Trocar Turma"
                var botaoTurma = document.getElementById('editarSalvarTurma');
                var turmaTexto = document.getElementById('turmaTexto');
                var turmaDestinoSelect = document.getElementById('turmaDestinoSelect');

                botaoTurma.innerText = "TROCAR TURMA";
                botaoTurma.style.backgroundColor = "";
                botaoTurma.style.color = "";
                botaoTurma.style.width = "";

                turmaTexto.style.display = 'block';
                turmaDestinoSelect.style.display = 'none';

                // Adicionar evento ao botão "Trocar Turma"
                botaoTurma.onclick = function (event) {
                    event.preventDefault();
                    editarTurma();
                };
            }

            function editarTurma() {
                var turmaTexto = document.getElementById('turmaTexto');
                var turmaDestinoSelect = document.getElementById('turmaDestinoSelect');
                var botaoTurma = document.getElementById('editarSalvarTurma');
                var turmaAtual = document.getElementById('turmaAtual').textContent.trim();

                if (!turmaAtual || turmaAtual === '--') {
                    alert('Por favor, selecione uma turma atual antes de continuar.');
                    return;
                }

                if (botaoTurma.innerText.trim() === "TROCAR TURMA") {
                    turmaTexto.style.display = 'none';
                    turmaDestinoSelect.style.display = 'block';
                    var selectElement = document.getElementById('turmaDestino');

                    // Envia cursoId via AJAX
                    $.ajax({
                        type: 'POST',
                        url: '../PHP/busca_turmas.php',
                        data: { curso_id: globalCursoId },
                        success: function (response) {
                            console.log("Curso ID enviado com sucesso:", globalCursoId);
                            // Atualiza o dropdown com as turmas retornadas
                            selectElement.innerHTML = response;
                            selectElement.style.display = 'block';
                        },
                        error: function () {
                            console.error("Erro ao enviar Curso ID.");
                        }
                    });

                    botaoTurma.innerText = "SALVAR";
                    botaoTurma.style.backgroundColor = "#6EC77D";
                    botaoTurma.style.color = "#0D4817";
                    botaoTurma.style.width = "90px";
                } else {
                    salvarTurma();
                }
            }

            function salvarTurma() {
                var turmaNova = document.getElementById('turmaDestino').value;
                if (turmaNova.trim() === '') {
                    alert('Por favor, selecione uma turma.');
                    return;
                }

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../PHP/alt_aluno_turma.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Resposta do servidor:", xhr.responseText);
                        var turmaTexto = document.getElementById('turmaTexto');
                        var turmaDestinoSelect = document.getElementById('turmaDestinoSelect');
                        var botaoTurma = document.getElementById('editarSalvarTurma');
                        turmaTexto.innerText = turmaNova;
                        turmaTexto.style.display = 'block';
                        turmaDestinoSelect.style.display = 'none';
                        botaoTurma.innerText = "TROCAR TURMA";
                        botaoTurma.style.backgroundColor = "";
                        botaoTurma.style.color = "";
                        botaoTurma.style.width = "";
                        location.reload();
                    } else if (xhr.readyState === 4) {
                        console.error("Falha na requisição:", xhr.statusText);
                        alert("Falha ao salvar a turma. Por favor, tente novamente.");
                    }
                };
                xhr.onerror = function () {
                    console.error("Erro na requisição.");
                    alert("Erro na requisição. Por favor, tente novamente.");
                };
                xhr.send("turma=" + encodeURIComponent(turmaNova) + "&aluno_turma_id=" + encodeURIComponent(alunoTurmaId));
            }

            // Delegação de eventos para garantir que os eventos de clique sejam anexados a cada nova turma dinamicamente
            document.body.addEventListener('click', function (event) {
                if (event.target.closest('.turma.clicavel')) {
                    mostrarDetalhes(event.target.closest('.turma.clicavel'));
                }
            });
        });

    </script>

    <div id="modalConfirmacao"
        style="display:none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center;">
        <div class="d-flex flex-column align-items-center"
            style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <p>Tem certeza de que deseja alterar a situação do aluno?</p>
            <div>
                <button class="btn btn-success" id="confirmarMudanca">Sim</button>
                <button class="btn btn-danger" id="cancelarMudanca">Não</button>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="d-flex row form-group justify-content-center mt-3" style="margin-left: 76px;">
            <div class="col-sm-5">
                <?php require_once '../COMPONENTS/infoAluno.php'; ?>
                <?php require_once '../COMPONENTS/infoAcademico.php'; ?>
            </div>
            <div class="col-sm-5">
                <?php require_once '../COMPONENTS/ocorrencias.php'; ?>
                <?php require_once '../COMPONENTS/trocarTurma.php'; ?>
            </div>
        </div>
    </div>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Adicionar evento para radio buttons de situação
            document.querySelectorAll('.situacaoRadio').forEach(radio => {
                radio.addEventListener('change', function () {
                    var alunoTurmaId = this.closest('.turma').getAttribute('data-aluno-turma-id');
                    var situacaoOriginal = document.querySelector('input[name="situacao_' + alunoTurmaId + '"]:checked').value;
                    mostrarModalConfirmacao(alunoTurmaId, situacaoOriginal);
                });
            });

            document.getElementById('cancelarMudanca').addEventListener('click', function () {
                esconderModalConfirmacao();
            });

            document.getElementById('confirmarMudanca').addEventListener('click', function () {
                salvarSituacao();
                esconderModalConfirmacao();
            });

            function mostrarModalConfirmacao(alunoTurmaId, situacaoOriginal) {
                document.getElementById('modalConfirmacao').style.display = 'flex';
                document.getElementById('confirmarMudanca').setAttribute('data-aluno-turma-id', alunoTurmaId);
                document.getElementById('confirmarMudanca').setAttribute('data-situacao-original', situacaoOriginal);
            }

            function esconderModalConfirmacao() {
                document.getElementById('modalConfirmacao').style.display = 'none';
                location.reload();
            }

            function salvarSituacao() {
                var alunoTurmaId = document.getElementById('confirmarMudanca').getAttribute('data-aluno-turma-id');
                var situacaoNova = document.querySelector('input[name="situacao_' + alunoTurmaId + '"]:checked').value;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../PHP/alt_aluno_situacao.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var resposta = xhr.responseText.trim();
                        var situacaoTexto = document.querySelector('#situacaoTexto');
                        if (situacaoTexto) {
                            situacaoTexto.innerText = resposta;
                        }
                        location.reload();
                    }
                };
                xhr.send("situacao=" + encodeURIComponent(situacaoNova) + "&aluno_turma_id=" + encodeURIComponent(alunoTurmaId));
            }
        });

    </script>

</body>

</html>