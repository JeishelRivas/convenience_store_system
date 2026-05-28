<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE orderdetails
        SET OrderID = ?, ProductID = ?, Quantity = ?
        WHERE OrderDetailID = ?
    ");

    $stmt->execute([
        intval($_POST['OrderID']),
        intval($_POST['ProductID']),
        intval($_POST['Quantity']),
        intval($_POST['OrderDetailID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Line item dimensions altered successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update record fields.",
        "error" => $e->getMessage()
    ]);
}
?>