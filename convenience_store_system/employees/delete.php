<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("DELETE FROM employees WHERE EmployeeID = ?");
    $stmt->execute([intval($_POST['id'])]);

    echo json_encode([
        "status" => "success",
        "message" => "Employee file permanently dropped from corporate registry!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Cannot delete employee. Active store sales or shifts are linked to this record.",
        "error" => $e->getMessage()
    ]);
}
?>