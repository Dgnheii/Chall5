<?php
 
require './libs/students.php';
session_start();
$username = isset($_GET['username']) ? $_GET['username'] : '';

if ($username){
    if($_SESSION['role'] == 1 && $username == $_SESSION['username']){
        $data = get_teacher($username);
    } elseif($_SESSION['role'] == 0 && $username == $_SESSION['username']) {
        $data = get_student($username);
    } elseif($_SESSION['role'] == 1 && $username != $_SESSION['username']) {
        $data = get_student($username);
    }
    $_SESSION['currentName'] = $data['username'];
    $_SESSION['userRole'] = $data['role'];
}
if (!$data){
   header("location: student-list.php");
}
if (!empty($_POST['edit_student']))
{
    
    $data['username'] = isset($_POST['username']) ? $_POST['username'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
    $errors = array();
    if (empty($data['username'])){
        $errors['username'] = 'Chưa nhập tên đăng nhập sinh viên';
    }
    else if(checkUsername($data['username']) == TRUE) {
        $errors['username'] = 'Tên đăng nhập đã tồn tại';
    }

    if (empty($data['password'])){
        $errors['password'] = 'Chưa nhập mật khẩu sinh viên';
    }

    if (empty($data['name'])){
        $errors['name'] = 'Chưa nhập tên sinh viên';
    }
     
    if (empty($data['email'])){
        $errors['email'] = 'Chưa nhập email sinh viên';
    }

    if (empty($data['phone'])){
        $errors['phone'] = 'Chưa nhập số điện thoại sinh viên';
    }
     
    if (!$errors){
        edit_student($_SESSION['currentName'], $data['username'], $data['password'], $data['name'], $data['email'], $data['phone']);
        if($_SESSION['username'] == $_SESSION['currentName']){
            $_SESSION['username'] = $data['username']; 
        }
        if($_SESSION['userRole'] == 1 && $_SESSION['role'] == 1){
            header("location: home.php");
        } else if ($_SESSION['userRole'] == 0 && $_SESSION['role'] == 1) {
            header("location: student-list.php");
        } else {
            header("location: student-info.php?username=".$data['username']);
        }
    }
}
 
disconnect_db();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Sửa thông tin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            table {
            margin: 8px;
            }

            body {
                background: linear-gradient(90deg,  rgba(66, 183, 245,0.8) 0%,rgba(66, 245, 189,0.4) 100%);
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
        <h1>Sửa thông tin</h1>
        <?php if($_SESSION['username'] == $_SESSION['currentName']) { ?>
            <a href="home.php">Home</a></br> </br>
        <?php } else { ?>
            <a href="student-list.php">Danh sách sinh viên</a> </br> </br>
        <?php } ?>
        <form method="post" action="student-edit.php">
        <input type="hidden" name="username" value="<?php echo $_SESSION['currentName']; ?>"/>
            <table width="50%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <?php if($_SESSION['role'] == 1) { ?>
                        <td>Username</td>
                        <td>
                            <input type="text" name="username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>"/>
                            <?php if (!empty($errors['username'])) echo $errors['username']; ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="text" name="password" value='<?php echo !empty($data['password']) ? $data['password'] : ''; ?>'/>
                        <?php if (!empty($errors['password'])) echo $errors['password']; ?>
                    </td>
                </tr>
                <tr>
                    <?php if($_SESSION['role'] == 1) { ?>
                        <td>Name</td>
                        <td>
                            <input type="text" name="name" value="<?php echo !empty($data['name']) ? $data['name'] : ''; ?>"/>
                            <?php if (!empty($errors['name'])) echo $errors['name']; ?>
                        </td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="text" name="email" value="<?php echo !empty($data['email']) ? $data['email'] : ''; ?>"/>
                        <?php if (!empty($errors['email'])) echo $errors['email']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Phone</td>
                    <td>
                        <input type="text" name="phone" value="<?php echo !empty($data['phone']) ? $data['phone'] : ''; ?>"/>
                        <?php if (!empty($errors['phone'])) echo $errors['phone']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="edit_student" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>