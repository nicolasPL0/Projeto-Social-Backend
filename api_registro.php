<?php
require_once 'conexao.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Optionally fetch all registros
    $stmt = $pdo->query("SELECT * FROM registros ORDER BY id DESC");
    $registros = $stmt->fetchAll();
    echo json_encode($registros);
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = isset($data['id']) ? $data['id'] : time(); // Use timestamp as basic ID if not provided, though the schema is BIGINT
    
    $sql = "INSERT INTO registros (
                id, tipo_ocorrencia, tipo, curso, turma, aluno, matricula, 
                data_registro, hora_registro, motivo_saida, outro_motivo, 
                observacoes, criado_em, criado_hora, lida
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([
            $data['id'],
            $data['tipo_ocorrencia'],
            $data['tipo'],
            $data['curso'],
            $data['turma'],
            $data['aluno'],
            $data['matricula'],
            $data['data'],
            $data['hora'],
            $data['motivo_saida'],
            $data['outro_motivo'],
            $data['observacoes'],
            $data['criado_em'],
            $data['criado_hora'],
            $data['lida'] ? 1 : 0
        ]);
        
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()]);
    }
}
?>
