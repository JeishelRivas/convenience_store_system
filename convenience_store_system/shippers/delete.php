<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM shippers WHERE ShipperID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Shipper completely removed from system indexes!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Cannot delete shipper. Active customer orders are currently attached to it.",
        "error" => $e->getMessage()
    ]);
}
?>