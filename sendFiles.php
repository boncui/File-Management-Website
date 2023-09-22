<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ./login.html");
    exit();
}

$curUser = $_SESSION['user'];
$dirPath = "/home/boncui/sharebox/$curUser";
$userFilePath = '/home/boncui/sharebox/users.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetUser = trim($_POST['targetUser']);
    $fileToSend = trim($_POST['fileToSend']);

    $targetDirPath = "/home/boncui/sharebox/$targetUser";
    $sourceFilePath = "$dirPath/$fileToSend";
    
    if (!file_exists($userFilePath)) {
        $_SESSION['error'] = "User database not found.";
        header("Location: home.php");
        exit();
    }

    $users = file($userFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array($targetUser, $users) || !file_exists($sourceFilePath)) {
        $_SESSION['error'] = "Invalid user or file selected.";
        header("Location: home.php");
        exit();
    }

    if (!file_exists($targetDirPath)) {
        mkdir($targetDirPath, 0777, true);
    }

    if (copy($sourceFilePath, "$targetDirPath/$fileToSend")) {
        $_SESSION['success'] = "File sent successfully!";
    } else {
        $_SESSION['error'] = "Failed to send file.";
    }

    header("Location: home.php");
    exit();
}

if (!file_exists($dirPath) || !is_dir($dirPath)) {
    $_SESSION['error'] = "Failed to retrieve files.";
    header("Location: home.php");
    exit();
}

$files = array_diff(scandir($dirPath), array('.', '..'));
?>
