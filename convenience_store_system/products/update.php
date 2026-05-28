<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE products
        SET ProductName = ?, CategoryID = ?, SupplierID = ?, Price = ?, StockQuantity = ?
        WHERE ProductID = ?
    ");

    $stmt->execute([
        $_POST['ProductName'],
        intval($_POST['CategoryID']),
        intval($_POST['SupplierID']),
        floatval($_POST['Price']),
        intval($_POST['StockQuantity']),
        intval($_POST['ProductID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Product metrics changed safely!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred during update operations",
        "error" => $e->getMessage()
    ]);
}
?>