<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Individual item lookups targeted for modal inputs
        $stmt = $pdo->prepare("SELECT * FROM products WHERE ProductID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Data feed arrays sent down directly to display engines
        $stmt = $pdo->query("SELECT * FROM products ORDER BY ProductID DESC");
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