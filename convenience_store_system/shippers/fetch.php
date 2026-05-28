<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Individual provider pull for update models
        $stmt = $pdo->prepare("SELECT * FROM shippers WHERE ShipperID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Collect global sets to satisfy DataTables components
        $stmt = $pdo->query("SELECT * FROM shippers ORDER BY ShipperID DESC");
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