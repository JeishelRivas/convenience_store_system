<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Programmatically track next ID sequence increment securely
    $idQuery = $pdo->query("SELECT MAX(SupplierID) AS max_id FROM suppliers");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO suppliers (SupplierID, SupplierName, ContactName, ContactPhone, Address, City)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['SupplierName'],
        $_POST['ContactName'],
        $_POST['ContactPhone'],
        $_POST['Address'],
        $_POST['City']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Supplier vendor successfully added to directory!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An internal system error occurred during registration.",
        "error" => $e->getMessage()
    ]);
}
?>