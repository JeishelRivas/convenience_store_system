<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE suppliers
        SET SupplierName = ?, ContactName = ?, ContactPhone = ?, Address = ?, City = ?
        WHERE SupplierID = ?
    ");

    $stmt->execute([
        $_POST['SupplierName'],
        $_POST['ContactName'],
        $_POST['ContactPhone'],
        $_POST['Address'],
        $_POST['City'],
        intval($_POST['SupplierID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Supplier dimensions altered successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred during update operations.",
        "error" => $e->getMessage()
    ]);
}
?>