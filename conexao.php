<?php
// O PHP vai ler estas variáveis direto do servidor do Railway
$host     = getenv('MYSQLHOST')     ?: 'localhost';
$port     = getenv('MYSQLPORT')     ?: '3306';
$username = getenv('MYSQLUSER')     ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; 
$dbname   = getenv('MYSQLDATABASE') ?: 'railway'; 

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Isso vai nos mostrar o erro exato no navegador se falhar
    die("Erro na conexão com o banco de dados do Railway: " . $e->getMessage());
}
?>
