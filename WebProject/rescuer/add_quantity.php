<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION["user_id"])) {
    // if user doesnt connect go to login page
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = include('database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

//collect data from POST (fetch)
$item_id = isset($_POST['item_id']) ? (int) $_POST['item_id'] : null;
if (is_null($item_id)) {
    echo json_encode(['success' => false, 'error' => 'Missing item_id']);
    exit;
}
$requested_quantity = isset($_POST['requested_quantity']) ? abs((int) $_POST['requested_quantity']) : null;

if (is_null($requested_quantity)) {
    echo json_encode(['success' => false, 'error' => 'Missing requested_quantity']);
    exit;
}

$user_coordinates_lat = isset($_POST['user_coordinates_lat']) ? $_POST['user_coordinates_lat'] : null;
$user_coordinates_lng = isset($_POST['user_coordinates_lng']) ? $_POST['user_coordinates_lng'] : null;

// check if data are valid
if (is_null($item_id) || is_null($requested_quantity) || is_null($user_coordinates_lat) || is_null($user_coordinates_lng)) {
    echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
    exit;
}

$user_coordinates = "$user_coordinates_lat, $user_coordinates_lng"; 

//checking if quantity is right
$updateQuantity = ($_POST['requested_quantity'] < 0) ? -$requested_quantity : $requested_quantity;

//update item table
$updateItemQuery = "UPDATE item SET amount = amount + ? WHERE item_id = ?";
$stmt = $conn->prepare($updateItemQuery);
$stmt->bind_param("ii", $updateQuantity, $item_id);

if ($stmt->execute()) {
    // if quantity item is 0 and delete from storage
    $checkAmountQuery = "SELECT amount FROM item WHERE item_id = ?";
    $stmtCheckAmount = $conn->prepare($checkAmountQuery);
    $stmtCheckAmount->bind_param("i", $item_id);
    $stmtCheckAmount->execute();
    $stmtCheckAmount->bind_result($amount);
    $stmtCheckAmount->fetch();
    $stmtCheckAmount->close();

    if ($amount == 0) {
        // if amount = 0, delete item from storage
        $deleteStorageQuery = "DELETE FROM storage WHERE item_id = ?";
        $stmtDeleteStorage = $conn->prepare($deleteStorageQuery);
        $stmtDeleteStorage->bind_param("i", $item_id);
        if (!$stmtDeleteStorage->execute()) {
            echo json_encode(['success' => false, 'error' => 'Failed to delete from storage']);
            exit;
        }
    }

    // select user_coordinates_id from user
    $sqlGetCoordinates = "SELECT user_coordinates_id FROM user WHERE user_id = ?";
    $stmtGetCoordinates = $conn->prepare($sqlGetCoordinates);
    $stmtGetCoordinates->bind_param("i", $user_id);
    $stmtGetCoordinates->execute();
    $stmtGetCoordinates->bind_result($vehicle_coordinates_id);
    $stmtGetCoordinates->fetch();
    $stmtGetCoordinates->close();

    if (!$vehicle_coordinates_id) {
        echo json_encode(['success' => false, 'error' => 'Failed to retrieve coordinates for user']);
        exit;
    }

    // --- add to vehicle ---
    $status = "free"; //
    $number_of_tasks = 0; 

    $insertVehicleQuery = "INSERT INTO vehicle (vehicle_id, vehicle_coordinates_id, status, number_of_tasks) 
                       VALUES (?, ?, ?, ?)
                       ON DUPLICATE KEY UPDATE vehicle_coordinates_id = VALUES(vehicle_coordinates_id), 
                       status = VALUES(status), number_of_tasks = VALUES(number_of_tasks)";
    $stmtInsertVehicle = $conn->prepare($insertVehicleQuery);
    $stmtInsertVehicle->bind_param("issi", $user_id, $vehicle_coordinates_id, $status, $number_of_tasks);

    if (!$stmtInsertVehicle->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to insert or update vehicle']);
        exit;
    }

    // --- insert and update vehicleitems ---

    // checking if item_id already exists to vehicle (vehicle_id)
    $checkVehicleItemQuery = "SELECT quantity FROM vehicleitems WHERE vehicle_id = ? AND item_id = ?";
    $stmtCheckVehicleItem = $conn->prepare($checkVehicleItemQuery);
    $stmtCheckVehicleItem->bind_param("ii", $user_id, $item_id);
    $stmtCheckVehicleItem->execute();
    $stmtCheckVehicleItem->bind_result($existingQuantity);
    $stmtCheckVehicleItem->fetch();
    $stmtCheckVehicleItem->close();

    if ($existingQuantity) {
        // if item already exists, UPDATE (add wih the previous quantity)
        $newQuantity = $existingQuantity + abs($updateQuantity);
        $updateVehicleItemQuery = "UPDATE vehicleitems SET quantity = ? WHERE vehicle_id = ? AND item_id = ?";
        $stmtUpdateVehicleItem = $conn->prepare($updateVehicleItemQuery);
        $stmtUpdateVehicleItem->bind_param("iii", $newQuantity, $user_id, $item_id);

        if ($stmtUpdateVehicleItem->execute()) {
            echo json_encode(['success' => true, 'message' => 'Quantity updated successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update vehicle item']);
        }
        $stmtUpdateVehicleItem->close();
    } else {
        // if NOT, INSERT row
        $insertVehicleItemQuery = "INSERT INTO vehicleitems (vehicle_id, item_id, quantity) VALUES (?, ?, abs(?))";
        $stmtInsertVehicleItem = $conn->prepare($insertVehicleItemQuery);
        $stmtInsertVehicleItem->bind_param("iii", $user_id, $item_id, $updateQuantity);

        if ($stmtInsertVehicleItem->execute()) {
            echo json_encode(['success' => true, 'message' => 'Vehicle item inserted successfully']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to insert vehicle item']);
        }
        $stmtInsertVehicleItem->close();
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update item']);
}

$conn->close();
