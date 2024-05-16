<?php
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
    <link rel="icon" href="../ICON/C.svg" type="image/svg">
    <style>
        .fale path{
            stroke: #043140;
        }

          /* Estilos para o modal */
/* Estilos revisados somente para o modal, para evitar impactos na sidebar */

.modal {
    display: none; /* Isso garante que o modal está oculto ao carregar a página */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    align-items: center;
    justify-content: center;
    overflow: auto;
}

.item{
  color:white;
}

.modal-content {
    background-color: #fefefe;
    margin: auto; /* Removido, não é necessário com flex */
    padding: 20px;
    font-size: 20px;
    border: 1px solid #888;
    width: 30%; /* Ajuste conforme necessário, mas mantenha menor que 100% */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    text-align: center;
}


.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
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
                <h1>FALE CONOSCO</h1>
                <div class="php">
                    <?php echo $date;?><!--  Mostrar o data atual -->
                </div>
            </div>

            <div class="user">
                <?php echo $dropdown;?><!-- Mostrar o usuario, foto e menu dropdown -->
            </div>
        </div>
        <hr>
    </header>

    <div>
        <?php echo $sidebarHTML;?><!--  Mostrar o menu lateral -->
    </div>
    
    <main>
        <a href="javascript:void(0);" class="item" data-info="(12) 3908-8998"><p>Telefone</p></a>
        <a href="javascript:void(0);" class="item" data-info="Rua das flores, n° 234 - Centro"><p>Endereço</p></a>
        <a href="javascript:void(0);" class="item" data-info="sistemaclau.com.br"><p>Site</p></a>
        <a href="javascript:void(0);" class="item" data-info="sistemaclau@gmail.com">
            <p>E-mail</p>
        </a>
    </main>
    
    <div id="myModal" class="modal">
  <div class="modal-content">
  <span class="close">&times;</span>

    <div id="modalContent">
      <!-- Aqui serão exibidas as informações relativas ao botão -->
    </div>
  </div>
</div>

    <div class="buttons">
        <?php echo $redes;?><!--  Mostrar o botão de fale conosco -->
    </div>
    <script>
 document.addEventListener("DOMContentLoaded", function() {
    // Garante que o modal esteja oculto ao carregar a página
    var modal = document.getElementById("myModal");
    modal.style.display = "none";

    var items = document.getElementsByClassName("item");
    for (var i = 0; i < items.length; i++) {
        items[i].addEventListener("click", function() {
            var info = this.getAttribute("data-info");
            var modalContent = document.getElementById("modalContent");
            modalContent.innerHTML = info;
            modal.style.display = "flex"; // Exibe o modal
        });
    }

    var span = document.querySelector(".modal-content .close");
    span.onclick = function() {
        modal.style.display = "none"; // Esconde o modal
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none"; // Esconde o modal ao clicar fora
        }
    }
});


</script>


    <script src="../JS/dropdown.js"></script>
    <script src="../JS/botao.js"></script>
    <script src="../PHP/sidebar/menu.js"></script>
</body>

</html>