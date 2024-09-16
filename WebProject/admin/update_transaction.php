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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    //update status transaction
    function takeOverTransaction($transaction_id, $user_id)
    {
        global $conn;

        // SQL to update status transaction to 'acquired'
        $sql = "UPDATE transaction 
                SET status = 'acquired', vehicle_id = ?, completion_date = NOW()
                WHERE transaction_id = ? AND status = 'pending'";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
            return false;
        }

        $stmt->bind_param("ii", $user_id, $transaction_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Transaction taken over successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Execution failed: ' . $stmt->error]);
        }

        $stmt->close();
    }

    takeOverTransaction($transaction_id, $user_id);
}

$conn->close();