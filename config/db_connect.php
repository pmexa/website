<?php
/**
 * Ficheiro de ligação à base de dados
 * Caminho: /var/www/html/config/db_connect.php
 */

// Mostrar erros (útil em fase de testes — podes comentar mais tarde)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuração da ligação
$servername = "localhost";        // Servidor MySQL
$username   = "root";      // Nome do utilizador MySQL
$password   = "atec123"; // Password do utilizador
$database   = "stocks";            // Nome da base de dados

// Criar ligação
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar ligação
if (!$conn) {
    die("❌ Erro na ligação à base de dados: " . mysqli_connect_error());
}

// Opcional: definir charset UTF-8 (importante para acentos)
mysqli_set_charset($conn, "utf8mb4");

// ✅ Ligação estabelecida com sucesso
// (Não imprimir mensagens aqui — evita erros de cabeçalhos HTTP)
?>
