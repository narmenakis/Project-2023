<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Δεν είστε συνδεδεμένος. Παρακαλώ συνδεθείτε πρώτα.");
}

$userId = $_SESSION["user_id"];

$conn = include('database.php');

if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

// edit post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if exist proper data
    if (isset($_POST['productName']) && isset($_POST['quantity']) && isset($_POST['announcementtitle'])) {
        $announcementTitle = trim($_POST['announcementtitle']);
        $productNames = $_POST['productName'];  //producy name
        $quantities = $_POST['quantity'];  // quantity

        // check if tables have data
        if (!empty($announcementTitle) && !empty($productNames) && !empty($quantities)) {
            // check if are equal
            if (count($productNames) === count($quantities)) {

                $conn->begin_transaction();

                try {
                    for ($i = 0; $i < count($productNames); $i++) {
                        $productName = trim($productNames[$i]);
                        $quantity = $quantities[$i];

                        if (empty($productName) || empty($quantity)) {
                            throw new Exception("Παρακαλώ συμπληρώστε όλα τα πεδία για κάθε προϊόν.");
                        }

                        // select item_id based on productName
                        $sqlItem = "SELECT item_id FROM item WHERE item_name = ?";
                        $stmtItem = $conn->prepare($sqlItem);
                        $stmtItem->bind_param("s", $productName);
                        $stmtItem->execute();
                        $resultItem = $stmtItem->get_result();

                        // if item exists
                        if ($resultItem->num_rows > 0) {
                            $row = $resultItem->fetch_assoc();
                            $itemId = $row['item_id'];

                            // insert on announcement
                            $sqlInsertAnnouncement = "INSERT INTO announcement (announcement_title, announcement_date, item_id, announcement_item_quantity) 
                                                      VALUES (?, NOW(), ?, ?)";
                            $stmtAnnouncement = $conn->prepare($sqlInsertAnnouncement);
                            $stmtAnnouncement->bind_param("sis", $announcementTitle, $itemId, $quantity);

                            if (!$stmtAnnouncement->execute()) {
                                throw new Exception("Σφάλμα κατά την καταχώρηση ανακοίνωσης: " . $stmtAnnouncement->error);
                            }

                            $stmtAnnouncement->close();
                        } else {
                            throw new Exception("Το προϊόν '" . htmlspecialchars($productName) . "' δεν βρέθηκε.");
                        }

                        $stmtItem->close();
                    }

                    $conn->commit();

                    header("Location: announcements.php");
                    exit();  
                } catch (Exception $e) {
                    $conn->rollback();
                    echo "Σφάλμα: " . $e->getMessage();
                }
            } else {
                echo "The number of products does not match the number of quantities.";
            }
        } else {
            echo "Please fill in the title, product and quantity fields";
        }
    }
}

$conn->close();
