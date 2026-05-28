<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE shippers
        SET ShipperName = ?, Phone = ?
        WHERE ShipperID = ?
    ");

    $stmt->execute([
        $_POST['ShipperName'],
        $_POST['Phone'],
        intval($_POST['ShipperID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Logistics channel adjusted cleanly!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred during mutation save processing.",
        "error" => $e->getMessage()
    ]);
}
?>