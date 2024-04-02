<?php
    session_start();
    require('function.php');
    if (isset($_POST['login']) ){
        $username = $_POST['username'];
        $pass = $_POST['password'];
        if ( check_parameter($username,$pass)){
            die("Please fill in all the fields !");
        }
        if (no_symbol_validation($username) ){
            die("Username must contain only letters,numbers and underscore !");
        }
        connect_db();
        if (check_login($username,$pass)){
            header('location:home.php');
        }
        disconnect_db();
    }  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <title>Login</title>

</head>
<style>
        body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}

    body{
    
    justify-content: center;
    align-items: center;
    height: 100vh;
    }

    h2{
    text-align: center;
    } body{
        
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    h2{
    text-align: center;
    }
    form {
        background-color: #ffffff;
        width: 300px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type = "text"],
    input[type = "password"] {
        width: 90%;
        padding: 5px;
        margin-bottom:10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type = "submit"] {
        background-color: green;
        color: #ffffff;
        padding: 5px 10px;
        border: black;
        border-radius: 4px;
        cursor: pointer;
    }
    input[type = "button"].signup:hover
    {
        padding: 5px;
        background-color: #00b3b8;
    }
</style>
<body class="w3-red">
    <h2>Log in</h2>
    <div style="color:black;align-items:center;">
    <form action="login.php"  method="post">
            Username:
            <br>
            <input type="text" name = "username">
            <br>
            Password:
            <br> 
            <input type="password" name = "password">
            <br>
            <br>
            <input type="submit"  name ="login" value="Login">
            <br><br>
            <a href="signup.php">Click here to sign up</a>
    </form>
    </div>
</body>
</html>