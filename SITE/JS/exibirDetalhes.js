
function exibirDetalhesUsuario(dados) {
    //Variavel Nome
    var nome = document.getElementById('modalNome');
    var contNome = '';

    if (dados) {
        contNome += dados.Usuario_Nome;
    } else {
        contNome = 'Não informado';
    }

    nome.innerHTML = contNome;
    nome.style.display = 'block';

    // Variável Nascimento
    var nascimento = document.getElementById('modalNascimento');
    var contNascimento = '';

    if (dados && dados.Usuario_Nascimento) {
        // Converter a data para um objeto Date
        var dataObj = new Date(dados.Usuario_Nascimento);

        // Extrair dia, mês e ano
        var dia = ("0" + dataObj.getDate()).slice(-2); // Adiciona um zero à esquerda se necessário
        var mes = ("0" + (dataObj.getMonth() + 1)).slice(-2); // Adiciona um zero à esquerda, mês começa em 0
        var ano = dataObj.getFullYear();

        // Montar a string de data no formato desejado
        contNascimento = dia + '-' + mes + '-' + ano;
    } else {
        contNascimento = 'Não informado';
    }

    nascimento.innerHTML = contNascimento;
    nascimento.style.display = 'block';

    //Variavel Idade
    function calcularIdade(dataNascimento) {
        var hoje = new Date();
        var nascimento = new Date(dataNascimento);
        var calcIdade = hoje.getFullYear() - nascimento.getFullYear();
        var m = hoje.getMonth() - nascimento.getMonth();

        if (m < 0 || (m === 0 && hoje.getDate() < nascimento.getDate())) {
            calcIdade--;
        }

        return calcIdade;
    }

    var calcIdade = calcularIdade(dados.Usuario_Nascimento);

    var idade = document.getElementById('modalIdade');
    var contIdade = '';

    if (dados) {
        contIdade = calcIdade + ' anos';
    } else {
        contIdade = 'Não informado';
    }

    idade.innerHTML = contIdade;
    idade.style.display = 'block';

    // Função para formatar o CPF
    function formatarCPF(cpf) {
        // Remove tudo que não for dígito
        cpf = cpf.replace(/\D/g, '');

        // Formata o CPF
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

        return cpf;
    }
    //Variavel CPF
    var Cpf = document.getElementById('modalCpf');
    var contCpf = '';

    if (dados) {
        // Formata o CPF antes de adicionar ao conteúdo
        contCpf += formatarCPF(dados.Usuario_Cpf);
    } else {
        contCpf = 'Não informado';
    }

    Cpf.innerHTML = contCpf;
    Cpf.style.display = 'block';

    // Função para formatar o RG
    function formatarRG(rg) {
        // Remove tudo que não for dígito
        rg = rg.replace(/\D/g, '');

        // Formata o RG
        rg = rg.replace(/(\d{2})(\d)/, "$1.$2");
        rg = rg.replace(/(\d{3})(\d)/, "$1.$2");
        rg = rg.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

        return rg;
    }
    //Variavel RG
    var rg = document.getElementById('modalRg');
    var contRg = '';

    if (dados) {
        contRg += formatarRG(dados.Usuario_Rg);
    } else {
        contRg = 'Não informado';
    }

    rg.innerHTML = contRg;
    rg.style.display = 'block';

    //Variavel Sexo
    var Sexo = document.getElementById('modalSexo');
    var contSexo = '';

    if (dados && dados.Usuario_Sexo) {
        if (dados.Usuario_Sexo === 'M') {
            contSexo = 'Masculino';
        } else if (dados.Usuario_Sexo === 'F') {
            contSexo = 'Feminino';
        } else {
            contSexo = 'Não informado';
        }
    } else {
        contSexo = 'Não informado';
    }

    Sexo.innerHTML = contSexo;
    Sexo.style.display = 'block';


    //Variavel E-mail
    var Email = document.getElementById('modalEmail');
    var contEmail = '';

    if (dados) {
        contEmail += dados.Usuario_Email;
    } else {
        contEmail = 'Não informado';
    }

    Email.innerHTML = contEmail;
    Email.style.display = 'block';


    // Função para formatar o celular
    function formatarCelular(celular) {
        // Remove tudo que não for dígito
        celular = celular.replace(/\D/g, '');

        // Formata o celular
        celular = celular.replace(/(\d{2})(\d)/, "($1) $2");
        celular = celular.replace(/(\d{5})(\d)/, "$1-$2");

        return celular;
    }

    var Celular = document.getElementById('modalCelular');
    var contCelular = '';

    if (dados) {
        // Formata o celular antes de adicionar ao conteúdo
        contCelular += formatarCelular(dados.Usuario_Fone);
    } else {
        contCelular = 'Não informado';
    }

    Celular.innerHTML = contCelular;
    Celular.style.display = 'block';


    //Variavel Data de Ingresso
    var Ingresso = document.getElementById('modalIngresso');
    var contIngresso = '';

    if (dados && dados.Registro_Data) {
        // Converter a data para um objeto Date
        var dataObj = new Date(dados.Registro_Data);

        // Extrair dia, mês e ano
        var dia = ("0" + dataObj.getDate()).slice(-2); // Adiciona um zero à esquerda se necessário
        var mes = ("0" + (dataObj.getMonth() + 1)).slice(-2); // Adiciona um zero à esquerda, mês começa em 0
        var ano = dataObj.getFullYear();

        // Montar a string de data no formato desejado
        contIngresso = dia + '-' + mes + '-' + ano;
    } else {
        contIngresso = 'Não informado';
    }

    Ingresso.innerHTML = contIngresso;
    Ingresso.style.display = 'block';

    //Variavel Obs
    var obs = document.getElementById('modalObs');
    var contObs = '';

    if (dados) {
        contObs += dados.Usuario_Obs;
    } else {
        contObs = 'Não informado';
    }

    obs.innerHTML = contObs;
    obs.style.display = 'block';

    //Variavel Logradouro
    var Logradouro = document.getElementById('modalLogradouro');
    var contLogradouro = '';

    if (dados && dados.Enderecos_Rua) {
        contLogradouro += dados.Enderecos_Rua;
    } else {
        contLogradouro = 'Não informado';
    }

    Logradouro.innerHTML = contLogradouro;
    Logradouro.style.display = 'block';

    //Variavel Numero
    var Numero = document.getElementById('modalNumero');
    var contNumero = '';

    if (dados && dados.Enderecos_Numero) {
        contNumero += dados.Enderecos_Numero;
    } else {
        contNumero = 'Não informado';
    }

    Numero.innerHTML = contNumero;
    Numero.style.display = 'block';

    //Variavel Complemento
    var Complemento = document.getElementById('modalComplemento');
    var contComplemento = '';

    if (dados && dados.Enderecos_Complemento) {
        contComplemento += dados.Enderecos_Complemento;
    } else {
        contComplemento = 'Não informado';
    }

    Complemento.innerHTML = contComplemento;
    Complemento.style.display = 'block';

    // Função para formatar o CEP
    function formatarCEP(cep) {
        // Remove tudo que não for dígito
        cep = cep.replace(/\D/g, '');

        // Formata o CEP
        if (cep.length === 8) {
            cep = cep.replace(/(\d{5})(\d{3})/, "$1-$2");
        }

        return cep;
    }

    //Variavel Cep
    var Cep = document.getElementById('modalCep');
    var contCep = '';

    if (dados && dados.Enderecos_Cep) {
        contCep += formatarCEP(dados.Enderecos_Cep);
    } else {
        contCep = 'Não informado';
    }

    Cep.innerHTML = contCep;
    Cep.style.display = 'block';


    //Variavel Bairro
    var Bairro = document.getElementById('modalBairro');
    var contBairro = '';

    if (dados && dados.Enderecos_Bairro) {
        contBairro += dados.Enderecos_Bairro;
    } else {
        contBairro = 'Não informado';
    }

    Bairro.innerHTML = contBairro;
    Bairro.style.display = 'block';

    //Variavel Cidade
    var Cidade = document.getElementById('modalCidade');
    var contCidade = '';

    if (dados && dados.Enderecos_Cidade) {
        contCidade += dados.Enderecos_Cidade;
    } else {
        contCidade = 'Não informado';
    }

    Cidade.innerHTML = contCidade;
    Cidade.style.display = 'block';

    //Variavel Uf
    var Uf = document.getElementById('modalUf');
    var contUf = '';

    if (dados && dados.Enderecos_Uf) {
        contUf += dados.Enderecos_Uf;
    } else {
        contUf = 'Não informado';
    }

    Uf.innerHTML = contUf;
    Uf.style.display = 'block';
    // Variável para a imagem
    var imagem = document.getElementById('imagemExibida');

    if (dados && dados.Usuario_Foto) {
        imagem.src = dados.Usuario_Foto;
    } else {
        imagem.src = '../ICON/perfil.svg';
    }
}
