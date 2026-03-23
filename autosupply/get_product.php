<?php
include 'db_connect.php';

$part_number = $_GET['part_number'] ?? '';

// We join products with supplier_products to get the selling price
$sql = "SELECT p.part_number, p.name, p.brand, sp.unit_price as price 
        FROM products p 
        JOIN supplier_products sp ON p.part_number = sp.product_part_number 
        WHERE p.part_number = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $part_number);
$stmt->execute();
$result = $stmt->get_result();

if ($product = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'product' => $product]);
} else {
    echo json_encode(['success' => false]);
}
?>