<?php
// Recupera as configurações das variáveis de ambiente (padrão no Railway) ou usa os fallbacks locais
$host = getenv('MYSQLHOST') ?: (getenv('DB_HOST') ?: 'localhost');
$port = getenv('MYSQLPORT') ?: (getenv('DB_PORT') ?: '3306');
$dbname = getenv('MYSQLDATABASE') ?: (getenv('DB_DATABASE') ?: (getenv('DB_NAME') ?: 'railway'));
$username = getenv('MYSQLUSER') ?: (getenv('DB_USER') ?: 'root');
$password = getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : (getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : '');

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Retornar os dados como array associativo por padrão
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
