<?php
// connect to database
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productName']) && isset($_POST['quantity'])) {
        $productName = trim($_POST['productName']);
        $quantity = (int) $_POST['quantity'];  // Μετατροπή σε ακέραιο

        if (empty($productName)) {
            echo "Please add a product.";
        } else {
            // Πρώτα λαμβάνουμε την τρέχουσα ποσότητα από τη βάση δεδομένων
            $sqlGetCurrentAmount = "SELECT item_id, amount FROM item WHERE item_name = ?";
            $stmtGetAmount = $conn->prepare($sqlGetCurrentAmount);
            $stmtGetAmount->bind_param("s", $productName);
            $stmtGetAmount->execute();
            $stmtGetAmount->bind_result($itemId, $currentAmount);
            $stmtGetAmount->fetch();
            $stmtGetAmount->close();

            // Εάν δεν βρεθεί η ποσότητα, εμφανίστε μήνυμα
            if ($currentAmount === null) {
                echo "This product does not exist.";
            } else {
                //calculate new amount
                $newAmount = $currentAmount + $quantity;

                if ($newAmount < 0) {
                    $newAmount = 0;
                }

                // update with $newAmount
                $sqlUpdateItem = "UPDATE item SET amount = ?, date_added = NOW() WHERE item_name = ?";
                $stmtItem = $conn->prepare($sqlUpdateItem);
                $stmtItem->bind_param("is", $newAmount, $productName);

                if ($stmtItem->execute()) {
                    // if amount 0, delete row from storage
                    if ($newAmount == 0) {
                        $sqlDeleteStorage = "DELETE FROM storage WHERE item_id = ?";
                        $stmtDeleteStorage = $conn->prepare($sqlDeleteStorage);
                        $stmtDeleteStorage->bind_param("i", $itemId);
                        if (!$stmtDeleteStorage->execute()) {
                            echo "Error deleting from storage: " . $stmtDeleteStorage->error;
                        }
                    } else {
                        // check if item exists on storage
                        $coordinates_id = 15;  
                        $sqlCheckStorage = "SELECT * FROM storage WHERE item_id = ?";
                        $stmtCheckStorage = $conn->prepare($sqlCheckStorage);
                        $stmtCheckStorage->bind_param("i", $itemId);
                        $stmtCheckStorage->execute();
                        $resultCheckStorage = $stmtCheckStorage->get_result();

                        if ($resultCheckStorage->num_rows == 0) {
                            //NO , add item to storage
                            $sqlInsertStorage = "INSERT INTO storage (storage_coordinates_id, item_id) VALUES (?, ?)";
                            $stmtInsertStorage = $conn->prepare($sqlInsertStorage);
                            $stmtInsertStorage->bind_param("ii", $coordinates_id, $itemId);
                            if (!$stmtInsertStorage->execute()) {
                                echo "Error inserting into storage: " . $stmtInsertStorage->error;
                            }
                        }
                    }

                    // Redirect to storage.php after successful update and insert
                    header("Location: storage.php");
                    exit();
                } else {
                    echo "Error updating record: " . $stmtItem->error;
                }
                $stmtItem->close();
            }
        }
    }
}

$conn->close();
