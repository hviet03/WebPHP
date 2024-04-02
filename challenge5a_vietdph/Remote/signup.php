<?php 
    // session_start();
    require("function.php");
    if (isset($_POST['signup'])  ){
        
        if (check_parameter($_POST['username'],$_POST['password'],$_POST['role'],$_POST['fullname'],$_POST['email'],$_POST['phone'])){
            die("Please enter all the fields !");

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
        connect_db();
        if (check_dupl_username($_POST['username'])){
            die("Duplicated username !");
        }
        echo "<script>alert('Sign up successfully!')</script>";
        
        // add the credentials to db 
        add_record($_POST['username'],$_POST['password'],$_POST['role'],$_POST['fullname'],$_POST['email'],$_POST['phone']);
        disconnect_db();
        header('location:login.php');
    }
    
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <title>Sign up</title>

</head>
<style>
    body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
    body{justify-content: center;align-items: center;height: 100vh;}
    h2{text-align: center;}
    form {background-color: white;width: 300px;margin: 0 auto;padding: 20px;border: 1px solid #ccc;border-radius: 15px;}
    
    input[type = "text"],
    input[type = "email"],
    input[type = "password"] {width: 90%;padding: 2px;margin-bottom:10px;border: 1px solid black;border-radius: 10px;}
    input[type = "submit"] {background-color: green;color: #ffffff;padding: 10px 20px;border: none;border-radius: 15px;cursor: pointer;align-items: center;}
   
</style>
<body class="w3-red">
    <h2>Sign up</h2>
    <div style="color:black">
    <form action="signup.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="role">Role:</label><br>
        <label class="role-label" for="teacher">Teacher</label>
        <input type="radio" id="teacher" name="role" value="teacher" required>
        <label class="role-label" for="student">Student</label>
        <input type="radio" id="student" name="role" value="student" required><br>


        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="fullname">Full name</label>:</label><br>
        <input type="text" id="fullname" name="fullname" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Phone number:</label><br>
        <input type="text" id="phone" name="phone" required>

        <input  type="submit" value="Sign up" name="signup"><br>
    </form>
    </div>
</body>
</html>
