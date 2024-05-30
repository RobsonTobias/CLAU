<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
if($_SESSION['Tipo_Tipo_cd'] != 2){
    header("Location: ../logout.php");
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
        .professores path {
            fill: #043140;
        }

        .centro {
            text-align: center;
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
                <h1>RELATÓRIO DE PROFESSORES</h1>
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
                        echo "<tr data-id='" . $row["Usuario_id"] . "' class='" . $classeLinha . " apagado' onclick='mostrarDetalhes(this)'>";
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
        <div class="informacoes">
            <div class="informacao">
                <div class="titulo">
                    <p>Informações Pessoais</p>
                    <button class="editar" type="button" onclick="editar()">EDITAR INFORMAÇÕES</button>
                </div>
                <div class="infofuncionario">
                    <div class="func">
                        <div class="foto">
                            <img id="imagemExibida" src="../ICON/perfil.svg" alt="foto">
                        </div>
                        <div class="info-func">
                            <div class="modal1">Nome: <div class="texto" id="modalNome"></div>
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
            <div class="informacao" style="margin-top:20px">
                <div class="titulo">
                    <p>Turmas que leciona</p>
                </div>
                <div class="pesquisa turma">
                    <table class="table table-hover">
                        <thead>
                            <th>Código</th>
                            <th>Curso</th>
                            <th class="centro">Alunos</th>
                            </tr>
                        </thead>

                        <tbody id="tabela-turma"></tbody>
                    </table>
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

    <script src="../JS/pesquisa.js">

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
                        <td class="centro">${turma.Total_Alunos}</td>
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