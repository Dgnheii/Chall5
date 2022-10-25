<?php
require './libs/messages.php';
session_start();

$_SESSION['user_nhan'] = isset($_GET['username']) ? $_GET['username'] : '';
if($_SESSION['user_nhan'] == "admin"){
    header("location: home.php");
} else {
    $user_nhan = $_SESSION['user_nhan'];
    $user_gui = $_SESSION['username'];
    if($user_gui == $user_nhan){
        $message = select_own($user_nhan);
    }
    else{
        $message = select_all($user_gui, $user_nhan);
    }

    disconnect_db();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Message</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            table {
            margin: 8px;
            }

            body {
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
        <h1>Message</h1>    
        <?php if($user_gui != $user_nhan) { ?>
            <a href="student-info.php?username=<?php echo $user_nhan ?>">Trở về</a> <br/> <br/>
            <a href="message-send.php?user_nhan=<?php echo $user_nhan ?>">Send Message</a> <br/> <br/>
        <?php } else {?>
            <a href="home.php">Trở về</a> <br/> <br/>
        <?php } ?>
            <table width="90%" border="1" cellspacing="0" cellpadding="10   ">
            <tr>
                <td>Message for <?php echo $user_nhan; ?> </td>
                <?php if ($user_gui == $user_nhan) { ?>
                    <td>Người gửi</td>
                <?php } else { ?>
                    <td>Option</td>
                <?php } ?>
            </tr>
            <?php foreach ($message as $data) { ?>
            <tr>
                <td>
                    <?php echo $data['content']; ?>
                </td>
                <td>
                    <?php if ($user_gui != $user_nhan) { ?>
                    <form method="post" action="message-delete.php">
                        <input onclick="window.location = 'message-edit.php?id=<?php echo $data['id']; ?>'" type="button" value="Sửa"/>
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>"/>                   
                        <input onclick="return confirm('Bạn có chắc muốn xóa không?');" type="submit" name="delete" value="Xóa"/>
                    </form>     
                    <?php } else { 
                        echo $data['user_gui'];
                    } ?>
                </td>
            </tr>
            <?php } ?>
            </table>
    </body>
</html>