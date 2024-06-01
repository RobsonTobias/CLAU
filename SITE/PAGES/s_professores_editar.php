<?php
include ('../conexao.php');

if (session_status() == PHP_SESSION_NONE) {
    // Se não houver sessão ativa, inicia a sessão
    session_start();
}
$userId = $_SESSION['UsuarioSelecionado'];

// Consulta para recuperar informações do usuário
$sql = "SELECT * FROM Usuario
    INNER JOIN Enderecos on Enderecos.Enderecos_id = Usuario.Enderecos_Enderecos_cd
    WHERE Usuario_id = $userId";
$result = $conn->query($sql);

// Verificar se o usuário existe
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $estadocivil = $row['Usuario_EstadoCivil'];
    $_SESSION['imagemOriginal'] = $row['Usuario_Foto'];
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
    <link rel="stylesheet" href="../STYLE/cadastro.css">
    <link rel="stylesheet" href="../STYLE/alterar.css">
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .professores path {
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
                <h1>ALTERAR PROFESSORES</h1>
                <div class="php">
                    <?php echo $date; ?>
                    <!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown; ?>
                <!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML; ?>
        <!--  Mostrar o menu lateral -->
    </div>

    <main>
        <div class="geral">
            <p>Informações do Professor</p>
            <form action="../PHP/alt_professor.php" id="form" class="form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
                <div class="info">
                    <div class="dados">
                        <div class="linha">
                            <label for="nome" class="nome">
                                <p>NOME COMPLETO <span>*</span></p>
                                <input type="text" id="nome" name="nome" value="<?php echo $row['Usuario_Nome']; ?>"
                                    required>
                            </label>
                            <label for="apelido" class="apelido">
                                <p>PRIMEIRO NOME / APELIDO<span>*</span></p>
                                <input type="text" name="apelido" id="apelido"
                                    value="<?php echo $row['Usuario_Apelido']; ?>" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="email" class="email">
                                <p>E-MAIL<span>*</span></p>
                                <input type="email" id="email" name="email" value="<?php echo $row['Usuario_Email']; ?>"
                                    required>
                            </label>
                            <label for="sexo" class="sexo">
                                <p>SEXO<span>*</span></p>
                                <div class="select">
                                    <select name="sexo" id="sexo">
                                        <option value="Masculino" <?php echo ($row['Usuario_Sexo'] == 'M') ? 'selected' : ''; ?>>Masculino</option>
                                        <option value="Feminino" <?php echo ($row['Usuario_Sexo'] == 'F') ? 'selected' : ''; ?>>Feminino</option>
                                    </select>

                                </div>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cpf" class="cpf">
                                <p>CPF<span>*</span></p>
                                <input type="text" id="cpf" name="cpf" required maxlength="13"
                                    onkeyup="handleCPF(event)" value="<?php echo $row['Usuario_Cpf']; ?>">
                            </label>
                            <label for="rg" class="rg">
                                <p>RG<span>*</span></p>
                                <input type="text" id="rg" name="rg" maxlength="12" required
                                    value="<?php echo $row['Usuario_Rg']; ?>" onkeyup="handleRG(event)">
                            </label>
                            <label for="nascimento" class="nascimento">
                                <p>DATA NASCIMENTO<span>*</span></p>
                                <input type="date" id="nascimento" name="nascimento"
                                    value="<?php echo $row['Usuario_Nascimento']; ?>" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="civil" class="civil">
                                <p>ESTADO CIVIL<span>*</span></p>
                                <div class="select2">
                                    <select name="civil" id="civil">
                                        <option value="solteiro" <?php if ($estadocivil == 'solteiro')
                                            echo 'selected'; ?>>Solteiro</option>
                                        <option value="casado" <?php if ($estadocivil == 'casado')
                                            echo 'selected'; ?>>
                                            Casado</option>
                                        <option value="separado" <?php if ($estadocivil == 'separado')
                                            echo 'selected'; ?>>Separado</option>
                                        <option value="divorciado" <?php if ($estadocivil == 'divorciado')
                                            echo 'selected'; ?>>Divorciado</option>
                                        <option value="viuvo" <?php if ($estadocivil == 'viuvo')
                                            echo 'selected'; ?>>Viúvo
                                        </option>
                                    </select>
                                </div>
                            </label>
                            <label for="celular" class="celular">
                                <p>CELULAR<span>*</span></p>
                                <input type="tel" id="celular" name="celular" maxlength="15" required
                                    placeholder="11 99999-9999" value="<?php echo $row['Usuario_Fone']; ?>"
                                    onkeyup="handlePhone(event)">
                            </label>
                            <label for="recado" class="recado">
                                <p>TELEFONE RECADO</p>
                                <input type="tel" id="recado" name="recado" maxlength="15" placeholder="11 99999-9999"
                                    value="<?php echo $row['Usuario_Fone_Recado']; ?>" onkeyup="handlePhone(event)">
                            </label>
                        </div>
                        <div>
                            <label for="obs" class="obs">
                                <textarea name="obs" id="obs"><?php echo $row['Usuario_Obs']; ?></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="foto">
                        <img id="imagemExibida" src="<?php echo $row['Usuario_Foto']; ?>" alt="foto">
                        <label for="imagemInput">ALTERAR FOTO</label>
                        <input type="file" id="imagemInput" name="imagem" accept="image/*" onchange="exibirImagem()">
                    </div>
                </div>
                <div class="endereco">
                    <div class="dados">
                        <div class="linha">
                            <label for="cep" class="cep">
                                <p>CEP<span>*</span></p>
                                <input type="text" id="cep" name="cep" required maxlength="9" placeholder="Digite o CEP"
                                    value="<?php echo $row['Enderecos_Cep']; ?>" onkeyup="handleZipCode(event)">
                            </label>
                            <label for="logradouro" class="logradouro">
                                <p>LOGRADOURO</p>
                                <input type="text" name="logradouro" id="logradouro"
                                    value="<?php echo $row['Enderecos_Rua']; ?>" readonly>
                            </label>
                            <label for="numero" class="numero">
                                <p>Nº<span>*</span></p>
                                <input type="text" name="numero" id="numero"
                                    value="<?php echo $row['Enderecos_Numero']; ?>" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="bairro" class="bairro">
                                <p>BAIRRO</p>
                                <input type="text" id="bairro" name="bairro"
                                    value="<?php echo $row['Enderecos_Bairro']; ?>" readonly>
                            </label>
                            <label for="complemento" class="complemento">
                                <p>COMPLEMENTO</p>
                                <input type="text" id="complemento" name="complemento"
                                    value="<?php echo $row['Enderecos_Complemento']; ?>">
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cidade" class="cidade">
                                <p>CIDADE</p>
                                <input type="text" id="cidade" name="cidade"
                                    value="<?php echo $row['Enderecos_Cidade']; ?>" readonly>
                            </label>
                            <label for="estado" class="estado">
                                <p>ESTADO</p>
                                <input type="text" id="estado" name="estado" value="<?php echo $row['Enderecos_Uf']; ?>"
                                    readonly>
                            </label>
                        </div>
                    </div>
                    <div class="icone">
                        <img src="../ICON/endereco.svg" alt="endereco">
                    </div>
                </div>
                <div class="botao func">
                    <button class="cadastrar" type="submit" onclick="cadastrar()">SALVAR</button>
                </div>
            </form>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes; ?>
        <!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
    <script src="../JS/end.js"></script>
    <script>
        $(document).ready(function () {
            $("#form").on("submit", function (e) {
                e.preventDefault(); // Impede o envio normal do formulário

                var formData = new FormData(this);

                $.ajax({
                    url: '../PHP/alt_professor.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Dados do usuário atualizados com sucesso")) {
                            alert("Dados do usuário atualizados com sucesso"); // Exibe um alerta de sucesso
                            window.location.href = '../PAGES/s_professores_relatorio.php';
                        } else {
                            alert(response); // Exibe outros alertas retornados pelo servidor
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });

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

        const handleZipCode = (event) => {
            let input = event.target
            input.value = zipCodeMask(input.value)
        }

        const zipCodeMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{5})(\d)/, '$1-$2')
            return value
        }

        const handlePhone = (event) => {
            let input = event.target
            input.value = PhoneMask(input.value)
        }

        const PhoneMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "($1) $2")
            value = value.replace(/(\d)(\d{4})$/, "$1-$2")
            return value
        }

        const handleCPF = (value) => {

            let input = event.target
            input.value = CPFMask(input.value)
        }

        const CPFMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d{2})/, "$1-$2")

            return value
        }

        const handleRG = (value) => {

            let input = event.target
            input.value = RGMask(input.value)
        }

        const RGMask = (value) => {
            if (!value) return ""
            value = value.replace(/\D/g, '')
            value = value.replace(/(\d{2})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d)/, "$1.$2")
            value = value.replace(/(\d{3})(\d{1})/, "$1-$2")

            return value
        }
    </script>
</body>

</html>