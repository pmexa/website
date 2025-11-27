<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/config/db_connect.php';

// Inicializar variáveis
$mensagem = "";
$erro = "";

// Verificar envio do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST['nome'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $preco = floatval($_POST['preco'] ?? 0);

    if (empty($nome) || empty($categoria) || $quantidade <= 0 || $preco <= 0) {
        $erro = "⚠️ Por favor, preenche todos os campos corretamente.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO produtos (nome, categoria, quantidade, preco) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssid", $nome, $categoria, $quantidade, $preco);
        if (mysqli_stmt_execute($stmt)) {
            $mensagem = "✅ Produto adicionado com sucesso!";
        } else {
            $erro = "❌ Erro ao adicionar produto: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html lang="pt-PT">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Adicionar Produto — Gestão de Stocks</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  :root {
    --accent:#ff6b6b;
    --bg:#f8fafc;
    --card:#fff;
    --muted:#555;
    font-family:'Poppins',sans-serif;
  }
  body{
    margin:0;
    background:var(--bg);
    color:#222;
  }
  header{
    background:linear-gradient(135deg,#ff6b6b,#ff8787);
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 40px;
    position:sticky;
    top:0;
    z-index:10;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
  }
  .brand{font-weight:700;font-size:20px;}
  nav a{
    color:#fff;
    text-decoration:none;
    margin:0 12px;
    font-weight:500;
    transition:opacity 0.2s;
  }
  nav a:hover{opacity:0.8;}
  .btn{
    background:#fff;
    color:var(--accent);
    padding:10px 18px;
    border-radius:8px;
    font-weight:700;
    text-decoration:none;
    transition:all 0.2s;
  }
  .btn:hover{background:#ffe6e6;}
  .container{
    max-width:700px;
    margin:40px auto;
    background:var(--card);
    padding:30px;
    border-radius:16px;
    box-shadow:0 8px 18px rgba(0,0,0,0.05);
  }
  h1{text-align:center;color:#333;}
  form{display:flex;flex-direction:column;gap:16px;margin-top:20px;}
  label{font-weight:600;color:#444;}
  input,select{
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
  }
  input:focus,select:focus{outline:none;border-color:var(--accent);box-shadow:0 0 4px rgba(255,107,107,0.4);}
  .submit-btn{
    background:var(--accent);
    color:#fff;
    border:none;
    padding:12px;
    border-radius:10px;
    font-weight:700;
    cursor:pointer;
    transition:background 0.3s;
  }
  .submit-btn:hover{background:#ff8787;}
  .mensagem{margin-top:20px;padding:10px 14px;border-radius:8px;font-weight:600;text-align:center;}
  .sucesso{background:#e6ffed;color:#256d1b;}
  .erro{background:#ffe6e6;color:#b3261e;}
  footer{text-align:center;color:#777;margin-top:60px;font-size:14px;}
</style>
</head>
<body>

<header>
  <div class="brand">📦 Gestão de Stocks</div>
  <nav>
    <a href="index.php">Início</a>
    <a href="adicionar_produtos.php">Adicionar Produto</a>
  </nav>
  <a class="btn" href="index.php">← Voltar ao Dashboard</a>
</header>

<div class="container">
  <h1>Adicionar novo produto</h1>
  <p style="text-align:center;color:#555;">Preenche o formulário abaixo para adicionar um novo item ao stock.</p>

  <?php if ($mensagem): ?>
    <div class="mensagem sucesso"><?php echo $mensagem; ?></div>
  <?php elseif ($erro): ?>
    <div class="mensagem erro"><?php echo $erro; ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <div>
      <label for="nome">Nome do produto:</label>
      <input type="text" id="nome" name="nome" required>
    </div>
    <div>
      <label for="categoria">Categoria:</label>
      <select id="categoria" name="categoria" required>
        <option value="">-- Escolhe uma categoria --</option>
        <option value="Tecnologia">Tecnologia</option>
        <option value="Alimentação">Alimentação</option>
        <option value="Higiene">Higiene</option>
        <option value="Casa">Casa</option>
        <option value="Outro">Outro</option>
      </select>
    </div>
    <div>
      <label for="quantidade">Quantidade:</label>
      <input type="number" id="quantidade" name="quantidade" min="1" required>
    </div>
    <div>
      <label for="preco">Preço (por unidade):</label>
      <input type="number" id="preco" name="preco" step="0.01" min="0.01" required>
    </div>
    <button type="submit" class="submit-btn">💾 Guardar Produto</button>
  </form>
</div>

<footer>
  © <?php echo date('Y'); ?> Gestão de Stocks — Desenvolvido pelo Grupo zero três
</footer>

</body>
</html>

