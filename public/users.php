<?php
require_once __DIR__ . '/../src/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['name'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Nome é obrigatório']);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO users (name) VALUES (?)");
$stmt->execute([$data['name']]);

echo json_encode([
    'id' => $pdo->lastInsertId(),
    'name' => $data['name'],
    'message' => 'Usuário criado com sucesso'
]);