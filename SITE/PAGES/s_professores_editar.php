<?php
require_once '../COMPONENTS/head.php';
require_once '../PHP/function.php';

if ($_SESSION['Tipo_Tipo_cd'] != 2) {
    header("Location: ../logout.php");
}
$userId = $_SESSION['UsuarioSelecionado'];
$elemento = 'Professor'; //utilizado no texto de adicionar
$home = 's_professores.php';
$titulo = 'ALTERAR PROFESSOR'; //Título da página, que fica sobre a data
require_once '../PHP/formatarInfo.php';
?>
<style>
    .professores path {
        fill: #043140;
    }
</style>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <?php require_once '../COMPONENTS/header.php' ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-center mt-3 mb-3" style="margin-left: 76px;">
            <div class="card col-sm-10">
                <div class="card-body p-2">
                    <h5 class="m-0">Informações do <?php echo $elemento; ?></h5>
                </div>
                <form id="form" class="form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="usuario_id" value="<?php echo $userId; ?>">
                    <?php
                    $listar = ListarInfoUsuario($userId);
                    if ($listar !== null) {
                        while ($l = $listar->fetch_array()) {
                            // Armazenar valores originais na sessão
                            $_SESSION['original'] = [
                                'nome' => $l['Usuario_Nome'],
                                'apelido' => $l['Usuario_Apelido'],
                                'email' => $l['Usuario_Email'],
                                'sexo' => $l['Usuario_Sexo'],
                                'cpf' => $l['Usuario_Cpf'],
                                'rg' => $l['Usuario_Rg'],
                                'nascimento' => $l['Usuario_Nascimento'],
                                'civil' => $l['Usuario_EstadoCivil'],
                                'celular' => $l['Usuario_Fone'],
                                'recado' => $l['Usuario_Fone_Recado'],
                                'obs' => $l['Usuario_Obs'],
                                'imagem' => $l['Usuario_Foto'],
                                'cep' => $l['Enderecos_Cep'],
                                'logradouro' => $l['Enderecos_Rua'],
                                'numero' => $l['Enderecos_Numero'],
                                'bairro' => $l['Enderecos_Bairro'],
                                'complemento' => $l['Enderecos_Complemento'],
                                'cidade' => $l['Enderecos_Cidade'],
                                'estado' => $l['Enderecos_Uf']
                            ];
                            ?>
                            <?php require_once '../COMPONENTS/alterarInfoUsuario.php'; ?>
                            <?php require_once '../COMPONENTS/alterarEndereco.php'; ?>
                            <div id="botao" class="d-flex justify-content-between">
                                <div class="d-flex row align-items-center">
                                    <div class="texto">Adicionar Professor como Coordenador?</div>
                                    <input type="checkbox" name="coordenador" id="coordenador" class="rounded-pill" style="width:1rem; margin-left: 10px;" <?php echo Coordenador($userId) ? 'checked' : ''; ?>>
                                </div>
                                <div>
                                    <button class="cadastrar" type="submit">SALVAR</button>
                                </div>
                            </div>
                        <?php }
                    } ?>
                </form>
                <br>
            </div>
        </div>
    </div>

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
                    url: '../PHP/alt_professor.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.includes("Dados do usuário atualizados com sucesso")) {
                            alert("Dados do usuário atualizados com sucesso"); // Exibe um alerta de sucesso
                            window.location.href = '../PAGES/s_professores.php';
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