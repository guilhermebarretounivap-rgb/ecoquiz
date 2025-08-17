<?php
require_once __DIR__ . '/../src/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['user_id']) || !isset($data['score']) || !isset($data['total'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Parâmetros inválidos']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Inserir no histórico
    $stmt = $pdo->prepare("INSERT INTO quiz_results (user_id, score, total_questions) VALUES (?, ?, ?)");
    $stmt->execute([$data['user_id'], $data['score'], $data['total']]);

    // Atualizar pontuação total do usuário
    $stmt = $pdo->prepare("UPDATE users SET total_score = total_score + ? WHERE id = ?");
    $stmt->execute([$data['score'], $data['user_id']]);

    $pdo->commit();

    echo json_encode(['message' => 'Resultado salvo com sucesso']);
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}