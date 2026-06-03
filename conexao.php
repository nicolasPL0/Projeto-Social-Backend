<?php
// Tenta pegar as variáveis do Railway, se não existirem, usa o padrão local
$host = getenv('MYSQLHOST') ?: 'mysql.railway.internal';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'sCAvMtVwZMlZuDfPHnepqsnyWFkpBSyd';
$db   = getenv('MYSQLDATABASE') ?: 'railway'; // Nome padrão do Railway
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Se der erro, mostra na tela para sabermos o que é
    echo "Erro de conexão: " . $e->getMessage();
    exit;
}
?>
