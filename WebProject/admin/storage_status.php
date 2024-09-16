<?php
$conn = include('database.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categories = $_POST['category'];

if (empty($categories)) {
    echo json_encode([]);
    exit;
}

// SQL Query (products with amount > 0)
$sql = "SELECT item.item_id, item.item_name, item.amount, category.category_name, COALESCE(vehicleitems.quantity, 0) AS quantity 
        FROM item
        INNER JOIN category ON item.category_id = category.category_id
        LEFT JOIN vehicleitems ON item.item_id = vehicleitems.item_id

        WHERE item.amount > 0";

// if selection except from "all"
if (!empty($categories) && !in_array('all', $categories)) {
    // Δημιουργούμε το string για το IN clause
    $in_clause = implode(',', array_map(function ($cat) use ($conn) {
        return "'" . $conn->real_escape_string($cat) . "'";
    }, $categories));

    //add IN to SQL query to know all products
    $sql .= " AND category.category_name IN ($in_clause)";
}

$result = $conn->query($sql);

$items = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // add item
        $items[] = [
            'item_id' => $row['item_id'],
            'item_name' => $row['item_name'],
            'category_name' => $row['category_name'],
            'amount' => $row['amount'],
            'quantity' => $row['quantity']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($items);

$conn->close();
