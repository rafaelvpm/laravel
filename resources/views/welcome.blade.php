<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Profissional - Clínicas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 350px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center;
        }
        h2 { margin-bottom: 20px; color: #333; }
        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box; /* Garante que o padding não quebre a largura */
        }
        button {
            width: 100%;
            padding: 12px;
            background: #4facfe;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { background: #00c6ff; }
        .msg { margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>

    @if(session('sucesso'))
        <div class="msg" style="color: green;">{{ session('sucesso') }}</div>
    @endif

    <form method="POST" action="/cadastrar">
        @csrf 
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="telefone" id="telefone" placeholder="Telefone" required>
        <input type="email" name="email" placeholder="E-mail" required>

        <input type="hidden" name="origem" value="{{ request('src', 'direto') }}">

        <button type="submit">Cadastrar</button>
    </form>
</div>

<script>
    // Sua máscara de telefone continua funcionando aqui
    document.getElementById("telefone").addEventListener("input", function(e) {
        let v = e.target.value.replace(/\D/g, '');
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
        v = v.replace(/(\d{5})(\d)/, "$1-$2");
        e.target.value = v;
    });
</script>

</body>
</html>
