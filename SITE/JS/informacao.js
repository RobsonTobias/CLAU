function limpar() {
    // Adicione a lógica para limpar os campos do formulário aqui
    document.getElementById('form').reset();
    // Você pode adicionar mais lógica de limpeza conforme necessário
}

function exibirImagem() {
    const input = document.getElementById('imagemInput');
    const imagemExibida = document.getElementById('imagemExibida');

    if (input.files && input.files[0]) {
        const leitor = new FileReader();

        leitor.onload = function (e) {
            imagemExibida.src = e.target.result;
        };

        leitor.readAsDataURL(input.files[0]);
    }
}

const handleZipCode = (event) => {
    let input = event.target
    input.value = zipCodeMask(input.value)
}

const zipCodeMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{5})(\d)/, '$1-$2')
    return value
}

const handlePhone = (event) => {
    let input = event.target
    input.value = PhoneMask(input.value)
}

const PhoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{2})(\d)/, "($1) $2")
    value = value.replace(/(\d)(\d{4})$/, "$1-$2")
    return value
}

const handleCPF = (event) => {
    let input = event.target
    input.value = CPFMask(input.value)
}

const CPFMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g, '')
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d)/, "$1.$2")
    value = value.replace(/(\d{3})(\d{2})/, "$1-$2")

    return value
}

const handleRG = (event) => {
    let input = event.target
    input.value = RGMask(input.value)
}

const RGMask = (value) => {
    if (!value) return ""
    value = value.replace(/[^a-zA-Z0-9]/g, '')
    value = value.replace(/^([a-zA-Z]{0,2})?(\d{2})(\d{3})(\d{3})([a-zA-Z0-9])?$/, "$1$2.$3.$4-$5")
    return value
}