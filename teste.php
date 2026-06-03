<?php
// Troque pelo nome exato do seu arquivo de conexão (conexao.php ou config.php)
require_once 'conexao.php'; 

try {
    $stmt = $pdo->query("SELECT * FROM alunos LIMIT 5");
    $resultados = $stmt->fetchAll();
    
    echo "<h2>✅ O PHP acessou a tabela 'alunos' com sucesso!</h2>";
    if (empty($resultados)) {
        echo "<p>A tabela está funcionando, mas está <strong>vazia</strong>. Nenhum aluno cadastrado ainda.</p>";
    } else {
        echo "<p>Alunos encontrados:</p><pre>";
        print_r($resultados);
        echo "</pre>";
    }
} catch (PDOException $e) {
    echo "<h2>❌ Erro ao ler a tabela 'alunos':</h2>";
    echo "<p>Mensagem do banco: " . $e->getMessage() . "</p>";
}
?>
