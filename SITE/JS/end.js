document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
 
    cepInput.addEventListener('input', function() {
        const cepValue = cepInput.value.replace(/\D/g, '');
 
        if (cepValue.length === 8) {
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
