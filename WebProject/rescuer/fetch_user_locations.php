<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; 

$conn = require('database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// searching user transactions
$sql = "
    SELECT u.citizen_name, u.citizen_surname, u.citizen_phone, c.latitude, c.longitude, 
           t.transaction_id, t.starting_date, t.transaction_date, t.item_id, t.requested_item_amount, t.type, t.status, t.vehicle_id,
           u.authentication_token, i.item_name
    FROM user u
    LEFT JOIN transaction t ON u.user_id = t.user_id
    LEFT JOIN coordinates c ON u.user_coordinates_id = c.id
    LEFT JOIN item i ON t.item_id = i.item_id
    WHERE u.authentication_token = 'citizen' AND t.type IN ('offer', 'request') AND t.status IN ('pending', 'acquired');
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$users = [];

// grouping transactions for each user
while ($row = $result->fetch_assoc()) {
    $users[] = [
        'username' => $row['citizen_name'] . ' ' . $row['citizen_surname'], //combine name and surname
        'phone' => $row['citizen_phone'],
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
        'item_name' => $row['item_name'],
        'transactions' => [
            'transaction_id' => $row['transaction_id'],
            'starting_date' => $row['starting_date'],
            'transaction_date' => $row['transaction_date'],
            'item_id' => $row['item_id'],
            'requested_item_amount' => $row['requested_item_amount'],
            'type' => $row['type'],
            'status' => $row['status'],
            'vehicle_id' => $row['vehicle_id']
        ],
        'authentication_token' => $row['authentication_token']
    ];
}

header('Content-Type: application/json');
echo json_encode($users); 


$stmt->close();
$conn->close();
