<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 1) {
    header("Location: ../logout.php");
}
$home = 'm_home.php'; //utilizado pelo botão voltar
$titulo = 'RELATÓRIO DE FUNCIONÁRIOS'; //Título da página, que fica sobre a data
$paginaDestino = 'm_funcionario_cad.php'; //utilizado para redirecionar para a página de cadastro
$elemento = 'Funcionário'; //utilizado no texto de adicionar
?>

<style>
    .funcionario path {
        fill: #043140;
    }

    main {
        display: flex;
    }

    .pesquisa p {
        min-width: 0;
        margin-bottom: 0;
    }

    hr {
        background-color: #313131;
        width: 95%;
        height: 1px;
    }
</style>


<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <main class="ajuste">
        <div class="pesquisa">
            <div class="d-flex row justify-content-between teste">
                <p>Pesquisar:</p>
                <?php require_once '../COMPONENTS/add.php' ?>
            </div>
            <input type="text" id="searchInput" placeholder="Digite um nome para pesquisar">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>NOME</th>
                        <th>E-MAIL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM Usuario
                INNER JOIN Registro_Usuario ON Usuario.Usuario_id = Registro_Usuario.Usuario_Usuario_cd
                Where Registro_Usuario.Tipo_Tipo_cd = 2;";

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
                </tbody>
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
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../JS/exibirDetalhes.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
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
                    alert("Erro ao obter dados do usuário.");
                }
            });
        }
    </script>

    <script>
        // Utilizado para redirecionar para a página de Editar Funcionário
        function editar() {
            if (selectedUserId) {
                window.location.href = "m_funcionario_alt.php?userId=" + selectedUserId;
            } else {
                alert("Por favor, selecione um funcionário.");
            }
        }
    </script>



</body>

</html>