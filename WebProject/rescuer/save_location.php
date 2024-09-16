<?php
session_start(); 

$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; 

if (!$user_id) {
    echo "User not logged in.";
    exit;
}

// get data from AJAX request
$lat = isset($_POST['lat']) ? $_POST['lat'] : null;
$lng = isset($_POST['lng']) ? $_POST['lng'] : null;

// check if coordinates are correct
if (is_null($lat) || is_null($lng)) {
    echo "Error: Coordinates not received.";
    exit;
}

//check if user has already `user_coordinates_id`
$sql_check = "SELECT user_coordinates_id FROM user WHERE user_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param('i', $user_id);
$stmt_check->execute();
$stmt_check->bind_result($user_coordinates_id);
$stmt_check->fetch();
$stmt_check->close();

if (!is_null($user_coordinates_id)) {
    //user has `user_coordinates_id`, update `coordinates`
    $sql_update = "UPDATE coordinates SET latitude = ?, longitude = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ddi', $lat, $lng, $user_coordinates_id);

    if ($stmt_update->execute()) {
        echo "Location updated successfully.";
    } else {
        echo "Error updating the location: " . $stmt_update->error;
    }

    $stmt_update->close();
} else {
    // if NO`user_coordinates_id`, INSERT `coordinates`
    $sql_insert = "INSERT INTO coordinates (latitude, longitude) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param('dd', $lat, $lng);

    if ($stmt_insert->execute()) {
        // get the last ID added (coordinates_id)
        $coordinates_id = $stmt_insert->insert_id;

        // UPDATE user_coordinates_id  on user table
        $sql_update_user = "UPDATE user SET user_coordinates_id = ? WHERE user_id = ?";
        $stmt_update_user = $conn->prepare($sql_update_user);
        $stmt_update_user->bind_param('ii', $coordinates_id, $user_id);

        if ($stmt_update_user->execute()) {
            echo "Location saved and linked to the user.";
        } else {
            echo "Error updating user: " . $stmt_update_user->error;
        }

        $stmt_update_user->close();
    } else {
        echo "Error saving coordinates: " . $stmt_insert->error;
    }

    $stmt_insert->close();
}

$conn->close();
