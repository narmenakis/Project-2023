<?php
session_start();

$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION["user_id"])) {
    die("You are not logged in.");
}

$userId = $_SESSION["user_id"]; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['announcement_id']) && isset($_POST['quantity'])) {
        $announcementId = $_POST['announcement_id'];
        $quantity = (int) $_POST['quantity'];

        // check if quantity is valid
        if ($quantity <= 0) {
            echo "Not valid quantity.";
            exit();
        }

        // insert offer on transaction table
        $sqlInsertTransaction = "INSERT INTO transaction (type, status, starting_date, user_id, item_id, requested_item_amount, number_of_citizens_involved) 
                                 SELECT 'offer', 'pending', NOW(), ?, item_id, ?, ? FROM announcement WHERE announcement_id = ?";
        $stmt = $conn->prepare($sqlInsertTransaction);
        $stmt->bind_param("iiii", $userId, $quantity, $quantity, $announcementId);

        if ($stmt->execute()) {
            echo "Offer registered successfully!";
        } else {
            echo "Error during registration: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Data missing.";
    }
}
