<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE customers
        SET FullName = ?, Barangay = ?, Email = ?
        WHERE CustomerID = ?
    ");

    $stmt->execute([
        $_POST['FullName'],
        $_POST['Barangay'],
        $_POST['Email'],
        intval($_POST['CustomerID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Customer details altered safely!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to alter structural records.",
        "error" => $e->getMessage()
    ]);
}
?>