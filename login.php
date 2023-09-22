<?php
session_start();
if($_SESSION['user']) {
    header("Location: ./home.php"); // Redirect to home page if user is valid
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="This is the login page of the web server.">
        <meta name="name" content="Boncui">
        <link rel="stylesheet" href="login_layout.css" type="text/css">
        <title>Webserver Login Page Login</title>
    </head>
    <body>
        <?php
            if(isset($_SESSION["error"])) {
                echo "<p style='color:red;'>" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            } else if ($_SESSION["success"]) {
                echo "<p style='color:green;'>" . $_SESSION["success"] . "</p>";
                unset($_SESSION["success"]);
            }
        ?>
        <form method="post">    
            <div class="inputform">
                <label for="user">Username</label>
                <input type="text" id="user" name="user">
                <input type="submit" name="login" value="Login" />
            </div>
        </form> 
        <br>
        <div class="submit">
            <button onClick="window.location.href='createUser.html'">Create New User</button>
        </div>
        <?php
        if(isset($_POST['login'])){
        $user = $_POST['user'];
        $filePath = '/home/boncui/sharebox/users.txt';

        if (file_exists($filePath)) {
            $lines = file($filePath); // Read file into an array
            
            $validUser = false;
            foreach ($lines as $line) {
                echo $line;
                if (trim($user) === trim($line)) { // Use strict comparison (===) for exact match
                    $validUser = true;
                    $_SESSION['curUser'] = trim($user);
                    break;
                }
            }

            if ($validUser) {
                $_SESSION['user'] = trim($user);
                header("Location: ./home.php"); // Redirect to home page if user is valid
                exit();
            } else {
                $_SESSION['error'] = "User doesn't exist yet. Try creating one.";
                header("Location: ./login.php"); // Redirect to login failed page if user is not valid
                exit();
            }
        } else {
            echo "The user database is not available.";
        }

        }
        ?>
    </body>
</html>