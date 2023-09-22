<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = 'User not logged in.';
    header('Location: home.php');
    exit();
}

$curUser = $_SESSION['user'];
$target_dir = "/home/boncui/sharebox/".$curUser;
$maxFileSize = 500000; // Maximum file size in bytes (approx. 488 KB)

//make a directory if its not found
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Check if the file was uploaded via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    
    $target_file = $target_dir . '/' . basename($_FILES["fileToUpload"]["name"]); //ERROR IS HERE

    // Check if the file already exists
    if (file_exists($target_file)) {
        $_SESSION['error'] = 'File already exists.';
        header('Location: home.php');
        exit();
    }

    // Check if the file size exceeds the maximum limit
    if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
        $_SESSION['error'] = 'File is too large. Choose a smaller file.';
        header('Location: home.php');
        exit();
    }

    // Attempt to move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        chmod($target_file, 0777); // Set appropriate permissions for the uploaded file
        $_SESSION['success'] = "File uploaded successfully!";
        header('Location: home.php');
        exit();
    } else {
        $_SESSION['error'] = 'There was an error with the upload. Try again.';
        header('Location: home.php');
        exit();
    }

} else {
    $_SESSION['error'] = 'Invalid request method or missing file data.';
    header('Location: home.php');
    exit();
}
?>
