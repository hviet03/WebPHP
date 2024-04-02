<?php
    session_start();
    include("function.php");
    if (! isset($_SESSION['role']) || $_SESSION['role'] == 'Student' || ! isset($_POST['delete_id'])){
        header('Location: home.php');
        exit;
    }
    connect_db();
    if (delete_record($_POST['delete_id'])){
        disconnect_db();

        header('Location: view.php');

        
    }
    disconnect_db();

    echo "<script>alert('Delete failed!')</script>";





?>