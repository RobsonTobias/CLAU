<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['Tipo_Tipo_cd'] != 5) {
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

require_once '../PHP/formatarInfo.php';
$home = 's_alunos.php'; //utilizado pelo botão voltar
$titulo = 'INFORMAÇÃO DO ALUNO'; //Título da página, que fica sobre a data
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

    <?php require_once '../COMPONENTS/header.php' ?>

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
                        <button class="editar" type="button">EDITAR INFORMAÇÃO</button>
                    </a>
                </div>
                <div class="infofuncionario">
                    <div class="func">
                        <div class="foto">
                            <img id="imagemExibida" src="<?php echo $row['Usuario_Foto']; ?>" alt="foto">
                        </div>
                        <div class="info-func">
                            <div class="linha">
                                <div class="col1 modal1">Nome: <div class="texto">
                                        <?php echo $row['Usuario_Nome']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal1">Matrícula:
                                    <div class="texto" id="modalUf">
                                        <?php echo $row['Usuario_Matricula']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal1">Nascimento: <div class="texto" id="modalNascimento">
                                        <?php $nascimento = new DateTime($row['Usuario_Nascimento']);
                                        echo $nascimento->format('d-m-Y'); ?>
                                    </div>
                                </div>
                                <div class="col2 modal1 idade" for="idade">Idade:
                                    <div class="texto" id="modalIdade">
                                        <?php echo $row['Idade'] . " anos"; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal1">CPF: <div class="texto" id="modalCpf">
                                        <?php echo $row['Usuario_Cpf']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal1">RG: <div class="texto" id="modalRg">
                                        <?php echo $row['Usuario_Rg']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal1">Sexo: <div class="texto" id="modalSexo">
                                        <?php if ($row['Usuario_Sexo'] === 'M') {
                                            echo 'Masculino';
                                        } else {
                                            echo 'Feminino';
                                        } ?>
                                    </div>
                                </div>
                                <div class="col2 modal1">E-mail: <div class="texto" id="modalEmail">
                                        <?php echo $row['Usuario_Email']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal1">Celular: <div class="texto" id="modalCelular">
                                        <?php echo $row['Usuario_Fone']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal1">Data de Ingresso: <div class="texto" id="modalIngresso">
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
                        <div class="col1 cola modal1">Logradouro: <div class="texto" id="modalLogradouro">
                                <?php echo $row['Enderecos_Rua']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal1">Nº: <div class="texto" id="modalNumero">
                                <?php echo $row['Enderecos_Numero']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal1">Complemento: <div class="texto" id="modalComplemento">
                                <?php echo $row['Enderecos_Complemento']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal1">CEP: <div class="texto" id="modalCep">
                                <?php echo $row['Enderecos_Cep']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal1">Bairro: <div class="texto" id="modalBairro">
                                <?php echo $row['Enderecos_Bairro']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal1">Cidade: <div class="texto" id="modalCidade">
                                <?php echo $row['Enderecos_Cidade']; ?>
                            </div>
                        </div>
                        <div class="col3 colc modal1">UF: <div class="texto" id="modalUf">
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
                            echo "<div class='col1 cola modal1 ocorrencia'>Data: <div class='texto'>" . $dataOcorrencia->format('d/m/Y') . "</div></div>";
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
                        NOVA TURMA 
                    </button>
                </div>
                <?php
                // Supondo que $resultTurmas é o resultado da sua consulta ao banco de dados
                if ($resultTurmas->num_rows > 0) {
                    while ($rowTurma = $resultTurmas->fetch_assoc()) {
                        $alunoTurmaId = $rowTurma["Aluno_Turma_id"];
                        $cursoId = $rowTurma["Curso_id"];
                        // Início do bloco HTML para as informações de cada turma
                        ?>
                        <div class="infofuncionario clicavel" onclick="mostrarDetalhes(this)"
                            data-turma-cod="<?php echo htmlspecialchars($rowTurma['Turma_Cod'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-curso-id=" <?php $rowTurma['Curso_id']; ?>">
                            <div class="cola modal1 ocorrencia">Curso:
                                <div class="texto"> <?php echo $rowTurma['Curso_Nome']; ?> </div>
                            </div>
                            <div class="linha">
                                <div class="col1 cola modal1">Turma:
                                    <div class="texto"> <?php echo $rowTurma['Turma_Cod']; ?> </div>
                                </div>
                                <div class="col2 colb modal1">Professor:
                                    <div class="texto" id="modalCidade"> <?php echo $rowTurma['Professor']; ?> </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 cola modal1">Horário:
                                    <div class="texto" id="modalCidade">
                                        <?php
                                        $horarioInicio = date('H:i', strtotime($rowTurma['Turma_Horario']));
                                        $horarioTermino = date('H:i', strtotime($rowTurma['Turma_Horario_Termino']));
                                        echo $horarioInicio . ' - ' . $horarioTermino;
                                        ?>
                                    </div>
                                </div>
                                <div class="col2 colb modal1">Situação:
                                    <div class="select texto" id="situacaoSelect">
                                        <label>
                                            <input class="texto" type="radio" name="situacao" value="Ativo" <?php echo ($rowTurma['Aluno_Turma_Status'] === '1' ? 'checked' : ''); ?>>
                                            Ativo
                                        </label>
                                        <label>
                                            <input class="texto" type="radio" name="situacao" value="Inativo" <?php echo ($rowTurma['Aluno_Turma_Status'] === '0' ? 'checked' : ''); ?>>
                                            Inativo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 cola modal1">Frequência:
                                    <div class="texto" style="width: 10%;">
                                        <?php echo $rowTurma['Frequencia']; ?>%
                                    </div>&nbsp;&nbsp;
                                    <div class="barra-frequencia-container">
                                        <div class="barra-frequencia" style="width: <?php echo $rowTurma['Frequencia']; ?>%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<div>Nenhuma turma encontrada para este aluno.</div>";
                }
                ?>

            </div>
            <div class="informacao">
                <div class="titulo">
                    <p>Troca de Turma</p>
                    <button class="editar editarSituacao" id="editarSalvarTurma" type="button" >
                        TROCAR TURMA
                    </button>
                </div>
                <div class="infofuncionario">
                    <div class="linha ocorrencia">
                        <div class="col1 cola modal1">Turma Atual:
                            <div class="texto" id="turmaAtual">
                            </div>
                        </div>
                        <div class="col2 colb modal1">Turma Destino:
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

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('editarSalvarTurma').addEventListener('click', function (event) {
                event.preventDefault();
                editarTurma();
            });

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
                    selectElement.style.display = 'block';

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

            // Inicializar variáveis de usuário
            var selectedUserId = <?php echo json_encode($userId); ?>;
            var alunoTurmaId = <?php echo json_encode($alunoTurmaId); ?>;

            // Adicionar evento para radio buttons de situação
            var situacaoOriginal;
            document.querySelectorAll('input[name="situacao"]').forEach(radio => {
                radio.addEventListener('change', function () {
                    situacaoOriginal = document.querySelector('input[name="situacao"]:checked').value;
                    mostrarModalConfirmacao();
                });
            });

            document.getElementById('cancelarMudanca').addEventListener('click', function () {
                esconderModalConfirmacao();
                document.querySelectorAll('input[name="situacao"]').forEach(radio => {
                    radio.checked = radio.value === situacaoOriginal;
                });
            });

            document.getElementById('confirmarMudanca').addEventListener('click', function () {
                salvarSituacao();
                esconderModalConfirmacao();
            });

            function mostrarModalConfirmacao() {
                document.getElementById('modalConfirmacao').style.display = 'flex';
            }

            function esconderModalConfirmacao() {
                document.getElementById('modalConfirmacao').style.display = 'none';
                location.reload();
            }

            function salvarSituacao() {
                var situacaoNova = document.querySelector('input[name="situacao"]:checked').value;
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