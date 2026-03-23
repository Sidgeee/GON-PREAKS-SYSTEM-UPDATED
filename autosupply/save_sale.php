<?php
session_start();
include 'db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'];
$payment = $data['payment_method'];
$user_id = $_SESSION['user_id'];

// 1. Calculate Grand Total
$total = 0;
foreach($cart as $item) { $total += ($item['price'] * $item['qty']); }

// 2. Insert into Sales table (using created_at as we found earlier)
$stmt = $conn->prepare("INSERT INTO sales (total_amount, payment_method, user_id, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("dsi", $total, $payment, $user_id);
$stmt->execute();
$sale_id = $conn->insert_id;

// 3. Deduct Stock for each item
foreach($cart as $item) {
    $stmt = $conn->prepare("UPDATE supplier_products SET stock_quantity = stock_quantity - ? WHERE product_part_number = ?");
    $stmt->bind_param("is", $item['qty'], $item['part_number']);
    $stmt->execute();
}

echo json_encode(['success' => true, 'sale_id' => $sale_id]);
?>