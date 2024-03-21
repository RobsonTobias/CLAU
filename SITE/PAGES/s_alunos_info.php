<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}

$userId = $_SESSION['UsuarioSelecionado'];

// Consulta para recuperar informações do usuário
$sql = "SELECT 
U.*,
E.*,
RU.*,
AT.*,
O.*,
T.*,
C.*,
U2.Usuario_Nome AS Professor
FROM 
Usuario U
JOIN
Enderecos E ON U.Enderecos_Enderecos_cd = E.Enderecos_id
JOIN
Registro_Usuario RU ON U.Usuario_id = RU.Usuario_Usuario_cd
JOIN 
Aluno_Turma AT ON U.Usuario_id = AT.Usuario_Usuario_cd
LEFT JOIN
Ocorrencia O ON AT.Aluno_Turma_id = O.Aluno_Turma_cd
JOIN 
Turma T ON AT.Turma_Turma_Cod = T.Turma_Cod
JOIN
Curso C ON T.Curso_cd = C.Curso_id
JOIN 
Usuario U2 ON T.Usuario_Usuario_cd = U2.Usuario_id
where U.Usuario_id = $userId";

$result = $conn->query($sql);

// Verificar se o usuário existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $estadocivil = $row['Usuario_EstadoCivil'];
} else {
    echo "Usuário não encontrado";
}
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
                    <button class="editar" type="button" onclick="editar()">EDITAR INFORMAÇÃO</button>
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
                                        <?php echo $row['Usuario_Nascimento']; ?>
                                    </div>
                                </div>
                                <div class="col2 modal" for="idade">Idade: <div class="texto" id="modalIdade"></div>
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
                                        <?php echo $row['Usuario_Sexo']; ?>
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
                <div class="infofuncionario">
                    <div class="linha">
                        <div class="col1 cola modal ocorrencia">Data:
                            <div class="texto" id="modalNascimento">
                                <?php echo $row['Usuario_Nascimento']; ?> <!-- Aqui vai a data da ocorrencia -->
                            </div>
                        </div>
                        <div class="col2 modal ocorrencia" for="idade">
                            Assunto:
                            <div class="texto" id="modalIdade">
                                <?php echo $row['Usuario_Sexo']; ?> <!-- Aqui vai o Assunto -->
                            </div>
                        </div>
                    </div>
                    <div class="cola ocorrencia">
                        <?php echo $row['Mensagem']; ?> <!-- Aqui vai a descrição da ocorrencia -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="informacao">
                <div class="titulo">
                    <p>Informações Acadêmicas</p>
                    <button class="editar" type="button" onclick="editarSituacao()">EDITAR SITUAÇÃO</button>
                </div>
                <div class="infofuncionario">
                    <div class="cola modal ocorrencia">Curso:
                        <div class="texto">
                            <?php echo $row['Curso_Nome']; ?>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal">Turma:
                            <div class="texto">
                                <?php echo $row['Turma_Cod']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">Professor:
                            <div class="texto" id="modalCidade">
                                <?php echo $row['Professor']; ?>
                            </div>
                        </div>
                        <div class="col3 colc modal">Matrícula:
                            <div class="texto" id="modalUf">
                                <?php echo $row['Usuario_Matricula']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal">Período:
                            <div class="texto">
                                <?php echo $row['Turma_Cod']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">Horário:
                            <div class="texto" id="modalCidade">
                                <?php echo $row['Turma_Horario'] .'-'. $row['Turma_Horario_Termino']; ?>
                            </div>
                        </div>
                        <div class="col3 colc modal">Situação:
                            <div class="texto" id="modalUf">
                                <?php echo $row['Usuario_Matricula']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="col1 cola modal">Frequência:
                            <div class="texto">
                                <?php echo $row['Turma_Cod']; ?>
                            </div>
                        </div>
                        <div class="col2 colb modal">Horário:
                            <div class="texto" id="modalCidade">
                                <?php echo $row['Professor']; ?>
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
                window.location.href = "s_alunos_editar.php?userId=" + selectedUserId;
            } else {
                alert("Por favor, selecione um aluno antes de editar.");
            }
        }

        function exibirDetalhesUsuario(dados) {
            //Variavel Idade
            function calcularIdade(dataNascimento) {
                var hoje = new Date();
                var nascimento = new Date(dataNascimento);
                var calcIdade = hoje.getFullYear() - nascimento.getFullYear();
                var m = hoje.getMonth() - nascimento.getMonth();

                if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
                    calcIdade--;
                }

                return calcIdade;
            }

            var calcIdade = calcularIdade(dados.Usuario_Nascimento);

            var idade = document.getElementById('modalIdade');
            var contIdade = '';

            if (dados) {
                contIdade = calcIdade + ' anos';
            } else {
                contIdade = '<p>Não informado</p>';
            }

            idade.innerHTML = contIdade;
            idade.style.display = 'block';
        }
    </script>
</body>

</html>