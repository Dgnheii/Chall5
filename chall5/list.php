<?php
require './libs/students.php';
$username = isset($_GET['username']) ? $_GET['username'] : '';
$students = get_all_students();
session_start();
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
        <h1>Danh sách sinh viên</h1>
        <a href="home.php">Home</a> <br/> <br/>
        <?php if($_SESSION['role'] == 1){ ?>
            <a href="student-add.php">Thêm sinh viên</a> <br/> <br/>
            <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
            <tr>
                <td>Username</td>
                <td>Password</td>
                <td>Name</td>
                <td>Email</td>
                <td>Phone</td>
                <td>Options</td>
            </tr>
            <?php foreach ($students as $item){ ?>
            <tr>
                <td><?php echo $item['username']; ?></td>
                <td><?php echo $item['password']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['phone']; ?></td>
                <td>
                    <form method="post" action="student-delete.php">
                        <input onclick="window.location = 'student-edit.php?username=<?php echo $item['username']; ?>'" type="button" value="Sửa"/>
                        <input type="hidden" name="username" value="<?php echo $item['username']; ?>"/>                   
                        <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                    </form>                        
                </td>
            </tr>
            <?php } ?>
            </table>
        <?php } else {?>
            <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
            <tr>
                <td>Username</td>
                <td>Option</td>
            </tr>
            <?php foreach ($students as $item){ ?>
            <tr>
                <td><?php echo $item['username']; ?></td>
                <td>
                <input onclick="window.location = 'student-info.php?username=<?php echo $item['username']; ?>'" type="button" value="View"/>
                </td>
            </tr>
            
            <?php } ?>
            </table>
        <?php } ?> 
        
    </body>
</html>