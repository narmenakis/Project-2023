<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//search storage coordinates (id = 15)
$sql = "SELECT latitude, longitude FROM coordinates WHERE id = 15";
$result = $conn->query($sql);

$warehouse = null;

if ($result->num_rows > 0) {
    $warehouse = $result->fetch_assoc();
}

//check query parameter "format" to return JSON or text
$format = isset($_GET['format']) ? $_GET['format'] : 'json';

if ($format == 'json') {
    header('Content-Type: application/json');
    echo json_encode($warehouse);
} else {
    // return data to text
    echo "Warehouse Location:<br>";
    echo "Latitude: " . $warehouse['latitude'] . "<br>";
    echo "Longitude: " . $warehouse['longitude'] . "<br>";
}

$conn->close();
