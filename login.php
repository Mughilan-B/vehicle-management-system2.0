<?php

session_start();

$username = "admin";
$password = "1234";

if(isset($_POST['login'])){

    $user = $_POST['username'];
    $pass = $_POST['password'];

    if($user == $username && $pass == $password){

        $_SESSION['admin'] = $user;

        header("Location: dashboard.php");

    }

    else{

        echo "<script>
        alert('Invalid Username or Password');
        </script>";

    }

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Login</title>

<style>

body{
    margin:0;
    padding:0;
    font-family:Arial;
    background:#0f172a;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-box{
    background:rgba(30,41,59,0.7);
    backdrop-filter:blur(10px);
    padding:40px;
    border-radius:10px;
    width:300px;
}

    .logo-container{
    text-align:center;
}

.logo{
    width:150px;
    display:block;
    margin:auto;
    margin-bottom:10px;
}

h1{
    color:white;
    text-align:center;
}

input{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    margin-top:20px;
    border:none;
    border-radius:5px;
    background:#38bdf8;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#0284c7;
}

</style>

</head>

<body>

<div class="login-box">

<div class="logo-container">

<img src="images/logo.png"
class="logo">

<h1>Admin Login</h1>

</div>

<form method="POST">

<input type="text"
name="username"
placeholder="Username"
required>

<input type="password"
name="password"
placeholder="Password"
required>

<button type="submit"
name="login">

Login

</button>

</form>

</div>

</body>
</html>