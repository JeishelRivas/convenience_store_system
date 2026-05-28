<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Targeted retrieval for individual supplier rows
        $stmt = $pdo->prepare("SELECT * FROM suppliers WHERE SupplierID = ?");
        $stmt->execute([$_GET['id']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row ? $row : []);
    } else {
        // Collect whole row sets to feed DataTables display engine
        $stmt = $pdo->query("SELECT * FROM suppliers ORDER BY SupplierID DESC");
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