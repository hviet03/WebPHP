<?php
    session_start();
    include("function.php");
    if (!isset($_SESSION['user_id']) || !isset($_POST['add_solution']) || $_SESSION['role'] == 'Teacher') {
        // Redirect to the login page or deny access if not authorized
        
        header('Location: login.php');
        exit;
    }
    // Physical upload
    $filename = uploadFile("uploads/student_uploads/","upload_solution");
    if ($filename == null){
        die ("Please upload valid file");
    }
    // add homework to db 
    connect_db();
    add_solution($_SESSION['user_id'],(int)$_SESSION['upload_homework_id'],$filename);
    $count=count_submission($_SESSION['upload_homework_id']);
    update_submission($_SESSION['upload_homework_id'],$count);
    disconnect_db();
    header('location:homework.php');


?>