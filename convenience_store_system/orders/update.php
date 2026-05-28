<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE orders
        SET CustomerID = ?, EmployeeID = ?, ShipperID = ?, OrderDate = ?
        WHERE OrderID = ?
    ");

    $stmt->execute([
        intval($_POST['CustomerID']),
        intval($_POST['EmployeeID']),
        intval($_POST['ShipperID']),
        $_POST['OrderDate'],
        intval($_POST['OrderID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Order context properties mutated successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Data mutation task halted internal execution workflows",
        "error" => $e->getMessage()
    ]);
}
?>