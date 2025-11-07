<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once __DIR__ . '/config/db_connect.php';

// Obter produtos
$query = "SELECT * FROM produtos ORDER BY data_adicionado DESC";
$result = mysqli_query($conn, $query);

// Estatísticas simples
$totalProdutos = 0;
$valorTotal = 0;
if ($result && mysqli_num_rows($result) > 0) {
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)) {
        $totalProdutos++;
        $valorTotal += $row['preco'] * $row['quantidade'];
    }
    mysqli_data_seek($result, 0);
}
?>
<!doctype html>
<html lang="pt-PT">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Gestão de Stocks — Dashboard</title>
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
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;
  }
  h2{color:#333;margin-top:40px;}
  .stats{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    margin-top:20px;
  }
  .stat-card{
    flex:1;
    min-width:220px;
    background:var(--card);
    border-radius:16px;
    padding:20px;
    text-align:center;
    box-shadow:0 8px 18px rgba(0,0,0,0.05);
  }
  .stat-card h3{margin:0;font-size:30px;color:var(--accent);}
  .stat-card p{margin:6px 0 0;font-weight:600;color:var(--muted);}
  table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:12px;
    box-shadow:0 8px 18px rgba(0,0,0,0.05);
    overflow:hidden;
  }
  th,td{
    padding:12px;
    text-align:center;
  }
  th{
    background:#ff6b6b;
    color:#fff;
    text-transform:uppercase;
    font-size:13px;
  }
  tr:nth-child(even){background:#f9f9f9;}
  tr:hover{background:#fff3f3;}
  footer{
    margin-top:60px;
    text-align:center;
    padding:20px;
    color:#777;
    font-size:14px;
  }
</style>
</head>
<body>

<header>
  <div class="brand">📦 Gestão de Stocks</div>
  <nav>
    <a href="index.php">Início</a>
    <a href="adicionar_produtos.php">Adicionar Produto</a>
  </nav>
  <a class="btn" href="adicionar_produtos.php">+ Novo Produto</a>
</header>

<div class="container">
  <h1>Dashboard de Inventário</h1>
  <p>Bem-vindo à tua plataforma de gestão de stocks. Aqui encontras um resumo rápido do teu inventário atual.</p>

  <div class="stats">
    <div class="stat-card">
      <h3><?php echo $totalProdutos; ?></h3>
      <p>Total de produtos</p>
    </div>
    <div class="stat-card">
      <h3><?php echo number_format($valorTotal, 2, ',', '.'); ?> €</h3>
      <p>Valor total em stock</p>
    </div>
    <div class="stat-card">
      <h3><?php echo date('d/m/Y'); ?></h3>
      <p>Data atual</p>
    </div>
  </div>

  <h2>📋 Lista de produtos</h2>
  <?php if ($result && mysqli_num_rows($result) > 0): ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Quantidade</th>
        <th>Preço (€)</th>
        <th>Total (€)</th>
        <th>Adicionado em</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['nome']); ?></td>
        <td><?php echo htmlspecialchars($row['categoria']); ?></td>
        <td><?php echo htmlspecialchars($row['quantidade']); ?></td>
        <td><?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
        <td><?php echo number_format($row['preco'] * $row['quantidade'], 2, ',', '.'); ?></td>
        <td><?php echo htmlspecialchars($row['data_adicionado']); ?></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p style="color:#666;margin-top:20px;">Ainda não existem produtos registados. <a href="adicionar_produtos.php" style="color:var(--accent);font-weight:bold;">Adiciona o primeiro produto</a>.</p>
  <?php endif; ?>
</div>

<footer>
  © <?php echo date('Y'); ?> Gestão de Stocks — Desenvolvido por Nuno 🚀
</footer>

</body>
</html>
