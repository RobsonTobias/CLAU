<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$alunoId = $_SESSION['AlunoId'];
$_SESSION['TurmaId'] = null;
// Consulta para recuperar informações do usuário
$sql = "SELECT * FROM Usuario
    INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
    WHERE Usuario_id = $alunoId";
$result = $conn->query($sql);

// Verificar se o usuário existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado";
}

$dataNascimento = new DateTime($row['Usuario_Nascimento']);
$hoje = new DateTime('now');
$idade = $hoje->diff($dataNascimento)->y; //Calcula a idade
$nascimentoFormatado = $dataNascimento->format('d-m-Y'); //Formatar a data de Nascimento

$home = 's_alunos_info.php'; //utilizado pelo botão voltar
$titulo = 'CADASTRO DE ALUNO NA TURMA'; //Título da página, que fica sobre a data
require_once '../PHP/formatarInfo.php';
?>

<style>
    .aluno path {
        fill: #043140;
    }

    .cadastrar {
        background-color: #6EC77D;
        color: #0D4817;
        width: 150px;
        height: 30px;
        border-radius: 15px;
        border: none;
        font-weight: bold;
    }

    .render {
        margin-left: 15px;
        margin-top: -25px;
        color: #ffffff;
    }
</style>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex row form-group justify-content-center mt-3" style="margin-left: 76px;">
            <div class="col-sm">
                <?php require_once '../COMPONENTS/infoAluno2.php'; ?>
                <?php require_once '../COMPONENTS/infoTurma.php'; ?>
            </div>
            <div class="col-sm">
                <?php require_once '../COMPONENTS/pesquisaTurma2.php'; ?>

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

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function (event) {
            var searchQuery = event.target.value.toLowerCase();
            var tableRows = document.querySelectorAll('.table tr');

            tableRows.forEach(function (row) {
                // Verifica se a linha não é o cabeçalho da tabela
                if (row.querySelector('td')) {
                    // Obter o texto da primeira célula (coluna NOME) da linha
                    var nameText = row.querySelector('td').textContent.toLowerCase();
                    if (nameText.startsWith(searchQuery)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }); // Fecha o 'tableRows'
        }); // Encerra o 'addEventListener'
    </script>

    <script>
        window.onload = function () {
            if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
                window.location.reload();
            }
        };
        document.addEventListener('DOMContentLoaded', function () {
            const filtroCurso = document.getElementById('filtroCurso');
            const filtroProfessor = document.getElementById('filtroProfessor');

            function filtrarTabela() {
                const cursoSelecionado = filtroCurso.value;
                const professorSelecionado = filtroProfessor.value;
                const linhas = document.querySelectorAll('.table tr:not(:first-child)'); // Ignora o cabeçalho

                linhas.forEach(linha => {
                    const curso = linha.querySelector('.sigla').textContent;
                    const professor = linha.querySelector('.professor_id').textContent;
                    let mostrarLinha = true;

                    if (cursoSelecionado && curso !== cursoSelecionado) {
                        mostrarLinha = false;
                    }
                    if (professorSelecionado && professor !== professorSelecionado) {
                        mostrarLinha = false;
                    }

                    linha.style.display = mostrarLinha ? '' : 'none';
                });
            }

            // Adiciona eventos para filtrar quando as seleções mudarem
            filtroCurso.addEventListener('change', filtrarTabela);
            filtroProfessor.addEventListener('change', filtrarTabela);
        });
    </script>

    <script> // Utilizado para fazer o cadastro do aluno na turma depois de clicar no botão Adicionar Aluno
        function cadastrar() {

            // Dados a serem enviados. Aqui, você pode adicionar qualquer outro dado necessário.
            var dados = {
                alunoId: "<?php echo $_SESSION['AlunoId']; ?>",
                turmaId: "<?php echo $_SESSION['TurmaId']; ?>"
            };

            $.ajax({
                url: '../PHP/cad_aluno_turma.php',
                type: 'POST',
                data: dados,
                success: function (response) {
                    if (response.includes("Cadastro realizado com sucesso!")) {
                        alert("Cadastro realizado com sucesso!"); // Exibe um alerta de sucesso
                        window.location.replace("s_alunos.php"); // Redireciona para a nova página

                    } else {
                        alert(response); // Exibe outros alertas retornados pelo servidor
                    }
                },
            });
        }
    </script>

    <script>
        function mostrarDetalhes(elemento) {
            document.querySelectorAll('.render').forEach(function (el) {
                el.classList.remove('render');
            });

            const selectedUserId = elemento.getAttribute('data-id'); // Atualizei a obtenção do atributo data-id
            elemento.classList.add('render');

            $.ajax({
                url: '../PHP/det_turma.php',
                type: 'GET',
                data: { userId: selectedUserId }, // Atualizei a variável passada para a chamada AJAX
                success: function (response) {
                    exibirDetalhesTurma(response);
                  
                },
                error: function () {
                    alert("Erro ao obter dados da turma.");
                }
            });
        }
    </script>
    <script>
        function exibirDetalhesTurma(dados) {
            //Variavel Curso
            var curso = document.getElementById('modalCurso');
            var contCurso = '';

            if (dados) {
                contCurso += dados.Curso;
            } else {
                contCurso = '<p>Não informado</p>';
            }

            curso.innerHTML = contCurso;
            curso.style.display = 'block';

            //Variavel Horário
            var horario = document.getElementById('modalHorario');
            var contHorario = '';

            if (dados && dados.Turma_Horario) {
                // Assumindo que dados.Turma_Horario esteja no formato "HH:MM:SS" ou "HH:MM"
                var partesDoHorario = dados.Turma_Horario.split(':'); // Divide a string pelo caractere ':'
                if (partesDoHorario.length >= 2) {
                    // Reconstrói a string para ter apenas horas e minutos
                    contHorario = partesDoHorario[0] + ':' + partesDoHorario[1];
                } else {
                    // Se não for possível dividir corretamente, mantém o horário original
                    contHorario = dados.Turma_Horario;
                }
            } else {
                contHorario = '<p>Não informado</p>';
            }

            horario.innerHTML = contHorario;
            horario.style.display = 'block';

            //Variavel Dia
            var dia = document.getElementById('modalDia');
            var contDia = '';

            if (dados) {
                contDia += dados.Turma_Dias;
            } else {
                contDia = '<p>Não informado</p>';
            }

            dia.innerHTML = contDia;
            dia.style.display = 'block';

            //Variavel Código Turma
            var codigo = document.getElementById('modalCodigo');
            var contCodigo = '';

            if (dados) {
                contCodigo += dados.Turma_Cod;
            } else {
                contCodigo = '<p>Não informado</p>';
            }

            codigo.innerHTML = contCodigo;
            codigo.style.display = 'block';

            //Variavel Professor
            var professor = document.getElementById('modalProfessor');
            var contProfessor = '';

            if (dados) {
                contProfessor += dados.professor;
            } else {
                contProfessor = '<p>Não informado</p>';
            }

            professor.innerHTML = contProfessor;
            professor.style.display = 'block';

            //Variavel Máximo de alunos
            var maxAluno = document.getElementById('modalMax');
            var contMaxAluno = '';

            if (dados) {
                contMaxAluno += dados.Turma_Vagas;
            } else {
                contMaxAluno = '<p>Não informado</p>';
            }

            maxAluno.innerHTML = contMaxAluno;
            maxAluno.style.display = 'block';

            //Variavel Observações
            var obs = document.getElementById('modalObsTurma');
            var contObs = '';

            if (dados) {
                contObs += dados.Turma_Obs;
            } else {
                contObs = '<p>Não informado</p>';
            }

            obs.innerHTML = contObs;
            obs.style.display = 'block';
        }

    </script>

</body>

</html>