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
]);  connect_db();
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
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
input[type = "submit"] {background-color: green;color: #ffffff;padding: 10px 20px;border: none;border-radius: 15px;cursor: pointer;align-items: center;}

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
    <h1 class="w3-jumbo"><b>Homework </b></h1>
    <hr style="width:120px;border:5px solid red" class="w3-round">
  </div>
<br>
 
  <div>
  <h3><b>Homework Table</b></h3>
    <br>
    <?php  if ($role == 'Teacher'):// only teacher can add student ?>
        <input  type="submit" value="Add new homework" name="add" onclick="window.location.href ='add_homework.php'"><br>            
    <?php endif; ?>

    <br>
    <table>
        <tr>
            <th>Tittle</th> 
            <th>Due date</th> 
            <th>Action</th>     
        </tr>
        <?php
            connect_db();
            $result = get_all_homework();
            disconnect_db();
        ?>
            <?php while ($row = mysqli_fetch_assoc($result))://print all users and use javascript to send the clicked student to next page ?>   
            
        <tr>
            <td> <?php echo $row['tittle'] ?></td>
            <td> <?php echo $row['date'] ?></td>
            <td>
                    <form action="view_homework.php" method="POST">
                        <input type="hidden" name="homework_id" value="<?php echo $row['homework_id']; ?>">
                    <button  type="submit"> Details </button> 
                    </form>
                <?php  if ($role == 'Teacher'):// only teacher can edit student but not other teacher?>
                    <form action="edit_homework.php" method="POST">
                    <input type="hidden" name="edit_id" value="<?php echo $row['homework_id']; ?>"> 
                    <button  type="submit" onclick="window.location.href ='edit_student.php'">  Edit </button> 
                    </form>
                    
                    <form action="delete_homework.php" method="POST">
                        <input type="hidden" name="delete_id" value="<?php echo $row['homework_id']; ?>">
                    <button  type="submit">Delete</button> 
                    </form>
                <?php endif; ?>

            </td>
            
        </tr>
        <?php endwhile; ?>

        
    </table>
  </div>
  
<!-- End page content -->
</div>


<!-- Footer -->
<footer>
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:10px;padding-right:58px"><p class="w3-right"><a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" title="GIFT" target="_blank" class="w3-hover-opacity">Small gift for you</a></p></div>
</footer>



</body>
</html>
