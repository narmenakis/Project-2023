<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citizen Requests</title>
    <link rel="stylesheet" type="text/css" href="css/citizen1.css">
</head>

<body>
    <div class="topnav">
        <a href="homepagecitizen.html">Home</a>
        <a href="requests.php">Add requests</a>
        <a href="announcementsandoffers.html">Announcements and Offers</a>
        <a href="../signup-login/logout.php">Log Out</a>

    </div>

<div class="container">
    <h1 class="h1-new">Citizen Requests</h1>

    <!-- Request Form Section -->
    <div>
        <form id="updateForm" action="requeststable.php" method="POST" onsubmit="showConfirmation()">
            <!-- Hidden Inputs -->
            <input type="hidden" id="currentAmount" name="currentAmount" value="<?php echo $currentAmount; ?>">
            <input type="hidden" id="newAmount" name="newAmount" value="">
            <h2>Add a new Request</h2>

            <!-- Product Name Section (autocomplete) -->
            <div>
                <label for="productName">I need:</label>
                <input type="text" id="productName" name="productName" list="productList"
                    placeholder="Start typing a product" required>
                <datalist id="productList">
                    <?php include('../admin/fetch_items.php'); ?>
                </datalist>
            </div>

            <!-- People Section -->
            <div>
                <label for="quantity">People need help:</label>
                <input type="number" id="quantity" name="quantity" placeholder="No. of people" required min="1">
            </div>

            <!-- Submit Button -->
            <button type="submit" style="margin-top: 20px;">SUBMIT</button>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <h1 class="h1-new">Requests History</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Status</th>
                <th>Starting Date</th>
                <th>Transaction Date</th>
                <th>Completion Date</th>
                <th>Item Name</th>
                <th>No. of Citizens Involved</th>
            </tr>
        </thead>
        <tbody id="transactionTableBody">
        </tbody>
    </table>

    <script>
        // show confirmation message
        function showConfirmation() {
            alert('Request registered successfully!');
        }

        // load requests
        fetch('request_transactions.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                const tableBody = document.getElementById('transactionTableBody');

                data.forEach(transaction => {
                    const row = document.createElement('tr');

                    row.innerHTML = `
                        <td>${transaction.transaction_id}</td>
                        <td>${transaction.status}</td>
                         <td>${transaction.starting_date}</td>
                             <td>${transaction.transaction_date}</td>
                        <td>${transaction.completion_date}</td>
                        <td>${transaction.item_name}</td>
                        <td>${transaction.number_of_citizens_involved}</td>
                    `;

                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error loading transactions:', error);
            });
    </script>

</body>

</html>