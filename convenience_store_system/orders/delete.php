<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM orders WHERE OrderID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Transaction history context successfully removed from the system!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Purge operation blocked. Drop dependent rows inside orderdetails first.",
        "error" => $e->getMessage()
    ]);
}
?>