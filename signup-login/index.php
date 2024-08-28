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
        <h1>Community Assist Hub</h1>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HomePage</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>

<?php if (isset($user))?>
      <p>Hello <?= htmlspecialchars( $user["citizen_name"]) ?></p>

  
<div id="content">
    <!-- Το περιεχόμενο θα εμφανιστεί εδώ βάσει του ρόλου του χρήστη -->
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Κάνετε ένα AJAX request για να πάρετε τον ρόλο του χρήστη
    fetch('getUserRole.php')
        .then(response => response.json())
        .then(data => {
            const userRole = data.role;
            let content = '';

            if (userRole === 'admin') {
                content = `
                    <h1 class="title">Admin HomePage</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="storage.html">Storage</a>
                        <a href="statistics.html">Statistics</a>
                        <a href="adminmap.html">Add Rescuers</a>
                        <a href="announcements.html">Announcements</a>
                        <a href="signin.html">Sign In</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                `;
            } else if (userRole === 'rescuer') {
                content = `
                    <h1 class="title">Rescuer HomePage</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="rescuer-map.html">Rescue Map</a>
                        <a href="incident-report.html">Report Incident</a>
                        <a href="announcements.html">Announcements</a>
                        <a href="logout.php">Log Out</a>
                    </div>
                `;
            } else if (userRole === 'citizen') {
                content = `
                    <h1 class="title">Citizen HomePage</h1>
                    <div class="topnav">
                        <a class="active" href="#home">Home</a>
                        <a href="view-rescuers.html">View Rescuers</a>
                        <a href="report-issue.html">Report Issue</a>
                        <a href="announcements.html">Announcements</a>
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
