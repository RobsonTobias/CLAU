<?php 
    function toatsActive($tipo){
        if($tipo== "erro"){
            $mensagem= "Não foi possivel realizar essa ação";
        }

        if($tipo== "success"){
            $mensagem= "Ação realizada com sucesso";
        }

        if($tipo== "warning"){
            $mensagem= "Não é possivel fazer isso por agora";
        }

        if($tipo== "info"){
            $mensagem= "Informo que..";
        }

        print(
        "<div>
            <div class='toast hide observ toast-$tipo'>
                <div class='toast-header-$tipo'>
                    <img src='...'  alt='...'>
                    
                    <strong>$mensagem</strong>
                    
                        <span class='ml-2 mb-1 close' data-dismiss='toast'>&times;</span>
                    
                </div>
            </div>
        </div>"
            );
    }
?>