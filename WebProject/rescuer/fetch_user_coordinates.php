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
// get user coordinates from `coordinates`
$sql = "SELECT latitude, longitude FROM coordinates WHERE id = (SELECT user_coordinates_id FROM user WHERE user_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$coordinates = $result->fetch_assoc();

if ($coordinates) {
    echo json_encode($coordinates);
} else {
    echo json_encode(["error" => "No coordinates found for this user."]);
}

$stmt->close();
$conn->close();
