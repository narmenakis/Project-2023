<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("You are not logged in. Please log in first.");
}

$userId = $_SESSION["user_id"];

$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// edit POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //check if necessary data exist
    if (isset($_POST['productName']) && isset($_POST['quantity'])) {
        $productName = trim($_POST['productName']);
        $quantity = $_POST['quantity'];

        //check if empty
        if (empty($productName) || empty($quantity)) {
            echo "Please fill in all fields.";
        } else {
            // searching item_id (productName)
            $sqlItem = "SELECT item_id FROM item WHERE item_name = ?";
            $stmtItem = $conn->prepare($sqlItem);
            $stmtItem->bind_param("s", $productName);
            $stmtItem->execute();
            $resultItem = $stmtItem->get_result();

            // if item exists
            if ($resultItem->num_rows > 0) {
                $row = $resultItem->fetch_assoc();
                $itemId = $row['item_id'];

                // add new transaction row
                $sqlInsertTransaction = "INSERT INTO transaction (type, status, starting_date, user_id, item_id, requested_item_amount, number_of_citizens_involved) 
                                         VALUES ('request', 'pending', NOW(), ?, ?, ?, ?)";
                $stmtTransaction = $conn->prepare($sqlInsertTransaction);
                $stmtTransaction->bind_param("iiii", $userId, $itemId, $quantity, $quantity);

                if ($stmtTransaction->execute()) {
                    // success. go to requests.php
                    header("Location: requests.php");
                    exit(); 
                } else {
                    echo "Error: " . $conn->error;
                }

                // closing transaction statement
                $stmtTransaction->close();
            } else {
                echo "Product not found.";
            }

            // closing item statement
            $stmtItem->close();
        }
    }
}
$conn->close();
