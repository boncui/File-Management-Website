<?php
session_start();

// Check if the user is logged in
if(!isset($_SESSION['user'])) {
    $_SESSION['error'] = "You must be logged in to download files.";
    header("Location: ./login.html"); 
    exit();
}

// Validate input parameters
if(!isset($_GET['user']) || !isset($_GET['file'])) {
    $_SESSION['error'] = "Invalid parameters.";
    header("Location: home.php"); 
    exit();
}

$user = $_GET['user'];
$file = $_GET['file'];

// Check if the logged-in user matches the user parameter
if($_SESSION['user'] !== $user) {
    $_SESSION['error'] = "Logged in as incorrect user.";
    header("Location: home.php"); 
    exit();
}

$dirPath = "/home/boncui/sharebox/".$user;
$filePath = $dirPath . '/' . $file;

// Check if the file exists
if(!file_exists($filePath)) {
    $_SESSION['error'] = "File not found.";
    header("Location: home.php"); 
    exit();
}

// Check if the file path is within the user's directory to prevent directory traversal attacks
if (strpos(realpath($filePath), realpath($dirPath)) !== 0) {
    $_SESSION['error'] = "Access denied.";
    header("Location: home.php"); 
    exit();
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($filePath);

// Set headers to facilitate file download
header("Content-Type: " . $mime);
header('Content-Disposition: attachment; filename="' . basename($file) . '"'); 
header('Pragma: public');

// Output the file contents
readfile($filePath);
die();
?>
