<?php
require 'db.php';


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// privalomi laukai
$required = ['id', 'number', 'date', 'due_date', 'items'];

foreach ($required as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing field: $field"]);
        exit;
    }
}

/**
 * 🔧 NORMALIZUOJAM company
 */
$company = $data['company'] ?? [];

$company = [
    'buyer' => $company['buyer'] ?? [
        'name' => '',
        'address' => '',
        'code' => '',
        'email' => '',
        'phone' => '',
        'vat' => ''
    ],
    'seller' => $company['seller'] ?? [
        'name' => '',
        'address' => '',
        'code' => '',
        'email' => '',
        'phone' => '',
        'vat' => ''
    ]
];

/**
 * 🔧 NORMALIZUOJAM items
 */
$items = array_map(function ($item) {
    return [
        'description' => $item['description'] ?? '',
        'quantity'    => (int)($item['quantity'] ?? 1),
        'price'       => (float)($item['price'] ?? 0),
        'discount'    => $item['discount'] ?? [
            'type' => 'fixed',
            'value' => 0
        ]
    ];
}, $data['items']);

$stmt = $pdo->prepare("
    INSERT INTO invoices (
        id, number, date, due_date, company, items, shipping_price
    ) VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $data['id'],
    $data['number'],
    $data['date'],
    $data['due_date'],
    json_encode($company, JSON_UNESCAPED_UNICODE),
    json_encode($items, JSON_UNESCAPED_UNICODE),
    $data['shippingPrice'] ?? 0
]);

echo json_encode(['status' => 'ok']);
