<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLAU - Home</title>
    <link rel="stylesheet" href="../../PHP/sidebar/menu.css">
    <link rel="stylesheet" href="../../STYLE/botao.css" />
    <link rel="stylesheet" href="../../STYLE/data.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../STYLE/style_home.css">
    <style>
        .chamada path{
            stroke: #043140;
        }
    </style>
</head>

<body>

<?php include('../../PHP/data/data.php');?>
<?php include('../../PHP/sidebar/menu.php');?>

    <header>
        <div class="title">
            <div class="nomedata">
                <h1>LISTA DE CHAMADA E DIÁRIO DE CLASSE</h1>
                <div class="php">
                    <?php echo $date;?>
                </div>
            </div>

            <div class="user">
                <p>Usuário</p>
                <div class="dropdown">
                <img src="https://placekitten.com/400/400" alt="Perfil" onclick="myFunction()" class="dropbtn">
                <div id="myDropdown" class="dropdown-content">
                    <a href="#home">Perfil</a>
                    <a href="#about">Notificação</a>
                    <a href="../../index.html">Sair</a>
                  </div>
            </div>
            </div>
        </div>
        <hr>
    </header>
    
    <div>
        <?php echo $sidebarHTML;?>
    </div>

    <main>
        <div class="item"><img src="../../ICON/chamada.svg" alt="Chamada_Diario">
            <p>Chamadas e Diário de Classe</p>
        </div>
        <div class="item"><img src="../../ICON/nota.svg" alt="Notas">
            <p>Notas</p>
        </div>
        <div class="item"><img src="../../ICON/aluno.svg" alt="Aluno">
            <p>Aluno</p>
        </div>
        <div class="item"><img src="../../ICON/turma.svg" alt="Turma">
            <p>Turma</p>
        </div>
        <div class="item"><img src="../../ICON/planejamento.svg" alt="Planejamento">
            <p>Planejamento</p>
        </div>
        <div class="item"><img src="../../ICON/relatorio.svg" alt="Relatorios">
            <p>Relatórios</p>
        </div>
        <div class="item"><img src="../../ICON/grade.svg" alt="Grade_Horaria">
            <p>Grade Horária</p>
        </div>
        <div class="item"><img src="../../ICON/calendario.svg" alt="Calendario">
            <p>Calendário</p>
        </div>
    </main>

    <div class="buttons">
        <button class="buttons__toggle"><div class="borda"><img src="../../ICON/fale.svg" alt="Fale_Conosco"></div></button>
        <div class="allbtns">
            <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="../../ICON/Facebook.svg" alt="Facebook"></a>
            <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="../../ICON/Linkedin.svg" alt="Linkedin"></a>
            <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="../../ICON/Instagram.svg" alt="Instagram"></a>
        </div>
    </div>

    <script src="../../JS/dropdown.js"></script>
    <script src="../../JS/botao.js"></script>
    <script src="../../PHP/sidebar/menu.js"></script>
</body>

</html>