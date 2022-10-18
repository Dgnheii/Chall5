<?php
global $conn;

function connect_db()
{
    global $conn;
    if (!$conn){
        $conn = mysqli_connect('localhost', 'root', 'vertrigo', 'qlsv') or die ('Can\'t not connect to database');
        mysqli_set_charset($conn, 'utf8');
    }
}
 
function disconnect_db()
{
    global $conn;
    if ($conn){
        mysqli_close($conn);
    }
}

function upload_ques($username, $hwname, $fileDestination)
{
    global $conn;
    connect_db();
    $sql = "
            INSERT INTO homework(user,name,folder,submited) VALUES ('$username','$hwname','$fileDestination','1')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header ('Location: homework.php');
    }
}

function upload_ans($id, $tenbai, $username, $fileDestination)
{
    global $conn;
    connect_db();
    $sql = "
            INSERT INTO answer(tenbai,username,folder,submited) VALUES ('$tenbai','$username','$fileDestination','1')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header ('Location: answer.php?id='.$id);
    }
}

function get_all_file($table)
{
    global $conn;
    connect_db();
    $sql = "
            select * from $table";
    $query = mysqli_query($conn, $sql);
    $result = array();
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    return $result;
}

function get_name($id){
    global $conn;
    connect_db();
    $sql = "
            select * from homework where id = $id";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
}

function delete_hw($id)
{
    global $conn;
    connect_db();
    $sql = "
            DELETE FROM homework
            WHERE id = $id
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

function delete_ans($id)
{
    global $conn;
    connect_db();
    $sql = "
            DELETE FROM answer
            WHERE id = $id
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}
?>