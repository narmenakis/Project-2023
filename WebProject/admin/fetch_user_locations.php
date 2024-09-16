<?php

$conn = include('database.php'); 

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Prepare SQL to fetch user locations (rescuer and citizens with their transactions)
$sql = "
    SELECT u.user_id, u.citizen_name, u.citizen_surname, u.citizen_phone, u.authentication_token,
           c.latitude, c.longitude,
           t.transaction_id, t.transaction_date, t.item_id, t.requested_item_amount, t.type, t.status,
           i.item_name
    FROM user u
    LEFT JOIN transaction t ON u.user_id = t.user_id
    LEFT JOIN coordinates c ON u.user_coordinates_id = c.id
    LEFT JOIN item i ON t.item_id = i.item_id
    WHERE u.authentication_token IN ('citizen', 'rescuer')"; // Include both citizens and rescuers

$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    // Fetch data
    while ($row = $result->fetch_assoc()) {
        $userId = $row['user_id'];

        // If the user is not already in the list, add them
        if (!isset($users[$userId])) {
            $users[$userId] = [
                'user_id' => $row['user_id'],
                'username' => $row['citizen_name'] . ' ' . $row['citizen_surname'], // Combine name
                'phone' => $row['citizen_phone'],
                'authentication_token' => $row['authentication_token'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                'transactions' => null // Initialize transactions
            ];
        }

        // If the user has a transaction, add it to their data
        if ($row['transaction_id']) {
            $users[$userId]['transactions'] = [
                'transaction_id' => $row['transaction_id'],
                'transaction_date' => $row['transaction_date'],
                'item_id' => $row['item_id'],
                'requested_item_amount' => $row['requested_item_amount'],
                'type' => $row['type'],
                'status' => $row['status'],
                'item_name' => $row['item_name']
            ];
        }
    }
}

echo json_encode([
    'success' => true,
    'users' => array_values($users) 
]);

$conn->close();