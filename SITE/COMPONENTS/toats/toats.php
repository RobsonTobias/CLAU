<?php
$url_nLogin = "/CLAU-Escobar/SITE/" ;
$url_chamada = $_SERVER['REQUEST_URI'];
    if($url_nLogin!=$url_chamada){
        print
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">';
    }
?>
<link rel="stylesheet" href="../PHP/toats/toats.css">
<script src="../PHP/toats/toats.js"></script>
<?php 
    function toatsActive($tipo){
        if($tipo== "erro"){
            $mensagem= "Não foi possivel realizar essa ação";
            $icon= "bi bi-bug-fill";
        }

        if($tipo== "success"){
            $mensagem= "Ação realizada com sucesso";
            $icon= "bi bi-check-lg";
        }

        if($tipo== "warning"){
            $mensagem= "Não é possivel fazer isso por agora";
            $icon= "bi bi-exclamation-lg";
        }

        if($tipo== "info"){
            $mensagem= "Informo que..";
            $icon= "bi bi-info-circle";
        }

        print(
        "<div class='local-custom-toast-right'>
        <div class='custom-toast custom-toast-$tipo' role='alert' aria-live='assertive' aria-atomic='true'>
            
                <i class='$icon'></i>
                    
                <strong>$mensagem</strong>

                <button type='button' class='close' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            
        </div>
    </div>"
            );
    }
?>