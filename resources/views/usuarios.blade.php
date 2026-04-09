<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #0b0f1a;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
      position: relative;
      overflow-x: hidden;
    }

    #stars {
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
    }

    .star {
      position: absolute;
      background: #fff;
      border-radius: 50%;
    }

    .card {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      background: #111827;
      border: 0.5px solid rgba(255, 255, 255, 0.08);
      border-radius: 16px;
      padding: 2rem 1.75rem 2.5rem;
    }

    .header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #1e293b;
      border: 1px solid rgba(255, 255, 255, 0.1);
      margin: 0 auto 1.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon svg {
      width: 20px;
      height: 20px;
    }

    h1 {
      font-size: 16px;
      font-weight: 500;
      color: #e2e8f0;
      margin-bottom: 4px;
    }

    .subtitle {
      font-size: 13px;
      color: #475569;
    }

    .sep {
      height: 0.5px;
      background: rgba(255, 255, 255, 0.05);
      margin: 1.5rem 0;
    }

    .field {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      font-size: 12px;
      color: #64748b;
      margin-bottom: 6px;
    }

    input {
      width: 100%;
      background: #0f172a;
      border: 0.5px solid rgba(255, 255, 255, 0.07);
      border-radius: 8px;
      color: #cbd5e1;
      font-size: 14px;
      padding: 10px 12px;
      outline: none;
      transition: border-color 0.15s;
      font-family: inherit;
    }

    input::placeholder { color: #1e293b; }
    input:focus { border-color: rgba(148, 163, 184, 0.25); }
    input[readonly] { color: #334155; cursor: default; }

    .row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }

    .cep-wrap { position: relative; }

    .spinner {
      display: none;
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 12px;
      height: 12px;
      border: 1.5px solid rgba(255, 255, 255, 0.06);
      border-top-color: #64748b;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

    .spinner.on { display: block; }

    @keyframes spin { to { transform: translateY(-50%) rotate(360deg); } }

    .dot-ok {
      display: none;
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: #22c55e;
    }

    .dot-ok.on { display: block; }

    .error-msg {
      font-size: 11px;
      color: #ef4444;
      margin-top: 4px;
      display: none;
    }

    .error-msg.on { display: block; }

    .btn {
      width: 100%;
      margin-top: 1.5rem;
      padding: 11px;
      background: #1e293b;
      border: 0.5px solid rgba(255, 255, 255, 0.1);
      border-radius: 8px;
      color: #94a3b8;
      font-size: 13px;
      font-family: inherit;
      cursor: pointer;
      transition: background 0.15s, color 0.15s;
      letter-spacing: 0.2px;
    }

    .btn:hover { background: #263345; color: #e2e8f0; }
    .btn:active { transform: scale(0.99); }
  </style>
</head>
<!-- Inicia o corpo da página -->
<body>

  <!-- Container das estrelas (elementos visuais de fundo) -->
  <div id="stars"></div>

  <!-- Cartão principal que contém todo o formulário -->
  <div class="card">
    <!-- Cabeçalho do cartão com título e descrição -->
    <div class="header">
      <!-- Título principal da página -->
      <h1>Cadastro</h1>
      <!-- Subtítulo com instruções para o usuário -->
      <p class="subtitle">Preencha seus dados abaixo</p>
    </div>

    <!-- Formulário que envia os dados para /usuarios/salvar usando POST -->
    <form action="/usuarios/salvar" method="post">
      <!-- Token CSRF do Laravel para proteção contra ataques -->
      @csrf

      <!-- Campo de entrada do nome -->
      <div class="field">
        <!-- Label descrevendo o campo -->
        <label for="nome">Nome</label>
        <!-- Input de texto para o nome (obrigatório) -->
        <input type="text" name="nome" id="nome" placeholder="Seu nome completo" required>
      </div>

      <!-- Campo de entrada do email -->
      <div class="field">
        <!-- Label descrevendo o campo -->
        <label for="email">E-mail</label>
        <!-- Input de email para validação automática (obrigatório) -->
        <input type="email" name="email" id="email" placeholder="voce@email.com" required>
      </div>

      <!-- Linha separadora visual -->
      <div class="sep"></div>

      <!-- Campo de entrada do CEP (com spinner de carregamento) -->
      <div class="field cep-wrap">
        <!-- Label descrevendo o campo -->
        <label for="cep">CEP</label>
        <!-- Input do CEP com máximo de 9 caracteres (obrigatório) -->
        <input type="text" name="cep" id="cep" maxlength="9" placeholder="00000-000" required>
        <!-- Spinner (ícone girando) que aparece enquanto busca o CEP -->
        <div class="spinner" id="spinner"></div>
        <!-- Ponto verde que aparece quando CEP é encontrado com sucesso -->
        <div class="dot-ok" id="dot-ok"></div>
      </div>
      <!-- Mensagem de erro que aparece se CEP não for encontrado -->
      <p class="error-msg" id="cep-error">CEP não encontrado</p>

      <!-- Campo de entrada da rua (preenchido automaticamente após buscar o CEP) -->
      <div class="field">
        <!-- Label descrevendo o campo -->
        <label for="rua">Rua</label>
        <!-- Input readonly (só leitura) que é preenchido pela API de CEP -->
        <input type="text" name="rua" id="rua" readonly placeholder="—">
      </div>

      <!-- Container com dois campos em linha (bairro e cidade) -->
      <div class="row">
        <!-- Campo de entrada do bairro (preenchido automaticamente) -->
        <div class="field">
          <!-- Label descrevendo o campo -->
          <label for="bairro">Bairro</label>
          <!-- Input readonly preenchido pela API de CEP -->
          <input type="text" name="bairro" id="bairro" readonly placeholder="—">
        </div>
        <!-- Campo de entrada da cidade (preenchido automaticamente) -->
        <div class="field">
          <!-- Label descrevendo o campo -->
          <label for="cidade">Cidade</label>
          <!-- Input readonly preenchido pela API de CEP -->
          <input type="text" name="cidade" id="cidade" readonly placeholder="—">
        </div>
      </div>

      <!-- Campo de entrada do estado (preenchido automaticamente) -->
      <div class="field">
        <!-- Label descrevendo o campo -->
        <label for="estado">Estado</label>
        <!-- Input readonly preenchido pela API de CEP -->
        <input type="text" name="estado" id="estado" readonly placeholder="—">
      </div>

      <!-- Botão para enviar o formulário -->
      <button type="submit" class="btn">Salvar</button>
    </form>
  </div>

  <!-- Script JavaScript que controla a funcionalidade da página -->
  <script>
    // ========== SEÇÃO: GERAR ESTRELAS DE FUNDO ==========
    // Obtém o container onde as estrelas serão colocadas
    const starsEl = document.getElementById('stars');
    // Loop que cria 120 estrelas aleatórias
    for (let i = 0; i < 120; i++) {
      // Cria um elemento div para representar uma estrela
      const s = document.createElement('div');
      // Define a classe CSS 'star' para estilizar a estrela
      s.className = 'star';
      // Define o tamanho aleatório: 3px se random > 0.85, senão 2px (algumas maiores)
      const size = Math.random() > 0.85 ? 3 : 2;
      // Define os estilos da estrela usando cssText
      s.style.cssText = `
        left: ${Math.random() * 100}%;        /* Posição horizontal aleatória (0-100%) */
        top: ${Math.random() * 100}%;         /* Posição vertical aleatória (0-100%) */
        width: ${size}px;                     /* Largura da estrela */
        height: ${size}px;                    /* Altura da estrela */
        opacity: ${(Math.random() * 0.25 + 0.04).toFixed(2)};  /* Opacidade aleatória (0.04 a 0.29) */
      `;
      // Adiciona a estrela ao container
      starsEl.appendChild(s);
    }

    // ========== SEÇÃO: BUSCA E PREENCHIMENTO DE CEP ==========
    // Obtém referência ao input do CEP
    const cepInput = document.getElementById('cep');
    // Obtém referência ao spinner (ícone de carregamento)
    const spinner  = document.getElementById('spinner');
    // Obtém referência ao ponto verde de sucesso
    const dotOk    = document.getElementById('dot-ok');
    // Obtém referência à mensagem de erro
    const cepError = document.getElementById('cep-error');

    // ========== EVENTO: Quando o usuário digita no campo CEP ==========
    cepInput.addEventListener('input', function () {
      // Remove todos os caracteres não numéricos (\D = não dígito)
      let v = this.value.replace(/\D/g, '');
      // Se tiver mais de 5 dígitos, formata como "00000-000"
      if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5, 8);
      // Atualiza o valor do input com a formatação
      this.value = v;
      // Remove o ponto verde (em caso de edição)
      dotOk.classList.remove('on');
      // Remove a mensagem de erro (em caso de edição)
      cepError.classList.remove('on');
    });

    // ========== EVENTO: Quando o usuário sai do campo CEP (blur) ==========
    cepInput.addEventListener('blur', function () {
      // Remove todos os caracteres não numéricos para validar
      const cep = this.value.replace(/\D/g, '');
      // Valida se o CEP tem exatamente 8 dígitos, se não, sai da função
      if (cep.length !== 8) return;

      // Mostra o spinner (ícone de carregamento)
      spinner.classList.add('on');
      // Remove o ponto verde
      dotOk.classList.remove('on');
      // Remove a mensagem de erro
      cepError.classList.remove('on');

      // Faz a requisição HTTP para a API ViaCEP
      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        // Primeira .then: converte a resposta para JSON
        .then(r => r.json())
        // Segunda .then: processa os dados recebidos
        .then(data => {
          // Remove o spinner (para de carregar)
          spinner.classList.remove('on');
          // Verifica se a API retornou erro (CEP não existe)
          if (data.erro) {
            // Define a mensagem de erro
            cepError.textContent = 'CEP não encontrado';
            // Mostra a mensagem de erro
            cepError.classList.add('on');
            // Limpa todos os campos de endereço
            ['rua', 'bairro', 'cidade', 'estado'].forEach(id => {
              document.getElementById(id).value = '';
            });
            // Sai da função
            return;
          }
          // Preenche o campo de rua com dados da API (ou vazio se undefined)
          document.getElementById('rua').value    = data.logradouro || '';
          // Preenche o campo de bairro com dados da API
          document.getElementById('bairro').value = data.bairro     || '';
          // Preenche o campo de cidade com dados da API
          document.getElementById('cidade').value = data.localidade || '';
          // Preenche o campo de estado com dados da API
          document.getElementById('estado').value = data.uf         || '';
          // Mostra o ponto verde de sucesso
          dotOk.classList.add('on');
        })
        // .catch: trata erros de rede ou conexão
        .catch(() => {
          // Remove o spinner
          spinner.classList.remove('on');
          // Define mensagem de erro de conexão
          cepError.textContent = 'Erro ao consultar o CEP';
          // Mostra a mensagem de erro
          cepError.classList.add('on');
        });
    });
  </script>

</body>
</html>