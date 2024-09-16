<?php
$host = 'localhost';
$dbname = 'webfinal';
$name = 'root';
$code = 'root';

// Create a new PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $name, $code);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Load JSON data from file
$jsonData = file_get_contents('storage.json');
$data = json_decode($jsonData, true);

if (!$data) {
    echo 'Error decoding JSON data';
    exit;
}

// Insert categories
$categories = $data['categories'];
$insertCategorySQL = "INSERT INTO category (category_id, category_name) VALUES (:id, :category_name)";
$checkCategorySQL = "SELECT COUNT(*) FROM category WHERE category_id = :id";
$stmt = $pdo->prepare($insertCategorySQL);
$checkStmt = $pdo->prepare($checkCategorySQL);

foreach ($categories as $category) {
    // Check if the category already exists
    $checkStmt->execute([':id' => $category['id']]);
    $categoryExists = $checkStmt->fetchColumn();

    if (!$categoryExists) {
        // Category does not exist, proceed with insert
        $stmt->execute([
            ':id' => $category['id'],
            ':category_name' => $category['category_name']
        ]);
    } else {
        echo "Category ID " . $category['id'] . " already exists. Skipping insertion.\n";
    }
}

// Insert items
$items = $data['items'];
$insertItemSQL = "INSERT INTO item (item_id, item_name, category_id) VALUES (:id, :name, :category)";
$stmt = $pdo->prepare($insertItemSQL);

foreach ($items as $item) {
    $stmt->execute([
        ':id' => $item['id'],
        ':name' => $item['name'],
        ':category' => $item['category']
    ]);

    // Insert item details
    $details = $item['details'];
    $insertDetailSQL = "INSERT INTO itemdetails (item_id, detail_name, detail_value) VALUES (:item_id, :detail_name, :detail_value)";
    $detailStmt = $pdo->prepare($insertDetailSQL);

    foreach ($details as $detail) {
        $detailStmt->execute([
            ':item_id' => $item['id'],
            ':detail_name' => $detail['detail_name'],
            ':detail_value' => $detail['detail_value']
        ]);
    }
}

echo 'Data inserted successfully!';
?>
