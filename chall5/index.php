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
            @import url(https://fonts.googleapis.com/css?family=Roboto:300);
            .login-page {
            width: 400px;
            padding: 15% 0 0;
            margin: auto;
            }
            .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
            }
            .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: rgb(52, 221, 221);
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
            }
            body {
            background: linear-gradient(90deg,  rgba(66, 183, 245,0.8) 0%,rgba(66, 245, 189,0.4) 100%);
            font-family: "Roboto", sans-serif; 
            }
        </style>
</head>
<body>
    <?php
        global $conn;
        $conn = mysqli_connect('localhost', 'root', 'vertrigo', 'qlsv') or die ('Can\'t not connect to database');
        if($_POST) {
            $username=$_POST['username'];
            $password=$_POST['password'];
            $username = mysqli_real_escape_string($conn,$username);
            $password = mysqli_real_escape_string($conn,$password);
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

    
        <div class="login-page">
            <div class="form">
                <form method="POST" action="index.php">
                    <label for="username">Username:</label><br>
                    <input type="text" id ="username" name="username"></input></br>
                    <label for="password">Password:</label><br>
                    <input type="password" id ="password" name="password"></input></br></br>
                    <button type="submit">Login</button>
                </form>
                <!-- </form>
                <form class="login-form">
                <input type="text" placeholder="username"/>
                <input type="password" placeholder="password"/>
                <button>login</button>
                </form> -->
            </div>
        </div>
</body>
</html>