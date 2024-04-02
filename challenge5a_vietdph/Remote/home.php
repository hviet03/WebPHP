<?php
  session_start();
  include("function.php");
  if (! isset($_SESSION['user_id'])) {
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
]);
  connect_db();
  $row = get_information($_SESSION['user_id']);
  $username = $row['username'];
  if ($row['role'] == 1){
      $role = "Teacher";
  }
  else {
      $role = "Student";
  }
  $_SESSION['role'] = $role;
  $fullname = $row['full_name'];
  $email = $row['email'];
  $phone = $row['phone_num'];

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
    <h1 class="w3-jumbo"><b>Welcome aboard, </b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b><?php echo $username; ?></b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
 
  <div>
    <h3><b>Your information:</b></h3>
    <br><br>
    <ul >
        <li>
            <span>Username:</span>
            <span><?php echo $username;?></span>
        </li>
        <li>
            <span>Password:</span>
            <span><?php echo htmlspecialchars($_SESSION['password']);?></span>
        </li>
        <li>
            <span>Full name:</span>
            <span><?php echo htmlspecialchars($fullname);?></span>
        </li>
        <li>
            <span>Role:</span>
            <span><?php echo htmlspecialchars($role);?>
        </li>
        <li>
            <span>Email:</span>
            <span><?php echo htmlspecialchars($email);?></span>
        </li>
        <li>
            <span>Phone Number:</span>
            <span><?php echo $phone;?></span>
        </li>
    </ul>
    <a href="edit.php" class="round-button">Edit</a>

  </div>
  
<!-- End page content -->
</div>


<!-- Footer -->
<footer>
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:10px;padding-right:58px"><p class="w3-right"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="GIFT" target="_blank" class="w3-hover-opacity">Small gift for you</a></p></div>
</footer>




</body>
</html>
