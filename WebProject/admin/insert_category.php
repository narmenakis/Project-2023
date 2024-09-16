<?php
// load database
$mysqli = require __DIR__ . "/database.php";

// Prepare SQL Insert query
$sql = "INSERT INTO category (category_name) VALUES (?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

// ckecking post fits database name
$categoryName = $_POST["categoryName"] ?? null;

if ($categoryName) {
    $stmt->bind_param("s", $categoryName);

    // execute
    try {
        $stmt->execute();
        header("Location: storage.php");
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            echo "This category already exists.";
        } else {
            die("Error: " . $e->getMessage());
        }
    }
} else {
    die("Category name is required.");

}