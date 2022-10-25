<?php
require './libs/homeworks.php';
session_start();
$id = isset($_POST['id']) ? $_POST['id'] : '';
if ($id){
    if($_SESSION['role'] == 1){
        delete_hw($id);
    } else {
        delete_ans($id, $_SESSION['username']);
    }
}
if($_SESSION['role'] == 1){
    header("location: homework.php");
} else {
    header("location: answer.php?id=".$_SESSION['hw_id']);
}

?>