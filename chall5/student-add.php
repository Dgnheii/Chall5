<?php
 
require './libs/students.php';
 
if (!empty($_POST['add_student']))
{
    $data['username']        = isset($_POST['username']) ? $_POST['username'] : '';
    $data['password']        = isset($_POST['password']) ? $_POST['password'] : '';
    $data['name']        = isset($_POST['name']) ? $_POST['name'] : '';
    $data['email']         = isset($_POST['email']) ? $_POST['email'] : '';
    $data['phone']    = isset($_POST['phone']) ? $_POST['phone'] : '';
     
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
     
    // Neu ko co loi thi insert
    if (!$errors){
        add_student($data['username'],$data['password'],$data['name'], $data['email'], $data['phone']);
        // Trở về trang danh sách
        header("location: student-list.php");
    }
}
 
disconnect_db();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Thêm sinh viên</title>
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
        <h1>Thêm sinh viên </h1>
        <a href="student-list.php">Trở về</a> <br/> <br/>
        <form method="post" action="student-add.php">
            <table width="50%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td>Username</td>
                    <td>
                        <input type="text" name="username" value="<?php echo !empty($data['username']) ? $data['username'] : ''; ?>"/>
                        <?php if (!empty($errors['username'])) echo $errors['username']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="text" name="password" value="<?php echo !empty($data['password']) ? $data['password'] : ''; ?>"/>
                        <?php if (!empty($errors['password'])) echo $errors['password']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>
                        <input type="text" name="name" value="<?php echo !empty($data['name']) ? $data['name'] : ''; ?>"/>
                        <?php if (!empty($errors['name'])) echo $errors['name']; ?>
                    </td>
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
                        <input type="submit" name="add_student" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>