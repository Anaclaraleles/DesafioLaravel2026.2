function limpa_formulario_cep(userId) {
    const suffix = userId ? '-' + userId : '';

    document.getElementById('rua' + suffix).value = "";
    document.getElementById('bairro' + suffix).value = "";
    document.getElementById('cidade' + suffix).value = "";
    document.getElementById('uf' + suffix).value = "";
}

async function pesquisacep(valor, userId) {
    const suffix = userId ? '-' + userId : '';
    const cep = valor.replace(/\D/g, '');

    if (cep.length !== 8) {
        limpa_formulario_cep(userId);
        return;
    }

    document.getElementById('rua' + suffix).value = "...";
    document.getElementById('bairro' + suffix).value = "...";
    document.getElementById('cidade' + suffix).value = "...";
    document.getElementById('uf' + suffix).value = "...";

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            limpa_formulario_cep(userId);
            alert("CEP não encontrado.");
            return;
        }

        document.getElementById('rua' + suffix).value = data.logradouro;
        document.getElementById('bairro' + suffix).value = data.bairro;
        document.getElementById('cidade' + suffix).value = data.localidade;
        document.getElementById('uf' + suffix).value = data.uf;

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        limpa_formulario_cep(userId);
    }
}

window.pesquisacep = pesquisacep;