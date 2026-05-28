<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Generate the next safe unique Primary key ID
    $idQuery = $pdo->query("SELECT MAX(CustomerID) AS max_id FROM customers");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO customers (CustomerID, FullName, Barangay, Email)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['FullName'],
        $_POST['Barangay'],
        $_POST['Email']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Customer record appended successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save record.",
        "error" => $e->getMessage()
    ]);
}
?>