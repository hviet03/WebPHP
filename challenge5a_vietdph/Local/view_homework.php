<?php
  session_start();
  include("function.php");
  if (!isset($_SESSION['user_id']) || !isset($_POST['homework_id'])) {
    // Redirect to the login page or deny access if not authorized
    header('Location: login.php');
    exit;
  }
  session_regenerate_id(true);
  setcookie(session_name(), session_id(), [
    'httponly' => true,
    'expires' => 0,
    'path' => '/',
    'secure' => false,
    'samesite' => 'Lax'
]);  $homework_id = $_POST['homework_id'];
  connect_db();
   // get current user's username and role
  $temp = get_information($_SESSION['user_id']);
  $user_username = $temp['username'];
  $user_role = ($temp['role'] == 1)? 'Teacher':'Student';
   // get search homework information
  $row = get_homework_information($homework_id);
  $tittle = htmlspecialchars_decode($row['tittle']);
  $description = htmlspecialchars_decode($row['description']);
  $filename = $row['file_name'];
  $date = $row['date'];
  $submission = $row['current_submission'];
  $_SESSION['upload_homework_id'] = $homework_id;

  disconnect_db();
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>CodeAndPunch</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
ul {list-style: none;padding: 0;margin: 0;}
li {display: flex;align-items: center;margin-bottom: 50px;}
li span{font-weight: bold;margin-right: 10px;width: 300px;}
</style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Username: <?php echo $user_username; ?><br>Role: <?php echo $user_role; ?></b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="home.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> 
    <a href="edit.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Edit information</a>
    <a href="view.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">View user</a> 
    <a href="homework.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Homework</a> 
    <a href="game.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Game</a>
    <br><br><br><br><br><br><br><br>
    <a href="logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Sign Out</a> 

  </div>
</nav>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:20px" id="showcase">
    <h1 class="w3-jumbo"><b>View homework</b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
 
  <div>
    <h3 ><span><b>Homework details</b></span> </h3>
    <br><br>
   
        <ul>
            <li>
                <span>Tittle:</span>
                <span><?php echo htmlspecialchars($tittle); ?></span>
            </li>
            <li>
                <span>Description:</span>
                <span><?php echo htmlspecialchars($description); ?></span>
            </li>
            <li>
                <span>Due date:</span>
                <span><?php echo htmlspecialchars($date); ?></span>
            </li>
            <li>
                <span>File:</span>
                <span>
                <?php 
                $directory = 'uploads/homework';
                try{  // get a file 
                    // Scan the directory and get the list of files
                    $files = scandir($directory);
                    
                    // Iterate through the files
                    foreach ($files as $file) {
                     
                        if ($file !== '.' && $file !== '..') {
                            // Check if the entered file name matches the current file
                            if ($file === basename($filename)) {
                                // Provide a download link to the user
                                $filePath = $directory . '/' . $file;
                                echo '<a href="' . $filePath . '" download>' . $file . '</a><br>';
                            }
                        }
                    }
                }
                catch (Exception $e){
                    echo "<script>alert('No matching file found')</script>";

                }
                ?></span>
            </li>
            <?php  if ($user_role == 'Teacher'):// only teacher can see?>
                <li>
                        <span>Current number of submission:</span>
                        <span><?php echo $submission; ?></span>
                </li>
            <?php else: ?>
                <li>
                        <span>Upload solution:</span>
                        <span>
                          <br>
                          <form action="add_student_upload.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="upload_solution" required>
                            
                            <br><br><br>
                            <input type="submit" name="add_solution">
                          </form>
                        </span>
                </li>
            <?php endif; ?>
        </ul>
        

  </div>
  
<!-- End page content -->
</div>


<!-- Footer -->
<footer>
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:10px;padding-right:58px"><p class="w3-right"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="GIFT" target="_blank" class="w3-hover-opacity">Small gift for you</a></p></div>
</footer>


<script>



</script>

</body>
</html>
