<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";

$sql = sprintf("SELECT * FROM user 
                WHERE username = '%s'", 
                $mysqli->real_escape_string($_POST["username"]));

                $result = $mysqli->query($sql);
                $user = $result->fetch_assoc();

                if ($user) {
        
                    if (password_verify($_POST["password"], $user["password"])) {
                        
                        session_start();

                        session_regenerate_id();

                        $_SESSION["user_id"] = $user["user_id"];
                        $_SESSION["user_role"] = $user["authentication_token"];

                        header("Location: index.php");
                        exit;
                    }
                }
     
 $is_invalid = true;

}
 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

        <h1>Login</h1>

        <?php if ($is_invalid): ?>
            <em>Invalid Login. Please try again.</em>
            <?php endif; ?>

        <form method="post">

        <div>
        <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                 value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
    
        </div>
                
             <div>
             <label for="password">Password</label>
                <input type="password" id="password" name="password">
     
             </div>   
                

            <button>Log In</button>
        </form>

    </body>
    </html>
