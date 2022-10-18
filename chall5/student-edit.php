<?php
 
require './libs/students.php';
session_start();
$username = isset($_GET['username']) ? $_GET['username'] : '';
if ($username){
    if($_SESSION['role'] == 1){
        $data = get_teacher($username);
    } else {
        $data = get_student($username);
    }
    
    $currentName = $username;
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
     
    // Validate thong tin
    $errors = array();
    if (empty($data['username'])){
        $errors['username'] = 'Chưa nhập tên đăng nhập sinh viên';
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
     
    // Neu ko co loi thi insert
    if (!$errors){
        edit_student($currentName, $data['username'], $data['password'], $data['name'], $data['email'], $data['phone'], $_SESSION['role']);
        $_SESSION['username'] = $data['username'];
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
                background: #bff;
            }
            
            input {
                background: #bff;
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
            background: #bff;
            }
            input {
                background: #b8e1ff;
            }
        </style>
    </head>
    <body>
        <h1>Sửa thông tin</h1>
        <a href="home.php">Home</a> <br/> <br/>
        <form method="post" action="student-edit.php?username=<?php echo $data['username']; ?>">
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
                        
                        <input onclick="return confirm('Sửa thành công');" type="submit" name="edit_student" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>