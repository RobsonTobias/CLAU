<?php
include('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
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
        .campo{
            display: flex;
            flex-direction: column;
        }
        .geral{
            background-color: #D9D9D9;
            border-radius: 15px;
            box-shadow: 0 0 5px 1px #00000040;
        }
        .info{
            background-color: #949494;
            border-radius: 15px;
            height: 30px;
        }
        .infocurso{
            width: 560px;
        }
        .infohorario{
            width: 200px;
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
            <div class="pesquisa" style="margin-top: 20px;">
                <p>Informações da Turma</p>
                <div class="geral">
                    <div class="campo">
                        <p>CURSO</p>
                        <p class="info infocurso"></p>
                    </div>
                    <div class="linha">
                        <div class="campo">
                            <p>HORÁRIO</p>
                            <p class="info infohorario"></p>
                        </div>
                        <div class="campo">
                            <p>DIA</p>
                            <p class="info infodia"></p>
                        </div>
                        <div class="campo">
                            <p>CÓDIGO TURMA</p>
                            <p class="info infocodigo"></p>
                        </div>
                    </div>
                    <div class="linha">
                        <div class="campo">
                            <p>PROFESSOR</p>
                            <p class="info infoprof"></p>
                        </div>
                        <div class="campo">
                            <p>MÁXIMO ALUNOS</p>
                            <p class="info infoaluno"></p>
                        </div>
                    </div>
                    <div class="campo">
                        <p>OBSERVAÇÕES</p>
                        <p class="info infoobs"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pesquisa">
                <p>Turmas Cadastradas</p>
                <input type="text" id="searchInput" placeholder="Digite um nome para pesquisar">
                <table class="table table-hover">
                    <tr>
                        <th>NOME</th>
                        <th>E-MAIL</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM Usuario
                        INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                        Where Registro_Usuario.Tipo_Tipo_cd = 4;";

                    $contador = 0;
                    $resultado = $conn->query($sql);
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            $classeLinha = ($contador % 2 == 0) ? 'linha-par' : 'linha-impar';
                            echo "<tr data-id='" . $row["Usuario_id"] . "' class='" . $classeLinha . "' onclick='mostrarDetalhes(this)'>";
                            echo "<td class='nomeusuario'>" . $row["Usuario_Nome"] . "</td>";
                            echo "<td class='emailusuario'>" . $row["Usuario_Email"] . "</td>";
                            echo "</tr>";
                            $contador++;
                        }
                    } else {
                        echo "<tr><td colspan='2'>Nenhum funcionário encontrado.</td></tr>";
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
            buscarTurmas(selectedUserId);
        }

        function editar() {
            if (selectedUserId) {
                window.location.href = "s_professores_editar.php?userId=" + selectedUserId;
            } else {
                alert("Por favor, selecione um professor antes de editar.");
            }
        }
    </script>

    <script>
        function exibirDetalhesUsuario(dados) {
            //Variavel Nome
            var nome = document.getElementById('modalNome');
            var contNome = '';

            if (dados) {
                contNome += dados.Usuario_Nome;
            } else {
                contNome = '<p>Não informado</p>';
            }

            nome.innerHTML = contNome;
            nome.style.display = 'block';

            // Variável Nascimento
            var nascimento = document.getElementById('modalNascimento');
            var contNascimento = '';

            if (dados && dados.Usuario_Nascimento) {
                // Converter a data para um objeto Date
                var dataObj = new Date(dados.Usuario_Nascimento);

                // Extrair dia, mês e ano
                var dia = ("0" + dataObj.getDate()).slice(-2); // Adiciona um zero à esquerda se necessário
                var mes = ("0" + (dataObj.getMonth() + 1)).slice(-2); // Adiciona um zero à esquerda, mês começa em 0
                var ano = dataObj.getFullYear();

                // Montar a string de data no formato desejado
                contNascimento = dia + '-' + mes + '-' + ano;
            } else {
                contNascimento = '<p>Não informado</p>';
            }

            nascimento.innerHTML = contNascimento;
            nascimento.style.display = 'block';

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

            //Variavel CPF
            var Cpf = document.getElementById('modalCpf');
            var contCpf = '';

            if (dados) {
                contCpf += dados.Usuario_Cpf;
            } else {
                contCpf = '<p>Não informado</p>';
            }

            Cpf.innerHTML = contCpf;
            Cpf.style.display = 'block';

            //Variavel RG
            var Rg = document.getElementById('modalRg');
            var contRg = '';

            if (dados) {
                contRg += dados.Usuario_Rg;
            } else {
                contRg = '<p>Não informado</p>';
            }

            Rg.innerHTML = contRg;
            Rg.style.display = 'block';

            //Variavel Sexo
            var Sexo = document.getElementById('modalSexo');
            var contSexo = '';

            if (dados) {
                contSexo += dados.Usuario_Sexo;
            } else {
                contSexo = '<p>Não informado</p>';
            }

            Sexo.innerHTML = contSexo;
            Sexo.style.display = 'block';

            //Variavel E-mail
            var Email = document.getElementById('modalEmail');
            var contEmail = '';

            if (dados) {
                contEmail += dados.Usuario_Email;
            } else {
                contEmail = '<p>Não informado</p>';
            }

            Email.innerHTML = contEmail;
            Email.style.display = 'block';

            //Variavel Celular
            var Celular = document.getElementById('modalCelular');
            var contCelular = '';

            if (dados) {
                contCelular += dados.Usuario_Fone;
            } else {
                contCelular = '<p>Não informado</p>';
            }

            Celular.innerHTML = contCelular;
            Celular.style.display = 'block';

            //Variavel Data de Ingresso
            var Ingresso = document.getElementById('modalIngresso');
            var contIngresso = '';

            if (dados && dados.Registro_Data) {
                // Converter a data para um objeto Date
                var dataObj = new Date(dados.Registro_Data);

                // Extrair dia, mês e ano
                var dia = ("0" + dataObj.getDate()).slice(-2); // Adiciona um zero à esquerda se necessário
                var mes = ("0" + (dataObj.getMonth() + 1)).slice(-2); // Adiciona um zero à esquerda, mês começa em 0
                var ano = dataObj.getFullYear();

                // Montar a string de data no formato desejado
                contIngresso = dia + '-' + mes + '-' + ano;
            } else {
                contIngresso = '<p>Não informado</p>';
            }

            Ingresso.innerHTML = contIngresso;
            Ingresso.style.display = 'block';

            //Variavel Obs
            var obs = document.getElementById('modalObs');
            var contObs = '';

            if (dados) {
                contObs += dados.Usuario_Obs;
            } else {
                contObs = '<p>Não informado</p>';
            }

            obs.innerHTML = contObs;
            obs.style.display = 'block';

            //Variavel Logradouro
            var Logradouro = document.getElementById('modalLogradouro');
            var contLogradouro = '';

            if (dados) {
                contLogradouro += dados.Enderecos_Rua;
            } else {
                contLogradouro = '<p>Não informado</p>';
            }

            Logradouro.innerHTML = contLogradouro;
            Logradouro.style.display = 'block';

            //Variavel Numero
            var Numero = document.getElementById('modalNumero');
            var contNumero = '';

            if (dados) {
                contNumero += dados.Enderecos_Numero;
            } else {
                contNumero = '<p>Não informado</p>';
            }

            Numero.innerHTML = contNumero;
            Numero.style.display = 'block';

            //Variavel Complemento
            var Complemento = document.getElementById('modalComplemento');
            var contComplemento = '';

            if (dados) {
                if (dados.Enderecos_Complemento != null) {
                    contComplemento += dados.Enderecos_Complemento;
                }

            } else {
                contComplemento = '<p>Não informado</p>';
            }

            Complemento.innerHTML = contComplemento;
            Complemento.style.display = 'block';

            //Variavel Cep
            var Cep = document.getElementById('modalCep');
            var contCep = '';

            if (dados) {
                contCep += dados.Enderecos_Cep;
            } else {
                contCep = '<p>Não informado</p>';
            }

            Cep.innerHTML = contCep;
            Cep.style.display = 'block';

            //Variavel Bairro
            var Bairro = document.getElementById('modalBairro');
            var contBairro = '';

            if (dados) {
                contBairro += dados.Enderecos_Bairro;
            } else {
                contBairro = '<p>Não informado</p>';
            }

            Bairro.innerHTML = contBairro;
            Bairro.style.display = 'block';

            //Variavel Cidade
            var Cidade = document.getElementById('modalCidade');
            var contCidade = '';

            if (dados) {
                contCidade += dados.Enderecos_Cidade;
            } else {
                contCidade = '<p>Não informado</p>';
            }

            Cidade.innerHTML = contCidade;
            Cidade.style.display = 'block';

            //Variavel Uf
            var Uf = document.getElementById('modalUf');
            var contUf = '';

            if (dados) {
                contUf += dados.Enderecos_Uf;
            } else {
                contUf = '<p>Não informado</p>';
            }

            Uf.innerHTML = contUf;
            Uf.style.display = 'block';

            // Variável para a imagem
            var imagem = document.getElementById('imagemExibida');

            if (dados && dados.Usuario_Foto) {
                imagem.src = dados.Usuario_Foto;
            } else {
                imagem.src = '../ICON/perfil.svg';
            }
        }

    </script>

</body>

</html>