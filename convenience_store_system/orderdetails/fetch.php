<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Targeted retrieval for individual line items
        $stmt = $pdo->prepare("SELECT * FROM orderdetails WHERE OrderDetailID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Array streams passed directly down to the main list views
        $stmt = $pdo->query("SELECT * FROM orderdetails ORDER BY OrderDetailID DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["data" => $rows]);
    }
} catch (Exception $e) {
    echo json_encode([
        "data" => [],
        "error" => $e->getMessage()
    ]);
}
?>