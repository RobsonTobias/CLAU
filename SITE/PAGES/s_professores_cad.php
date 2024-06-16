<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
require_once '../PHP/formatarInfo.php';
$home = 's_professores.php'; //utilizado pelo botão voltar
$titulo = 'CADASTRO DE PROFESSOR'; //Título da página, que fica sobre a data
$elemento = 'Professor';
?>

<style>
    .professores path {
        fill: #043140;
    }
    input{
        border: 0;
        color: white;
        height: 1.7rem;
        padding-inline: 10px;
        background-color: #949494;
        width: 100%;
    }
    #form .texto{
        margin-left: 10px;
    }
</style>


<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-center mt-3" style="margin-left: 76px;">
            <div class="card col-sm-6">
                <div class="card-body p-2">
                    <h5 class="m-0">Informações do <?php echo $elemento; ?></h5>
                </div>
                <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                    <div id="cadastro" class="card sombra p-2">
                        <div class="row">
                            <div class="col-sm-8 p-0">
                                <div class="texto">NOME COMPLETO<span>*</span></div>
                                <input type="text" id="nome" name="nome" class="rounded-pill" required>
                            </div>
                            <div class="col-sm-4">
                                <div class="texto">APELIDO<span>*</span></div>
                                <input type="text" name="apelido" id="apelido" class="rounded-pill" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <main>
        <div class="geral">
            <p>Informações do Professor</p>
            <form action="" id="form" class="form" method="post" enctype="multipart/form-data">
                <div class="info">
                    <div class="dados">
                        <div class="linha">
                            <label for="nome" class="nome">
                                <p>NOME COMPLETO <span>*</span></p>
                                <input type="text" id="nome" name="nome" required>
                            </label>
                            <label for="apelido" class="apelido">
                                <p>PRIMEIRO NOME / APELIDO<span>*</span></p>
                                <input type="text" name="apelido" id="apelido" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="email" class="email">
                                <p>E-MAIL<span>*</span></p>
                                <input type="email" id="email" name="email" required>
                            </label>
                            <label for="sexo" class="sexo">
                                <p>SEXO<span>*</span></p>
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
                                <p>CPF<span>*</span></p>
                                <input type="text" id="cpf" name="cpf" required maxlength="13"
                                    onkeyup="handleCPF(event)" placeholder="Digite somente números">
                            </label>
                            <label for="rg" class="rg">
                                <p>RG<span>*</span></p>
                                <input type="text" id="rg" name="rg" maxlength="12" required
                                    placeholder="Digite somente números" onkeyup="handleRG(event)">
                            </label>
                            <label for="nascimento" class="nascimento">
                                <p>DATA NASCIMENTO<span>*</span></p>
                                <input type="date" id="nascimento" name="nascimento" required>
                            </label>
                        </div>
                        <div class="linha">
                            <label for="civil" class="civil">
                                <p>ESTADO CIVIL<span>*</span></p>
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
                                <p>CELULAR<span>*</span></p>
                                <input type="tel" id="celular" name="celular" maxlength="15" required
                                    placeholder="11 99999-9999" onkeyup="handlePhone(event)">
                            </label>
                            <label for="recado" class="recado">
                                <p>TELEFONE RECADO</p>
                                <input type="tel" id="recado" name="recado" maxlength="15" placeholder="11 99999-9999"
                                    onkeyup="handlePhone(event)">
                            </label>
                        </div>
                        <div>
                            <label for="obs" class="obs">
                                <textarea name="obs" id="obs" placeholder="Observações sobre o professor..."></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="foto">
                        <img id="imagemExibida" src="../ICON/perfil.svg" alt="foto">
                        <label for="imagemInput">INSERIR FOTO</label>
                        <input type="file" id="imagemInput" name="imagem" accept="image/*" onchange="exibirImagem()">
                    </div>
                </div>
                <div class="endereco">
                    <div class="dados">
                        <div class="linha">
                            <label for="cep" class="cep">
                                <p>CEP<span>*</span></p>
                                <input type="text" id="cep" name="cep" required maxlength="9" placeholder="Digite o CEP"
                                    onkeyup="handleZipCode(event)">
                            </label>
                            <label for="logradouro" class="logradouro">
                                <p>LOGRADOURO</p>
                                <input type="text" name="logradouro" id="logradouro" readonly>
                            </label>
                            <label for="numero" class="numero">
                                <p>Nº<span>*</span></p>
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
                                <input type="text" id="complemento" name="complemento">
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
                <div class="botao func">
                    <button class="cadastrar" type="submit">CADASTRAR</button>
                    <button class="limpar" type="button" onclick="limpar()">LIMPAR</button>
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
    <script src="../JS/informacao.js"></script>
    <script>
        $(document).ready(function () {
            $("#form").on("submit", function (e) {
                e.preventDefault(); // Impede o envio normal do formulário

                var formData = new FormData(this);

                $.ajax({
                    url: '../PHP/cad_professor.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Cadastro realizado com sucesso!")) {
                            $('#form').trigger("reset"); // Limpa o formulário
                            $('#imagemExibida').attr('src', '../ICON/perfil.svg');
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
    </script>
</body>

</html>