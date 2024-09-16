<?php
// checking debugging errors
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

// SQL query choose status 'acquired' and coordinates of users
$sql = "
    SELECT u.citizen_name, u.citizen_surname, u.citizen_phone, c.latitude, c.longitude, 
           t.transaction_id, t.transaction_date, t.item_id, t.requested_item_amount, t.type, t.status, t.vehicle_id,
           i.item_name
    FROM user u
    JOIN transaction t ON u.user_id = t.user_id
    JOIN coordinates c ON u.user_coordinates_id = c.id
    JOIN item i ON t.item_id = i.item_id
    WHERE t.status = 'acquired' AND  t.vehicle_id = $user_id;
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$transactions = [];

// grouping transactions for each user
while ($row = $result->fetch_assoc()) {
    $transactions[] = [
        'citizen_name' => $row['citizen_name'],
        'citizen_surname' => $row['citizen_surname'],
        'citizen_phone' => $row['citizen_phone'],
        'latitude' => $row['latitude'],     
        'longitude' => $row['longitude'],  
        'transaction_id' => $row['transaction_id'],
        'transaction_date' => $row['transaction_date'],
        'item_id' => $row['item_id'],
        'item_name' => $row['item_name'],
        'requested_item_amount' => $row['requested_item_amount'],
        'type' => $row['type'],
        'status' => $row['status'],
        'vehicle_id' => $row['vehicle_id']
    ];
}

// return to JSON form
echo json_encode(['success' => true, 'transactions' => $transactions]);

$stmt->close();
$conn->close();
