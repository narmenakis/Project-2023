<?php
//connect to database
$conn = include('database.php');

if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

//  POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productCategory']) && isset($_POST['productName'])) {
        $productName = trim($_POST['productName']);
        $categoryName = $_POST['productCategory'];

        if (empty($productName)) {
            echo "Please add a product.";
        } else {
            //category_id 
            $sqlCategory = "SELECT category_id FROM category WHERE category_name = ?";
            $stmtCategory = $conn->prepare($sqlCategory);
            $stmtCategory->bind_param("s", $categoryName);
            $stmtCategory->execute();
            $resultCategory = $stmtCategory->get_result();

            if ($resultCategory->num_rows > 0) {
                $row = $resultCategory->fetch_assoc();
                $categoryId = $row['category_id'];

                $sqlCheck = "SELECT * FROM item WHERE item_name = ?";
                $stmtCheck = $conn->prepare($sqlCheck);
                $stmtCheck->bind_param("s", $productName);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    echo "This product already exists.";
                } else {
                    // add item_name
                    $sqlInsertItem = "INSERT INTO item (item_name, category_id) VALUES (?, ?)";
                    $stmtItem = $conn->prepare($sqlInsertItem);
                    $stmtItem->bind_param("ss", $productName, $categoryId);

                    if ($stmtItem->execute()) {
                        header("Location: storage.php");
                    }
                    $stmtItem->close();
                }

                $stmtCheck->close();
            } else {
                echo "Η κατηγορία που επιλέξατε δεν βρέθηκε.";
            }

            $stmtCategory->close();
        }
    }
}

$conn->close();