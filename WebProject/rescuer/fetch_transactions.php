<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    exit;
}

$user_id = $_SESSION['user_id']; 

$conn = include('database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// SQL query to get all transactions who vehicle_id = user_id
$sql = "SELECT transaction_id, status, amount, date FROM transaction WHERE vehicle_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

// if results exist
if ($result->num_rows > 0) {
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
    echo json_encode(['success' => true, 'transactions' => $transactions]);
} else {
    echo json_encode(['success' => false, 'message' => 'No transactions found']);
}

$stmt->close();
$conn->close();
