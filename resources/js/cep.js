function limpa_formulario_cep(userId) {
    document.getElementById('rua-' + userId).value = "";
    document.getElementById('bairro-' + userId).value = "";
    document.getElementById('cidade-' + userId).value = "";
    document.getElementById('uf-' + userId).value = "";
}

async function pesquisacep(valor, userId) {
    const cep = valor.replace(/\D/g, '');

    if (cep.length !== 8) {
        limpa_formulario_cep(userId);
        return;
    }

    document.getElementById('rua-' + userId).value = "...";
    document.getElementById('bairro-' + userId).value = "...";
    document.getElementById('cidade-' + userId).value = "...";
    document.getElementById('uf-' + userId).value = "...";

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();

        if (data.erro) {
            limpa_formulario_cep(userId);
            alert("CEP não encontrado.");
            return;
        }

        document.getElementById('rua-' + userId).value = data.logradouro;
        document.getElementById('bairro-' + userId).value = data.bairro;
        document.getElementById('cidade-' + userId).value = data.localidade;
        document.getElementById('uf-' + userId).value = data.uf;

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        limpa_formulario_cep(userId);
    }
}

window.pesquisacep = pesquisacep;