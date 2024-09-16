<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$conn = include('database.php');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// SQL query return data from item
$sql = "SELECT item.item_id, item.item_name, item.amount
        FROM item
        WHERE item.amount > 0";  // only available 

$result = $conn->query($sql);

if (!$result) {
    die(json_encode(['error' => 'Error in SQL query: ' . $conn->error]));
}

$items = [];

if ($result->num_rows > 0) {
    // collect data and add to array $items
    while ($row = $result->fetch_assoc()) {
        $items[] = [
            'item_id' => $row['item_id'],
            'item_name' => $row['item_name'],
            'quantity' => $row['amount']  
        ];
    }
} else {
    echo json_encode(['error' => 'No items found']);
    exit;
}

header('Content-Type: application/json');
echo json_encode($items);

$conn->close();
