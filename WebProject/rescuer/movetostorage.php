<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id']; 

$conn = include('database.php');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

//get all items that connect to με το συγκεκριμένο vehicle_id (user_id)
$selectItemsQuery = "SELECT item_id, quantity FROM vehicleitems WHERE vehicle_id = ?";
$stmtSelect = $conn->prepare($selectItemsQuery);
$stmtSelect->bind_param("i", $user_id);
$stmtSelect->execute();
$result = $stmtSelect->get_result();

//update storageς and delete from vehicleitems
while ($row = $result->fetch_assoc()) {
    $item_id = $row['item_id'];
    $quantity = $row['quantity'];

    // check if item_id already exists on item
    $checkItemQuery = "SELECT amount FROM item WHERE item_id = ?";
    $stmtCheckItem = $conn->prepare($checkItemQuery);
    $stmtCheckItem->bind_param("i", $item_id);
    $stmtCheckItem->execute();
    $stmtCheckItem->store_result();

    if ($stmtCheckItem->num_rows > 0) {
        // if yes, take existing amount (amount)
        $stmtCheckItem->bind_result($existingAmount);
        $stmtCheckItem->fetch();

        // calculate new amount as sum quantity of vehicleitems and amount of item
        $newAmount = $existingAmount + $quantity;

        // UPDATE item
        $updateItemQuery = "UPDATE item SET amount = ? WHERE item_id = ?";
        $stmtUpdateItem = $conn->prepare($updateItemQuery);
        $stmtUpdateItem->bind_param("ii", $newAmount, $item_id);

        if (!$stmtUpdateItem->execute()) {
            echo json_encode(['success' => false, 'error' => 'Failed to update item for item_id: ' . $item_id]);
            exit;
        }
    } else {
        // if no, add to item
        $insertItemQuery = "INSERT INTO item (item_id, amount) VALUES (?, ?)";
        $stmtInsertItem = $conn->prepare($insertItemQuery);
        $stmtInsertItem->bind_param("ii", $item_id, $quantity);

        if (!$stmtInsertItem->execute()) {
            echo json_encode(['success' => false, 'error' => 'Failed to insert item into item table: ' . $item_id]);
            exit;
        }
    }

    //delete item from vehicleitems
    $deleteVehicleItemQuery = "DELETE FROM vehicleitems WHERE vehicle_id = ? AND item_id = ?";
    $stmtDeleteVehicleItem = $conn->prepare($deleteVehicleItemQuery);
    $stmtDeleteVehicleItem->bind_param("ii", $user_id, $item_id);

    if (!$stmtDeleteVehicleItem->execute()) {
        echo json_encode(['success' => false, 'error' => 'Failed to delete vehicle item: ' . $item_id]);
        exit;
    }
}

echo json_encode(['success' => true]);
$conn->close();