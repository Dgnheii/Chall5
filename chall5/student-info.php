<?php
require './libs/students.php';
session_start();
$username = isset($_GET['username']) ? $_GET['username'] : '';
$_SESSION['user_nhan'] = $username;
$student = get_student($username, $_SESSION['role']);
disconnect_db();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Danh sách sinh viên</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            table {
            margin: 8px;
            }

            body {
                background: linear-gradient(90deg,  rgba(66, 183, 245,0.8) 0%,rgba(66, 245, 189,0.4) 100%);;
            }

            th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: .8em;
            background: #b8e1ff;
            color: #fff;
            padding: 2px 6px;
            border-collapse: separate;
            border: 1px solid #000;
            }
            
            td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: .9em;
            border: 1px solid #000;
            }
            
            input {
                background: #b8e1ff;
            }
        </style>
    </head>
    <body>
        <h1>User Infomation</h1>
        <a href="student-list.php">User List</a> <br/> <br/>
        <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
            <tr>
                <td>Username</td>
                <td>Password</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Options</td>
            </tr>
            <tr>
                <td><?php echo $student['username']; ?></td>
                <td><?php 
                    if($_SESSION['role'] == 1){
                        echo $student['password']; 
                    }
                    else
                    {
                        echo "";
                    }
                ?></td>
                <td><?php echo $student['name']; ?></td>
                <td><?php echo $student['email']; ?></td>
                <td><?php echo $student['phone']; ?></td>
                <?php if($_SESSION['username'] != $student['username']) { ?>
                    <td>
                        <input onclick="window.location = 'message-list.php?username=<?php echo $student['username']; ?>'" type="button" value="Message"/>
                    </td>
                <?php } else { ?>
                    <td></td>
                <?php } ?>
            </tr>
        </table>
    </body>
</html>