<?php
// Tenta ler as variáveis do Railway
$host     = getenv('MYSQLHOST')     ?: 'localhost';
$port     = getenv('MYSQLPORT')     ?: '3306';
$username = getenv('MYSQLUSER')     ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';

// TESTE CRUCIAL: O Railway quase sempre usa 'railway' como nome do banco
// mesmo que você tenha criado as tabelas manualmente.
$dbname   = getenv('MYSQLDATABASE') ?: 'railway'; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Se der erro, vamos tentar o banco 'projeto_social' como plano B
    try {
        $dbname = 'projeto_social';
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    } catch (PDOException $e2) {
        die("Erro de Conexão: " . $e2->getMessage());
    }
}
?>
