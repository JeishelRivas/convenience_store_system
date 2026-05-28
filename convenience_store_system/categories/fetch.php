<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Single row pull targetted for editing injection
        $stmt = $pdo->prepare("SELECT * FROM categories WHERE CategoryID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Collect global sets to populate your DataTables engine layout
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY CategoryID DESC");
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