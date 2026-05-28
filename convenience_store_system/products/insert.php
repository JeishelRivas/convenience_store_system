<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Dynamically tracking sequential keys without overlapping identities
    $idQuery = $pdo->query("SELECT MAX(ProductID) AS max_id FROM products");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO products (ProductID, ProductName, CategoryID, SupplierID, Price, StockQuantity)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['ProductName'],
        intval($_POST['CategoryID']),
        intval($_POST['SupplierID']),
        floatval($_POST['Price']),
        intval($_POST['StockQuantity'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Inventory item created cleanly!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Creation task blocked internally",
        "error" => $e->getMessage()
    ]);
}
?>