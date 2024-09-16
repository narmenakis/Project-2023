<?php
// connect with database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "webfinal";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection successful!";
}

// close connection
$conn->close();
