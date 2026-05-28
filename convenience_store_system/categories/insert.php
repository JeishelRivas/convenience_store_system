<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Generate next available Primary ID key seamlessly 
    $idQuery = $pdo->query("SELECT MAX(CategoryID) AS max_id FROM categories");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO categories (CategoryID, CategoryName)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['CategoryName']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "New product category successfully registered!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred during addition processing",
        "error" => $e->getMessage()
    ]);
}
?>