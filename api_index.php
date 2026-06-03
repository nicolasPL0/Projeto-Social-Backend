<?php
require_once 'conexao.php';

header('Content-Type: application/json');

$hoje = date('Y-m-d');

// 1. Atrasos de hoje
$stmtHoje = $pdo->prepare("SELECT * FROM registros WHERE data_registro = ? ORDER BY hora_registro DESC");
$stmtHoje->execute([$hoje]);
$registrosHoje = $stmtHoje->fetchAll();

// 2. Alunos em alerta
$stmtAlunos = $pdo->query("SELECT matricula, nome, turma FROM alunos WHERE status = 'Ativo'");
$alunos = $stmtAlunos->fetchAll();

$stmtRegistros = $pdo->query("SELECT matricula, tipo_ocorrencia FROM registros");
$todosRegistros = $stmtRegistros->fetchAll();

$contagemTol = [];
$contagemOcorr = [];

foreach ($todosRegistros as $r) {
    $mat = $r['matricula'];
    if (!isset($contagemTol[$mat])) $contagemTol[$mat] = 0;
    if (!isset($contagemOcorr[$mat])) $contagemOcorr[$mat] = 0;

    // Use similar logic as the frontend or the DB logic
    // 'Tolerância' counts as tolerancia. 'Notificação', 'Fardamento' count as ocorrencia (for this alert system).
    if ($r['tipo_ocorrencia'] === 'Tolerância') {
        $contagemTol[$mat]++;
    } elseif ($r['tipo_ocorrencia'] === 'Notificação' || $r['tipo_ocorrencia'] === 'Fardamento') {
        $contagemOcorr[$mat]++;
    }
}

$emAlerta = [];
foreach ($alunos as $a) {
    $mat = $a['matricula'];
    $tol = isset($contagemTol[$mat]) ? $contagemTol[$mat] : 0;
    $ocorr = (isset($contagemOcorr[$mat]) ? $contagemOcorr[$mat] : 0) + floor($tol / 3);

    if ($ocorr >= 2 || $tol >= 2) {
        $emAlerta[] = [
            'nome' => $a['nome'],
            'turma' => $a['turma'],
            'tol' => $tol,
            'ocorr' => $ocorr
        ];
    }
}

echo json_encode([
    'hoje' => $registrosHoje,
    'alertas' => $emAlerta
]);
?>
