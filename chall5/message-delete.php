<?php
require './libs/messages.php';
session_start();
// Thực hiện xóa
$id = isset($_POST['id']) ? $_POST['id'] : '';
$user_nhan = $_SESSION['user_nhan'];
if ($id){
    delete_message($id);
}

header("location: message-list.php?username=".$user_nhan);
?>