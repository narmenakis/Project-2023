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

$conn = include('database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// SQL Query fetch data (products amount > 0)
$sql = "SELECT vehicleitems.vehicle_id, vehicleitems.item_id, vehicleitems.quantity
        FROM vehicleitems
        WHERE vehicleitems.vehicle_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);

$stmt->execute();
$result = $stmt->get_result();

$vehicleitem = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // add item
        $vehicleitem[] = [
            'vehicle_id' => $row['vehicle_id'],
            'item_id' => $row['item_id'],
            'quantity' => $row['quantity']
        ];
    }
}

echo json_encode($vehicleitem);

$stmt->close();
$conn->close();
