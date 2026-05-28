<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    if (isset($_GET['id'])) {
        // Fetch specific individual profile data rows
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE CustomerID = ?");
        $stmt->execute([$_GET['id']]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($customer ? $customer : []);
    } else {
        // Feed whole sets downstream safely into the DataTables display array
        $stmt = $pdo->query("SELECT * FROM customers ORDER BY CustomerID DESC");
        $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["data" => $customers]);
    }
} catch (Exception $e) {
    echo json_encode([
        "data" => [],
        "error" => $e->getMessage()
    ]);
}
?>