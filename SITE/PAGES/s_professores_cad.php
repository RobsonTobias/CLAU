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
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .professores path {
            fill: #043140;
        }
    </style>
</head>

<body>

    <?php include('../PHP/data.php');?>
    <?php include('../PHP/sidebar/menu.php');?>
    <?php include('../PHP/redes.php');?>
    <?php include('../PHP/dropdown.php');?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CADASTRO DE PROFESSORES</h1>
                <div class="php">
                    <?php echo $date;?><!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown;?><!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>

    <main>
        <div class="geral">
            <p>Informações do Professor</p>
            <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                <div class="info">
                    <div class="dados">
                        <div class="linha">
                            <label for="nome" class="nome">
                                <p>NOME COMPLETO</p>
                                <input type="text" id="nome" name="nome" required>
                            </label>
                            <label for="apelido" class="apelido">
                                <p>PRIMEIRO NOME / APELIDO</p>
                                <input type="text" name="apelido" id="apelido" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="email" class="email">
                                <p>E-MAIL</p>
                                <input type="email" id="email" name="email" required>
                            </label>
                            <label for="sexo" class="sexo">
                                <p>SEXO</p>
                                <div class="select">
                                <select name="sexo" id="sexo">
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                </select>
                            </div>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cpf" class="cpf">
                                <p>CPF</p>
                                <input type="text" id="cpf" name="cpf" required
                                    pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}">
                            </label>
                            <label for="rg" class="rg">
                                <p>RG</p>
                                <input type="text" id="rg" name="rg" required>
                            </label>
                            <label for="nascimento" class="nascimento">
                                <p>DATA NASCIMENTO</p>
                                <input type="date" id="nascimento" name="nascimento" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="civil" class="civil">
                                <p>ESTADO CIVIL</p>
                                <div class="select2">
                                <select name="civil" id="civil">
                                    <option value="solteiro">Solteiro</option>
                                    <option value="casado">Casado</option>
                                    <option value="separado">Separado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="viuvo">Viúvo</option>
                                </select>
                            </div>
                            </label>
                            <label for="celular" class="celular">
                                <p>CELULAR</p>
                                <input type="tel" id="celular" name="celular" required
                                    pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" placeholder="11 99999-9999">
                            </label>
                            <label for="recado" class="recado">
                                <p>TELEFONE RECADO</p>
                                <input type="tel" id="recado" name="recado" required
                                    pattern="[0-9]{2} [0-9]{5}-[0-9]{4}" placeholder="11 99999-9999">
                            </label>
                        </div>
                        <div>
                            <label for="obs" class="obs">
                                <textarea name="obs" id="obs" placeholder="Observações sobre o professor..."></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="foto">
                        <img id="imagemExibida" src="https://placekitten.com/400/400" alt="foto">
                        <label for="imagemInput">INSERIR FOTO</label>
                        <input type="file" id="imagemInput" name="imagem" accept="image/*" onchange="exibirImagem()">
                    </div>
                </div>
                <div class="endereco">
                    <div class="dados">
                        <div class="linha">
                            <label for="cep" class="cep">
                                <p>CEP</p>
                                <input type="text" id="cep" name="CEP" required maxlength="9"
                                    placeholder="Digite o CEP">
                            </label>
                            <label for="logradouro" class="logradouro">
                                <p>LOGRADOURO</p>
                                <input type="text" name="logradouro" id="logradouro" readonly>
                            </label>
                            <label for="numero" class="numero">
                                <p>Nº</p>
                                <input type="text" name="numero" id="numero" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="bairro" class="bairro">
                                <p>BAIRRO</p>
                                <input type="text" id="bairro" name="bairro" readonly>
                            </label>
                            <label for="complemento" class="complemento">
                                <p>COMPLEMENTO</p>
                                <input type="text" id="complemento" name="complemento" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cidade" class="cidade">
                                <p>CIDADE</p>
                                <input type="text" id="cidade" name="cidade" readonly>
                            </label>
                            <label for="estado" class="estado">
                                <p>ESTADO</p>
                                <input type="text" id="estado" name="estado" readonly>
                            </label>
                        </div>
                    </div>
                    <div class="icone">
                        <img src="../ICON/endereco.svg" alt="endereco">
                    </div>
                </div>
                <div class="fim">
                    <div class="cursos">
                        <p>CURSOS A LECIONAR</p>
                        <div class="check">
                            <label>
                                <input type="checkbox" name="item" value="administracao"> ADMINISTRAÇÃO
                            </label>
                            <label>
                                <input type="checkbox" name="item" value="informatica"> INFORMÁTICA
                            </label>
                            <label>
                                <input type="checkbox" name="item" value="ingles"> INGLÊS
                            </label>
                            <label>
                                <input type="checkbox" name="item" value="robotica"> ROBÓTICA
                            </label>
                            <label>
                                <input type="checkbox" name="item" value="webdesign"> WEB-DESIGN
                            </label>
                        </div>
                    </div>
                    <div class="botao">
                        <button class="cadastrar" type="submit" onclick="cadastrar()">CADASTRAR</button>
                        <button class="limpar" type="button" onclick="limpar()">LIMPAR</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/end.js"></script>
    <script>
        function cadastrar() {
            // Adicione a lógica de cadastro aqui
            alert('Cadastro realizado com sucesso!');
            // Você pode redirecionar o usuário ou realizar outras ações necessárias
        }

        function limpar() {
            // Adicione a lógica para limpar os campos do formulário aqui
            document.getElementById('form').reset();
            // Você pode adicionar mais lógica de limpeza conforme necessário
        }
        function exibirImagem() {
            const input = document.getElementById('imagemInput');
            const imagemExibida = document.getElementById('imagemExibida');

            if (input.files && input.files[0]) {
                const leitor = new FileReader();

                leitor.onload = function (e) {
                    imagemExibida.src = e.target.result;
                };

                leitor.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>