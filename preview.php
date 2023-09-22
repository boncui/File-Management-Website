<?php
    session_start();
    if(!$_SESSION['user']) {
        header("Location: ./login.html"); // Redirect to login page if not logged in
        exit();
    }
    
        $user = $_GET['user'];
        if($_SESSION['user'] != $user){
            $_SESSION['error'] = "Logged in as incorrect user";
            header("Location: home.php"); // Redirect to login page if not logged in
            exit();
        } else {
            $file = $_GET['file'];
            $dirPath = "/home/boncui/sharebox/".$user;
            $filePath = $dirPath . '/' . $file;
        }
        if (!file_exists($filePath)) {
            $_SESSION['error'] = "File not found";
            header("Location: home.php"); // Redirect to home page if the file doesn't exist
            exit();
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($filePath);
        
        // Finally, set the Content-Type header to the MIME type of the file, and display the file.
        header("Content-Type: ".$mime);
        header('content-disposition: inline; filename="'.$file.'";');
        header('Pragma: public');
        readfile($filePath);
        die();
     ?>