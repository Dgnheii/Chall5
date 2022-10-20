<?php
require './libs/students.php';
session_start();
disconnect_db();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style type="text/css">
            body {
                background: #bff;
            }
            
            input {
                background: #b8e1ff;
            }
            button {
                background: #b8e1ff;
            }
        </style>
</head>
<body>
    <h1>Login</h1>
    <?php
        global $conn;
        $conn = mysqli_connect('localhost', 'root', 'vertrigo', 'qlsv') or die ('Can\'t not connect to database');
        if($_POST) {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $username = addslashes($username);
            $password = addslashes($password);
            $result = mysqli_query($conn, "SELECT * from sinhvien where username='$username' and password = '$password' ");
            $row = mysqli_fetch_assoc($result); 
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            if ($row) {
                header ("Location:home.php");
            }
            else {
                echo '<p style="color:red">Tên đăng nhập hoặc mật khẩu không đúng!!</p>';
            }
        }
    ?>

    <form method="POST" action="index.php">
        <label for="username">Username:</label><br>
        <input type="text" id ="username" name="username"></input></br>
        <label for="password">Password:</label><br>
        <input type="password" id ="password" name="password"></input></br></br>
        <button type="submit">Login</button>
    </form>
</body>
</html>