<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'You are not logged in. Please log in first.']);
    exit;
}

$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// select transactions and item_name instead of item_id
$sql = "
    SELECT t.transaction_id, t.status, t.starting_date, t.transaction_date, t.completion_date, i.item_name, t.number_of_citizens_involved
    FROM transaction t 
    JOIN item i ON t.item_id = i.item_id
    WHERE t.user_id = ? 
    AND t.type = 'request'
    ORDER BY t.transaction_date DESC
";

$stmt = $conn->prepare($sql);
$userId = $_SESSION["user_id"];
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];

while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}

echo json_encode($transactions);

$stmt->close();
$conn->close();
