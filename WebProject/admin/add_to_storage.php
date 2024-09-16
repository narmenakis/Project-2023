<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// searching items with amount > 0
$sql = "SELECT item_id, amount FROM item";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $sql_clear = "DELETE FROM storage";
    $conn->query($sql_clear);

    // manage every item on table item
    while ($row = $result->fetch_assoc()) {
        $item_id = $row['item_id'];
        $amount = $row['amount'];

        // add only items with amount > 0 on storage
        if ($amount > 0) {
            $sql_insert = "INSERT INTO storage (storage_coordinates_id, item_id)
                           VALUES (15, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("i", $item_id);

            if ($stmt->execute()) {
                echo "Product with item_id " . $item_id . " successfully added to storage.<br>";
            } else {
                echo "Error adding product with item_id " . $item_id . ": " . $conn->error . "<br>";
            }

            $stmt->close();
        }
    }
} else {
    echo "No products found.";
}

$conn->close();

