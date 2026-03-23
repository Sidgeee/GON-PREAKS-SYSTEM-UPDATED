<?php
include 'db_connect.php';

// Get the data sent from pos.js
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['cart'])) {
    $conn->begin_transaction(); // Start a transaction

    try {
        // 1. Insert into Sales Table
        $stmt = $conn->prepare("INSERT INTO sales (cashier_name, total_amount, payment_method) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $data['cashier'], $data['total'], $data['payment_method']);
        $stmt->execute();
        $sale_id = $conn->insert_id;

        foreach ($data['cart'] as $item) {
            // 2. Insert into Sale_Items Table
            $stmt = $conn->prepare("INSERT INTO sale_items (sale_id, supplier_part_number, quantity, price, subtotal) VALUES (?, ?, ?, ?, ?)");
            $subtotal = $item['selling_price'] * $item['qty'];
            $stmt->bind_param("isidd", $sale_id, $item['supplier_part_number'], $item['qty'], $item['selling_price'], $subtotal);
            $stmt->execute();

            // 3. Deduct Stock from Supplier_Products
            $stmt = $conn->prepare("UPDATE supplier_products SET stock_quantity = stock_quantity - ? WHERE sup_prod_id = ?");
            $stmt->bind_param("ii", $item['qty'], $item['sup_prod_id']);
            $stmt->execute();

            // 4. Record the Movement
            $stmt = $conn->prepare("INSERT INTO inventory_movements (sup_prod_id, movement_type, quantity, reference_id, notes) VALUES (?, 'SALE', ?, ?, 'POS Transaction')");
            $stmt->bind_param("iii", $item['sup_prod_id'], $item['qty'], $sale_id);
            $stmt->execute();
        }

        $conn->commit(); // Success! Save changes to database
        echo json_encode(['status' => 'success', 'sale_id' => $sale_id]);

    } catch (Exception $e) {
        $conn->rollback(); // Something went wrong, undo everything
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>