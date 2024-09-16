<?php

if (empty($_POST["username"])) {
    die("Name is required");
}

if (!isset($_POST['shareLocation'])) {
    die("You must allow your location to proceed.");
}

if (empty($_POST["password"])) {
    die("Password is required");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

if (empty($_POST["firstname"])) {
    die("First Name is required");
}

if (empty($_POST["surname"])) {
    die("Last Name is required");
}

if (empty($_POST["phonenumber"])) {
    die("Phone Number is required");
}

if (empty($_POST["phonenumber"]) || strlen($_POST["phonenumber"]) !== 10 || !ctype_digit($_POST["phonenumber"])) {
    die("Phone number is incorrect");
}

$mysqli = require __DIR__ . "/database.php";

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// initiate values for SQL queries (only citizen for signup)
$role = 'citizen'; 
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$coordinates_id = NULL;

if ($role === 'citizen' && !empty($latitude) && !empty($longitude)) {
    // insert coordinates
    $sql_coordinates = "INSERT INTO coordinates (latitude, longitude) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql_coordinates);
    $stmt->bind_param("dd", $latitude, $longitude);
    $stmt->execute();
    $coordinates_id = $mysqli->insert_id;
}

// insert map
$sql_user = "INSERT INTO user (username, password, authentication_token, user_coordinates_id, citizen_name, citizen_surname, citizen_phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql_user);
$stmt->bind_param("sssisss", $_POST["username"], $password_hash, $role, $coordinates_id, $_POST["firstname"], $_POST["surname"], $_POST["phonenumber"]);

// execute and find mistakes
if ($stmt->execute()) {
    header("Location: signup-success.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("Username already exists");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
