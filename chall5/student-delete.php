<?php
require './libs/students.php';
session_start();
// Thực hiện xóa
$username = isset($_POST['username']) ? $_POST['username'] : '';
if ($username){
    delete_student($username);
}
header("location: student-list.php");
?>