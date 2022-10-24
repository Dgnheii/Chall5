<?php
require './libs/students.php';
$username = isset($_GET['username']) ? $_GET['username'] : '';
session_start()
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            body {
                background: #bff;
            }
            h1 {
                font-size: 35px;
            }
            a {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 15px;
                background: #b8e1ff;
                border: 2px solid #000;
                color: #000;
                padding: 3px 6px;
            }
        </style>
    </head>
    <body>
        <h1>Home</h1> <br/>
        <a href="student-list.php">User List</a> <br/> <br/> <br/>
        <a href="student-edit.php?username=<?php echo $_SESSION['username']; ?>">Sửa thông tin</a> <br/> <br/> <br/>
        <?php if($_SESSION['role'] == 0) { ?>
        <a href="message-list.php?username=<?php echo $_SESSION['username']; ?>">Tin nhắn</a> <br/> <br/> <br/>
        <?php } ?>
        <a href="homework.php">Homework</a></br> </br></br>
        <a href="index.php">Log out</a> <br/> <br/> <br/>
    </body>
</html>