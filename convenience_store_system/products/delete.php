<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM products WHERE ProductID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Product cleanly dropped out from storage array catalogs!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Cannot delete product due to foreign key constraints on active transactions.",
        "error" => $e->getMessage()
    ]);
}
?>