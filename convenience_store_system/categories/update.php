<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE categories
        SET CategoryName = ?
        WHERE CategoryID = ?
    ");

    $stmt->execute([
        $_POST['CategoryName'],
        intval($_POST['CategoryID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Category metrics changed successfully!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to update category record details",
        "error" => $e->getMessage()
    ]);
}
?>