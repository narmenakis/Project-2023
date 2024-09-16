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
    if (isset($_POST['offerID'])) {
        $offerID = $_POST['offerID'];

        // prepare SQL command to delete
        $sql = "DELETE FROM transaction WHERE transaction_id = ? AND user_id = ? AND type = 'offer' AND status = 'pending'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $offerID, $userId);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header("Location: announcementsandoffers.html");
            } else {
                echo "No offers found matching the criteria.";
            }
        } else {
            echo "Error canceling the offer: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Data missing.";
    }
}
