<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM orderdetails WHERE OrderDetailID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Line item safely dropped out from records!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Database processing failure during dropping task.",
        "error" => $e->getMessage()
    ]);
}
?>