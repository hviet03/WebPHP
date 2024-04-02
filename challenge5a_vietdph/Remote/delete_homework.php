<?php
    session_start();
    include("function.php");
    if (! isset($_SESSION['role']) || $_SESSION['role'] == 'Student' || ! isset($_POST['delete_id'])){
        header('Location: home.php');
        exit;
    }
    session_regenerate_id(true);
    setcookie(session_name(), session_id(), [
        'httponly' => true,
        'expires' => 0,
        'path' => '/',
        'secure' => false,
        'samesite' => 'Lax'
    ]);    connect_db();
   
    // delete file in physical folder

    $row = get_homework_information($_POST['delete_id']);
    $filename= $row['file_name'];
    $physical_deleted = false;
    if (file_exists($filename)) {
            try
            {
                if (unlink($filename) {
                    $physical_deleted = true;

                } else {
                    echo "Unable to delete the file.";
                }
            }
            catch(Exception $e){
                echo "ERROR";
            }
        
    }else {
            echo "File does not exist.";
        }
    if ($physical_deleted){
        if (delete_homework($_POST['delete_id'])){
            disconnect_db();
    
            header('Location: homework.php');
    
            
        }
        
    }
    // delete homework in database
    
    disconnect_db();

    echo "<script>alert('Delete failed!')</script>";





?>
