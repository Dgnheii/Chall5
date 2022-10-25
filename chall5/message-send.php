<?php

require './libs/messages.php';
session_start();
$user_nhan = isset($_GET['username']) ? $_GET['username'] : '';
$user_nhan = $_SESSION['user_nhan'];
$user_gui = $_SESSION['username'];
$data = array();
if (!empty($_POST['send_message']) && $user_nhan != "admin")
{
    $data['content'] = isset($_POST['content']) ? $_POST['content'] : '';
    $errors = array();
    if (empty($data['content'])){
        $errors['content'] = 'Nội dung không được để trống';
    }

    if (!$errors){
        send_message($user_gui, $user_nhan, $data['content']);
        header("location: message-list.php?username=".$user_nhan);
    }
}
disconnect_db();
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Send Message</title>
        <meta charset="UTF-8">
        <meta content="viewport" content="width=device-width, initial-scale=1.0">
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
        <h1>Send Message</h1>
        <a href="message-list.php?username=<?php echo $user_nhan; ?>">Trở về</a> <br/> <br/>
        <form method="post" action="message-send.php">
        <input type="hidden" name="user_nhan" value="<?php echo $user_nhan; ?>"/>
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
                        <?php if (!empty($errors['content'])) echo $errors['content']; ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="send_message" value="Send"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>