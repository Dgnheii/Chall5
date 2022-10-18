<?php
require './libs/messages.php';
session_start();
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id = $_SESSION['id'];
$user_gui = $_SESSION['username'];
$user_nhan = $_SESSION['user_nhan'];
if ($id){
    $data = selectByID($id);
}

 
if (!$data){
   header("location: message-list.php?username=".$user_nhan);
}
 
if (!empty($_POST['edit_message']))
{
    $data['content'] = isset($_POST['content']) ? $_POST['content'] : '';
    $errors = array();
    if (empty($data['content'])){
        $errors['content'] = 'Tin nhắn không được để trống!';
    }
     
    if (!$errors){
        edit_message($id, $user_gui, $user_nhan, $data['content']);
        header("location: message-list.php?username=".$user_nhan);
        
    }
}

 
disconnect_db();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Sửa tin nhắn</title>
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
        <h1>Sửa tin nhắn</h1>
        <a href="message-list.php?username=<?php echo $_SESSION['user_nhan'];?>">Message</a> <br/> <br/>
        <form method="post" action="message-edit.php">
        <input type="hidden" name="id" value="<?php echo $id; ?>"/> 
            <table width="50%" border="1" cellspacing="0" cellpadding="10">
                <tr>
                    <td>Người gửi</td>
                    <td>
                        <?php echo $user_gui; ?>
                    </td>
                </tr>
                <tr>
                    <td>Người nhận</td>
                    <td>
                        <?php echo $user_nhan; ?>
                    </td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>
                        <input type="text" name="content" value="<?php echo !empty($data['content']) ? $data['content'] : ''; ?>"/>
                        <?php if (!empty($errors['content'])) echo $errors['content'];?>
                    </td>
                </tr>
                    <td></td>
                    <td> 
                        <input type="submit" name="edit_message" value="Lưu"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>