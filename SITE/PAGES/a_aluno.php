<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "CLAU";

// Cria uma conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica a conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
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
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .alunos path {
            fill: #043140;
        }
    </style>
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php include('../PHP/data.php');?>
    <?php include('../PHP/sidebar/menu_aluno.php');?>
    <?php include('../PHP/redes.php');?>
    <?php include('../PHP/dropdown.php');?>

    <header>
        <div class="title">
            <div class="nomedata closed">
                <h1>CONSULTA DO ALUNO</h1>
                <div class="php">
                    <?php echo $date;?>
                    <!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown;?>
                <!-- Mostra o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML;?>
        <!--  Mostrar o menu lateral -->
    </div>

    <main>
    <div class="geral">
    <p>Informações do Aluno</p>
    <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
        <div class="info">
            <div class="dados">
                <div class="linha">
                    <label for="nome" class="nome">
                        <p>NOME COMPLETO <span>*</span></p>
                        <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" required disabled>
                    </label>
                            <label for="apelido" class="apelido">
                                <p>PRIMEIRO NOME / APELIDO<span>*</span></p>
                                <input type="text" name="apelido" id="apelido" required disabled>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="email" class="email">
                                <p>E-MAIL<span>*</span></p>
                                <input type="email" id="email" name="email" required disabled>
                            </label>
                            <label for="sexo" class="sexo">
                                <p>SEXO<span>*</span></p>
                                <div class="select">
                                    <select name="sexo" id="sexo" disabled>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Feminino">Feminino</option>
                                    </select>
                                </div>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cpf" class="cpf">
                                <p>CPF<span>*</span></p>
                                <input type="text" id="cpf" name="cpf" required disabled maxlength="13"
                                    onkeyup="handleCPF(event)" placeholder="Digite somente números">
                            </label>
                            <label for="rg" class="rg">
                                <p>RG<span>*</span></p>
                                <input type="text" id="rg" name="rg" maxlength="12" required disabled
                                    placeholder="Digite somente números" onkeyup="handleRG(event)">
                            </label>
                            <label for="nascimento" class="nascimento">
                                <p>DATA NASCIMENTO<span>*</span></p>
                                <input type="date" id="nascimento" name="nascimento" required disabled>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="civil" class="civil" >
                                <p>ESTADO CIVIL<span>*</span></p>
                                <div class="select2">
                                    <select name="civil" id="civil" disabled>
                                        <option value="solteiro">Solteiro</option>
                                        <option value="casado">Casado</option>
                                        <option value="separado">Separado</option>
                                        <option value="divorciado">Divorciado</option>
                                        <option value="viuvo">Viúvo</option>
                                    </select>
                                </div>
                            </label>
                            <label for="celular" class="celular">
                                <p>CELULAR<span>*</span></p>
                                <input type="tel" id="celular" name="celular" maxlength="15" required disabled
                                    placeholder="11 99999-9999" onkeyup="handlePhone(event)">
                            </label>
                            <label for="recado" class="recado">
                                <p>TELEFONE RECADO</p>
                                <input type="tel" id="recado" name="recado" maxlength="15" placeholder="11 99999-9999"
                                    onkeyup="handlePhone(event)">
                            </label>
                        </div>
                        <div class="linha">
                            <label for="responsavel" class="responsavel">
                                <p>NOME COMPLETO DO RESPONSAVEL</p>
                                <input type="text" id="responsavel" name="responsavel" >
                            </label>
                            <label for="celular_r" class="celular_r">
                                <p>CELULAR DO RESPONSAVEL</p>
                                <input type="tel" id="celular_r" name="celular_r" maxlength="15"
                                    placeholder="11 99999-9999" onkeyup="handlePhone(event)">
                            </label>
                        </div>
                        <div class="linha">
                            <label for="cpf_r" class="cpf_r">
                                <p>CPF DO RESPONSAVEL</p>
                                <input type="text" id="cpf_r" name="cpf_r" maxlength="13"
                                    onkeyup="handleCPF(event)" placeholder="Digite somente números">
                            </label>
                            <label for="rg_r" class="rg_r">
                                <p>RG DO RESPONSAVEL</p>
                                <input type="text" id="rg_r" name="rg_r" maxlength="12"
                                    placeholder="Digite somente números" onkeyup="handleRG(event)">
                            </label>
                            <label for="parentesco" class="parentesco">
                                <p>NIVEL DE PARENTESCO</p>
                                <div class="select">
                                    <select name="parentesco" id="parentesco" disabled>
                                        <option value="solteiro">Pai</option>
                                        <option value="casado">Mãe</option>
                                        <option value="separado">Avô/Avó</option>
                                        <option value="divorciado">Tio/Tia</option>
                                        <option value="viuvo">Irmão/Irmã</option>
                                    </select>
                                </div>
                            </label>
                        </div>
                        <div>
                            
                            <label for="obs" class="obs">
                                <textarea name="obs" id="obs" placeholder="Observações sobre o aluno..."></textarea>
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
                                <p>CEP<span>*</span></p>
                                <input type="text" id="cep" name="CEP" required disabled maxlength="9" placeholder="Digite o CEP"
                                    onkeyup="handleZipCode(event)">
                            </label>
                            <label for="logradouro" class="logradouro">
                                <p>LOGRADOURO</p>
                                <input type="text" name="logradouro" id="logradouro" readonly>
                            </label>
                            <label for="numero" class="numero">
                                <p>Nº<span>*</span></p>
                                <input type="text" name="numero" id="numero" required disabled>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="bairro" class="bairro">
                                <p>BAIRRO</p>
                                <input type="text" id="bairro" name="bairro" readonly>
                            </label>
                            <label for="complemento" class="complemento">
                                <p>COMPLEMENTO</p>
                                <input type="text" id="complemento" name="complemento" required disabled>
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

            </form>
        </div>
    </main>

    <div class="buttons">
        <?php echo $redes;?>
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
                    url: '../PHP/cad_aluno.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Cadastro realizado com sucesso!")) {
                            $('#form').trigger("reset"); // Limpa o formulário
                            $('#imagemExibida').attr('src', 'https://placekitten.com/400/400');
                            alert("Cadastro realizado com sucesso!"); // Exibe um alerta de sucesso
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

        function limpar() {
            // Adicione a lógica para limpar os campos do formulário aqui
            document.getElementById('form').reset();
            
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