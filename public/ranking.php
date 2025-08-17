<?php
require_once __DIR__ . '/../src/db.php';
header('Content-Type: application/json');

$stmt = $pdo->query("SELECT name, total_score FROM users ORDER BY total_score DESC LIMIT 10");
echo json_encode($stmt->fetchAll());