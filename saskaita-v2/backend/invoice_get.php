<?php
require 'db.php';

header('Content-Type: application/json');

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing id']);
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM invoices
    WHERE id = ?
");

$stmt->execute([$id]);
$invoice = $stmt->fetch();

if (!$invoice) {
    http_response_code(404);
    echo json_encode(['error' => 'Invoice not found']);
    exit;
}

$invoice['company'] = json_decode($invoice['company'], true);
$invoice['items']   = json_decode($invoice['items'], true);

echo json_encode($invoice, JSON_UNESCAPED_UNICODE);
