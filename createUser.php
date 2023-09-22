<?php
session_start();
if(isset($_SESSION['user'])) {
    header("Location: ./home.php"); // Redirect to home page if user is valid
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="This is the create user of the web server.">
        <meta name="name" content="Boncui">
        <title>Web Server New User</title>
    </head>
    
    <body>
    <?php
    if (isset($_GET['user']) && !empty(trim($_GET['user']))) {
        $user = trim(filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING));
    } else {
        $_SESSION['error'] = "Invalid username.";
        header("Location: ./login.php");
        exit();
    }
    $filePath = '/home/boncui/sharebox/users.txt';

    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            if ($user === trim($line)) {
                $_SESSION['error'] = "User already exists. Try logging in.";
                header("Location: ./login.php");
                exit();
            }
        }
    
        if (!mkdir('/home/boncui/sharebox/users/'.$user, 0777, true)) {
            $_SESSION['error'] = 'Failed to create directories...';
            header("Location: ./login.php");
            exit();
        }
    
        $_SESSION['success'] = "User successfully created! Try logging in.";
        header("Location: ./login.php");
        exit();
    } else {
        echo "The user database is not available.";
    }

    ?>
    </body>
</html>

