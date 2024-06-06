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
