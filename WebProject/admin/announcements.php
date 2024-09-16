<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Announcement Page</title>
  <link rel="stylesheet" href="css/admin_new.css">
</head>

<body>

  <div class="topnav">
    <a href="homepageadmin.html">Home</a>
    <a href="storage.php">Storage</a>
    <a href="statistics.html">Statistics</a>
    <a href="addrescuer.html">Add Rescuer</a>
    <a href="announcements.php">Announcements</a>
    <a href="../signup-login/logout.php">Log Out</a>
  </div>

  <h1 class="h1-new">Admin Announcement Page</h1>

  <!-- Manage  -->
  <form id="productForm" action="submit_announcements.php" method="POST" onsubmit="return confirmSubmission(event)">
    <label for="announcementtitle">Title:</label>
    <input type="text" id="announcementtitle" name="announcementtitle" placeholder="Announcement Title" required>

    <div id="productContainer">
      <div class="product-container">
        <label for="productName">Product Name:</label>
        <select id="productName" name="productName[]" required>
          <?php include('fetch_items.php'); ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity1" name="quantity[]" placeholder="Quantity" min="1" required>
      </div>
    </div>

    <div class="button-group">
      <button type="button" onclick="addProduct()">Add Products</button>
      <button type="button" onclick="removeProduct()">Remove Products</button>
      <button type="submit">PUBLISH</button>
    </div>


  </form>

  <!-- Add product method -->
  <script>
    let productCount = 1;

    function addProduct() {
      productCount++;

      const container = document.getElementById('productContainer');

      //create new div for items
      const productDiv = document.createElement('div');
      productDiv.classList.add('product-container');

      //  HTML for new item and quantity
      productDiv.innerHTML = `
        <label for="productName${productCount}">Add Product:</label>
        <select id="productName${productCount}" name="productName[]" required>
          <?php include('fetch_items.php'); ?>
        </select>

        <label for="quantity${productCount}">Quantity:</label>
        <input type="number" id="quantity${productCount}" name="quantity[]" placeholder="Quantity" min="1" />
      `;

      container.appendChild(productDiv);
    }

    function removeProduct() {
      const container = document.getElementById('productContainer');

      if (productCount > 1) {  
        container.removeChild(container.lastElementChild);  
        productCount--;  
      }
    }

    // message confirm after announcement release
    function confirmSubmission(event) {
      event.preventDefault(); 

      // send through js
      const form = document.getElementById('productForm');
      const formData = new FormData(form);

      fetch('submit_announcements.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(result => {
          alert('Announcement published successfully!');
          form.reset(); // clear form after success
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>

</body>

</html>