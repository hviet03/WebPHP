<?php
  session_start();
  include("function.php");
  if (! isset($_SESSION['user_id'])) {
    // Redirect to the login page or deny access if not authorized
    header('Location: login.php');
    exit;
  }
  if (!isset($_SESSION['role']) ||  $_SESSION['role'] == 'Student'){
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
]);  connect_db();
  $row = get_information($_SESSION['user_id']);
  $username = $row['username'];
  if ($row['role'] == 1){
      $role = "Teacher";
  }
  else {
      $role = "Student";
  }
  $fullname = $row['full_name'];
  $email = $row['email'];
  $phone = $row['phone_num'];

  if (isset($_POST['add'])  ){
    if (check_parameter($_POST['username'],$_POST['password'],$_POST['fullname'],$_POST['email'],$_POST['phone'])){
        die("Please enter all the fields !");

    }
    if (check_dupl_username($_POST['username'])){
      die("Duplicated username !");
  }
    if (no_symbol_validation($_POST['username'])){
        die("Username must contain only letters,numbers and underscore !");
    }
    if (no_symbol_validation($_POST['fullname'])){
        die("Full Name must not contain special characters !");
    }
    if (!email_validation($_POST['email'])){
        die("Invalid email !");
    }
    if (! number_validation($_POST['phone'])){
        die("Phone number must contain only number 0-9 and length must be less or equal to 10!");
    }
    echo "<script>alert('Add student successfully!')</script>";
    
    // add the credentials to db 
    add_record($_POST['username'],$_POST['password'],0,$_POST['fullname'],$_POST['email'],$_POST['phone']);
    disconnect_db();
    header('location:home.php');
}
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
.round-button {background-color: green;color: white;border: none;border-radius: 50%;padding: 10px 20px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;cursor: pointer;}

</style>
</head>
<body>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Username: <?php echo $username; ?><br>Role: <?php echo $role; ?></b></h3>
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
    <h1 class="w3-jumbo"><b>Add new student </b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
 
  <div>
    <h3><b>Student's information</b></h3>
    <br><br>
    <form action="add_student.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <p>Role: Student </p>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="fullname">Full name</label>:</label><br>
        <input type="text" id="fullname" name="fullname" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone number:</label><br>
        <input type="text" id="phone" name="phone" required>
        <br><br>
        <input  type="submit" value="Add" name="add"><br>
    </form>
   

  </div>
  
<!-- End page content -->
</div>


<!-- Footer -->
<footer>
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:10px;padding-right:58px"><p class="w3-right"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="GIFT" target="_blank" class="w3-hover-opacity">Small gift for you</a></p></div>
</footer>


<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>

</body>
</html>
