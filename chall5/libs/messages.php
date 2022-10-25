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

function select_all($user_gui, $user_nhan){
    global $conn;
    connect_db();
    $user_gui = mysqli_real_escape_string($conn, htmlentities($user_gui));
    $user_nhan = mysqli_real_escape_string($conn, htmlentities($user_nhan));
    $sql = "select * from message where user_gui = '$user_gui' and user_nhan = '$user_nhan' ";
    $query = mysqli_query($conn, $sql);
    $result = array();
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    return $result;
}

function select_own($user_nhan){
    global $conn;
    connect_db();
    $user_nhan = mysqli_real_escape_string($conn, htmlentities($user_nhan));
    $sql = "select * from message where user_nhan = '$user_nhan' ";
    $query = mysqli_query($conn, $sql);
    $result = array();
    if ($query){
        while ($row = mysqli_fetch_assoc($query)){
            $result[] = $row;
        }
    }
    return $result;
}

function selectByID($id){
    global $conn;
    connect_db();
    $id = (string)(int)$id;
    $sql = "select * from message where id = $id";
    $query = mysqli_query($conn, $sql);
     
    $result = mysqli_fetch_assoc($query);
     
    return $result;
}

function send_message($user_gui, $user_nhan, $content)
{
    global $conn;
    connect_db();

    $user_gui = mysqli_real_escape_string($conn, htmlentities($user_gui));
    $user_nhan = mysqli_real_escape_string($conn, htmlentities($user_nhan));
    $content = mysqli_real_escape_string($conn, htmlentities($content));

    $stmt = $conn->prepare("
                            INSERT INTO message (user_gui, user_nhan, content) VALUES (?,?,?)");
    $stmt->bind_param("sss", $user_gui, $user_nhan, htmlentities($content));

    return $stmt->execute();
}

function edit_message($id, $user_gui, $user_nhan, $content)
{
    global $conn;
    connect_db();

    $user_gui = mysqli_real_escape_string($conn, htmlentities($user_gui));
    $user_nhan = mysqli_real_escape_string($conn, htmlentities($user_nhan));
    $content = mysqli_real_escape_string($conn, htmlentities($content));

    $sql = "
            UPDATE message SET
            user_gui = '$user_gui',
            user_nhan = '$user_nhan',
            content = '$content'
            WHERE id = $id and user_gui = '$user_gui'
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

function delete_message($id, $username)
{
    global $conn;
    connect_db();
    $username = mysqli_real_escape_string($conn, htmlentities($username));
    $id = (string)(int)$id;
    $sql = "
            DELETE FROM message
            WHERE id = $id and user_gui = '$username'
    ";
     
    $query = mysqli_query($conn, $sql);
     
    return $query;
}

?>