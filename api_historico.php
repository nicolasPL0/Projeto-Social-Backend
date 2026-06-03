<?php
require_once 'conexao.php';

header('Content-Type: application/json');

$curso = isset($_GET['curso']) ? $_GET['curso'] : '';
$turma = isset($_GET['turma']) ? $_GET['turma'] : '';

// Buscar alunos filtrados
$sql = "SELECT matricula, nome, curso, turma FROM alunos WHERE status = 'Ativo'";
$params = [];

if ($curso) {
    $sql .= " AND curso = ?";
    $params[] = $curso;
}
if ($turma) {
    $sql .= " AND turma = ?";
    $params[] = $turma;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$alunos = $stmt->fetchAll();

// Buscar todos os registros dos alunos filtrados para agregar os dados
$matriculas = array_column($alunos, 'matricula');

if (empty($matriculas)) {
    echo json_encode([]);
    exit;
}

$inQuery = implode(',', array_fill(0, count($matriculas), '?'));
$sqlRegistros = "SELECT matricula, tipo_ocorrencia FROM registros WHERE matricula IN ($inQuery)";
$stmtRegistros = $pdo->prepare($sqlRegistros);
$stmtRegistros->execute($matriculas);
$registros = $stmtRegistros->fetchAll();

// Mapear os registros por matrícula
$ocorrenciasPorMatricula = [];
foreach ($registros as $reg) {
    $mat = $reg['matricula'];
    if (!isset($ocorrenciasPorMatricula[$mat])) {
        $ocorrenciasPorMatricula[$mat] = ['Tolerância' => 0, 'Notificação' => 0, 'Fardamento' => 0, 'Saída Antecipada' => 0];
    }
    $ocorrenciasPorMatricula[$mat][$reg['tipo_ocorrencia']]++;
}

$resultado = [];
foreach ($alunos as $aluno) {
    $mat = $aluno['matricula'];
    $contagem = isset($ocorrenciasPorMatricula[$mat]) ? $ocorrenciasPorMatricula[$mat] : ['Tolerância' => 0, 'Notificação' => 0, 'Fardamento' => 0, 'Saída Antecipada' => 0];
    
    // Regra: 3 tolerâncias = 1 ocorrência
    $tolerancias = $contagem['Tolerância'];
    $extraOco = floor($tolerancias / 3);
    
    $oco = $contagem['Fardamento'] + $extraOco;
    $adv = $contagem['Notificação'];
    $noti = $contagem['Saída Antecipada'];
    
    $resultado[] = [
        'matricula' => $mat,
        'name' => $aluno['nome'],
        'curso' => $aluno['curso'],
        'turma' => $aluno['turma'],
        'adv' => $adv,
        'oco' => $oco,
        'noti' => $noti
    ];
}

echo json_encode($resultado);
?>
