<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Generate next available auto-increment key block safely
    $idQuery = $pdo->query("SELECT MAX(ShipperID) AS max_id FROM shippers");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO shippers (ShipperID, ShipperName, Phone)
        VALUES (?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['ShipperName'],
        $_POST['Phone']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Courier profile securely logged!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An internal exception blocked registration.",
        "error" => $e->getMessage()
    ]);
}
?>