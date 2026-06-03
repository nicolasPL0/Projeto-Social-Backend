<?php
require_once 'conexao.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $curso = isset($_GET['curso']) ? $_GET['curso'] : '';
    $turma = isset($_GET['turma']) ? $_GET['turma'] : '';
    $mes_inicio = isset($_GET['mes_inicio']) ? intval($_GET['mes_inicio']) : 0;
    $mes_fim = isset($_GET['mes_fim']) ? intval($_GET['mes_fim']) : 0;
    $matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';

    $sql = "SELECT r.*, a.nome as aluno_nome FROM registros r LEFT JOIN alunos a ON r.matricula = a.matricula WHERE 1=1";
    $params = [];

    if ($curso) {
        $sql .= " AND r.curso = ?";
        $params[] = $curso;
    }
    if ($turma) {
        $sql .= " AND r.turma = ?";
        $params[] = $turma;
    }
    if ($matricula) {
        $sql .= " AND r.matricula = ?";
        $params[] = $matricula;
    }
    if ($mes_inicio && $mes_fim) {
        $menor = min($mes_inicio, $mes_fim);
        $maior = max($mes_inicio, $mes_fim);
        // Using string matching for month if the date is YYYY-MM-DD
        // Assuming data_registro is DATE type as per schema
        $sql .= " AND MONTH(r.data_registro) >= ? AND MONTH(r.data_registro) <= ?";
        $params[] = $menor;
        $params[] = $maior;
    }

    $sql .= " ORDER BY r.data_registro DESC, r.hora_registro DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $registros = $stmt->fetchAll();

    echo json_encode($registros);

} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['action']) && $data['action'] === 'delete') {
        $id = $data['id'];
        $stmt = $pdo->prepare("DELETE FROM registros WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    if (isset($data['action']) && $data['action'] === 'delete_all') {
        $stmt = $pdo->prepare("DELETE FROM registros");
        $stmt->execute();
        echo json_encode(['success' => true]);
        exit;
    }
}
?>
