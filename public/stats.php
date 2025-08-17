<?php
require_once __DIR__ . '/../src/db.php';
header('Content-Type: application/json');

$avgStmt = $pdo->query("SELECT AVG(score / total_questions) AS avg_correct_ratio FROM quiz_results");
$avg = $avgStmt->fetchColumn();

$totalGames = $pdo->query("SELECT COUNT(*) FROM quiz_results")->fetchColumn();
$totalPlayers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

echo json_encode([
    'avg_correct_ratio' => round($avg * 100, 2) . '%',
    'total_games' => (int)$totalGames,
    'total_players' => (int)$totalPlayers
]);