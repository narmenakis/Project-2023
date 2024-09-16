<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user
            WHERE user_id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/signup-login.css">
</head>

<body>

    <div id="content">
       
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // AJAX request 
            fetch('getUserRole.php')
                .then(response => response.json())
                .then(data => {
                    const userRole = data.role;
                    let content = '';

                    if (userRole === 'admin') {
                        content = `
                    <h1 class="h1-new">Admin Home Page</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="../admin/storage.php">Storage</a>
                        <a href="../admin/statistics.html">Statistics</a>
                        <a href="../admin/addrescuer.html">Add Rescuer</a>
                        <a href="../admin/announcements.php">Announcements</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                `;
                    } else if (userRole === 'rescuer') {
                        content = `
                    <h1 class="h1-new">Rescuer Home Page</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="../rescuer/rescuermap.html">Rescuer Map</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                `;
                    } else if (userRole === 'citizen') {
                        content = `
                    <h1 class="h1-new">Citizen Home Page</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="../citizen/requests.php">Add requests</a>
                        <a href="../citizen/announcementsandoffers.html">Announcements and Offers</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                `;
                    } else {
                        content = `<h1>Uknown User!</h1>`;
                    }

                    document.getElementById("content").innerHTML = content;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>





    <img src="images.jpg" alt="Homepage Photo">



</body>

</html>