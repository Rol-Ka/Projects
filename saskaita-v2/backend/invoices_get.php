<?php
require 'db.php';

header('Content-Type: application/json');

$stmt = $pdo->query("
    SELECT 
        id,
        number,
        date,
        due_date,
        shipping_price,
        company,
        items
    FROM invoices
    ORDER BY created_at DESC
");

$invoices = $stmt->fetchAll();

foreach ($invoices as &$inv) {
    $inv['company'] = json_decode($inv['company'], true);
    $inv['items'] = json_decode($inv['items'], true);
}

echo json_encode($invoices, JSON_UNESCAPED_UNICODE);
