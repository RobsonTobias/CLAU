document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');

    cepInput.addEventListener('keydown', function (event) {
        // Se a tecla pressionada for Enter ou Tab
        if (event.key === 'Enter' || event.key === 'Tab') {
            event.preventDefault(); // Impede o comportamento padrão (Tab muda de campo)

            // Chama a função para buscar o endereço
            buscarEndereco();
        }
    });
});

function buscarEndereco() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');

    if (cep.length !== 8) {
        alert('Digite um CEP válido com 8 dígitos.');
        return;
    }

    const url = `https://viacep.com.br/ws/${cep}/json/`;

    fetch(url)
        .then(response => response.json())
        .then(data => preencherEndereco(data))
        .catch(error => console.error('Erro ao buscar o endereço:', error));
}

function preencherEndereco(data) {
    if (data.erro) {
        alert('CEP não encontrado. Verifique se o CEP está correto.');
        return;
    }

    document.getElementById('logradouro').value = data.logradouro;
    document.getElementById('bairro').value = data.bairro;
    document.getElementById('cidade').value = data.localidade;
    document.getElementById('estado').value = data.uf;
}
