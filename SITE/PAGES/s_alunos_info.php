<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
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

        .idade {
            margin-left: 63px;
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
    </style>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
    <script>
        function mostrarDetalhes(elemento) {
            var turmaCod = elemento.getAttribute('data-turma-cod');
            document.getElementById('turmaAtual').textContent = turmaCod;
        }
    </script>



    <?php include ('../PHP/data.php'); ?>
    <?php include ('../PHP/sidebar/menu.php'); ?>
    <?php include ('../PHP/redes.php'); ?>
    <?php include ('../PHP/dropdown.php'); ?>

    <div id="modalConfirmacao"
        style="display:none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1050; align-items: center; justify-content: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <p>Tem certeza de que deseja alterar a situação do aluno?</p>
            <button id="confirmarMudanca" style="margin-right: 10px;">Sim</button>
            <button id="cancelarMudanca">Não</button>
        </div>
    </div>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>INFORMAÇÕES DO ALUNO</h1>
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

    <main class="coluna">
        <div class="row">
            <!-- Dados do aluno, igual ao da página de relatório do aluno -->
            <div class="informacao">
                <div class="titulo">
                    <p>Informações Pessoais</p>
                    <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
                    <a href="s_alunos_editar.php">
                    <button class="editar" type="button" >EDITAR INFORMAÇÃO</button>
                    </a>
                </div>
                <div class="infofuncionario">
                    <div class="func">
                        <div class="foto">
                            <img id="imagemExibida" src="<?php echo $row['Usuario_Foto']; ?>" alt="foto">
                        </div>
                        <div class="info-func">
                            <div class="modal">Nome: <div class="texto">
                                    <?php echo $row['Usuario_Nome']; ?>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Nascimento: <div class="texto" id="modalNascimento">
                                        <?php $nascimento = new DateTime($row['Usuario_Nascimento']);
                                        echo $nascimento->format('d/m/Y'); ?>
                                    </div>
                                </div>
                                <div class="col2 modal idade" for="idade">Idade:
                                    <div class="texto" id="modalIdade">
                                        <?php echo $row['Idade'] . " anos"; ?>
                                    </div>
                                </div>
                                <div class="col3 colc modal">Matrícula:
                                    <div class="texto" id="modalUf">
                                        <?php echo $row['Usuario_Matricula']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">CPF: <div class="texto" id="modalCpf">
                                        <?php echo $row['Usuario_Cpf']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal">RG: <div class="texto" id="modalRg">
                                        <?php echo $row['Usuario_Rg']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Sexo: <div class="texto" id="modalSexo">
                                        <?php if ($row['Usuario_Sexo'] === 'M') {
                                            echo 'Masculino';
                                        } else {
                                            echo 'Feminino';
                                        } ?>
                                    </div>
                                </div>
                                <div class="col2 modal">E-mail: <div class="texto" id="modalEmail">
                                        <?php echo $row['Usuario_Email']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Celular: <div class="texto" id="modalCelular">
                                        <?php echo $row['Usuario_Fone']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal">Data de Ingresso: <div class="texto" id="modalIngresso">
                                        <?php echo $row['Registro_Data']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="obs-func">
                        <p id="modalObs">
                            <?php echo $row['Usuario_Obs']; ?>
                        </p>
                    </div>
                </div>
                <div class="endereco">
                    <p>Endereço</p>
                    <div class="linha">
                        <div class="col1 cola modal">Logradouro: <div class="texto" id="modalLogradouro">
                                <?php echo $row['Enderecos_Rua']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">Nº: <div class="texto" id="modalNumero">
                                <?php echo $row['Enderecos_Numero']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal">Complemento: <div class="texto" id="modalComplemento">
                                <?php echo $row['Enderecos_Complemento']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">CEP: <div class="texto" id="modalCep">
                                <?php echo $row['Enderecos_Cep']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal">Bairro: <div class="texto" id="modalBairro">
                                <?php echo $row['Enderecos_Bairro']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">Cidade: <div class="texto" id="modalCidade">
                                <?php echo $row['Enderecos_Cidade']; ?>
                            </div>
                        </div>
                        <div class="col3 colc modal">UF: <div class="texto" id="modalUf">
                                <?php echo $row['Enderecos_Uf']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="informacao">
                <div class="titulo">
                    <p>Ocorrências</p>
                </div>
                <div id="ocorrencias" class="scroll-div-vertical">
                    <?php
                    if ($resultOcorrencias->num_rows > 0) {
                        while ($rowOcorrencia = $resultOcorrencias->fetch_assoc()) {
                            $dataOcorrencia = new DateTime($rowOcorrencia['Ocorrencia_Registro']);
                            // Exibir os detalhes de cada ocorrência
                            echo "<div class='infofuncionario margin'>";
                            echo "<div class='col1 cola modal ocorrencia'>Data: <div class='texto'>" . $dataOcorrencia->format('d/m/Y') . "</div></div>";
                            echo "<div class='cola ocorrencia'>" . $rowOcorrencia['Mensagem'] . "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<div>Nenhuma ocorrência registrada para este aluno.</div>";
                    }
                    ?>
                </div>
            </div>

        </div>
        </div>
        <div class="row">
            <div class="informacao">
                <div class="titulo">
                    <p>Informações Acadêmicas</p>
                    <button class="editar editarSituacao" id="editarSalvar" type="button"
                        onclick="window.location.href = 's_alunos_turma_cad.php'">
                        NOVA TURMA </button>
                </div>
                <?php
                // Supondo que $resultTurmas é o resultado da sua consulta ao banco de dados
                if ($resultTurmas->num_rows > 0) {
                    while ($rowTurma = $resultTurmas->fetch_assoc()) {
                        $alunoTurmaId = $rowTurma["Aluno_Turma_id"];
                        $cursoId = $rowTurma["Curso_id"];
                        // Início do bloco HTML para as informações de cada turma
                        echo '<div class="infofuncionario clicavel" onclick="mostrarDetalhes(this)" data-turma-cod="' . htmlspecialchars($rowTurma['Turma_Cod'], ENT_QUOTES, 'UTF-8') . '">';
                        echo '    <div class="cola modal ocorrencia">Curso:';
                        echo '        <div class="texto">';
                        echo $rowTurma['Curso_Nome'];
                        echo '        </div>';
                        echo '    </div>';
                        echo '    <div class="linha">';
                        echo '        <div class="col1 cola modal">Turma:';
                        echo '            <div class="texto">';
                        echo $rowTurma['Turma_Cod'];
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div class="col2 colb modal">Professor:';
                        echo '            <div class="texto" id="modalCidade">';
                        echo $rowTurma['Professor'];
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '    <div class="linha">';
                        echo '        <div class="col1 cola modal">Horário:';
                        echo '            <div class="texto" id="modalCidade">';
                        $horarioInicio = date('H:i', strtotime($rowTurma['Turma_Horario']));
                        $horarioTermino = date('H:i', strtotime($rowTurma['Turma_Horario_Termino']));
                        echo $horarioInicio . ' - ' . $horarioTermino;
                        echo '            </div>';
                        echo '        </div>';
                        echo '        <div class="col2 colb modal">Situação:';
                        echo '            <div class="select texto" id="situacaoSelect" >';
                        echo '              <label><input class="texto" type="radio" name="situacao" value="Ativo" ' . ($rowTurma['Aluno_Turma_Status'] === '1' ? 'checked' : '') . '> Ativo</label>';
                        echo '              <label><input class="texto" type="radio" name="situacao" value="Inativo" ' . ($rowTurma['Aluno_Turma_Status'] === '0' ? 'checked' : '') . '> Inativo</label>';
                        echo '             </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '    <div class="linha">';
                        echo '        <div class="col1 cola modal">Frequência:';
                        echo '            <div class="texto">';
                        echo $rowTurma['Frequencia'] . '%'; // Aqui usamos o valor da frequência da consulta
                        echo '            </div>&nbsp;&nbsp;';
                        echo '            <div class="barra-frequencia-container">';
                        echo '                <div class="barra-frequencia" style="width: ' . $rowTurma['Frequencia'] . '%;">';
                        echo '                </div>';
                        echo '            </div>';
                        echo '        </div>';
                        echo '    </div>';
                        echo '</div>';
                        // Fim do bloco HTML
                    }
                } else {
                    echo "<div>Nenhuma turma encontrada para este aluno.</div>";
                }
                ?>

            </div>
            <div class="informacao">
                <div class="titulo">
                    <p>Troca de Turma</p>
                    <button class="editar editarSituacao" id="editarSalvarTurma" type="button"
                        onclick="editarTurma()">TROCAR
                        TURMA</button>
                </div>
                <div class="infofuncionario">
                    <div class="linha ocorrencia">
                        <div class="col1 cola modal">Turma Atual:
                            <div class="texto" id="turmaAtual">
                            </div>
                        </div>
                        <div class="col2 colb modal">Turma Destino:
                            <div class="texto" id="turmaTexto">
                                --
                            </div>
                            <div class="select" id="turmaDestinoSelect">
                                <select name="turmaDestino" id="turmaDestino" style="display:none;">
                                    <?php
                                    // Consulta SQL para obter as turmas do curso especificado
                                    $sqlTurma = "SELECT Turma_Cod FROM Turma WHERE Curso_cd = $cursoId";
                                    $resultTurma = $conn->query($sqlTurma);

                                    // Verifica se foram encontradas turmas para o curso
                                    if ($resultTurma->num_rows > 0) {
                                        // Loop para exibir cada turma como uma opção no menu suspenso
                                        while ($rowTurma = $resultTurma->fetch_assoc()) {
                                            echo "<option value='" . $rowTurma["Turma_Cod"] . "'>" . $rowTurma["Turma_Cod"] . " </option>";
                                        }
                                    } else {
                                        echo "<option>Nenhuma Turma encontrada!</option>";
                                    }
                                    ?>
                                </select>
                            </div>
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
    <script>

        function salvarSituacao() {
            // Obtém a nova situação a partir do botão de rádio selecionado no modal
            var situacaoNova = document.querySelector('input[name="situacao"]:checked').value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/alt_aluno_situacao.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Assumindo que a resposta do servidor seja a nova situação do aluno ("Ativo" ou "Inativo")
                    var resposta = xhr.responseText.trim(); // Supondo que a resposta seja simplesmente "Ativo" ou "Inativo"

                    // Atualiza o texto que mostra a situação do aluno na página
                    var situacaoTexto = document.querySelector('#situacaoTexto'); // Certifique-se de que este elemento exista
                    if (situacaoTexto) {
                        situacaoTexto.innerText = resposta;
                    }

                    // location.reload(); // Descomente esta linha se quiser recarregar a página inteira após a mudança
                }
            };
            xhr.send("situacao=" + encodeURIComponent(situacaoNova) + "&aluno_turma_id=" + encodeURIComponent(alunoTurmaId)); // Substitua `alunoTurmaId` pelo ID correto
        }


        function editarTurma() {
            var turmaTexto = document.getElementById('turmaTexto');
            var turmaDestinoSelect = document.getElementById('turmaDestinoSelect');
            var botaoTurma = document.getElementById('editarSalvarTurma'); // Referência ao botão por ID

            if (botaoTurma.innerText === "TROCAR TURMA") {
                // Entrando no modo de Edição
                turmaTexto.style.display = 'none';
                turmaDestinoSelect.style.display = 'block'; // Garante que o select seja exibido
                turmaDestino.style.display = '';
                botaoTurma.innerText = "SALVAR";

                // Ajustes de estilo para o modo de edição
                botaoTurma.style.backgroundColor = "#6EC77D"; // Verde
                botaoTurma.style.color = "#0D4817"; // Verde escuro
                botaoTurma.style.width = "90px";
            } else {
                // Se já estiver no modo de edição, procede para salvar a nova turma
                salvarTurma();
            }
        }

        function salvarTurma() {
            var turmaNova = document.getElementById('turmaDestino').value;

            // Verifica se o valor da turma nova não está vazio
            if (turmaNova.trim() === '') {
                alert('Por favor, selecione uma turma.');
                return;
            }

            var turma = new XMLHttpRequest();
            turma.open("POST", "../PHP/alt_aluno_turma.php", true); // Certifique-se que o caminho está correto
            turma.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            turma.onreadystatechange = function () {
                if (turma.status >= 200 && turma.status < 300) {
                    console.log("Resposta do servidor:", turma.responseText);
                    // Sucesso no salvamento, atualiza o texto e esconde o select
                    var turmaTexto = document.getElementById('turmaTexto');
                    var turmaDestinoSelect = document.getElementById('turmaDestinoSelect');
                    var botaoTurma = document.getElementById('editarSalvarTurma');

                    turmaTexto.innerText = turmaNova; // Atualiza com a nova turma
                    turmaTexto.style.display = 'block';
                    turmaDestinoSelect.style.display = 'none'; // Esconde o select
                    botaoTurma.innerText = "TROCAR TURMA";

                    // Reverte os estilos do botão para o estado inicial
                    botaoTurma.style.backgroundColor = "";
                    botaoTurma.style.color = "";
                    botaoTurma.style.width = "";
                    location.reload(); // Recarrega a página para atualizar as informações exibidas
                } else {
                    console.error("Falha na requisição:", turma.statusText);
                }
            };
            turma.onerror = function () {
                console.error("Erro na requisição.");
            };
            turma.send("turma=" + encodeURIComponent(turmaNova) + "&aluno_turma_id=" + encodeURIComponent(alunoTurmaId));
        }

        var selectedUserId = <?php echo json_encode($userId); ?>; // Atribui o valor PHP à variável JavaScript
        var alunoTurmaId = <?php echo json_encode($alunoTurmaId); ?>;// Variável global com a ID da Turma do Aluno logado

    </script>

    <script>
        var situacaoOriginal; // Variável para armazenar a situação atual antes da mudança

        document.querySelectorAll('input[name="situacao"]').forEach(radio => {
            radio.addEventListener('change', function () {
                // Armazena a situação atual antes de qualquer mudança
                situacaoOriginal = document.querySelector('input[name="situacao"]:checked').value;
                mostrarModalConfirmacao();
            });
        });

        document.getElementById('cancelarMudanca').addEventListener('click', function () {
            esconderModalConfirmacao();
            // Restaura a seleção do botão de rádio para a situação original
            document.querySelectorAll(`input[name="situacao"]`).forEach(radio => {
                radio.checked = radio.value === situacaoOriginal;
            });
        });

        document.getElementById('confirmarMudanca').addEventListener('click', function () {
            salvarSituacao(); // A função que salva a nova situação
            esconderModalConfirmacao();
        });

        function mostrarModalConfirmacao() {
            document.getElementById('modalConfirmacao').style.display = 'flex';
        }

        function esconderModalConfirmacao() {
            document.getElementById('modalConfirmacao').style.display = 'none';
            // Recarrega a página imediatamente após cancelar
            location.reload();
        }
    </script>


</body>

</html>