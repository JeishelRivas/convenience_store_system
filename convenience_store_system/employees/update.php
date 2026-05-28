<?php
include '../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        UPDATE employees
        SET FirstName = ?, LastName = ?, Birthdate = ?, Position = ?, Notes = ?
        WHERE EmployeeID = ?
    ");

    $stmt->execute([
        $_POST['FirstName'],
        $_POST['LastName'],
        $_POST['Birthdate'],
        $_POST['Position'],
        $_POST['Notes'],
        intval($_POST['EmployeeID'])
    ]);

    echo json_encode([
        "status" => "success",
        "message" => "Employee data alterations successfully saved!"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "An error occurred during modification data updates.",
        "error" => $e->getMessage()
    ]);
}
?>