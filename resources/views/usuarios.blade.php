<form action="/usuarios/salvar" method="post">
    @csrf
    <label for="nome">Nome:</label> <!-- Campo de texto para o nome do usuário -->
    <input type="text" name="nome" id="nome" required><br><br>
    
    <label for="email">Email:</label> <!-- Campo de email para o endereço de email do usuário -->
    <input type="email" name="email" id="email" required><br><br>
    
    <label for="cep">CEP:</label> <!-- Campo para o CEP do usuário -->
    <input type="text" name="cep" id="cep" maxlength="9" required><br><br>
    
    <label for="rua">Rua:</label> <!-- Campo de texto para a rua, preenchido automaticamente pela API ViaCEP -->
    <input type="text" name="rua" id="rua" readonly><br><br>
    
    <label for="bairro">Bairro:</label> <!-- Campo de texto para o bairro, preenchido automaticamente pela API ViaCEP -->
    <input type="text" name="bairro" id="bairro" readonly><br><br>
    
    <label for="cidade">Cidade:</label> <!-- Campo de texto para a cidade, preenchido automaticamente pela API ViaCEP -->
    <input type="text" name="cidade" id="cidade" readonly><br><br>
    
    <label for="estado">Estado:</label> <!-- Campo de texto para o estado, preenchido automaticamente pela API ViaCEP -->
    <input type="text" name="estado" id="estado" readonly><br><br>
    
    <button type="submit">Salvar</button> <!-- Botão para enviar o formulário -->
</form>
<!-- O formulário acima coleta informações do usuário, incluindo nome, email e endereço (com preenchimento automático via API de CEP) -->
<style>
    * {
        font-family: Arial, sans-serif;
    }

    form {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }
</style>
<!-- O estilo acima é aplicado ao formulário para melhorar a aparência e a usabilidade, centralizando o formulário na página e estilizando os campos e o botão de envio -->
<script>
// Event listener: Executa quando o campo CEP perde o foco (sai do campo)
document.getElementById('cep').addEventListener('blur', function() {
    // Remove todos os caracteres que não são números do CEP
    let cep = this.value.replace(/\D/g, '');
    
    // Verifica se o CEP tem exatamente 8 dígitos
    if (cep.length === 8) {
        // Atualiza o valor do campo com o CEP limpo
        this.value = cep;
        
        // Faz uma requisição para a API ViaCEP para buscar os dados do endereço
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json()) // Converte a resposta em JSON
            .then(data => {
                // Se o CEP não foi encontrado
                if (data.erro) {
                    alert('CEP não encontrado!');
                    // Limpa todos os campos de endereço
                    document.getElementById('rua').value = '';
                    document.getElementById('bairro').value = '';
                    document.getElementById('cidade').value = '';
                    document.getElementById('estado').value = '';
                    return;
                }
                
                // Preenche os campos com os dados retornados pela API
                document.getElementById('rua').value = data.logradouro || ''; // Rua/logradouro
                document.getElementById('bairro').value = data.bairro || ''; // Bairro
                document.getElementById('cidade').value = data.localidade || ''; // Cidade
                document.getElementById('estado').value = data.uf || ''; // Estado (Unidade Federativa)
            })
            // Se houver erro na requisição
            .catch(error => {
                console.error('Erro:', error); // Exibe o erro no console do navegador
                alert('Erro ao consultar CEP'); // Mostra uma mensagem de erro ao usuário
            });
    }
});
</script>
<!-- O script acima adiciona um evento ao campo de CEP para buscar os dados do endereço automaticamente quando o usuário terminar de digitar o CEP e sair do campo, utilizando a API ViaCEP para obter as informações de rua, bairro, cidade e estado -->