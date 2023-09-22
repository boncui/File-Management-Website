<?php 
session_start();
if(!$_SESSION['user']) {
    header("Location: ./login.html"); // Redirect to login page if not logged in
    exit();
}
$curUser = $_SESSION['user'];
$dirPath = "/home/boncui/sharebox/$curUser";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="This is the home page of the web server.">
        <meta name="name" content="Boncui">
        <link rel="stylesheet" href="home_layout.css" type="text/css">
        <title>Files</title>
    </head>
    <body>
        <form action="logout.php" method="post"> 
            <input type="submit" name="logout" value="Logout"> 
        </form> 
        <form action="sendFiles.php" method="POST">
            <label for="fileToSend">Select file to send:</label>
            <div id="fileToSend">
                <?php
                $files = glob("$dirPath/*");
                if ($files) {
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            $fileName = basename($file);
                            echo "<label>";
                            echo "<input type='radio' name='fileToSend' value=\"$fileName\"> $fileName";
                            echo "</label><br>";
                        }
                    }
                } else {
                    echo "<p>No files available for sending.</p>";
                }
                ?>
            </div>
            <br><br>
            <label for="targetUser">Enter the username of the recipient:</label>
            <input type="text" name="targetUser" id="targetUser" required>
            <br><br>
            <button type="submit">Send File</button>
        </form>
        
        <form action="deleteUser.php" method="post"> 
            <input type="submit" name="deleteUser" value="Delete Account"> 
        </form> 
        <form action="uploadFile.php" method="post" enctype="multipart/form-data"> 
            <input type="file" id="fileToUpload" name="fileToUpload">
            <input type="submit" name="submit" value="Upload"> 
        </form> 
        <?php 
            if(isset($_SESSION["error"])) {
                echo "<p style='color:red;'>" . $_SESSION["error"] . "</p>";
                unset($_SESSION["error"]);
            } else if ($_SESSION["success"]) {
                echo "<p style='color:green;'>" . $_SESSION["success"] . "</p>";
                unset($_SESSION["success"]);
            }
        ?>
        <h2>Uploaded Files:</h2>
        <?php 
            $curUser = $_SESSION['user'];
            $dirPath = "/home/boncui/sharebox/".$curUser;
            $files = scandir($dirPath);  
            foreach ($files as $file) {
                $filePath = $dirPath . '/' . $file;
                if (is_file($filePath)) {
                    echo $file . '
                    <div style="height: 30px; width: 100px; display: flex; flex-direction: row; justify_content: space-between; margin: 0;">
                        <form action="download.php?user='.$curUser. '&file='.$file.'" method="post" style="margin: 10px">
                            <input type="submit" name="submit" value="Download File" />
                        </form>
                        <form action="preview.php?user='.$curUser. '&file='.$file.'" method="post" target="_blank" style="margin: 10px">
                            <input type="submit" name="submit" value="Preview File" />
                        </form>
                        <form action="delete.php?user='.$curUser. '&file='.$file.'" method="post" style="margin: 10px">
                            <input style="background-color: #f44336; color: white;"type="submit" name="submit" value="Delete File" />
                        </form>
                    </div>
                    <br>';
                }
            }
        ?>
    </body>
</html>