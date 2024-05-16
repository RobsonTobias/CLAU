<?php
include('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
}
$alunoId = $_SESSION['AlunoId'];

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
    $cpf = $row['Usuario_Cpf'];
    $cpfFormatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2); //Formata o CPF
    $rg = $row['Usuario_Rg'];
    $rgFormatado = substr($rg,0,2). '.' . substr($rg,2,3). '.' . substr($rg,5,3). '-' . substr($rg,8,1); //Formata o RG
    $fone = $row['Usuario_Fone'];
    $foneFormatado = '('. substr($fone,0,2). ') '. substr($fone,2,5). '-'. substr($fone,7,4); //Formata o Fone
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
        .aluno path{
            fill: #043140;
        }
        p{
            color: #068888;
            font-size: 16px;
            font-weight: bold;
        }
        .infoturma{
            background-color: #E7E7E7;
            border-radius: 20px;
            box-shadow: 0 0 5px 1px #00000040;
            padding: 15px;
            gap: 15px;
        }
        .infoturma p{
            font-size: 22px;
            font-weight: bold;
            color: #233939;
        }
        .campo{
            display: flex;
            flex-direction: column;
            margin: 10px;
        }
        .campo p{
            color: #068888;
            font-size: 16px;
            font-weight: bold;
        }
        .geral{
            background-color: #D9D9D9;
            border-radius: 15px;
            box-shadow: 0 0 5px 1px #00000040;
            padding-bottom: 5px;
        }
        .info{
            background-color: #949494;
            border-radius: 15px;
            height: 30px;
        }
        .infohorario{
            width: 210px;
        }
        .infodia, .infocodigo{
            width: 200px;
        }
        .infoprof{
            width: 430px;
        }
        .infomaxaluno{
            width: 200px;
        }
        .tituloturma{
            margin-left: 10px;
        }
        .botao button{
            cursor: pointer;
        }
        .func{
            margin-top: 15px;
        }
        .botao{
            display: flex;
            align-items: end;
            justify-content: end;
        }
        .cadastrar{
            background-color: #6EC77D;
            color: #0D4817;
            width: 150px;
            height: 30px;
            border-radius: 15px;
            border: none;
            font-weight: bold;
        }
        .render{
            margin-left: 15px;
            margin-top: -25px;
            color: #ffffff;
        }
        .centralizar{
            text-align: center;
            padding-left: 0px;
        }
        select{
            background-color: #4D4D4D;
            color: #F4F4F4;
            font-size: 15px;
            padding: 3px;
            margin-right: 10px;
            margin-bottom: 10px;
            margin-top: 3px;
            border-radius: 5px;
            padding-right: 15px;
        }
    </style>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php include('../PHP/data.php'); ?>
    <?php include('../PHP/sidebar/menu.php'); ?>
    <?php include('../PHP/redes.php'); ?>
    <?php include('../PHP/dropdown.php'); ?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CADASTRO DE ALUNO</h1>
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

    <main>
        <div style = "display:flex; flex-direction: column; margin-left: 200px;">
            <div class="informacao">
                <div class="titulo">
                    <p>Informações Pessoais</p>
                </div>
                <div class="infofuncionario">
                    <div class="func">
                        <div class="foto">
                            <img id="imagemExibida" src="<?php echo $row['Usuario_Foto']; ?>" alt="foto">
                        </div>
                        <div class="info-func">
                            <div class="modal">Nome: <div class="texto"><?php echo $row['Usuario_Nome']; ?></div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Nascimento: <div class="texto"><?php echo $nascimentoFormatado; ?></div>
                                </div>
                                <div class="col2 modal" for="idade">Idade: <div class="texto"><?php echo $idade; ?> anos</div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">CPF: <div class="texto"><?php echo $cpfFormatado; ?></div>
                                </div>
                                <div class="col2 modal">RG: <div class="texto"><?php echo $rgFormatado; ?></div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Sexo: <div class="texto"><?php if ($row['Usuario_Sexo'] == 'M'){echo 'Masculino';}else{echo 'Feminino';} ?></div>
                                </div>
                                <div class="col2 modal">E-mail: <div class="texto"><?php echo $row['Usuario_Email']; ?></div>
                                </div>
                            </div>
                            <div class="linha">
                                <div class="col1 modal">Celular: <div class="texto"><?php echo $foneFormatado; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="obs-func">
                        <p><?php echo $row['Usuario_Obs']; ?></p>
                    </div>
                </div>
            </div>
            <div class="infoturma" style="margin-top: 20px;">
                <p>Informações da Turma</p>
                <div class="geral">
                    <div class="campo">
                        <p class="tituloturma" style="margin-top: 10px;">CURSO</p>
                        <p class="info infocurso" ><div id="modalCurso"></div></p>
                    </div>
                    <div class="linha">
                        <div class="campo">
                            <p class="tituloturma">HORÁRIO</p>
                            <p class="info infohorario"><div id="modalHorario"></div></p>
                        </div>
                        <div class="campo">
                            <p class="tituloturma">DIA</p>
                            <p class="info infodia"><div id="modalDia"></div></p>
                        </div>
                        <div class="campo">
                            <p class="tituloturma">CÓDIGO TURMA</p>
                            <p class="info infocodigo"><div id="modalCodigo"></div></p>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="campo">
                            <p class="tituloturma">PROFESSOR</p>
                            <p class="info infoprof"><div id="modalProfessor"></div></p>
                        </div>
                        <div class="campo">
                            <p class="tituloturma">MÁXIMO ALUNOS</p>
                            <p class="info infomaxaluno"><div id="modalMax"></div></p>
                        </div>
                    </div>
                    <div class="campo">
                        <p class="tituloturma">OBSERVAÇÕES</p>
                        <p class="info infoobs"><div id="modalObs"></div></p>
                    </div>
                </div>
                <div class="botao func">
                    <button class="cadastrar" type="submit" onclick="cadastrar()">ADICIONAR ALUNO</button>
                </div>
            </div>
        </div>
        <div class="pesquisa">
                <p style="font-size: 22px;">Turmas Cadastradas</p>
                
                <select id="filtroCurso">
                    <option value="">CURSO</option>
                    <?php
                    // Consulta para buscar cursos
                    $sqlCursos = "SELECT Curso_id, Curso_Sigla FROM Curso";
                    $resultCursos = $conn->query($sqlCursos);
                    if ($resultCursos->num_rows > 0) {
                        while ($curso = $resultCursos->fetch_assoc()) {
                            echo "<option value='" . $curso['Curso_Sigla'] . "'>" . $curso['Curso_Sigla'] . "</option>";
                        }
                    }
                    ?>
                </select>
                
                <select id="filtroProfessor">
                    <option value="">PROFESSOR</option>
                    <?php
                    // Consulta para buscar professores
                    $sqlProfessores = "SELECT Usuario_id, Usuario_Apelido FROM Usuario
                    INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                    WHERE Registro_Usuario.Tipo_Tipo_cd = 4;";
                    $resultProfessores = $conn->query($sqlProfessores);
                    if ($resultProfessores->num_rows > 0) {
                        while ($professor = $resultProfessores->fetch_assoc()) {
                            echo "<option value='" . $professor['Usuario_Apelido'] . "'>" . $professor['Usuario_Apelido'] . "</option>";
                        }
                    }
                    ?>
                </select>
            
                <table class="table table-hover">
                    <tr>
                        <th>TURMA</th>
                        <th>CURSO</th>
                        <th>PROFESSOR</th>
                        <th>MAX. ALUNOS</th>
                        <th>MATRICULADOS</th>
                    </tr>
                    <?php
                    $sql = "SELECT Turma.*, Curso.Curso_Sigla AS sigla, COUNT(Aluno_Turma.Usuario_Usuario_cd) AS matriculados, Usuario.Usuario_Apelido AS professor FROM Turma
                    INNER JOIN Curso ON Turma.curso_cd = Curso.Curso_id
                    INNER JOIN Usuario ON Turma.Usuario_Usuario_cd = Usuario.Usuario_id 
                    LEFT JOIN Aluno_Turma ON Turma.Turma_Cod = Aluno_Turma.Turma_Turma_Cod
                    GROUP BY Curso.Curso_id, Turma.Turma_Cod";

                    $contador = 0;
                    $resultado = $conn->query($sql);
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $classeLinha = ($contador % 2 == 0) ? 'linha-par' : 'linha-impar';
                            echo "<tr data-id='" . $row["Turma_Cod"] . "' class='" . $classeLinha . "' onclick='mostrarDetalhes(this)'>";
                            echo "<td class='turma_cod'>" . $row["Turma_Cod"] . "</td>";
                            echo "<td class='sigla centralizar'>" . $row["sigla"] . "</td>";
                            echo "<td class='professor_id'>" . $row["professor"] . "</td>";
                            echo "<td class='maxalunos centralizar'>" . $row["Turma_Vagas"] . "</td>";
                            echo "<td class='matriculados centralizar'>" . $row["matriculados"] . "</td>";
                            echo "</tr>";
                            $contador++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>Nenhuma tumra encontrada.</td></tr>";
                    }
                    ?>
                </table>
            </div>

    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>

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
        function cadastrar (){

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
                        window.location.replace("s_alunos_relatorio.php"); // Redireciona para a nova página

                    } else {
                        alert(response); // Exibe outros alertas retornados pelo servidor
                    }
                },
            });
        }
    </script>

    <script>
        var selectedUserId; // Variável global para armazenar o ID do usuário selecionado

        function mostrarDetalhes(elemento) {
            // Remover a classe 'render' de todos os elementos que possam tê-la
            document.querySelectorAll('.render').forEach(function(el) {
                el.classList.remove('render');
            });

            selectedUserId = elemento.getAttribute('data-id'); // Atualiza a variável global

            // Adiciona a classe 'render' ao elemento clicado
            elemento.classList.add('render');

            $.ajax({
                url: '../PHP/det_turma.php',
                type: 'GET',
                data: { userId: selectedUserId }, // Deve ser selectedUserId, não userId
                success: function (response) {
                    // Aqui você vai lidar com a resposta
                    exibirDetalhesTurma(response);
                    // Após receber a resposta, é adicionado a classe 'render' aos elementos internos onde os detalhes da turma são mostrados.
                    document.getElementById('modalCurso').classList.add('render');
                    document.getElementById('modalHorario').classList.add('render');
                    document.getElementById('modalDia').classList.add('render');
                    document.getElementById('modalCodigo').classList.add('render');
                    document.getElementById('modalProfessor').classList.add('render');
                    document.getElementById('modalMax').classList.add('render');
                    document.getElementById('modalObs').classList.add('render');
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
            var obs = document.getElementById('modalObs');
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