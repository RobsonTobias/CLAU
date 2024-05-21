document.addEventListener("DOMContentLoaded", function() {
    const toats = document.querySelectorAll('.toast');

    toats.forEach(toat => {
        const closeButton = toat.querySelector('.close');
        closeButton.addEventListener('click', () => hideToat(toat));

        // Exibir o toast automaticamente após 1 segundo
        setTimeout(() => showToat(toat), 500);

        // Ocultar o toast automaticamente após 5 segundos
        setTimeout(() => hideToat(toat), 5000);
    });

    // Função para mostrar um toast
    function showToat(toat) {
        toat.classList.add('show');
    }

    // Função para esconder um toast
    function hideToat(toat) {
        toat.classList.remove('show');
        setTimeout(() => {
            toat.style.display = "none";
        }, 1500); // Tempo de transição correspondente ao CSS
    }
});
