<?php
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE invoices SET
        number = ?,
        date = ?,
        due_date = ?,
        shipping_price = ?,
        company = ?,
        items = ?
    WHERE id = ?
");

$stmt->execute([
    $data['number'],
    $data['date'],
    $data['due_date'],
    $data['shipping_price'] ?? 0,
    json_encode($data['company'], JSON_UNESCAPED_UNICODE),
    json_encode($data['items'], JSON_UNESCAPED_UNICODE),
    $data['id']
]);

echo json_encode(['status' => 'ok']);
