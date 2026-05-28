<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Generate next programmatic unique high-key element without matching structural overlaps
    $idQuery = $pdo->query("SELECT MAX(OrderID) AS max_id FROM orders");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO orders (OrderID, CustomerID, EmployeeID, ShipperID, OrderDate)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        intval($_POST['CustomerID']),
        intval($_POST['EmployeeID']),
        intval($_POST['ShipperID']),
        $_POST['OrderDate']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Order checkout profile generated cleanly!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database level dependency validation rejected insertion task",
        "error" => $e->getMessage()
    ]);
}
?>