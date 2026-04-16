<?php
// ===============================
// CONFIG BANCO
// ===============================
$host = "geraldo-dinoa_bd-geraldo-dinoa";
$port = "5432";
$db   = "geraldo-dinoa";
$user = "rafaelvpm";
$pass = "MjCd2009@2011";

$conn = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");

if (!$conn) {
    die("Erro na conexão com o banco.");
}

// ===============================
// CAPTURA DO SRC (origem)
// ===============================
$origem = $_GET['src'] ?? 'direto';

// ===============================
// ENVIO FORM
// ===============================
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $email = $_POST['email'] ?? '';
    $origem = $_POST['origem'] ?? '';

    // Validação simples
    if ($nome && $telefone && $email) {

        $query = "INSERT INTO profissional (nome, telefone, email, origem)
                  VALUES ($1, $2, $3, $4)";

        $result = pg_query_params($conn, $query, array($nome, $telefone, $email, $origem));

        if ($result) {
            $mensagem = "Cadastro realizado com sucesso!";
        } else {
            $mensagem = "Erro ao salvar.";
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastro Profissional</title>

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

h2 {
    margin-bottom: 20px;
}

input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 14px;
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

button:hover {
    background: #00c6ff;
}

.msg {
    margin-top: 15px;
    font-weight: bold;
}
</style>

</head>

<body>

<div class="container">
    <h2>Cadastro</h2>

    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="telefone" placeholder="Telefone" required>
        <input type="email" name="email" placeholder="E-mail" required>

        <!-- Origem oculta -->
        <input type="hidden" name="origem" value="<?php echo htmlspecialchars($origem); ?>">

        <button type="submit">Cadastrar</button>
    </form>

    <div class="msg"><?php echo $mensagem; ?></div>
</div>

<script>
// Máscara telefone simples
document.querySelector("input[name='telefone']").addEventListener("input", function(e) {
    let v = e.target.value.replace(/\D/g, '');
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
    v = v.replace(/(\d{5})(\d)/, "$1-$2");
    e.target.value = v;
});
</script>

</body>
</html>
