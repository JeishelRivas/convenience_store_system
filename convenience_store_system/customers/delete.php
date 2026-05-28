<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM customers WHERE CustomerID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Customer entry dropped from the system."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Cannot delete customer due to existing relational orders records.",
        "error" => $e->getMessage()
    ]);
}
?>