<?php
$conn = include('database.php'); 

if (!$conn || $conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

$sql = "SELECT item_name FROM item";
$result = $conn->query($sql);

// check is results existed
if ($result->num_rows > 0) {
    // create <option> for each item
    while ($row = $result->fetch_assoc()) {
        echo "<option value=\"" . htmlspecialchars($row['item_name'], ENT_QUOTES, 'UTF-8') . "\">" . htmlspecialchars($row['item_name'], ENT_QUOTES, 'UTF-8') . "</option>";
    }
} else {
    echo "<option disabled>Items doesn't exist</option>";
}

$conn->close();
