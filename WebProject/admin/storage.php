<!DOCTYPE html>
<html lang="el">

<meta charset="UTF-8">
<title>Admin Storage Page</title>

<link rel="stylesheet" href="css/admin_new.css">

<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }
</style>
</head>

<body>

    <div class="topnav">
        <a href="homepageadmin.html">Home</a>
        <a href="storage.php">Storage</a>
        <a href="statistics.html">Statistics</a>
        <a href="addrescuer.html">Add Rescuer</a>
        <a href="announcements.php">Announcements</a>
        <a href=" ../signup-login/logout.php">Log Out</a>
    </div>

    <h1 class="h1-new">Admin Storage Page</h1>
    </head>

    <body>
    <div class="forms-container">
        <!-- URL JSON  form -->
        <form action="json_url.php" method="POST" novalidate>
            <h2>Load JSON data from URL</h2>
            <label for="jsonUrl">Insert URL:</label>
            <input type="url" id="jsonUrl" name="jsonUrl" required>
            <button type="submit">IMPORT JSON</button>
        </form>

        <!-- JSON  form -->
        <form action="json_parsing.php" method="POST" enctype="multipart/form-data" novalidate>
            <h2>Upload JSON file to database</h2>
            <input type="file" accept="application/JSON" name="jsoninput" id="jsoninput">
            <button type="submit">IMPORT JSON DATABASE FILE</button>
        </form>

        <!-- 1st form -->
        <form action="insert_category.php" method="POST" novalidate>
            <h2>Manage Categories</h2>
            <label for="categoryName">Add Category:</label>
            <input type="text" id="categoryName" name="categoryName" placeholder="Category" required>
            <button type="submit">ADD</button>
        </form>

        <!-- 2nd form -->
        <form action="insert_product.php" method="POST" novalidate>
            <h2>Manage Products</h2>
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" placeholder="Product Name" required>

            <label for="productCategory">Category:</label>
            <select id="productCategory" name="productCategory" required>
                <?php include('fetch_categories.php'); ?>

            </select>

            <button type="submit">ADD</button>
        </form>

        <!-- 3rd form  -->
        <form id="updateForm" action="update_product.php" method="POST" onsubmit="updateAmount()">
            <input type="hidden" id="currentAmount" name="currentAmount" value="<?php echo $currentAmount; ?>">
            <input type="hidden" id="newAmount" name="newAmount" value="">
            <h2>Edit Number of Products</h2>
            <label for="productName">Product Name:</label>
            <select id="productName" name="productName" required>
                <?php include('fetch_items.php'); ?>

                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" placeholder="Quantity" required>


                <button type="submit">SUBMIT</button>
        </form>


        <!-- <h1 class="h1-new">Select Category to View Items</h1> -->

        <!-- Φόρμα για το φιλτράρισμα ανά κατηγορία -->
        <form id="searchForm">
            <label for="category"><h2>Select Category to view items:</h2></label>
            <select id="category" name="category[]" multiple required>
                <option value="all">All Categories</option>
                <!-- Δυναμική εισαγωγή κατηγοριών μέσω PHP -->
                <?php include('fetch_categories.php'); ?>
            </select>
            <button type="submit">Filter</button>
        </form>
        </div>

        <br>

        <!-- Πίνακας για την εμφάνιση των αποτελεσμάτων -->
        <table id="resultsTable">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Quantity (Storage)</th>
                    <th>Quantity (Vehicle)</th>
                </tr>
            </thead>
            <tbody id="resultsBody">
                <!-- Τα αποτελέσματα θα προστεθούν εδώ δυναμικά -->
            </tbody>
        </table>

        <script>
            document.getElementById('searchForm').addEventListener('submit', function (e) {
                e.preventDefault();  // Αποφυγή ανανέωσης της σελίδας

                // Λήψη των επιλεγμένων κατηγοριών (πολλαπλές επιλογές)
                const selectedCategories = Array.from(document.getElementById('category').selectedOptions)
                    .map(option => option.value);

                // Δημιουργία του URLSearchParams με πολλαπλές κατηγορίες
                const params = new URLSearchParams();
                selectedCategories.forEach(category => {
                    params.append('category[]', category);
                });

                // Αίτημα AJAX προς το storage_status.php
                fetch('storage_status.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: params.toString()  // Χρησιμοποιούμε την αλυσίδα παραμέτρων
                })
                    .then(response => response.json())  // Μετατροπή των αποτελεσμάτων σε JSON
                    .then(data => {
                        const resultsBody = document.getElementById('resultsBody');
                        resultsBody.innerHTML = '';  // Καθαρισμός του πίνακα πριν την προσθήκη νέων αποτελεσμάτων

                        // Εμφάνιση των αποτελεσμάτων στον πίνακα
                        if (data.length === 0) {
                            resultsBody.innerHTML = '<tr><td colspan="4">No results found</td></tr>';
                        } else {
                            data.forEach(item => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                    <td>${item.item_name}</td>
                    <td>${item.category_name}</td>
                    <td>${item.amount}</td>
                    <td>${item.quantity}</td>
                `;
                                resultsBody.appendChild(row);

                                // Αυτόματη προσθήκη του item_id στον πίνακα storage
                                addToStorage(item.item_id);
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });


            // Συνάρτηση για την αυτόματη προσθήκη του προϊόντος στον πίνακα storage μέσω item_id
            function addToStorage(itemId) {
                fetch('add_to_storage.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'item_id': itemId  // Στέλνουμε το item_id για να προστεθεί στον πίνακα storage
                    })
                })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);  // Εμφάνιση μηνύματος επιτυχίας ή σφάλματος στο console
                    })
                    .catch(error => console.error('Error:', error));
            }

        </script>

    </body>

</html>