<?php
// O Railway agora usa o prefixo PROJETO_SOCIAL_ porque você mudou o nome do card!
$host     = getenv('PROJETO_SOCIAL_HOST')     ?: (getenv('MYSQLHOST') ?: 'localhost');
$port     = getenv('PROJETO_SOCIAL_PORT')     ?: (getenv('MYSQLPORT') ?: '3306');
$username = getenv('PROJETO_SOCIAL_USER')     ?: (getenv('MYSQLUSER') ?: 'root');
$password = getenv('PROJETO_SOCIAL_PASSWORD') ?: (getenv('MYSQLPASSWORD') ?: ''); 
$dbname   = getenv('PROJETO_SOCIAL_DATABASE') ?: (getenv('MYSQLDATABASE') ?: 'railway'); 

try {
    // Conexão segura usando PDO
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Configurações para tratamento de erros e acentuação
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Mostra o erro real na tela se falhar de novo
    die("Erro na conexão com o banco do Railway: " . $e->getMessage());
}
?>
