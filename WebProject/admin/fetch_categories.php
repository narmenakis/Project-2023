<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

// if GET, export categories an create <option> elements
$sql = "SELECT category_name FROM category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<option value=\"" . $row['category_name'] . "\">" . $row['category_name'] . "</option>";
    }
} else {
    echo "<option disabled>Δεν υπάρχουν κατηγορίες</option>";
}

$conn->close();
