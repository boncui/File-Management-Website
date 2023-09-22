<?php 
session_start();
if(!$_SESSION['user']) {
    header("Location: ./login.html"); // Redirect to login page if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h1>Are you sure?</h1>
    <form method="post"> 
        <input type="submit" name="delete" value="Yes"> 
    </form> 
    <form method="post"> 
        <input type="submit" name="noDelete" value="No"> 
    </form> 
    <?php
      
        if(isset($_POST['delete'])) {
            $user = $_SESSION['user'];
            $dirPath = "/home/boncui/sharebox/users/$user";
            $files = scandir($dirPath);
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                unlink($filePath);
            }
            rmdir($dirPath);

            $userListPath = '/home/boncui/sharebox/users.txt';
            $userList = file($userListPath);
            $out = array();

            foreach($userList as $line) {
                if(trim($line) != $user) {
                    $out[] = $line;
                }
            }
            $fp = fopen($userListPath, "w+");
            flock($fp, LOCK_EX);
            foreach($out as $line) {
                fwrite($fp, $line);
            }
            flock($fp, LOCK_UN);
            fclose($fp);  
            $_SESSION['success'] = "Successfully deleted user!";
            unset($_SESSION['user']);
            header("Location: ./login.php"); // Redirect to login page if not logged in
            exit();

        }
        
        if(isset($_POST['noDelete'])) {
            header("Location: ./home.php"); // Redirect to login page if not logged in
            exit();
        }
    ?>
</body>
</html>