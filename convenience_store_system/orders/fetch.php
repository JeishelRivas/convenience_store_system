<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Fetch matching targeted tracking line context to fill elements
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE OrderID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Global selection arrays dispatched to DataTables list viewport
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY OrderID DESC");
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