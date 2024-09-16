<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// fetch data from POST request
$lat = isset($_POST['lat']) ? $_POST['lat'] : null;
$lng = isset($_POST['lng']) ? $_POST['lng'] : null;
$user_coordinates_id = isset($_POST['user_coordinates_id']) ? $_POST['user_coordinates_id'] : null;

// check if data are valid
if (is_null($lat) || is_null($lng) || is_null($user_coordinates_id)) {
    echo "Error: Missing coordinates or user_coordinates_id.";
    exit;
}

// update destination for `user_coordinates_id`
$sql = "UPDATE coordinates SET latitude = ?, longitude = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ddi", $lat, $lng, $user_coordinates_id);

if ($stmt->execute()) {
    echo "Location updated successfully.";
} else {
    echo "Error updating location: " . $stmt->error;
}

$stmt->close();
$conn->close();
