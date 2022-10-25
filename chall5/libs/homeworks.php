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
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $hwname = mysqli_real_escape_string($conn, htmlentities($hwname));
    $fileDestination = mysqli_real_escape_string($conn, htmlentities($fileDestination));
    $sql = "
            INSERT INTO homework(user,name,folder,submited) VALUES ('$username','$hwname','$fileDestination','1')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header ('Location: homework.php');
    }
}

function upload_ans($idHomework, $tenbai, $username, $fileDestination)
{
    global $conn;
    connect_db();
    $idHomework = (string)(int)$idHomework;
    $tenbai = mysqli_real_escape_string($conn, htmlentities($tenbai));
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $fileDestination = mysqli_real_escape_string($conn, htmlentities($fileDestination));
    $sql = "
            INSERT INTO answer(idHomework,tenbai,username,folder,submited) VALUES ('$idHomework','$tenbai','$username','$fileDestination','1')";
    $query = mysqli_query($conn, $sql);
    if ($query && $username == $_SESSION['username']) {
        header ('Location: answer.php?id='.$idHomework);
    }
}

function get_all_file($table)
{
    global $conn;
    connect_db();
    $table = mysqli_real_escape_string($conn, htmlentities($table));
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

function getName($id){
    global $conn;
    connect_db();
    $id = (string)(int)$id;
    $sql = "
            select * from homework where id = $id";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result;
}

function getFileByID($id){
    global $conn;
    connect_db();
    $id = (string)(int)$id;
    $sql = "
            select * from answer where idHomework = $id";
    $query = mysqli_query($conn, $sql);
    $result = array();
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    return $result;
}

function delete_hw($id)
{
    global $conn;
    connect_db();
    $id = (string)(int)$id;
    $sql = "
            DELETE FROM homework
            WHERE id = $id
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

function delete_ans($id, $username)
{
    global $conn;
    connect_db();
    $id = (string)(int)$id;
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $sql = "
            DELETE FROM answer
            WHERE id = $id and username = '$username'
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}
?>