<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Supplier account permanently dropped from directory index!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Cannot delete supplier because active system products depend on it.",
        "error" => $e->getMessage()
    ]);
}
?>