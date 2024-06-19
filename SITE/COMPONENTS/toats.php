<style>
    /* Localização dos toasts */
.local-custom-toast-left {
    position: fixed !important;
    bottom: 0 !important;
    left: 0 !important;
}

.local-custom-toast-right {
    position: fixed !important;
    bottom: 0 !important;
    right: 50px !important;
}

/* Estilos básicos para custom toasts */
.custom-toast {
    max-width: 450px;
    padding: 0.75rem;
    margin: 1rem;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 0.25rem;
    box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.1);
    background-color: #fff;
    color: #ebe2e2;
    opacity: 0;
    transform: translateY(20px);
    transition: all 1.5s ease-in-out;
}

/* Exibir o custom toast */
.custom-toast.show {
    opacity: 0.95;
    transform: translateY(0);
}

/* Cabeçalho do custom toast */
.custom-toast-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    color: #555;
    background-color: #f7f7f7;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.custom-toast-header strong {
    margin-right: auto;
    font-weight: bold;
    font-size: 1rem;
    color: inherit;
}

.custom-toast-header .close {
    padding: 0.25rem 0.5rem;
    margin: -0.25rem -0.5rem -0.25rem auto;
    color: #000;
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
}

/* Corpo do custom toast */
.custom-toast-body {
    padding: 0.75rem;
    color: inherit;
}

/* Cores personalizadas para diferentes tipos de custom toast */
.custom-toast-success {
    border-color: #28a745 !important;
    background-color: #28a745 !important;
    color: #ffffff !important;
}

.custom-toast-erro {
    border-color: #dc3545 !important;
    background-color: #dc3545 !important;
    color: #ffffff !important;
}

.custom-toast-warning {
    border-color: #ffc107 !important;
    background-color: #ffc107 !important;
    color: #ffffff !important;
}

.custom-toast-info {
    border-color: #17a2b8 !important;
    background-color: #17a2b8 !important;
    color: #ffffff !important;
}

.close:hover {
    color: red;
}

.erro{
    color: #dc3545;
}

</style>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const toasts = document.querySelectorAll('.custom-toast');

    toasts.forEach(toast => {
        const closeButton = toast.querySelector('.close');
        closeButton.addEventListener('click', () => hideToast(toast));

        // Exibir o toast automaticamente após 0,5 segundo
        setTimeout(() => showToast(toast), 500);

        // Ocultar o toast automaticamente após 5 segundos
        setTimeout(() => hideToast(toast), 5000);
    });

    // Função para mostrar um toast
    function showToast(toast) {
        toast.classList.add('show');
    }

    // Função para esconder um toast
    function hideToast(toast) {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.style.display = "none";
        }, 1500); // Tempo de transição correspondente ao CSS
    }
});
</script>