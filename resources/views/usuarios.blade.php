<form action="/usuarios/salvar" method="post">
    @csrf
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required><br><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>
    
    <label for="cep">CEP:</label>
    <input type="text" name="cep" id="cep" maxlength="9" required><br><br>
    
    <label for="rua">Rua:</label>
    <input type="text" name="rua" id="rua" readonly><br><br>
    
    <label for="bairro">Bairro:</label>
    <input type="text" name="bairro" id="bairro" readonly><br><br>
    
    <label for="cidade">Cidade:</label>
    <input type="text" name="cidade" id="cidade" readonly><br><br>
    
    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" readonly><br><br>
    
    <button type="submit">Salvar</button>
</form>

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

<script>
document.getElementById('cep').addEventListener('blur', function() {
    let cep = this.value.replace(/\D/g, ''); // ✅ Removido espaço
    
    if (cep.length === 8) {
        
        this.value = cep;
        
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado!');
                    // Limpa os campos
                    document.getElementById('rua').value = '';
                    document.getElementById('bairro').value = '';
                    document.getElementById('cidade').value = '';
                    document.getElementById('estado').value = '';
                    return;
                }
                
                document.getElementById('rua').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('estado').value = data.uf || '';
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao consultar CEP');
            });
    }
});
</script>