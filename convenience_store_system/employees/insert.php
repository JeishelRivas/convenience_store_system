<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    // Safely track and allocate next structural auto-increment integer key
    $idQuery = $pdo->query("SELECT MAX(EmployeeID) AS max_id FROM employees");
    $idRow = $idQuery->fetch(PDO::FETCH_ASSOC);
    $newId = $idRow['max_id'] ? $idRow['max_id'] + 1 : 1;

    $stmt = $pdo->prepare("
        INSERT INTO employees (EmployeeID, FirstName, LastName, Birthdate, Position, Notes)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $newId,
        $_POST['FirstName'],
        $_POST['LastName'],
        $_POST['Birthdate'],
        $_POST['Position'],
        $_POST['Notes']
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Employee account safely added to registry!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An internal context constraint error occurred.",
        "error" => $e->getMessage()
    ]);
}
?>