<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//select item_name based on item_id to announcements
$sql = "SELECT announcement.announcement_id, announcement.announcement_title, announcement.announcement_item_quantity, item.item_name 
        FROM announcement 
        JOIN item ON announcement.item_id = item.item_id";  // JOIN connecting 2 tables
$result = $conn->query($sql);

$announcements = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($announcements);

$conn->close();
