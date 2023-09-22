<?php
    session_start();
    if(!isset($_SESSION['user'])) {
        header("Location: ./login.html"); // Redirect to login page if not logged in
        exit();
    }
    header('Content-Type: application/download');
    $user = $_GET['user'];
    if($_SESSION['user'] != $user){
        $_SESSION['error'] = "Logged in as incorrect user";
        header("Location: home.php"); // Redirect to login page if not logged in
        exit();
    } else {
        $file = $_GET['file'];
        $dirPath = "/home/boncui/sharebox/".$user;
        $filePath = $dirPath . '/' . $file;
        if (!unlink($filePath)) {
            $_SESSION['error'] = "$file cannot be deleted due to an error";
            header("Location: home.php"); // Redirect to login page if not logged in
            exit();
        }
        else {
            $_SESSION['success'] = "$file has been deleted";
            header("Location: home.php"); // Redirect to login page if not logged in
            exit();
        }
    }
?>