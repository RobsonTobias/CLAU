<?php include_once 'COMPONENTS/toats.php' ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="STYLE/botao.css" />
    <link rel="stylesheet" href="STYLE/style1.css">
    <title>CLAU - Sistema de Gestão Escolar</title>
    <link rel="icon" href="ICON/C.svg" type="image/svg">
</head>

<body class="senha">
    <div class="container">
        <div class="conteudo primeiro">
            <div class="primeira-coluna">
                <h2 class="titulo">Login</h2>
                <form action="login.php" class="form" method="post">
                    <label for="usuario" class="labels">
                        <p style="padding-left: 15px;">Usuário</p>
                        <input type="text" id="usuario" name="usuario" required>
                    </label>
                    <label for="password" class="labels">
                        <p style="padding-left: 15px;">Senha</p>
                            <input type="password" id="password" name="password" class="input__field" required>
                            <img alt="Eye Icon" title="Eye Icon" src="ICON/eye.svg" class="input__icon">
                    </label>
                    <?php
                        if (isset($_GET['tipo']) && $_GET['tipo'] == 'erro') {
                            echo "<p class='erro'>Usuário ou senha incorretos.</p>";
                        }
                    ?>
                    
                    <a href="#" class="ancora esquecer" id="senha">Esqueceu sua senha</a>
                    <input type="submit" value="Login" class="btn primeiro-btn home">
                </form>
            </div>

            <div class="segunda-coluna">
            </div>
            
        </div>
        <div class="conteudo segundo">
           
            <div class="primeira-coluna">
                <h2 class="titulo">Redefinir senha</h2>
                <div class="descricao">Para redefinir sua senha, informe seu email cadastrado e lhe enviaremos um link com as instruções</div>
                <form class="form">
                    <label for="" class="labels">
                        <p style="padding-left: 15px;">Email</p>
                        <input type="email" id="emailUsuario" >
                    </label>
                    
                    <button  class="btn segundo-btn" type="button" id="redefinir">Redefinir Senha</button>
                    <a href="#" class="ancora cancelar" id="login">Cancelar</a>
                </form>
                
            </div>

            <div class="segunda-coluna">
            </div>
        </div>
        <div class="buttons">
            <button class="buttons__toggle"><div class="borda"><img src="ICON/fale.svg" alt="Fale_Conosco"></div></button>
            <div class="allbtns">
                <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="ICON/Facebook.svg" alt="Facebook"></a>
                <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="ICON/Linkedin.svg" alt="Linkedin"></a>
                <a class="button" href="https://www.web-leb.com/code" target="_blank"><img src="ICON/Instagram.svg" alt="Instagram"></a>
            </div>
        </div>
    </div>
    <div class="local-custom-toast-left">
        <?php 
            if (isset($_GET["tipo"])){
                $tipo = $_GET['tipo'];
                echo toatsActive($tipo);
            }
        ?>
    </div>
    
    <script src="JS/botao.js"></script>
    <script src="JS/app.js"></script>
    <script src="JS/script.js"></script>
    <script src="JS/redefinir.js"></script>

</body>

</html>