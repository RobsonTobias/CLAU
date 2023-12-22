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
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <link rel="stylesheet" href="../STYLE/styles_alunos_info.css">
    <style>
        .aluno path {
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
                <h1>INFORMAÇÕES DO ALUNO</h1>
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

    <main class="main">
        <section class="esquerda">
            <div class="divisao cima">
                <h1>INFORMAÇÕES PESSOAIS</h1>
                <div class="line line1">
                    <div class="aluno">
                        <img src="https://placekitten.com/150/200" alt="Foto do aluno">
                        <div class="sobre-aluno">
                            <p><span>Nome:</span> Fulano de Tal</p>
                            <div class="info-com-data">
                                <p><span>Idade:</span> xx anos</p>
                                <p class="data-nascimento"><span>Data de Nascimento:</span> dd/mm/aaaa</p>
                            </div>
                            <p><span>Responsável:</span> Fulanao de Tal</p>
                            <p><span>Tel. Responsável:</span> (12)xxxxx-xxxx</p>
                            <div class="info-com-cpf">
                                <p><span>CPF:</span> XXX.XXX.XXX-XX</p>
                                <p class="rg"><span>RG:</span> XX.XXX.XXX-X</p>
                            </div>
                            <p><span>Sexo:</span> Masculino</p>
                        </div>
                    </div>
                    <textarea name="" id="" cols="30" rows="10" placeholder="Observações do Aluno"></textarea>
                </div>
                <div class="line line2">
                    <h2>Endereço</h2>
                    <p><span>Logradouro:</span> Rua dos Bobos</p>
                    <div class="endereco-info">
                        <p><span>Complemento:</span> Ap.XX - Bloco X</p>
                        <p class="cep"><span>CEP:</span> 123456-78</p>
                    </div>
                    <p><span>Bairro:</span> Bairro da Cidade</p>
                    <div class="cidade-uf">
                        <p><span>Cidade:</span> São José dos Campos</p>
                        <p class="uf"><span>UF:</span> SP</p>
                    </div>
                </div>
            </div>
            <div class="divisao baixo">
                <h1>INFORMAÇÕES ACADÊMICAS</h1>
                <div class="line">
                    <p><span>Curso:</span> Desenvolvimento de Sistemas</p>
                    <div class="info-com-matricula">
                        <p><span>Turma:</span> SG18001</p>
                        <p class="professor"><span>Professor:</span> Clau Clau</p>
                        <p class="matricula"><span>Matricula:</span> 123456</p>
                    </div>
                    <div class="info-com-horario">
                        <p><span>Período:</span> Noturno</p>
                        <p class="horario"><span>Horário:</span> 19h - 21h</p>
                        <p class="situacao"><span>Situação:</span> Ativo</p>
                    </div>
                    <p><span>Frequência:</span> 90%</p>
                </div>
            </div>
        </section>

        <section class="direita">
            <h1>OCORRÊNCIAS</h1>
            <!-- Aqui vai ser mostrada a lista das ocorrências -->
            <!-- criação automática a ser feita posteriormente, exemplo abaixo-->
            <ul>
                <li class="line">
                    <p><span>Data:</span> xx/xx/xxxx <span class="final">Assunto:</span> Pedagógico</p>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Inventore perspiciatis esse, animi nemo
                        minima dolor aut. Tenetur, cumque dicta animi ab veritatis amet. Sunt dolorum quo unde porro
                        pariatur reprehenderit?</p>
                </li>
            </ul>

            <input type="submit" value="NOVA OCORRÊNCIA">
        </section>
    </main>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>

    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>