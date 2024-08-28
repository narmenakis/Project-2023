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

$sql = "INSERT INTO user (username, password, authentication_token, creation_datetime, citizen_name, citizen_surname, citizen_phone)
        VALUES (?, ?, ?, NOW(), ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}


// $latitude = $_POST['latitude'];
// $longitude = $_POST['longitude'];

// // Συμπύκνωση σε μία μεταβλητή
// $coordinates = $latitude . ',' . $longitude;

$stmt->bind_param("sssssi", $_POST["username"], $password_hash, $_POST["authentication_token"], $_POST["firstname"], $_POST["surname"], $_POST["phonenumber"]);

   
// print_r($_POST);
// var_dump($password_hash);




//ΠΩΣ ΜΕΤΑΦΕΡΩ ΣΕ ΑΛΛΗ ΣΕΛΙΔΑ
if($stmt->execute()) {

header("Location: signup-success.html");

}  else if ($conn->errno === 1062) {
        die("Username already exists");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }

