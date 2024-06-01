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