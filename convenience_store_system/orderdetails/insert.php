<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Generate sequential auto-incrementing key ranges without structural overlap collisions
    $idQuery = $pdo->query("SELECT MAX(OrderDetailID) AS max_id FROM orderdetails");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO orderdetails (OrderDetailID, OrderID, ProductID, Quantity)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        intval($_POST['OrderID']),
        intval($_POST['ProductID']),
        intval($_POST['Quantity'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Item record appended to transaction details!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "FK validation error. Verify if Order ID and Product ID exist.",
        "error" => $e->getMessage()
    ]);
}
?>